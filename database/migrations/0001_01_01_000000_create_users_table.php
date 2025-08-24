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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_detail_id')->unique();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();

            #indexin
            $table->index('user_detail_id');
            $table->index('username');
            $table->index('email');

            $table->index(['email_verified_at','user_detail_id', 'created_at'], 'status_verified_at_index');
        });

        Schema::create('user_detail', function (Blueprint $table) {
                $table->increments("id");
                $table->string("user_detail_id")->unique();
                $table->string('full_name');
                $table->string("skills")->nullable();
                $table->string("tag_line")->nullable();
                $table->string("address_detail")->nullable();
                $table->string("phone_number")->nullable();
                $table->bigInteger("postal_code")->nullable();
                $table->string("credit_number")->nullable();
                $table->integer("balance_coins")->default(0);
                $table->timestamps();

                #indexin
                $table->index('user_detail_id');
        });

          Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string("role_id")->unique();
                $table->string("role_name");
                $table->timestamps();
          });

          Schema::create('user_detail_roles', function (Blueprint $table) {
                $table->id();
                $table->string('role_id');
                $table->string('user_detail_id');
                $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade');
                $table->boolean("is_active")->default(false);
                $table->timestamps();
                $table->foreign('user_detail_id')->references('user_detail_id')->on('user_detail')->onDelete('cascade');

                $table->index(['user_detail_id','is_active', 'created_at'],'user_detail_roles_index');
          });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('user_detail');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('user_detail_roles');
    }
};
