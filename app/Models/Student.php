<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_FINISHED = 'finished';
    public const STATUS_INACTIVE = 'inactive';

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

    public function syncLifecycleStatus(): void
    {
        $enrollmentStatuses = $this->enrollments()->pluck('status');

        if ($enrollmentStatuses->contains(Enrollment::STATUS_ACTIVE)) {
            $targetStatus = self::STATUS_ACTIVE;
        } elseif ($enrollmentStatuses->contains(Enrollment::STATUS_PENDING)) {
            $targetStatus = self::STATUS_PENDING;
        } elseif ($enrollmentStatuses->isNotEmpty() && $enrollmentStatuses->every(fn ($status) => $status === Enrollment::STATUS_COMPLETED)) {
            $targetStatus = self::STATUS_FINISHED;
        } elseif ($enrollmentStatuses->isNotEmpty() && $enrollmentStatuses->every(fn ($status) => $status === Enrollment::STATUS_CANCELLED)) {
            $targetStatus = self::STATUS_INACTIVE;
        } else {
            return;
        }

        if ($this->status !== $targetStatus) {
            $this->forceFill(['status' => $targetStatus])->save();
        }
    }
}
