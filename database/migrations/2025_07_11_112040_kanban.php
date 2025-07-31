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
        Schema::create('kanban', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('kanban_id')->unique();
            $table->string('name');
            $table->enum('status', ['todo', 'in_progress', 'done'])->default('todo');
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->foreign('kanban_id')->references('kanban_id')->on('tasks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kanban');
    }
};
