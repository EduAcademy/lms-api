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
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->text('data')->nullable();
            $table->string('file_url')->nullable();

            $table->foreignId('assignment_status_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('assignment_status')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('assignment_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('assignments')
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
        Schema::dropIfExists('assignment_submissions');
    }
};
