<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lecture_recordings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('topic')->nullable();
            $table->date('class_date');
            $table->string('google_drive_url', 2048);
            $table->text('description')->nullable();
            $table->boolean('is_published')->default(true);
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['course_id', 'class_date']);
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lecture_recordings');
    }
};
