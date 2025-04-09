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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_id')
                ->constrained('courses')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('group_id')
                ->nullable()
                ->constrained('groups')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('sub_group_id')
                ->nullable()
                ->constrained('sub_groups')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('instructor_id')
                ->constrained('instructors')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->integer('grade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
