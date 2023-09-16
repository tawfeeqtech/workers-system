<?php

use App\Http\Controllers\AdminDashboard\{AdminNotificationController, PostStatusController};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{AdminAuthController, ClientAuthController, ClientOrderController, PostController, WorkerAuthController, WorkerProfileController, WorkerReviewController};

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

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    Route::controller(PostStatusController::class)->prefix('post')->group(function () {
        Route::post('status', 'changeStatus');
    });

    Route::controller(AdminNotificationController::class)->prefix('notification')->group(function () {
        Route::get('all', 'index');
        Route::get('unread', 'unread');
        Route::post('markReadAll', 'markReadAll');
        Route::delete('deleteAll', 'deleteAll');
        Route::delete('delete/{id}', 'delete');
    });
});

Route::prefix('client')->group(function () {
    Route::controller(ClientOrderController::class)->prefix('order')->group(function () {
        Route::post('request', 'addOrder')->middleware(['auth:client']);
    });
});

Route::prefix('worker')->group(function () {
    Route::controller(PostController::class)->prefix('post')->group(function () {
        Route::get('single/{post_id}', 'viewPost');
        Route::post('add', 'store')->middleware('auth:worker');
        Route::get('show', 'index')->middleware('auth:admin');
        Route::get('approved', 'approved');
    });
    Route::controller(ClientOrderController::class)->prefix('orders')->middleware('auth:worker')->group(function () {
        Route::get('pendeing', 'workerOrder');
        Route::post('update/{id}', 'updateOrder');
    });

    Route::controller(WorkerReviewController::class)->prefix('reviews')->group(function () {
        Route::post('/', 'store')->middleware('auth:client');
        Route::get('post/{postId}', 'postRate')->middleware('auth:worker');
    });

    Route::controller(WorkerProfileController::class)->middleware('auth:worker')->prefix('profile')->group(function () {
        Route::get('', 'userProfile');
        Route::get('edit', 'edit');
        Route::post('update', 'update');
        Route::delete('posts/delete', 'delete');
    });
   
});
