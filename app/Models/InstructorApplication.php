<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorApplication extends Model
{
    use HasFactory;

    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_REVIEWED = 'reviewed';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_ACTIVATED = 'activated';

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'expertise',
        'experience_years',
        'bio',
        'portfolio',
        'agreed_terms',
        'status',
        'review_notes',
        'reviewed_by',
        'reviewed_at',
        'decision_at',
        'instructor_id',
        'source',
    ];

    protected $casts = [
        'agreed_terms' => 'boolean',
        'experience_years' => 'integer',
        'reviewed_at' => 'datetime',
        'decision_at' => 'datetime',
    ];

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
