<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

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






/* >>>>> Update BookList routes <<<<<< */
Route::resource('api/bookList', \App\Http\Controllers\UpdateBookListController::class, [
    'as' => 'api'
]);
Route::get('/', function () {
    return Inertia::render('Search');
})->name('default');


/* >>>>> Search books routes <<<<< */
Route::get('/import/book/list/admin', function () {
    return Inertia::render('Import');
})->name('import');



/* >>>>>Roles routes <<<<<< */

//Get all roles
Route::get('/roles', [\App\Http\Controllers\Roles\RoleController::class, 'index'])->middleware(['auth', 'isAdmin'])->name('roles.index');
//Roles api
Route::resource('api/roles', \App\Http\Controllers\Roles\ApiRoleController::class, [
    'as' => 'api'
])->middleware('auth');

/* >>>>>User routes <<<<<< */


//Get all users
Route::get('/users', [\App\Http\Controllers\Users\UserController::class, 'index'])->middleware(['auth', 'isAdmin'])->name('users.index');
//users api
Route::resource('api/users', \App\Http\Controllers\Users\ApiUserController::class, [
    'as' => 'api'
])->middleware('auth');
//Update user role
Route::patch('/api/users/{user}/roles', [\App\Http\Controllers\Users\ApiUserController::class, 'updateUserRole'])->middleware('auth')->name('api.users.roles.update');
Route::get('/api/users/{user}/roles', [\App\Http\Controllers\Users\ApiUserController::class, 'getUserRole'])->middleware('auth')->name('api.users.roles.show');

/* >>>>>Roles routes <<<<<< */
Route::get('landing', function () {
    return Inertia::render('SuperTest');
})->name('landing');



//Auth routes
Route::get('login', [\App\Http\Controllers\AuthController::class, 'redirectGoogleLogin'])->name('login');
Route::get('/google/callback', [\App\Http\Controllers\AuthController::class, 'handleGoogleCallback']);

