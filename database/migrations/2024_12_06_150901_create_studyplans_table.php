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
        Schema::create('studyplans', function (Blueprint $table) {
            $table->id();
            $table->integer('studyplan_no')->nullable();
            $table->integer('level')->default(1);
            $table->integer('semester')->default(1);
            $table->date('issued_at')->nullable(true);
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studyplans');
    }
};
