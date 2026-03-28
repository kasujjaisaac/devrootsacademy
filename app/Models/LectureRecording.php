<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LectureRecording extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'topic',
        'class_date',
        'google_drive_url',
        'description',
        'is_published',
        'uploaded_by',
    ];

    protected $casts = [
        'class_date' => 'date',
        'is_published' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
