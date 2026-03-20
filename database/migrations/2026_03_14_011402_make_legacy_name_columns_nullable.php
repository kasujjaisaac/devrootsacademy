<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Make legacy name columns nullable so form submissions that only
        // provide full_name do not fail the NOT NULL constraint.
        if (Schema::hasColumn('students', 'first_name') || Schema::hasColumn('students', 'last_name')) {
            Schema::table('students', function (Blueprint $table) {
                if (Schema::hasColumn('students', 'first_name')) {
                    $table->string('first_name', 191)->nullable()->change();
                }
                if (Schema::hasColumn('students', 'last_name')) {
                    $table->string('last_name', 191)->nullable()->change();
                }
            });
        }

        if (Schema::hasColumn('instructors', 'first_name') || Schema::hasColumn('instructors', 'last_name')) {
            Schema::table('instructors', function (Blueprint $table) {
                if (Schema::hasColumn('instructors', 'first_name')) {
                    $table->string('first_name', 191)->nullable()->change();
                }
                if (Schema::hasColumn('instructors', 'last_name')) {
                    $table->string('last_name', 191)->nullable()->change();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('students', 'first_name') || Schema::hasColumn('students', 'last_name')) {
            Schema::table('students', function (Blueprint $table) {
                if (Schema::hasColumn('students', 'first_name')) {
                    $table->string('first_name', 191)->nullable(false)->change();
                }
                if (Schema::hasColumn('students', 'last_name')) {
                    $table->string('last_name', 191)->nullable(false)->change();
                }
            });
        }

        if (Schema::hasColumn('instructors', 'first_name') || Schema::hasColumn('instructors', 'last_name')) {
            Schema::table('instructors', function (Blueprint $table) {
                if (Schema::hasColumn('instructors', 'first_name')) {
                    $table->string('first_name', 191)->nullable(false)->change();
                }
                if (Schema::hasColumn('instructors', 'last_name')) {
                    $table->string('last_name', 191)->nullable(false)->change();
                }
            });
        }
    }
};
