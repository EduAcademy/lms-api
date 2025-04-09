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
                ->unsignedBigInteger()
                ->references('id')
                ->on('courses')
                ->nullable(false)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('group_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('groups')
                ->nullable(true)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('sub_group_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('sub_groups')
                ->nullable(true)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('student_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('students')
                ->nullable(false)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('instructor_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('instructors')
                ->nullable(false)
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
