<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    public const STATUS_PENDING_ADMIN = 'pending_admin';
    public const STATUS_PENDING_STUDENT = 'pending_student';
    public const STATUS_RESOLVED = 'resolved';

    public const CATEGORY_ADMISSIONS = 'admissions';
    public const CATEGORY_FINANCE = 'finance';
    public const CATEGORY_TIMETABLE = 'timetable';
    public const CATEGORY_TECHNICAL = 'technical';
    public const CATEGORY_GENERAL = 'general';

    protected $fillable = [
        'user_id',
        'admin_id',
        'reference',
        'subject',
        'category',
        'priority',
        'status',
        'last_message_at',
        'resolved_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public static function categories(): array
    {
        return [
            self::CATEGORY_ADMISSIONS => 'Admissions',
            self::CATEGORY_FINANCE => 'Finance',
            self::CATEGORY_TIMETABLE => 'Timetable',
            self::CATEGORY_TECHNICAL => 'Technical Support',
            self::CATEGORY_GENERAL => 'General Help',
        ];
    }

    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING_ADMIN => 'Pending Admin',
            self::STATUS_PENDING_STUDENT => 'Pending Student',
            self::STATUS_RESOLVED => 'Resolved',
        ];
    }
}
