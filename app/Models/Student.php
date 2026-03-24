<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_number',
        'full_name',
        'username',
        'dob',
        'location',
        'email',
        'phone',
        'course_interest',
        'goals',
        'agreed_terms',
        'status',
    ];

    protected $casts = [
        'agreed_terms' => 'boolean',
        'dob'          => 'date',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public static function generateStudentNumber(): string
    {
        $prefix = 'DRA/'.now()->format('Y').'/';
        $latest = static::query()
            ->where('student_number', 'like', $prefix.'%')
            ->orderByDesc('student_number')
            ->value('student_number');

        $nextSequence = 1;

        if ($latest && preg_match('/(\d+)$/', $latest, $matches)) {
            $nextSequence = ((int) $matches[1]) + 1;
        }

        return $prefix.str_pad((string) $nextSequence, 4, '0', STR_PAD_LEFT);
    }
}
