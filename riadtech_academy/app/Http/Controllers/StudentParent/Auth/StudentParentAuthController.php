<?php

namespace App\Http\Controllers\StudentParent\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentParent;

class StudentParentAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('student_parent.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('student_parent')->attempt($credentials)) {
            return redirect()->route('student_parent.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }

    public function showRegisterForm()
{
    return view('student_parent.auth.register');
}

public function register(Request $request)
{
    // Validate input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:student_parents',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // Create student parent
    $studentParent = StudentParent::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    // Auto-login after registration
    Auth::guard('student_parent')->login($studentParent);

    // Redirect to dashboard
    return redirect()->route('student_parent.dashboard');
}


    public function logout()
    {
        Auth::guard('student_parent')->logout();
        return redirect()->route('student_parent.login');
    }

    public function dashboard()
    {
        return view('student_parent.dashboard');
    }
}
