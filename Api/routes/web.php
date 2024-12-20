<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\PasswordResetController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Front\Auth\FrontLoginController;
use App\Http\Controllers\Front\Auth\FrontPasswordResetController;
use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//====================> Front Route Start =========================
Route::get('/', [FrontLoginController::class, 'showLoginForm'])->name('front.showLoginForm');
Route::get('login', [FrontLoginController::class, 'showLoginForm'])->name('front.showLoginForm');
Route::post('login', [FrontLoginController::class, 'login'])->name('front.login');
Route::get('resetPassword', [FrontPasswordResetController::class, 'showPasswordRest'])->name('front.resetPassword');
Route::post('create', [FrontPasswordResetController::class, 'create'])->name('front.sendLinkToUser');
Route::get('find/{token}', [FrontPasswordResetController::class, 'find'])->name('front.find');
Route::post('reset', [FrontPasswordResetController::class, 'reset'])->name('front.resetPassword_set');
Route::group(['prefix' => 'front', 'middleware' => 'Front', 'namespace' => 'Front', 'as' => 'front.'], function () {
    //====================> Auth Front Route Start =========================
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/logout', [FrontLoginController::class, 'logout'])->name('logout');
    //====================> Auth Front Route Start =========================
});
//====================> Front Route End =========================

//====================> Backend Route Start =========================
Route::get('admin', [LoginController::class, 'showLoginForm'])->name('admin.showLoginForm');
Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('admin.showLoginForm');
Route::post('admin/login', [LoginController::class, 'login'])->name('admin.login');
Route::get('admin/resetPassword', [PasswordResetController::class, 'showPasswordRest'])->name('admin.resetPassword');
Route::post('admin/create', [PasswordResetController::class, 'create'])->name('admin.sendLinkToUser');
Route::get('admin/find/{token}', [PasswordResetController::class, 'find'])->name('admin.find');
Route::post('admin/reset', [PasswordResetController::class, 'reset'])->name('admin.resetPassword_set');
Route::group(['prefix' => 'admin', 'middleware' => 'Admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    //====================> Auth Backend Route Start =========================
    Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/profile', [UsersController::class, 'updateProfile'])->name('profile');
    Route::post('/updateProfileDetail', [UsersController::class, 'updateProfileDetail'])->name('updateProfileDetail');
    Route::post('/updatePassword', [UsersController::class, 'updatePassword'])->name('updatePassword');
    // =========================== User Management Controller ================================
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/', [UsersController::class, 'index'])->name('index');
        Route::get('/create', [UsersController::class, 'create'])->name('create');
        Route::post('/store', [UsersController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [UsersController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [UsersController::class, 'delete'])->name('delete');
        Route::get('/show', [UsersController::class, 'show'])->name('show');
        Route::post('/changeStatus', [UsersController::class, 'changeStatus'])->name('changeStatus');
    });
    //====================> Auth Backend Route End =========================
});
//====================> Backend Route End =========================
