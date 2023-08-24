<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\WorkHistoryController;

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

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('/certificate', CertificateController::class);
    Route::apiResource('/education', EducationController::class);
    Route::apiResource('/experience', ExperienceController::class);
    Route::apiResource('/profile', ProfileController::class);
    Route::apiResource('/skill', SkillController::class);
    Route::apiResource('/work_history', WorkHistoryController::class);
    Route::post('/logout', [ApiAuthController::class, 'logout']);
});

Route::get('/users', [ApiAuthController::class, 'users']);
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);

