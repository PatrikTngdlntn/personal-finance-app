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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('name');

            $table->decimal('amount', 15, 2);

            $table->string('currency')->default('IDR');

            $table->enum('billing_cycle', ['weekly', 'monthly', 'yearly']);

            $table->date('next_billing');

            $table->timestamps();

            $table->index('user_id');
            $table->index('next_billing');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
