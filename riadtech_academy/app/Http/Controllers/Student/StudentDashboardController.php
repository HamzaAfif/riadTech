<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentCourseAssignment;
use App\Models\Course;

class StudentDashboardController extends Controller
{
    public function index()
        {
            $student = Auth::guard('student')->user();

            // Get assigned courses
            $assignedCourses = StudentCourseAssignment::with('course')
                ->where('student_id', $student->id)
                ->get();

            return view('student.dashboard', compact('student', 'assignedCourses'));
        }
}
