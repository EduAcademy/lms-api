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
        Schema::create('coursematerials', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('type',['theoretical', 'practical'])->default('theoretical');
            $table->string('url');
            $table->unsignedBigInteger('course_id'); 
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->unsignedBigInteger('instructor_id'); 
            $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coursematerials');
    }
};
