<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'login', 'email', 'password', 'birthdate', 'teacher_id', 'parent_id', 'class_id',
    ];

    protected $hidden = ['password'];

    protected $dates = ['birthdate'];
    
    // Relations
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function parent()
    {
        return $this->belongsTo(StudentParent::class, 'parent_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'student_course_assignments')
                    ->withPivot('progress', 'status')
                    ->withTimestamps();
    }

    public function courseAssignments()
    {
        return $this->hasMany(StudentCourseAssignment::class);
    }


}
