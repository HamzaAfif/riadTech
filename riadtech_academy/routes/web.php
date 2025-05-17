<?php

use Illuminate\Support\Facades\Route;

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


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->middleware('auth:admin')
        ->name('dashboard');
});

use App\Http\Controllers\Admin\TeacherController;

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('teachers', [TeacherController::class, 'index'])->name('admin.teachers.index');       // List teachers
    Route::get('teachers/create', [TeacherController::class, 'create'])->name('admin.teachers.create'); // Show form to create teacher
    Route::post('teachers', [TeacherController::class, 'store'])->name('admin.teachers.store');        // Save new teacher
    Route::get('teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('admin.teachers.edit'); // Show form to edit teacher
    Route::put('teachers/{teacher}', [TeacherController::class, 'update'])->name('admin.teachers.update'); // Update teacher
    Route::delete('teachers/{teacher}', [TeacherController::class, 'destroy'])->name('admin.teachers.destroy'); // Delete teacher
});

use App\Http\Controllers\Teacher\AuthController as TeacherAuthController;

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
