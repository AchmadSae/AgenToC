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
        Schema::create('user_detail', function (Blueprint $table) {
            $table->string("id")->primary();
            $table->string("role");
            $table->string("address_detail")->nullable();
            $table->string("phone_number")->nullable();
            $table->bigInteger("postal_code")->nullable();
            $table->string("credit_number")->nullable();
            $table->integer("balance_coins")->default(0);
            $table->boolean("is_active");
            $table->timestamps();
        });

        Schema::table('user_detail', function (Blueprint $table) {
            $table->foreignId("id")->constrained(
                "users",
                indexName: "user_detail_id"
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_detail');
    }
};
