<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\AuthController as TeacherAuthController;
use App\Http\Controllers\Admin\TeacherController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\Admin\ParentController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Auth routes
    Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/parents', [ParentController::class, 'index'])->name('parents'); // Fixed this line
        Route::resource('teachers', TeacherController::class);
    });
});








Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('teachers', TeacherController::class);
    Route::get('/admin/parents', [ParentController::class, 'index'])->name('admin.parents');
});



// Login and logout
Route::prefix('teacher')->group(function () {
    Route::get('/login', [TeacherAuthController::class, 'showLoginForm'])->name('teacher.login');
    Route::post('/login', [TeacherAuthController::class, 'login'])->name('teacher.login.submit');
    Route::post('/logout', [TeacherAuthController::class, 'logout'])->name('teacher.logout');

    // Protected teacher routes
    Route::middleware('auth:teacher')->group(function () {
        Route::get('/dashboard', function () {
            return view('teacher.dashboard');
        })->name('teacher.dashboard');
    });
});

use App\Http\Controllers\StudentParent\Auth\StudentParentAuthController;
use App\Http\Controllers\StudentParent\DashboardController;
use App\Http\Controllers\StudentParent\StudentController;

Route::prefix('parent')->name('student_parent.')->group(function () {

    // Guest routes
    Route::get('/login', [StudentParentAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [StudentParentAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [StudentParentAuthController::class, 'logout'])->name('logout');
    Route::get('/register', [StudentParentAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [StudentParentAuthController::class, 'register'])->name('register.submit');

    // Protected parent routes
    Route::middleware('auth:student_parent')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Student creation by parent
        Route::post('/students/{student}/generate-password', [StudentController::class, 'generatePassword'])->name('students.generate_password');
        Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/students', [StudentController::class, 'store'])->name('students.store');
        

    });
});

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);

});
Route::post('/parent/assign-course', [StudentController::class, 'assignCourse'])->name('student_parent.assign_course');


use App\Http\Controllers\Student\StudentAuthController;
use App\Http\Controllers\Student\StudentDashboardController;

Route::prefix('student')->name('student.')->group(function () {
    Route::get('login', [StudentAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [StudentAuthController::class, 'login'])->name('login.submit');
    Route::post('logout', [StudentAuthController::class, 'logout'])->name('logout');
    


    Route::middleware('auth:student')->group(function () {
        Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    });
});
