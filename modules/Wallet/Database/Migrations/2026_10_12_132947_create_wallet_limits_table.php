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
        Schema::create('wallet_limits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained('wallets')->restrictOnDelete();
            $table->string('limit_type', 20)->index(); // BALANCE_LIMIT, DAILY_TRANSFER_LIMIT, MONTHLY_TRANSFER_LIMIT
            $table->decimal('limit_value', 15, 2)->default(0.00);
            $table->decimal('current_usage', 15, 2)->default(0.00);
            $table->timestamp('reset_at');

            $table->unique(['wallet_id', 'limit_type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_limits');
    }
};
