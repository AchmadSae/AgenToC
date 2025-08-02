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
            $table->string('user_id');
            $table->string('product_id')->nullable();
            $table->string('product_type')->nullable();
            $table->string('payment_method');
            $table->integer('quantity');
            $table->decimal('total_price', 10, 2);
            $table->string('attachment')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
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
