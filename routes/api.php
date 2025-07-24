<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CourseController;
use App\Http\Controllers\api\ContentController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\api\FileUploadController;
use App\Http\Controllers\LoginController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::get('menu/{id}', [InformationController::class, 'menu']);
Route::get('session', [InformationController::class, 'session']);
Route::get('menu2', [InformationController::class, 'menu2']);


Route::post('/upload', [FileUploadController::class, 'upload']);
Route::get('courses', [CourseController::class, 'index']);
Route::get('courses/{id}', [CourseController::class, 'show']);
Route::get('preview-course/{id}', [CourseController::class, 'preview']);
Route::post('courses', [CourseController::class, 'store']);
Route::put('courses/{id}', [CourseController::class, 'update']);
Route::delete('courses/{id}', [CourseController::class, 'destroy']);

Route::get('categories', [CourseController::class, 'categories']);

Route::get('/course/contents/{courseId}', [ContentController::class, 'index']);
Route::get('/contents/{id}', [ContentController::class, 'show']);
Route::post('/contents', [ContentController::class, 'store']);
Route::put('/contents/{id}', [ContentController::class, 'update']);
Route::delete('/contents/{id}', [ContentController::class, 'destroy']);

Route::post('login', [LoginController::class, 'aksiLogin']);
