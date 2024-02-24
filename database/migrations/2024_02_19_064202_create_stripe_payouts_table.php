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
        Schema::create('stripe_payouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compaign_id');
            $table->string('payout_id');
            $table->string('amount');
            $table->string('currency');
            $table->string('balance_transaction');
            $table->string('destination');
            $table->string('method');
            $table->string('status');
            $table->string('type');
            $table->date('arrival_date');
            $table->string('failure_code')->nullable();
            $table->text('failure_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripe_payouts');
    }
};
