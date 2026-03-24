<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instructor_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->nullable()->index();
            $table->string('phone', 20);
            $table->string('expertise');
            $table->unsignedSmallInteger('experience_years')->nullable();
            $table->text('bio');
            $table->string('portfolio', 500)->nullable();
            $table->boolean('agreed_terms')->default(false);
            $table->string('status')->default('submitted')->index();
            $table->text('review_notes')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable()->index();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('decision_at')->nullable();
            $table->unsignedBigInteger('instructor_id')->nullable()->index();
            $table->string('source')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instructor_applications');
    }
};
