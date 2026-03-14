<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Real DB columns + virtual aliases used by controllers/views
    protected $fillable = [
        'name', 'title', 'slug', 'category', 'description',
        'short_description', 'level', 'image', 'image_path',
        'fee', 'registration_fee', 'total_fee',
        'outline', 'weekly_outline', 'course_units',
        'duration_weeks', 'schedule', 'mode',
        'is_featured', 'is_active',
    ];

    protected $casts = [
        'weekly_outline' => 'array',
        'course_units'   => 'array',
        'is_featured'    => 'boolean',
        'is_active'      => 'boolean',
    ];

    // ── Virtual aliases so existing views/controllers keep working ──

    /** $course->title → reads the real 'name' column */
    public function getTitleAttribute(): ?string
    {
        return $this->attributes['name'] ?? null;
    }

    /** Course::create(['title' => '...']) → writes to 'name' */
    public function setTitleAttribute(string $value): void
    {
        $this->attributes['name'] = $value;
    }

    /** $course->image → reads 'image_path' */
    public function getImageAttribute(): ?string
    {
        return $this->attributes['image_path'] ?? null;
    }

    /** Course::create(['image' => '...']) → writes to 'image_path' */
    public function setImageAttribute(?string $value): void
    {
        $this->attributes['image_path'] = $value;
    }

    /** $course->outline → reads 'weekly_outline' (decoded array) */
    public function getOutlineAttribute(): mixed
    {
        $raw = $this->attributes['weekly_outline'] ?? null;
        return $raw ? json_decode($raw, true) : null;
    }

    /** Course::create(['outline' => [...]]) → writes to 'weekly_outline' */
    public function setOutlineAttribute(mixed $value): void
    {
        $this->attributes['weekly_outline'] = is_array($value) ? json_encode($value) : $value;
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
