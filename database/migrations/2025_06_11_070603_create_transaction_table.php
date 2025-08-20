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
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('id');
            $table->string('task_id')->nullable();
            $table->string('user_detail_id');
            $table->string('product_code')->nullable();
            $table->string('product_type')->nullable();
            $table->string('payment_method');
            $table->integer('quantity')->default(1);
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('user_detail_id')->references('user_detail_id')->on('users');
            $table->foreign('product_code')->references('product_code')->on('products');
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
