<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;

Route::get("/", function () {
    return [
        'status' => true,
    ];
});

Route::middleware(['guest'])->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'getAuthUser']);

    Route::get('categories/all', [CategoryController::class, "getAll"]);
    Route::resource("products", ProductController::class)->only(["index", "store", "show", "update", "destroy"]);
    Route::resource("categories", CategoryController::class)->only(["index", "store", "show", "update", "destroy"]);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
