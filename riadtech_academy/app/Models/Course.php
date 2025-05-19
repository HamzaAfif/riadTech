<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'number_of_tasks',
        'number_of_exams',
        'number_of_projects',
    ];

    public function students()
        {
            return $this->belongsToMany(Student::class, 'student_course_assignments')
                        ->withPivot('progress', 'status')
                        ->withTimestamps();
        }


}
