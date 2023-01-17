<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseController;
use App\Http\Middleware\CustomAuth;

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

Route::get("/login", [FirebaseController::class, "login"])->name("login");
Route::post("/login", [FirebaseController::class, "loginHandler"])->name("login.store");

Route::group(['middleware' => "customauth"], function () {
    Route::get('/', [FirebaseController::class, 'retrieve'])->name("dashboard");
    Route::get("/student", [FirebaseController::class, 'studentHandler']);

    Route::post("/out", [FirebaseController::class, 'out'])->name("out");
});

require __DIR__.'/auth.php';