<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CrController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\GoogleAuthController;   // fixed namespace
use App\Http\Controllers\GoogleDriveController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/register', 'welcome');
Route::post('/Registration', [StudentController::class, 'Registration'])->name('Register');
Route::view('/login', 'login');
Route::get('/Login', [StudentController::class, 'Login'])->name('login');
Route::get('/student/logout', [StudentController::class, 'Logout'])->name('student.logout');
Route::view('/chatbot','student.chatbot')->name('chatbot');
Route::match(['get', 'post'], '/student/chatbot', [StudentController::class, 'ChatBot'])->name('student.chatbot');

Route::middleware(['auth', RoleMiddleware::class . ':student'])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');
    Route::get('/student/Materials',[StudentController::class,'MaterialsData'])->name('student.Materials');

    //previous year
    Route::get('/student/previousmaterials',[StudentController::class,'PreviousMaterials'])->name('student.PreviousMaterials');
});

Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->name('admin.dashboard');
    Route::post('/subjects/store', [AdminController::class, 'store'])->name('subjects.store');

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

# ---------------- Google Login (for CR Authentication) ----------------
Route::get('/auth/google/login', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);


# ---------------- Google Drive (for file upload integration) ----------------
Route::get('/auth/google/drive', [GoogleDriveController::class, 'redirectToGoogle'])->name('google.drive');
Route::get('/auth/google/drive/callback', [GoogleDriveController::class, 'handleGoogleCallback']);


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

    //Normal Study Materials
    Route::get('/cr/study-materials',[CrController::class,'MaterialsData'])->name('cr.GetFiles');
    Route::get('/cr/Materials',[CrController::class,'MaterialsData'])->name('cr.Materials');
    Route::get('/cr/previousmaterials',[CrController::class,'PreviousMaterials'])->name('cr.PreviousMaterials');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/subjects', [AdminController::class, 'SubjectsData'])->name('subjects'); // admin.subjects
    Route::post('/subjects', [AdminController::class, 'store'])->name('subjects.store'); // admin.subjects.store
    Route::put('/subjects/{id}', [AdminController::class, 'update'])->name('subjects.update'); // admin.subjects.update
    Route::delete('/subjects/{id}', [AdminController::class, 'destroy'])->name('subjects.destroy'); // admin.subjects.destroy
});
