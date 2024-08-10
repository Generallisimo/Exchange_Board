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
        Schema::create('add_market_details', function (Blueprint $table) {
            $table->id();
            $table->string('hash_id');
            $table->string('details_market_to');
            $table->string('details_market_from');
            $table->timestamps();

            $table->foreign('hash_id')->references('hash_id')->on('markets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_market_details');
    }
};
