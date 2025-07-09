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
            $table->string('client_id');
            $table->string('worker_id')->nullable();
            $table->string('detail_task_id');
            $table->string('status')->default('pending');
            $table->dateTime('deadline')->nullable();
            $table->boolean('is_approved')->nullable();
            $table->timestamps();
        });

        Schema::create('task_detail', function (Blueprint $table) {

            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('task_contract');
            $table->integer('price');
            $table->text('required_skills');
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
