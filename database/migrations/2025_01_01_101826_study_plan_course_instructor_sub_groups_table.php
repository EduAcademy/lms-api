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
        Schema::create('spc_instructor_sub', function (Blueprint $table) {
            $table->id();
            $table->foreignId('study_plan_course_instructors_id')
            ->unsignedBigInteger()
            ->references('id')
            ->on('spc_instructor')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('sub_group_id')
            ->unsignedBigInteger()
            ->references('id')
            ->on('sub_groups')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('instructor_id')
            ->unsignedBigInteger()
            ->references('id')
            ->on('instructors')
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
        //
        Schema::dropIfExists('study_plan_course_instructor_sub_groups');
    }
};
