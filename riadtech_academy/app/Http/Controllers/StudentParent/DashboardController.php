<?php

namespace App\Http\Controllers\StudentParent;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Course;

class DashboardController extends Controller
{
    public function index()
    {
        $parentId = Auth::guard('student_parent')->id();

        $children = Student::where('parent_id', $parentId)->get();

        $courses = Course::all();

        return view('student_parent.dashboard', compact('children', 'courses'));
    }
}
