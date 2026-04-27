<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Transaction;

class Receipt extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_id',
        'image_path',
        'ocr_amount',
        'ocr_text'
    ];

    protected $casts = [
        'ocr_amount' => 'decimal:2',
    ];

    //ke transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
