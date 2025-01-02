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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('instructions')->nullable();
            $table->date('due_date');

            $table->foreignId('instructor_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('instructors')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('study_plan_course_instructor_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('spc_instructors')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('study_plan_course_instructor_sub_group_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('spc_instructor_sub_groups')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
