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
            $table->renameColumn('last_total', 'last_stripe_total');
            $table->renameColumn('last_total_with_tax', 'last_stripe_total_with_tax');
            $table->string('last_paypal_total');
            $table->string('last_paypal_total_with_tax');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compaign_resets', function (Blueprint $table) {
            $table->renameColumn('last_stripe_total', 'last_total');
            $table->renameColumn('last_stripe_total_with_tax', 'last_total_with_tax');
        });
    }
};
