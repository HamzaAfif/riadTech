<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCourseTask extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'task_key',
        'status',
        'xp_earned',
        'submitted_code',
        'completed_at',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
