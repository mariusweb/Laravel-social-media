<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
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

Route::get(
    '/',
    function () {
        return view('welcome');
    }
);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::group(
    ['middleware' => 'auth'],
    function () {
        Route::get(
            '/dashboard',
            function () {
                return view('dashboard');
            }
        )->name('dashboard');

        Route::view('profile', './pages/profile')->name('profile');
        Route::view('edit-profile', './pages/edit-profile')->name('edit-profile');
        Route::view('create-post', './pages/create-post')->name('create-post');
        Route::resource('post', PostController::class);
        Route::resource('profile-edit', ProfileController::class);
    }
);

require __DIR__ . '/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
