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
        Schema::create('payment', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id');
            $table->string('inquiry_id')->nullable();
            $table->string('payment_method');
            $table->bigInteger('amount');
            $table->string('payment_proof')->nullable();
            $table->dateTime('requested_at');
            $table->timestamps();
        });

        Schema::table('payment', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('inquiry_id')->references('id')->on('inquiry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
