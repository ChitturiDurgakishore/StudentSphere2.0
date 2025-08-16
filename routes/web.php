<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CrController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\GoogleDriveController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/register', 'welcome');
Route::post('/Registration', [StudentController::class, 'Registration'])->name('Register');
Route::view('/login', 'login');
Route::get('/Login', [StudentController::class, 'Login'])->name('Login');


Route::middleware(['auth', RoleMiddleware::class . ':student'])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');
    Route::get('/student/Materials',[StudentController::class,'MaterialsData'])->name('student.Materials');
    Route::get('/student/logout', [StudentController::class, 'Logout'])->name('student.logout');
});

Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Users Routings
    Route::get('/admin/users/search', [AdminController::class, 'viewUsers'])->name('admin.view-users');
    Route::get('/admin/users', [AdminController::class, 'UsersData'])->name('admin.users');
    Route::patch('/admin/demote-cr/{id}', [AdminController::class, 'demoteCR'])->name('admin.demote-cr');
    Route::patch('/admin/promote-student/{id}', [AdminController::class, 'promoteStudent'])->name('admin.promote-student');

    // Subjects Routing
    Route::get('/admin/subjects', [AdminController::class, 'SubjectsData'])->name('admin.subjects');
    Route::get('/admin/files',[AdminController::class,'UploadedFilesData'])->name('admin.UploadedFiles');
    Route::delete('/admin/files/{id}', [AdminController::class, 'deleteFileDb'])->name('admin.deleteFileDb');
});


Route::middleware(['auth', RoleMiddleware::class . ':cr'])->group(function () {
    Route::get('/cr/dashboard', function () {
        return view('cr.dashboard');
    })->name('cr.dashboard');

    Route::get('/cr/logout', [StudentController::class, 'Logout'])->name('cr.logout');

    Route::get('/cr/upload-files', [CrController::class, 'UploadPage'])->name('cr.Upload');

    // Handle CR File Upload
    Route::post('/cr/upload-files', [CrController::class, 'UploadFile'])->name('cr.UploadFile');



    Route::get('/cr/uploaded-files', [CrController::class, 'UploadedFilesCheck'])->name('cr.UploadedFilesCheck');

    // Uploaded page changing files
    Route::delete('/cr/delete-file/{id}', [CrController::class, 'deleteFile'])->name('cr.deleteFile');
    Route::post('/cr/replace-file/{id}', [CrController::class, 'replaceFile'])->name('cr.replaceFile');

    Route::get('/cr/logout', [StudentController::class, 'Logout'])->name('cr.logout');
});
 // Google OAuth Routes
    Route::get('/auth/google', [GoogleDriveController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleDriveController::class, 'handleGoogleCallback']);
