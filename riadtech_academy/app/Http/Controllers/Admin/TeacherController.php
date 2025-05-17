<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // Show list of teachers
    public function index()
    {
        // Get all teachers, paginate 10 per page
        $teachers = Teacher::paginate(10);

        // Pass teachers to the view
        return view('admin.teachers.index', compact('teachers'));
    }

    // Show create teacher form
    public function create()
    {
        return view('admin.teachers.create');
    }

    // Save new teacher
    public function store(Request $request)
    {
        // Validate the input - Laravel auto throws errors if invalid
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'password' => 'required|string|min:6|confirmed', // password_confirmation field must match
        ]);

        // Create the teacher, hash password
        Teacher::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        // Redirect back to list with success message
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher created successfully!');
    }

    // Show edit teacher form
    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    // Update teacher info
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:teachers,email,{$teacher->id}",
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $teacher->name = $validated['name'];
        $teacher->email = $validated['email'];

        if (!empty($validated['password'])) {
            $teacher->password = bcrypt($validated['password']);
        }

        $teacher->save();

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated successfully!');
    }

    // Delete a teacher
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted successfully!');
    }
}
