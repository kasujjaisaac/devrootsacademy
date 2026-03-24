<?php

use App\Models\Student;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (! Schema::hasColumn('students', 'student_number')) {
                $table->string('student_number')->nullable()->unique()->after('user_id');
            }
        });

        Student::query()
            ->whereNull('student_number')
            ->orderBy('id')
            ->get()
            ->each(function (Student $student) {
                $student->update([
                    'student_number' => Student::generateStudentNumber(),
                ]);
            });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'student_number')) {
                $table->dropUnique(['student_number']);
                $table->dropColumn('student_number');
            }
        });
    }
};
