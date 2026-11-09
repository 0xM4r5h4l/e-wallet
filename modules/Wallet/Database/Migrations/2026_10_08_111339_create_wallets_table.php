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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->unsignedBigInteger('balance')->default(0);
            $table->char('currency', 3)->default('EGP');
            $table->string('status', 20)->default('ACTIVE')->index(); // ACTIVE, SUSPENDED, CLOSED
            $table->string('kyc_status', 20)->default('PENDING')->index(); // PENDING, VERIFIED, REJECTED

            $table->timestamps();
            $table->unique(['user_id', 'currency']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
