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
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string("role_id");
            $table->string("address_detail")->nullable();
            $table->string("phone_number")->nullable();
            $table->bigInteger("postal_code")->nullable();
            $table->string("credit_number")->nullable();
            $table->integer("balance_coins")->default(0);
            $table->boolean("is_active");
            $table->timestamps();
        });


        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string("role_id");
            $table->string("role_name");
            $table->boolean("is_active");
            $table->timestamps();
        });

        // Schema::table('roles', function (Blueprint $table) {
        //     $table->foreign('role_id')->references('role_id')->on('user_detail');
        // });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_detail');
        Schema::dropIfExists('roles');
    }
};
