<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Receipt;
use thiagoalessio\TesseractOCR\TesseractOCR;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class ReceiptController extends Controller
{
     // form upload struk
     public function create()
     {
          return view('user.receipt.create');
     }

     public function scan(Request $request)
     {
          $request->validate(['receipt' => 'required|image|max:5120']);

          // ==========================
          // UPLOAD GAMBAR
          // ==========================

          $path     = $request->file('receipt')->store('receipts', 'public');
          $fullPath = storage_path('app/public/' . $path);

          // ==========================
          // PREPROCESSING GAMBAR
          // ==========================

          $manager = new ImageManager(new Driver());
          $image   = $manager->read($fullPath);

          // Hanya scale jika gambar terlalu kecil
          // Struk foto dari HP biasanya sudah 2000-4000px, tidak perlu 3x
          if ($image->width() < 1500) {
               $image->scale(width: 1500);
          }

          $image
               ->greyscale()
               ->contrast(30)   // turunkan dari 60 → 30, lebih aman untuk thermal print
               ->sharpen(8)     // tambah sharpen agar teks lebih tegas
               ->brightness(5); // brightness minimal saja

          $image->save($fullPath);

          // ==========================
          // OCR
          // ==========================

          $ocrText = (new TesseractOCR($fullPath))
               ->executable('C:\Program Files\Tesseract-OCR\tesseract.exe')
               ->lang('eng', 'ind')
               ->psm(4)  // ubah dari 4 → 6: "uniform block of text", cocok untuk struk
               ->oem(1)  // tambah: LSTM neural net, lebih akurat dari default
               ->run();

          // ==========================
          // NORMALISASI OCR
          // ==========================

          // HAPUS normalisasi huruf → angka yang agresif!
          // Mengganti O→0, S→5, B→8 merusak kata seperti TOTAL, SOAP, BRUSH
          // Cukup bersihkan karakter non-printable saja

          $ocrText = preg_replace('/[^\x20-\x7E\n\r]/', '', $ocrText);

          // Normalisasi spasi berlebih per baris
          $lines = explode("\n", $ocrText);
          $lines = array_map(fn($l) => preg_replace('/\s{2,}/', ' ', trim($l)), $lines);
          $lines = array_filter($lines, fn($l) => strlen($l) > 0);
          $lines = array_values($lines);

          // ==========================
          // EKSTRAK TOTAL
          // ==========================

          $amount = null;

          // Prioritas keyword dari yang paling spesifik
          $totalKeywords = [
               'total incl',    // MR D.I.Y pakai "Total Incl. PPN"
               'total incl. ppn',
               'grand total',
               'total bayar',
               'total belanja',
               'jumlah bayar',
               'jumlah',
               'total',
          ];

          foreach ($totalKeywords as $keyword) {
               foreach ($lines as $line) {
                    if (str_contains(strtolower($line), $keyword)) {

                         // Ambil SEMUA angka di baris ini
                         preg_match_all('/[\d.,]+/', $line, $matches);

                         if (!empty($matches[0])) {
                              // Coba dari belakang — angka terakhir biasanya nilainya
                              foreach (array_reverse($matches[0]) as $candidate) {
                                   $clean = (int) preg_replace('/[^\d]/', '', $candidate);

                                   // Filter: masuk akal untuk transaksi (Rp 1.000 - Rp 99.999.999)
                                   if ($clean >= 1000 && $clean <= 99999999) {
                                        $amount = $clean;
                                        break 3; // keluar dari semua loop
                                   }
                              }
                         }
                    }
               }
          }

          // ==========================
          // FALLBACK: cari "Rp xxx" terbesar
          // ==========================

          if (!$amount) {
               preg_match_all('/Rp\s*[\s]*([\d.,]+)/i', $ocrText, $matches);

               if (!empty($matches[1])) {
                    $numbers = [];

                    foreach ($matches[1] as $number) {
                         $clean = (int) preg_replace('/[^\d]/', '', $number);

                         if ($clean >= 1000 && $clean <= 99999999) {
                              $numbers[] = $clean;
                         }
                    }

                    // Ambil nilai terbesar yang bukan CASH/kembalian
                    if (!empty($numbers)) {
                         rsort($numbers);

                         // Skip nilai tertinggi jika ada 2 nilai besar berdekatan
                         // (kemungkinan CASH > TOTAL, kita ambil kedua terbesar)
                         $amount = $numbers[0];
                    }
               }
          }

          // ==========================
          // DETEKSI MERCHANT
          // ==========================

          $merchant    = null;
          $merchantMap = [
               'MR D.I.Y'   => 'MR D.I.Y',
               'MRDIY'      => 'MR D.I.Y',
               'MR DIY'     => 'MR D.I.Y',
               'INDOMARET'  => 'Indomaret',
               'ALFAMART'   => 'Alfamart',
               'ALFAMIDI'   => 'Alfamidi',
               'HYPERMART'  => 'Hypermart',
               'TRANSMART'  => 'Transmart',
               'LAWSON'     => 'Lawson',
               'CIRCLE K'   => 'Circle K',
          ];

          // Cek hanya di 10 baris pertama (header struk)
          $headerLines = array_slice($lines, 0, 10);

          foreach ($headerLines as $line) {
               $upper = strtoupper($line);

               foreach ($merchantMap as $keyword => $name) {
                    if (str_contains($upper, $keyword)) {
                         $merchant = $name;
                         break 2;
                    }
               }
          }

          // ==========================
          // EKSTRAK TANGGAL
          // ==========================

          $date = null;

          foreach ($lines as $line) {
               // Format: 31-05-26 atau 31/05/2026 atau 2026-05-31
               if (preg_match('/(\d{2}[-\/]\d{2}[-\/]\d{2,4})/', $line, $m)) {
                    $date = $m[1];
                    break;
               }
          }

          // ==========================
          // SIMPAN
          // ==========================

          $receipt = Receipt::create([
               'transaction_id' => null,
               'image_path'     => $path,
               'ocr_amount'     => $amount,
               'ocr_text'       => implode("\n", $lines), // simpan teks yang sudah bersih
          ]);

          return view('user.receipt.result', compact(
               'receipt',
               'merchant',
               'amount',
               'date',
               'lines', // kirim ke view untuk debug jika perlu
          ));
     }
}
