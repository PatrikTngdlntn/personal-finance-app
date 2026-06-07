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
        'ocr_text',
        'merchant_name',
        'receipt_date',
        'ocr_confidence',
        'status',
    ];

    protected $casts = [
        'ocr_amount' => 'decimal:2',
        'ocr_confidence' => 'decimal:2',
        'receipt_date' => 'date',
    ];

    // =========================
    // RELATIONSHIP
    // =========================
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // =========================
    // STATUS HELPER
    // =========================
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isProcessed()
    {
        return $this->status === 'processed';
    }

    public function isVerified()
    {
        return $this->status === 'verified';
    }

    public function isFailed()
    {
        return $this->status === 'failed';
    }
}
