<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\ProfileController;

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

Route::post('/order', [OrderController::class, 'store'])->name('frontend.order.store');
Route::get('/orders', [OrderController::class, 'listOrder'])->name('frontend.order');

// Route::middleware(['can:cashier', 'auth'])->group(function () { 
    // Route::get('user/me', [ProfileController::class, 'me']);
// });