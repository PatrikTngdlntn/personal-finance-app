<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Receipt;
use thiagoalessio\TesseractOCR\TesseractOCR;


class ReceiptController extends Controller
{
     // form upload struk
     public function create()
     {
          return view('user.receipt.create');
     }

     public function scan(Request $request)
     {
          $request->validate([
               'receipt' => 'required|image|max:5120'
          ]);

          // Upload gambar
          $path = $request->file('receipt')
               ->store('receipts', 'public');

          $fullPath = storage_path(
               'app/public/' . $path
          );

          // OCR
          $ocrText = (new TesseractOCR($fullPath))
               ->executable(
                    'C:\Program Files\Tesseract-OCR\tesseract.exe'
               )
               ->lang('eng', 'ind')
               ->psm(4)
               ->run();

          // ==========================
          // NORMALISASI OCR
          // ==========================

          $ocrText = str_replace(
               ['@', 'O', 'o'],
               ['0', '0', '0'],
               $ocrText
          );

          $ocrText = preg_replace(
               '/[^\x20-\x7E\n\r]/',
               '',
               $ocrText
          );

          // ==========================
          // EKSTRAK NOMINAL
          // ==========================

          $amount = null;

          $lines = explode("\n", $ocrText);

          foreach ($lines as $line) {

               $lineLower = strtolower($line);

               if (
                    str_contains($lineLower, 'total incl') ||
                    str_contains($lineLower, 'grand total') ||
                    str_contains($lineLower, 'total')
               ) {

                    preg_match_all(
                         '/[\d.,]+/',
                         $line,
                         $matches
                    );

                    if (!empty($matches[0])) {

                         $candidate = end($matches[0]);

                         $amount = (int) preg_replace(
                              '/[^\d]/',
                              '',
                              $candidate
                         );

                         break;
                    }
               }
          }

          // ==========================
          // FALLBACK JIKA TOTAL GAGAL
          // ==========================

          if (!$amount) {

               preg_match_all(
                    '/Rp\s*([\d.,]+)/i',
                    $ocrText,
                    $matches
               );

               if (!empty($matches[1])) {

                    $numbers = [];

                    foreach ($matches[1] as $number) {

                         $clean = (int) preg_replace(
                              '/[^\d]/',
                              '',
                              $number
                         );

                         // hindari nomor telepon
                         if (
                              $clean >= 1000 &&
                              strlen((string) $clean) <= 8
                         ) {
                              $numbers[] = $clean;
                         }
                    }

                    if (!empty($numbers)) {
                         $amount = max($numbers);
                    }
               }
          }

          // ==========================
          // DETEKSI MERCHANT
          // ==========================

          $merchant = null;

          foreach ($lines as $line) {

               $line = trim($line);

               if (
                    str_contains(strtoupper($line), 'MR D.I.Y')
               ) {
                    $merchant = 'MR D.I.Y';
                    break;
               }
          }

          // ==========================
          // SIMPAN
          // ==========================

          $receipt = Receipt::create([
               'transaction_id' => null,
               'image_path' => $path,
               'ocr_amount' => $amount,
               'ocr_text' => $ocrText,
          ]);

          return view(
               'user.receipt.result',
               compact(
                    'receipt',
                    'merchant',
                    'amount'
               )
          );
     }
}
