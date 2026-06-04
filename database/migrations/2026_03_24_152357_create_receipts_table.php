<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('transaction_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('image_path');

            $table->decimal('ocr_amount', 15, 2)
                ->nullable();

            $table->text('ocr_text')
                ->nullable();

            $table->string('merchant_name')
                ->nullable();

            $table->date('receipt_date')
                ->nullable();

            $table->decimal('ocr_confidence', 5, 2)
                ->nullable();

            $table->enum('status', [
                'pending',
                'processed',
                'verified',
                'failed'
            ])->default('pending');

            $table->timestamps();

            $table->index('transaction_id');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
