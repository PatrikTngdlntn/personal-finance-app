<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class ReportExport implements FromCollection, WithHeadings
{
    protected Collection $transactions;

    public function __construct(Collection $transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions->map(function ($transaction) {

            return [
                'Tanggal' => $transaction->transaction_date,
                'Tipe' => ucfirst($transaction->type),
                'Kategori' => $transaction->category->name ?? '-',
                'Wallet' => $transaction->wallet->name ?? '-',
                'Jumlah' => $transaction->amount,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Tipe',
            'Kategori',
            'Wallet',
            'Jumlah',
        ];
    }
}
