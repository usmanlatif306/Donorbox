<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('compaign_resets', function (Blueprint $table) {
            $table->string('total_stripe_withdraw_amount')->default('0');
            $table->string('total_paypal_withdraw_amount')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compaign_resets', function (Blueprint $table) {
            $table->dropColumn('total_stripe_withdraw_amount');
            $table->dropColumn('total_paypal_withdraw_amount');
        });
    }
};
