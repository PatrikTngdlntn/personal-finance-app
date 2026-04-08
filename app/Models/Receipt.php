<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;

class Receipt extends Model
{
    protected $fillable = [
        'transaction_id',
        'image_path',
        'ocr_amount',
        'ocr_text'
    ];

    //ke transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
