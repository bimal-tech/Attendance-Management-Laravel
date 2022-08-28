<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StaffController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\TeacherController;
use App\Http\Controllers\AttendanceController;
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
Route::post('edit/user/{user_id}',[UserController::class,'update']); //post request
Route::get('edit/user/{user_id}',[UserController::class,'edit']); //get request
Route::delete('/delete/user/{user_id}',[UserController::class,'destroy']);

Route::get('all_teacher',[TeacherController::class,'index']);
Route::post('edit/teacher/{teacher_id}',[TeacherController::class,'update']); //post request
Route::get('edit/teacher/{teacher_id}',[TeacherController::class,'edit']); //get request
Route::delete('/delete/teacher/{teacher_id}',[TeacherController::class,'destroy']);

Route::get('all_student',[StudentController::class,'index']);
Route::post('edit/student/{student_id}',[StudentController::class,'update']); //post request
Route::get('edit/student/{student_id}',[StudentController::class,'edit']); //get request
Route::delete('/delete/student/{student_id}',[StudentController::class,'destroy']);

Route::get('all_staff',[StaffController::class,'index']);
Route::post('edit/staff/{staff_id}',[StaffController::class,'update']); //post request
Route::get('edit/staff/{staff_id}',[StaffController::class,'edit']); //get request
Route::delete('/delete/staff/{staff_id}',[StaffController::class,'destroy']);


Route::get('/dashboard',[AttendanceController::class,'dashboard']);
Route::get('all/attendance',[AttendanceController::class,'index']); //get request
Route::post('store/attendance',[AttendanceController::class,'store']); //get request


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
