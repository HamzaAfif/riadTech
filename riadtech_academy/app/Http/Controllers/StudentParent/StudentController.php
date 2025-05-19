<?php

namespace App\Http\Controllers\StudentParent;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class StudentController extends Controller
{
    public function create()
    {
        return view('student_parent.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'email' => 'nullable|email|max:255',
        ]);

        
        $login = strtolower(Str::slug($request->name)) . rand(100, 999);
        $passwordPlain = Str::random(8); 

        $student = Student::create([
            'name' => $request->name,
            'birthdate' => $request->birthdate,
            'email' => $request->email,
            'login' => $login,
            'password' => Hash::make($passwordPlain),
            'parent_id' => auth()->id(),  
        ]);

        
        return redirect()->route('student_parent.dashboard')->with('new_student_password', [
            'login' => $student->login,
            'password' => $passwordPlain,
            'name' => $student->name,
        ]);
    }

    public function generatePassword(Student $student)
        {
            $parentId = auth()->guard('student_parent')->id();
            
            if ($student->parent_id !== $parentId) {
                abort(403, 'Unauthorized action.');
            }

            $newPassword = Str::random(8);

            $student->password = Hash::make($newPassword);
            $student->save();

            return redirect()->back()->with('generated_password', [
                'student_id' => $student->id,
                'login' => $student->login,
                'password' => $newPassword,
                'name' => $student->name,
            ]);
        }

        public function assignCourse(Request $request)
            {
                $request->validate([
                    'student_id' => 'required|exists:students,id',
                    'course_id' => 'required|exists:courses,id',
                ]);

                $student = Student::findOrFail($request->student_id);

                if ($student->parent_id !== auth('student_parent')->id()) {
                    abort(403, 'Unauthorized');
                }

                $student->courses()->syncWithoutDetaching([
                    $request->course_id => ['progress' => 0, 'status' => 'not_started']
                ]);

                return back()->with('success', 'Course assigned to student!');
            }


}
