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
        Schema::create('compaign_resets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compaign_id')->constrained()->cascadeOnDelete();
            $table->string('last_total');
            $table->string('last_total_with_tax');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compaign_resets');
    }
};
