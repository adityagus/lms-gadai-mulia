<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\api\CourseController;
use App\Http\Controllers\api\MasterController;
use App\Http\Controllers\api\WizardController;
use App\Http\Controllers\api\ContentController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\migrasiDataController;
use App\Http\Controllers\api\FileUploadController;
use App\Http\Controllers\api\AnnouncementController;

/*
|--------------------------------------------------------------------------
| Web Routes (SPA + Session + CSRF)
|--------------------------------------------------------------------------
*/

// 🔹 Route test session
Route::get('/set-session', function () {
    session(['tes_db' => 'ini dari database']);
    return 'Session di-set';
});

Route::get('/get-session', function () {
    return session()->all();
});

Route::get('/session', function () {
    return response()->json([
        'auth' => session('auth'),
    ]);
});

// 🔹 Auth
Route::post('/login', [LoginController::class, 'aksiLogin']);
Route::post('/logout', [LoginController::class, 'logout']);

// 🔹 Information
Route::get('/menu/{id}', [InformationController::class, 'menu']);
Route::get('/menu2', [InformationController::class, 'menu2']);

// 🔹 File upload
Route::post('/upload', [FileUploadController::class, 'upload']);

// 🔹 Courses
Route::middleware(['web', 'api'])->prefix('api')->group(function () {
  Route::get('/courses', [CourseController::class, 'index']);
  Route::get('/courses/{id}', [CourseController::class, 'show']);
  Route::get('/preview-course/{id}', [CourseController::class, 'preview']);
  Route::post('/courses', [CourseController::class, 'store']);
  Route::put('/courses/{id}', [CourseController::class, 'update']);
  Route::delete('/courses/{id}', [CourseController::class, 'destroy']);
  Route::get('/categories', [CourseController::class, 'categories']);
  Route::get('/search', [CourseController::class, 'search']);
  // Overview endpoint
  Route::get('/overview', [OverviewController::class, 'index']);
  Route::get('/user-overview', [OverviewController::class, 'userOverview']);
});

// 🔹 Content
Route::get('/course/contents/{courseId}', [ContentController::class, 'index']);
Route::get('/contents/{id}', [ContentController::class, 'show']);
Route::post('/contents', [ContentController::class, 'store']);
Route::put('/contents/{id}', [ContentController::class, 'update']);
Route::delete('/contents/{id}', [ContentController::class, 'destroy']);

// 🔹 Announcements
Route::get('/announcements', [AnnouncementController::class, 'index']);
Route::get('/announcements/trash', [AnnouncementController::class, 'trash']);
Route::get('/announcement/{menu_id}', [AnnouncementController::class, 'detail']);
Route::get('/announcements/document/{document_id}', [AnnouncementController::class, 'documentById']);
Route::post('/announcements', [AnnouncementController::class, 'store']);
Route::post('/announcements/{document_id}', [AnnouncementController::class, 'update']);
Route::patch('/announcements/{document_id}/restore', [AnnouncementController::class, 'restore']);
Route::delete('/announcements/{document_id}', [AnnouncementController::class, 'destroy']);
Route::delete('/announcements/hardDelete/{document_id}', [AnnouncementController::class, 'hardDelete']);

// 🔹 Master data
Route::prefix('master')->group(function () {
    Route::get('jabatan', [MasterController::class, 'getJabatan']);
    Route::get('areas', [MasterController::class, 'getAreas']);
    Route::get('types/{id_menu}', [MasterController::class, 'getTypesByIdMenu']);
    Route::get('wilayah', [MasterController::class, 'getWilayah']);
    Route::get('cabang', [MasterController::class, 'getCabang']);
});

// 🔹 Wizard
Route::post('/wizard/step/{step}', [WizardController::class, 'saveStep']);
Route::get('/wizard/session', [WizardController::class, 'getSession']);
Route::post('/wizard/finish', [WizardController::class, 'finish']);

// 🔹 CSRF Token
Route::get('csrf-token', function (Request $request) {
    return response()->json(['csrf_token' => csrf_token()]);
});

// migrasi data


// 🔹 Catch-all for SPA (Vue/React/Next.js front-end)
// ⚠️ TARUH PALING BAWAH
Route::get('/{any}', function () {
    return view('app'); // resources/views/app.blade.php
})->where('any', '.*');
