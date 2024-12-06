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
        Schema::create('assignmentsubmissions', function (Blueprint $table) {
            $table->id();
            $table->text('data')->nullable();
            $table->string('file_url')->nullable();
            $table->unsignedBigInteger('assignmentstatus_id');
            $table->foreign('assignmentstatus_id')->references('id')->on('assignmentstatus')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignmentsubmissions');
    }
};
