<?php

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


Route::middleware(['jwt', 'cross'])->group(function () {

    /**
     * 文章管理
     */
    Route::get("article/list", [\App\Http\Controllers\APi\ArticleController::class, 'index']);
    Route::get("article/read/{uuid}", [\App\Http\Controllers\APi\ArticleController::class, 'read']);
    Route::post("article/add", [\App\Http\Controllers\APi\ArticleController::class, 'save']);
    Route::post("article/edit/{uuid}", [\App\Http\Controllers\APi\ArticleController::class, 'update']);
    Route::post("article/delete", [\App\Http\Controllers\APi\ArticleController::class, 'delete']);
    Route::post("article/sort/{uuid}", [\App\Http\Controllers\APi\ArticleController::class, 'sort']);
    Route::post("article/top/{uuid}", [\App\Http\Controllers\APi\ArticleController::class, 'top']);
});
