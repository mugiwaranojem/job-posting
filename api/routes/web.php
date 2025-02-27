<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\JobModeratorController;

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

Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('auth.logout');

Route::post('testmail', [MailController::class, 'testMail']);

Route::get('/jobs/{token}/approve', [JobModeratorController::class, 'approveJobPost'])->name('jobs.approve');
Route::get('/jobs/{token}/spam', [JobModeratorController::class, 'markSpamJobPost'])->name('jobs.spam');

