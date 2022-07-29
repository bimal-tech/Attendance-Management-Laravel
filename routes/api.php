<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StaffController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register',[UserController::class,'store']);
Route::post('login',[AuthController::class,'login']);

Route::post('student_register',[StudentController::class,'store']);
Route::post('staff_register',[StaffController::class,'store']);
Route::post('teacher_register',[TeacherController::class,'store']);

Route::get('all_user',[UserController::class,'index']);
Route::get('all_teacher',[TeacherController::class,'index']);
Route::get('all_student',[StudentController::class,'index']);
Route::get('all_staff',[StaffController::class,'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
