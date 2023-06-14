<?php

use App\Http\Controllers\CourseController;
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

Route::middleware('auth:bearer')->prefix('courses')->as('courses.')->group(function () {
    Route::get('', [CourseController::class, 'index']);
    Route::post('refreshRate', [CourseController::class, 'refreshRate']);
    Route::get('{send_currency}/{receive_currency}', [CourseController::class, 'showRates']);
});
