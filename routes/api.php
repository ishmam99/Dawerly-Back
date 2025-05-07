<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MyFatoorahController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProvincesController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/payment/callback', [PaymentController::class, 'paymentCallback']);

Route::prefix('v1')->group(
    function () {
 Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->middleware('guest'); // Added middleware('guest') to allow unauthenticated access

    Route::group(['middleware'=>'auth:sanctum'] ,function () {
        Route::post('/logout', [AuthController::class, 'logout']);
            Route::get('/user-data', [AuthController::class, 'me']);
            Route::get('/getPaymentMethods', [PaymentController::class, 'getPaymentMethods']);
            Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment']);
            Route::post('/payment/callback', [PaymentController::class, 'paymentCallback']);
            Route::post('/delete-account', [AuthController::class, 'deleteAccount']);
    });
    Route::get('/provinces', [ProvincesController::class, 'index']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/category/{slug}', [CategoryController::class, 'show']);
    Route::get('/subcategory/{slug}', [SubCategoryController::class, 'show']);
Route::post('/send-otp', [AuthController::class, 'sendOtp']);
Route::post('/add-review', [ReviewController::class, 'store']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::get('technicians/{technician}', [\App\Http\Controllers\TechnicianController::class, 'show']);
Route::get('blogs', [BlogController::class, 'index']);
Route::get('blogs/{blog}', [BlogController::class, 'show']);
Route::get('images', [BlogController::class, 'images']);
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store']);
});
