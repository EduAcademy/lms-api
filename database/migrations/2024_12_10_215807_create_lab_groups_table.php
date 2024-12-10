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
        Schema::create('lab_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('theoretical_groups_id')
                ->constrained('theoretical_groups')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('instructor_id')
                ->constrained('instructors')
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
        Schema::dropIfExists('lab_groups');
    }
};
