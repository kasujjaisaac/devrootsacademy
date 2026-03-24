<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentApplication extends Model
{
    use HasFactory;

    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_REVIEWED = 'reviewed';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_ENROLLED = 'enrolled';

    protected $fillable = [
        'full_name',
        'username',
        'email',
        'phone',
        'dob',
        'location',
        'course_id',
        'goals',
        'agreed_terms',
        'status',
        'review_notes',
        'reviewed_by',
        'reviewed_at',
        'decision_at',
        'student_id',
        'enrollment_id',
        'source',
    ];

    protected $casts = [
        'dob' => 'date',
        'agreed_terms' => 'boolean',
        'reviewed_at' => 'datetime',
        'decision_at' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
