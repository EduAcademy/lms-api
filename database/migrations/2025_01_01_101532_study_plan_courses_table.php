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
        //
        Schema::create('study_plan_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('study_plan_id')
            ->unsignedBigInteger()
            ->references('id')
            ->on('study_plans')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('department_id')
            ->unsignedBigInteger()
            ->references('id')
            ->on('departments')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('course_id')
            ->unsignedBigInteger()
            ->references('id')
            ->on('courses')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('level_id')
            ->unsignedBigInteger()
            ->references('id')
            ->on('levels')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            
            $table->enum('semester', ['1', '2'])->default('1');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('study_plan_courses');
    }
};
