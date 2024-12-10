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
        Schema::create('student_course_instructor_groups', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            
            $table->foreignId('instructor_id')
                ->constrained('instructors')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            
            $table->foreignId('course_id')
                ->constrained('courses')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            
            $table->foreignId('theoretical_groups_id')
                ->constrained('theoretical_groups')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();                
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_course_instructor_groups');
    }
};
