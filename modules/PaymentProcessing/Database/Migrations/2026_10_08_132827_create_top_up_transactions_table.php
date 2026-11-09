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
        Schema::create('top_up_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained('wallets')->restrictOnDelete();
            $table->unsignedBigInteger('amount');
            $table->string('method', 20); // BANK_TRANSFER, CARD, CASH
            $table->string('payment_provider_id', 50)->nullable();
            $table->string('payment_transaction_id', 50)->nullable();
            $table->string('status', 20)->default('PENDING')->index(); // PENDING, SUCCESS, FAILED
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_up_transactions');
    }
};
