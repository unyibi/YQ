<?php

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
     * 账号管理
     */
    Route::get("admin/list", [\App\Http\Controllers\Center\AdminController::class, 'index']);
    Route::get("admin/read/{uuid}", [\App\Http\Controllers\Center\AdminController::class, 'read']);
    Route::post("admin/add", [\App\Http\Controllers\Center\AdminController::class, 'save']);
    Route::post("admin/edit/{uuid}", [\App\Http\Controllers\Center\AdminController::class, 'update']);
    Route::post("admin/delete", [\App\Http\Controllers\Center\AdminController::class, 'delete']);

    /**
     * 角色管理
     */
    Route::get("role/list", [\App\Http\Controllers\Center\RoleController::class, 'index']);
    Route::get("role/read/{uuid}", [\App\Http\Controllers\Center\RoleController::class, 'read']);
    Route::post("role/add", [\App\Http\Controllers\Center\RoleController::class, 'save']);
    Route::post("role/edit/{uuid}", [\App\Http\Controllers\Center\RoleController::class, 'update']);
    Route::post("role/delete", [\App\Http\Controllers\Center\RoleController::class, 'delete']);
});
