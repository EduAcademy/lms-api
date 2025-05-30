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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->default(Str::uuid()->toString());
            $table->string('professional_title');
            $table->text('about_me');
            $table->text('social_links');

            $table->foreignId('user_id')
                ->unsignedBigInteger()
                ->references('id')
                ->on('users')
                ->nullable(false)
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
        Schema::dropIfExists('instructors');
    }
};
