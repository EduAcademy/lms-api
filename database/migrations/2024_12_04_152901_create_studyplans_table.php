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
        Schema::create('study_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('study_plan_no')->nullable();
            $table->integer('level')->default(1);
            $table->integer('semester')->default(1);
            $table->date('issued_at')->nullable(true);
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

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_plans');
    }
};
