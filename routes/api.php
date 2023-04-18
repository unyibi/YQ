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

Route::middleware(['cross'])->group(function () {
    /**
     * 登录
     */
    Route::post("login", [\App\Http\Controllers\APi\LoginController::class, 'login']);
});

Route::middleware(['jwt', 'cross'])->group(function () {
    /**
     * 登录信息
     */
    Route::get("login/adminInfo", [\App\Http\Controllers\APi\LoginController::class, 'adminInfo']);

    /**
     * 栏目管理
     */
    Route::get("column/list", [\App\Http\Controllers\APi\ColumnController::class, 'index']);
    Route::get("column/read/{uuid}", [\App\Http\Controllers\APi\ColumnController::class, 'read']);
    Route::post("column/add", [\App\Http\Controllers\APi\ColumnController::class, 'save']);
    Route::post("column/edit/{uuid}", [\App\Http\Controllers\APi\ColumnController::class, 'update']);
    Route::post("column/delete", [\App\Http\Controllers\APi\ColumnController::class, 'delete']);
    Route::post("column/sort/{uuid}", [\App\Http\Controllers\APi\ColumnController::class, 'sort']);

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

    /**
     * 视频管理
     */
    Route::get("video/list", [\App\Http\Controllers\APi\VideoController::class, 'index']);
    Route::get("video/read/{uuid}", [\App\Http\Controllers\APi\VideoController::class, 'read']);
    Route::post("video/add", [\App\Http\Controllers\APi\VideoController::class, 'save']);
    Route::post("video/edit/{uuid}", [\App\Http\Controllers\APi\VideoController::class, 'update']);
    Route::post("video/delete", [\App\Http\Controllers\APi\VideoController::class, 'delete']);
    Route::post("video/sort/{uuid}", [\App\Http\Controllers\APi\VideoController::class, 'sort']);
    Route::post("video/top/{uuid}", [\App\Http\Controllers\APi\VideoController::class, 'top']);

    /**
     * 图片管理
     */
    Route::get("picture/list", [\App\Http\Controllers\APi\PictureController::class, 'index']);
    Route::get("picture/read/{uuid}", [\App\Http\Controllers\APi\PictureController::class, 'read']);
    Route::post("picture/add", [\App\Http\Controllers\APi\PictureController::class, 'save']);
    Route::post("picture/edit/{uuid}", [\App\Http\Controllers\APi\PictureController::class, 'update']);
    Route::post("picture/delete", [\App\Http\Controllers\APi\PictureController::class, 'delete']);
    Route::post("picture/sort/{uuid}", [\App\Http\Controllers\APi\PictureController::class, 'sort']);
    Route::post("picture/top/{uuid}", [\App\Http\Controllers\APi\PictureController::class, 'top']);

    /**
     * 账号管理
     */
    Route::get("admin/list", [\App\Http\Controllers\APi\AdminController::class, 'index']);
    Route::get("admin/read/{uuid}", [\App\Http\Controllers\APi\AdminController::class, 'read']);
    Route::post("admin/add", [\App\Http\Controllers\APi\AdminController::class, 'save']);
    Route::post("admin/edit/{uuid}", [\App\Http\Controllers\APi\AdminController::class, 'update']);
    Route::post("admin/delete", [\App\Http\Controllers\APi\AdminController::class, 'delete']);

    /**
     * 角色管理
     */
    Route::get("role/list", [\App\Http\Controllers\APi\RoleController::class, 'index']);
    Route::get("role/read/{uuid}", [\App\Http\Controllers\APi\RoleController::class, 'read']);
    Route::post("role/add", [\App\Http\Controllers\APi\RoleController::class, 'save']);
    Route::post("role/edit/{uuid}", [\App\Http\Controllers\APi\RoleController::class, 'update']);
    Route::post("role/delete", [\App\Http\Controllers\APi\RoleController::class, 'delete']);

    /**
     * 菜单管理
     */
    Route::get("permission/list", [\App\Http\Controllers\APi\PermissionController::class, 'index']);
    Route::get("permission/read/{uuid}", [\App\Http\Controllers\APi\PermissionController::class, 'read']);
    Route::post("permission/add", [\App\Http\Controllers\APi\PermissionController::class, 'save']);
    Route::post("permission/edit/{uuid}", [\App\Http\Controllers\APi\PermissionController::class, 'update']);
    Route::post("permission/delete", [\App\Http\Controllers\APi\PermissionController::class, 'delete']);

    /**
     * 文件上传
     */
    Route::post("upload/file", [\App\Http\Controllers\APi\UploadController::class, 'file']);
    Route::post("upload/image", [\App\Http\Controllers\APi\UploadController::class, 'image']);

});
