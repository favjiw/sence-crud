<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseController;
use App\Http\Middleware\CustomAuth;
use App\Http\Middleware\AdminOnly;
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
        Route::get("/pending", [FirebaseController::class, "pendingPresenceHandler"])->name("presence.pending");

        Route::get("/create", [FirebaseController::class, "presenceCreate"])->name("presence.create");
        Route::get("/{uid}", [FirebaseController::class, "presenceDetail"])->name("presence.detail");
        Route::post("/{uid}/update", [FirebaseController::class, "presenceUpdate"])->name("presence.update");

        Route::post("/{uid}/approve", [FirebaseController::class, "presenceApprove"])->name("presence.approve");
    });

    Route::prefix("/student")->group(function() {
        Route::get("/", [FirebaseController::class, 'studentHandler'])->name("student.index");
        Route::get("/create", [FirebaseController::class, "studentCreate"])->name("student.create");
        Route::post("/insert", [FirebaseController::class, "studentInsert"])->name("student.insert");

        Route::post("/{uid}/update", [FirebaseController::class, "studentUpdate"])->name("student.update");
        Route::get("/{uid}", [FirebaseController::class, "studentDetail"])->name("student.detail");
        Route::get("/{uid}/edit", [FirebaseController::class, "studentEdit"])->name("student.edit");

        Route::post("/{uid}/delete", [FirebaseController::class, "studentDelete"])->name("student.delete");
    });

    Route::group(["middleware" => "adminonly"], function() {
        Route::prefix("/teacher")->group(function() {
            Route::get("/", [FirebaseController::class, "teacherHandler"])->name("teacher.index");
            Route::get("/create", [FirebaseController::class, "teacherCreate"])->name("teacher.create");
            Route::post("/insert", [FirebaseController::class, "teacherInsert"])->name("teacher.insert");
    
            Route::get("/{uid}", [FirebaseController::class, "teacherDetail"])->name("teacher.detail");
            Route::post("/{uid}/update", [FirebaseController::class, "teacherUpdate"])->name("teacher.update");
    
            Route::post("/{uid}/delete", [FirebaseController::class, "teacherDelete"])->name("teacher.delete");
        });
    
        Route::prefix("/class")->group(function() {
            Route::get("/", [FirebaseController::class, "classHandler"])->name("class.index");
            Route::get("/create", [FirebaseController::class, "classCreate"])->name("class.create");
            Route::post("/insert", [FirebaseController::class, "classInsert"])->name("class.insert");
    
            Route::get("/{uid}", [FirebaseController::class, "classDetail"])->name("class.detail");
            Route::post("/{uid}/update", [FirebaseController::class, "classUpdate"])->name("class.update");
    
            Route::post("/{uid}/delete", [FirebaseController::class, "classDelete"])->name("class.delete");
        });
    });

    Route::post("/out", [FirebaseController::class, 'out'])->name("out");
});

require __DIR__.'/auth.php';