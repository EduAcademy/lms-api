<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->default(Str::uuid()->toString());

            $table->foreignId('department_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('departments')
                ->nullable(false)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('study_plan_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('study_plans')
                ->nullable(false)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('users')
                ->nullable(false)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();

            $table->foreignId('group_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('groups')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('sub_group_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('sub_groups')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
