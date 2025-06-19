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
        Schema::create('user_detail', function (Blueprint $table) {
            $table->string("id")->primary();
            $table->string("skills")->nullable();
            $table->string("tag_line")->nullable();
            $table->string("address_detail")->nullable();
            $table->string("phone_number")->nullable();
            $table->bigInteger("postal_code")->nullable();
            $table->string("credit_number")->nullable();
            $table->integer("balance_coins")->default(0);
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string("role_id")->unique();
            $table->string("role_name");
            $table->timestamps();
        });

        Schema::create('user_detail_roles', function (Blueprint $table) {
            $table->id();
            $table->string('user_detail_id');
            $table->string('role_id');
            $table->foreign('user_detail_id')->references('id')->on('user_detail')->onDelete('cascade');
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade');
            $table->boolean("is_active")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_detail_roles');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('user_detail');
    }
};
