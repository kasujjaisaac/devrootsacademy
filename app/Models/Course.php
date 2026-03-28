<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'category', 'description', 'short_description',
        'image', 'fee', 'outline',
        'level', 'duration_weeks', 'schedule', 'enrollment_close_date', 'mode',
        'is_featured', 'is_active',
    ];

    protected $casts = [
        'outline'     => 'array',
        'enrollment_close_date' => 'date',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function lectureRecordings()
    {
        return $this->hasMany(LectureRecording::class);
    }

    public function enrollmentStatus(): array
    {
        if (! $this->enrollment_close_date instanceof CarbonInterface) {
            return [
                'label' => 'Open',
                'tone' => 'open',
                'message' => 'Enrollment is open',
            ];
        }

        if ($this->enrollment_close_date->isPast()) {
            return [
                'label' => 'Closed',
                'tone' => 'closed',
                'message' => 'Enrollment closed '.$this->enrollment_close_date->format('M d, Y'),
            ];
        }

        if (now()->diffInDays($this->enrollment_close_date, false) <= 7) {
            return [
                'label' => 'Closing soon',
                'tone' => 'closing',
                'message' => 'Enrollment closes '.$this->enrollment_close_date->format('M d, Y'),
            ];
        }

        return [
            'label' => 'Open',
            'tone' => 'open',
            'message' => 'Enrollment closes '.$this->enrollment_close_date->format('M d, Y'),
        ];
    }
}
