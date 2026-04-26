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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // RELASI
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();

            // nullable (karena transfer tidak pakai kategori)
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            // untuk transfer antar wallet
            $table->foreignId('transfer_to_wallet_id')->nullable()->constrained('wallets')->nullOnDelete();
            // DATA
            $table->decimal('amount', 15, 2);

            $table->enum('type', ['income', 'expense', 'transfer']);

            $table->text('description')->nullable();

            $table->date('transaction_date');

            $table->timestamps();
            $table->softDeletes();

            // INDEX 
            $table->index('user_id');
            $table->index('wallet_id');
            $table->index('category_id');
            $table->index('transaction_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
