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
        Schema::create('course_materials', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('type', ['theoretical', 'practical'])->default('theoretical');
            $table->string('url');

            $table->foreignId('course_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('courses')
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
        Schema::dropIfExists('course_materials');
    }
};
