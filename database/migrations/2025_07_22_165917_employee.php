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
        Schema::create('employees', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('department_id')->nullable();
            $table->string('position');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('department_id')->references('id')->on('departments');

            $table->index('email');
            $table->index(['department_id','is_active','created_at'], 'employees_index');
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('name');
            $table->string('location')->nullable();
            $table->string('manager_id')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
