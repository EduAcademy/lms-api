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
        Schema::create('student_course_instructors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id'); // Default to 'student'
            $table->foreign('student_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('students')
                ->nullable(false)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
            $table->unsignedBigInteger('instructor_id'); // Default to 'student'
            $table->foreign('instructor_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('instructors')
                ->nullable(false)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unsignedBigInteger('course_id'); // Default to 'student'
            $table->foreign('course_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('courses')
                ->nullable(false)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();    
                
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_course_instructors');
    }
};
