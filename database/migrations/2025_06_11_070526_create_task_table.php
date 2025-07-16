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
        Schema::create('tasks', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('slug')->unique();
            $table->string('client_id');
            $table->string('worker_id');
            $table->string('kanban_id')->nullable();
            $table->string('detail_task_id');
            $table->string('status')->default('pending');
            $table->dateTime('deadline');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });

        Schema::create('task_detail', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('task_type');
            $table->integer('price');
            $table->text('required_skills');
            $table->binary('attachment')->nullable();
            $table->timestamps();
        });
        Schema::create('global_policey', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::create('revision_history', function (Blueprint $table) {
            $table->id();
            $table->string('task_id');
            $table->text('changes');
            $table->string('changed_by');
            $table->string('status')->default('in_progress');
            $table->binary('attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiry');
    }
};
