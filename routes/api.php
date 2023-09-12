<?php

use App\Http\Controllers\AdminDashboard\AdminNotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{AdminAuthController, ClientAuthController, PostController, WorkerAuthController};

// middleware(['DbBackup'])-> سبب مشكلة ارسال الرسالة على البريد مرتين
Route::prefix('auth')->group(function () {
    Route::controller(AdminAuthController::class)->prefix('admin')->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
    });

    Route::controller(WorkerAuthController::class)->prefix('worker')->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::get('verify/{token}', 'verify');

        // Route::post('forget-password', 'forgetPassword');
    });

    Route::controller(ClientAuthController::class)->prefix('client')->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::get('verify/{token}', 'verify');
    });
});

Route::get('/unauthorized', function () {
    return response()->json([
        'message' => "Unauthenticated.",
    ], 401);
})->name('login');


Route::controller(PostController::class)->prefix('worker/post')->group(function () {
    Route::post('add', 'store')->middleware('auth:worker');
});

Route::controller(AdminNotificationController::class)->middleware(['auth:admin'])->prefix('admin/notification')->group(function () {
    Route::get('all', 'index');
    Route::get('unread', 'unread');
    Route::post('markReadAll', 'markReadAll');
    Route::delete('deleteAll', 'deleteAll');
    Route::delete('delete/{id}', 'delete');
});