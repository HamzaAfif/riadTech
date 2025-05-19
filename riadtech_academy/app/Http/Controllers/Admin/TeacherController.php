<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index() {
        $teachers = Teacher::all();
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create() {
        return view('admin.teachers.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:teachers,email',
            'password' => 'required|min:6',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        Teacher::create($validated);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher created.');
    }

    public function show(Teacher $teacher) {
        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher) {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher) {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
        ]);

        if ($request->password) {
            $validated['password'] = bcrypt($request->password);
        }

        $teacher->update($validated);
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated.');
    }

    public function destroy(Teacher $teacher) {
        $teacher->delete();
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted.');
    }
}
