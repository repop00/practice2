<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LoginOrNot;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('authenticate');
// });

Route::get('/',[UserController::class,'showloginform'])->name('showloginform')->middleware('guest');  
Route::post('/login',[UserController::class,'login'])->name('login')->middleware('guest');
Route::post('/register',[UserController::class,'register'])->name('register')->middleware('guest');


Route::get('/dashboard',[UserController::class,'dashboard'])->name('dashboard')->middleware('LoginOrNot'); 
Route::get('/logout',[UserController::class,'logout'])->name('logout')->middleware('LoginOrNot'); 

