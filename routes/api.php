<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'login']);
Route::resource('/category', CategoryController::class);
Route::resource('/product', ProductController::class)->middleware(('auth:sanctum'));
Route::prefix('/menu')->group(function () {
    Route::get('/', [MenuController::class, 'index']);
    Route::get('/{id}', [MenuController::class, 'show']);
    Route::patch('/{id}', [MenuController::class, 'update'])->middleware(('auth:sanctum'));
    Route::delete('/{id}', [MenuController::class, 'destroy'])->middleware(('auth:sanctum'));
    Route::post('/', [MenuController::class, 'store'])->middleware(('auth:sanctum'));
});

Route::get('histories', [HistoryController::class, 'index']);
Route::post('command', [CommandeController::class, 'store']);
