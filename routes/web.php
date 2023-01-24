<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseController;
use App\Http\Middleware\CustomAuth;
use Kreait\Laravel\Firebase\Facades\Firebase;

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
    
    Route::prefix("/presence")->group(function() {
        Route::get("/create", [FirebaseController::class, "presenceCreate"])->name("presence.create");
        Route::get("/{uid}", [FirebaseController::class, "presenceDetail"])->name("presence.detail");
        Route::post("/{uid}/update", [FirebaseController::class, "presenceUpdate"])->name("presence.update");
    });

    Route::prefix("/student")->group(function() {
        Route::get("/", [FirebaseController::class, 'studentHandler'])->name("students.index");
        Route::get("/create", [FirebaseController::class, "studentsCreate"])->name("students.create");
    });

    Route::post("/out", [FirebaseController::class, 'out'])->name("out");
});

require __DIR__.'/auth.php';