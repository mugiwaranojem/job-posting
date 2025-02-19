<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Models\Job;

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

Route::get('/jobs/{job}/approve', function (Job $job) {
    $job->update(['status' => 'approved']);
    return redirect('/dashboard')->with('success', 'Job approved successfully!');
})->name('jobs.approve');

Route::get('/jobs/{job}/spam', function (Job $job) {
    $job->update(['status' => 'spam']);
    return redirect('/dashboard')->with('error', 'Job marked as spam!');
})->name('jobs.spam');
