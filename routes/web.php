<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ExerciseController;
use App\Http\Controllers\Admin\TemplateController;

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


Route::get('/login', [AuthController::class,'login'])->name('admin.login');
Route::post('/login',[AuthController::class,'login_process'])->name('login-process');


Route::group(['middleware'=>'admins'],function(){

    Route::get('dashboard',[AuthController::class,'dashboard'])->name('dashboard');
    Route::get('logout',[AuthController::class,'logout'])->name('admin.logout');

    //Templates
    Route::get('exercises',[ExerciseController::class,'exercises'])->name('admin.exercises');
    Route::get('exercise/create',[ExerciseController::class,'createExercise'])->name('admin.exercise.create');
    Route::post('exercise/create',[ExerciseController::class,'storeExercise'])->name('admin.exercise.store');
    
   

});