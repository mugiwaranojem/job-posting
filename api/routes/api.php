<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobSeekerController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobModeratorController;

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

Route::get('/version', function () {
    return app()->version();
});

Route::get('/jobs/{id}', [JobSeekerController::class, 'show']);
Route::get('/jobs', [JobSeekerController::class, 'allJobPosts']);

Route::post('/jobs', [EmployerController::class, 'postJob']);

Route::post('/jobs/sync', [JobModeratorController::class, 'syncJobs']);
