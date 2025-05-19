<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentCourseAssignment;
use App\Models\Course;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

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

        public function startCourse($slug)
        {
            $student = Auth::guard('student')->user();
            $course = Course::where('slug', $slug)->firstOrFail();

            $assignment = StudentCourseAssignment::where('student_id', $student->id)
                            ->where('course_id', $course->id)
                            ->first();

            if ($assignment && $assignment->status === 'not_started') {
                $assignment->status = 'in_progress';
                $assignment->save();
            }

            $path = public_path("courses/{$slug}/index.html");

            if (!File::exists($path)) {
                abort(404, 'Course content not found.');
            }

            return response()->file($path);
        }
}
