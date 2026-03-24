<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('username', 100)->nullable()->index();
            $table->string('email')->nullable()->index();
            $table->string('phone', 20)->index();
            $table->date('dob')->nullable();
            $table->string('location')->nullable();
            $table->unsignedBigInteger('course_id')->nullable()->index();
            $table->text('goals')->nullable();
            $table->boolean('agreed_terms')->default(false);
            $table->string('status')->default('submitted')->index();
            $table->text('review_notes')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable()->index();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('decision_at')->nullable();
            $table->unsignedBigInteger('student_id')->nullable()->index();
            $table->unsignedBigInteger('enrollment_id')->nullable()->index();
            $table->string('source')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_applications');
    }
};
