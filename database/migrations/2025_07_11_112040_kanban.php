<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Helpers\Constant;

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
            $table->enum('status', [Constant::SUBTASK_STATUS_TODO, Constant::TASK_STATUS_IN_PROGRESS, Constant::TASK_STATUS_COMPLETED])->default(Constant::SUBTASK_STATUS_TODO);
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
