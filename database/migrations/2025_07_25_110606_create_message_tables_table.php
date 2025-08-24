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
        Schema::create('tasks_chats_tmp', function (Blueprint $table) {
            $table->id();
            $table->string('task_id');
            $table->string('user_detail_id');
            $table->text('message')->nullable();
            $table->timestamps();
            $table->foreign('task_id')->references('id')->on('tasks');

            $table->index(['task_id','user_detail_id','created_at'], 'tasks_chats_tmp_index');
        });

        Schema::create('notification_tmp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_detail_id')->references('user_detail_id')->on('users');
            $table->string('title');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->index(['user_detail_id','is_read','created_at'], 'notification_tmp_index');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_tables');
    }
};
