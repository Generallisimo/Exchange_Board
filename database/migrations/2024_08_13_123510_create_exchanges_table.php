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
        Schema::create('exchanges', function (Blueprint $table) {
            $table->id();
            $table->string('exchange_id')->unique();
            $table->string('method')->nullable();
            $table->string('currency')->nullable();
            $table->string('client_id');
            $table->string('market_id');
            $table->string('amount');
            $table->string('result')->nullable()->default('await');
            $table->string('message')->nullable();
            $table->string('percent_client');
            $table->string('percent_market');
            $table->string('percent_agent');
            $table->string('details_market_payment');
            $table->string('details_market');
            $table->string('details_client');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchanges');
    }
};
