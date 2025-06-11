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
        Schema::create('inquiry', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('client_id');
            $table->string('worker_id')->nullable();
            $table->string('detail_task_id')->nullable();
            $table->string('status')->default('pending');
            $table->dateTime('deadline')->nullable();
            $table->boolean('is_approved')->nullable();
            $table->timestamps();
        });

        Schema::create('task_detail', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->binary('going_file')->nullable();
            $table->binary('done_file')->nullable();
            $table->timestamps();
        });

        Schema::table('kanban', function (Blueprint $table) {
            $table->foreignId("client_id")->constrained(
                "users",
                indexName: "user_detail_id"
            );
            $table->foreignId("worker_id")->constrained(
                "users",
                indexName: "user_detail_id"
            );
            $table->foreignId("detail_task_id")->constrained(
                "task_detail",
                indexName: "id"
            );
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
