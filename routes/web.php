<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () { return redirect('/book'); });
Route::get('/home', function () { return view('home'); });

Route::group([
    'middleware' => ['auth', 'verified', 'isAdmin', 'isActive'],
    'prefix' => 'admin'
    ], function () {
    Route::get('/user', [AdminController::class, 'user']);
    Route::get('/book', [AdminController::class, 'book']);
    Route::get('/statistics', [AdminController::class, 'statistics']);
    Route::get('/{user_id}/suspend', [AdminController::class, 'suspend']);
});

Route::group([
    'middleware' => ['auth', 'isActive', 'verified'],
    ], function () {
    Route::resource('/user', UsersController::class)->only(['show']);
    Route::resource('/book', BookController::class, ['except' => ['show', 'index']] );
    Route::resource('/category', CategoryController::class)->only(['store'])->middleware('isAdmin');
    Route::resource('/bookmark', BookmarkController::class);
    Route::resource('/report', ReportController::class);
    Route::resource('/review', ReviewController::class)->except('destroy');
    Route::get('/category/{category_id}/delete', [CategoryController::class, 'delete']);
    Route::get('/report/{book_id}/delete', [ReportController::class, 'delete']);
    Route::get('/review/{review_id}/destroy', [ReviewController::class, 'destroy'])->middleware('isAdmin');
    Route::get('/review/{book_id}/delete', [ReviewController::class, 'delete']);
});
Route::get('/confirmation', [UsersController::class, 'confirmation'])->middleware(['auth', 'verified']);
Route::get('/activity', [UsersController::class, 'activity']);
Route::resource('/profile', ProfileController::class)->middleware('auth');
Route::resource('/book', BookController::class)->only(['show', 'index'])->middleware('isActive');

Route::group([
    'middleware' => ['auth', 'isActive', 'verified'],
    'prefix' => 'user'
    ], function () {
    Route::get('/{user_id}/confirm', [UsersController::class, 'confirm_user']);
});
Route::resource('/user', UsersController::class)->only(['store']);

Route::group([
    'prefix' => 'action'
    ], function () {
    Route::post('/admin', [AdminController::class, 'action'])->middleware(['auth', 'verified', 'isAdmin']);
    Route::post('/user', [UsersController::class, 'action'])->middleware('auth');
    Route::post('/profile', [ProfileController::class, 'action'])->middleware('auth');
    Route::post('/book', [BookController::class, 'action'])->middleware(['auth', 'verified']);
    Route::post('/bookmark', [BookmarkController::class, 'action'])->middleware(['auth', 'verified']);
    Route::post('/report', [ReportController::class, 'action'])->middleware(['auth', 'verified']);
    Route::post('/notification', [NotificationController::class, 'action'])->middleware(['auth', 'verified']);
    Route::post('/general', [GeneralController::class, 'action']);
});

Route::group([
    'middleware' => ['auth', 'verified', 'isActive'],
    'prefix' => 'book'
    ], function () {
    Route::post('/quick_update', [BookController::class, 'quick_update']);
    Route::get('/{book_id}/delete', [BookController::class, 'delete'])->middleware('isAdmin');
});
Route::get('/{book_id}/{chapter_id}/read', [BookController::class, 'visit']);
Route::get('/notification/clear', [NotificationController::class, 'clear']);

Route::get('auth/google', [UsersController::class, 'google_login'])->name('google.login');
Route::get('auth/google/callback', [UsersController::class, 'google_callback'])->name('google.callback');
Route::post('auth/google/register', [UsersController::class, 'google_register']);
Route::post('/update_password', [UsersController::class, 'update_password']);

Auth::routes(['verify'=>true]);
