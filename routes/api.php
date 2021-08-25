<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\EtcController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\MonthlyInstallmentController;
use App\Http\Controllers\MonthlyExpenseController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('github?{users}', [GithubController::class, 'view']);
});

Route::group([
    'middleware' => (['auth:api', 'nameParameter', 'usernameLimit'])
], function () {
    Route::get('gusers', [GithubController::class, 'findUsers']);
});

Route::group([
    'middleware' => (['auth:api', 'postUsernameLimit'])
], function () {
    Route::post('githubUsers', [GithubController::class, 'findGitUsers']);
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Endpoint not found.',
    ], 404);
});

Route::get('hamming/v1', [EtcController::class, 'index']);
Route::get('hamming/v2', [EtcController::class, 'second']);


Route::resource('salaries', SalaryController::class);
Route::resource('monthlyInstallments', MonthlyInstallmentController::class);
Route::resource('monthlyExpenses', MonthlyExpenseController::class);