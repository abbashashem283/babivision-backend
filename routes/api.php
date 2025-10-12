<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix("auth")->controller(AuthController::class)->group(
    function () {
        Route::post("/login","login")->name("auth.login");
        Route::post("/logout","logout")->name("auth.logout");
        Route::post("/refresh","refresh")->name("auth.refresh");
        Route::post("/register","register")->name("auth.register");
        Route::post("/password/forgot-password", "forgotPassword")->name("auth.password.forgot");
        Route::post("/password/check-code", "checkPasswordCode")->name("auth.password.code");
        Route::post("/password/reset", "resetPassword")->name("auth.password.reset");
        Route::get("/verify","verify")->name("auth.verify");
        Route::get("/test", "test");
        Route::post("/test", "test2");
        Route::get("/user", "user")->name("auth.user");
    });

Route::get('/appointments', [AppointmentController::class, 'appointments'])  ;  

Route::get('/services', [ServiceController::class, 'services']);
Route::get('/clinics', [ClinicController::class, 'clinics']);