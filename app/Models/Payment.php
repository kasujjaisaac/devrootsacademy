<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_REVERSED = 'reversed';

    protected $fillable = [
        'student_id',
        'course_id',
        'amount',
        'payment_method',
        'status',
        'gateway',
        'reference',
        'merchant_reference',
        'gateway_tracking_id',
        'currency',
        'description',
        'paid_at',
        'raw_response',
        'callback_payload',
        'ipn_payload',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'raw_response' => 'array',
        'callback_payload' => 'array',
        'ipn_payload' => 'array',
        'amount' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }
}
