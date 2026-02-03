<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

            protected $fillable = [
            'full_name',
            'username',
            'dob',
            'location',
            'email',
            'phone',
            'course_interest',
            'motivation',
            'agreed_terms',
            'status',
        ];

}
