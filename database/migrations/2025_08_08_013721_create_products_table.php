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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_group_code');
            $table->string('product_code');
            $table->string('product_name');
            $table->integer('price')->nullable();
            $table->string('product_description');
            $table->string('product_image')->nullable();
            $table->timestamps();
            $table->foreign('product_group_code')->references('code')->on('product_groups');
            $table->foreign('product_code')->references('code')->on('product_groups');
        });

        Schema::create('product_groups', function (Blueprint $table) {
              $table->increments('id');
              $table->string('code');
              $table->string('value');
              $table->string('terms_and_policy');
              $table->string('note')->nullable();
              $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
//    public function down(): void
//    {
//        Schema::dropIfExists('products');
//        Schema::dropIfExists('product_groups');
//    }
};
