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
        Schema::create('tasks', function (Blueprint $table) {
            $table->string('id');
            $table->string('client_id');
            $table->string('worker_id')->nullable();
            $table->string('kanban_id')->nullable();
            $table->string('detail_task_id');
            $table->string('status')->default(\App\Helpers\Constant::TASK_STATUS_OPEN);
            $table->dateTime('deadline');
            $table->boolean('is_approved')->default(false);
            $table->dateTime('acceptance_deadline_time')->nullable();
            $table->timestamps();
            $table->foreign('detail_task_id')->references('id')->on('task_detail');
        });

        Schema::create('task_detail', function (Blueprint $table) {
            $table->string('id');
            $table->string('title');
            $table->text('description');
            $table->text('task_type');
            $table->integer('price');
            $table->string('task_contract')->nullable();
            $table->text('required_skills')->nullable();
            $table->timestamps();
        });

        Schema::create('task_file', function (Blueprint $table) {
              $table->id();
              $table->string('task_id');
              $table->string('file_path');
              $table->string('file_name');
              $table->string('file_type');
              $table->string('mime_type')->nullable();
              $table->integer('file_size')->nullable();
              $table->timestamps();
              $table->foreign('task_id')->references('id')->on('tasks');
        });
        Schema::create('revision_history', function (Blueprint $table) {
            $table->id();
            $table->string('task_id');
            $table->text('changes');
            $table->string('description')->nullable();
            $table->string('status')->default('pending');
            $table->string('attachment')->nullable();
            $table->timestamps();
            $table->foreign('task_id')->references('id')->on('tasks');
        });

        Schema::create('ticket_revision', function (Blueprint $table) {
              $table->string('id')->primary();
              $table->string('task_id');
              $table->string('title');
              $table->text('description');
              $table->string('status')->default('pending');
              $table->string('attachment_tmp')->nullable();
              $table->timestamps();
              $table->foreign('task_id')->references('id')->on('tasks');
        });

        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('task_id')->nullable();
            $table->string('user_id')->default('guest');
            $table->text('comment');
            $table->text('message')->nullable();
            $table->integer('rating')->default(0);
            $table->timestamps();
            $table->foreign('task_id')->references('id')->on('tasks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiry');
        Schema::dropIfExists('task_detail');
        Schema::dropIfExists('revision_history');
    }
};
