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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compaign_id');
            $table->unsignedBigInteger('donor_id');
            $table->string('amount');
            $table->string('formatted_amount');
            $table->string('currency');
            $table->string('type');
            $table->string('stripe_charge_id')->nullable();
            $table->string('paypal_transaction_id')->nullable();
            $table->string('status');
            $table->boolean('recurring')->default(false);
            $table->string('processing_fee');
            $table->string('formatted_processing_fee');
            $table->timestamp('donation_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
