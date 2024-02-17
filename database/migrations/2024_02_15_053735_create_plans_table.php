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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compaign_id');
            $table->unsignedBigInteger('donor_id');
            $table->string('amount');
            $table->string('formatted_amount');
            $table->string('type');
            $table->string('payment_method');
            $table->string('status');
            $table->datetime('last_donation_date');
            $table->date('next_donation_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
