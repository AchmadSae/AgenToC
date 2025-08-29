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
            $table->string('task_id')->nullable();
            $table->string('user_detail_id');
            $table->string('product_code')->nullable();
            $table->string('product_type')->nullable();
            $table->string('payment_method');
            $table->integer('quantity')->default(1);
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->index(['task_id','user_detail_id','product_code','created_at'], 'transactions_index');
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
