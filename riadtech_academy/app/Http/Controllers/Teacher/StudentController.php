<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::where('teacher_id', Auth::guard('teacher')->id())->get();
        return view('teacher.students.index', compact('students'));
    }

    public function create()
    {
        return view('teacher.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'login' => 'required|unique:students',
            'password' => 'required',
            'email' => 'nullable|email',
            'birthdate' => 'nullable|date',
        ]);

        Student::create([
            'name' => $request->name,
            'login' => $request->login,
            'email' => $request->email,
            'birthdate' => $request->birthdate,
            'password' => Hash::make($request->password),
            'teacher_id' => Auth::guard('teacher')->id(),
        ]);

        return redirect()->route('teacher.students.index')->with('success', 'Student created successfully!');
    }
}
