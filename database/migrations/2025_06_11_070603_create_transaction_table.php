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
        Schema::create('orders', function (Blueprint $table) {
            $table->string('order_id')->primary();
            $table->string('order_number')->unique();
            $table->string('invoice_id')->unique();
            $table->string('user_detail_id');
            $table->string('payment_method');
            $table->decimal('total_price', 10, 2);
            $table->decimal('tax', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->index(['user_detail_id','product_code','created_at'], 'transactions_index');
        });

        Schema::create('order_item', function (Blueprint $table) {
              $table->string('order_item_id')->primary();
              $table->string('order_id');
              $table->string('task_id')->nullable();
              $table->string('product_code');
              $table->string('product_type');
              $table->string('status')->nullable();
              $table->timestamps();
              $table->index(['task_id','order_id','task_detail_id','product_code','created_at'], 'order_item_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('transactions');
    }
};
