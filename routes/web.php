<?php

use App\Http\Controllers\pengaturan\PengaturanIndexController;
use App\Http\Controllers\pengaturan\ProfilSekolahController;
use App\Http\Controllers\pengaturan\ProfilUserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('welcome_page');
})->name('welcome');

Route::get('/enjoy', function () {
    return Inertia::render('enjoy_page');
})->name('enjoy');

Route::group(['prefix' => 'pengaturan', 'as' => 'pengaturan.'], function () {
    Route::resource('profil-sekolah', ProfilSekolahController::class);
    Route::resource('profil-user', ProfilUserController::class);
});
