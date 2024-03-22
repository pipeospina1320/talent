<?php

use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProgramParticipantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Route::middleware(['auth:sanctum'], function () {


Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index');
    Route::post('/users', 'store');
    Route::patch('/users/{id}', 'update');
    Route::delete('/users/{id}', 'destroy');
});

Route::controller(ChallengeController::class)->group(function () {
    Route::get('/challenges', 'index');
    Route::post('/challenges', 'store');
    Route::patch('/challenges/{id}', 'update');
    Route::delete('/challenges/{id}', 'destroy');
});

Route::controller(CompanyController::class)->group(function () {
    Route::get('/companies', 'index');
    Route::post('/companies', 'store');
    Route::patch('/companies/{id}', 'update');
    Route::delete('/companies/{id}', 'destroy');
});

Route::controller(ProgramController::class)->group(function () {
    Route::get('/programs', 'index');
    Route::post('/programs', 'store');
    Route::patch('/programs/{id}', 'update');
    Route::delete('/programs/{id}', 'destroy');
});

Route::controller(ProgramParticipantController::class)->group(function () {
    Route::get('/program-participants', 'index');
    Route::post('/program-participants', 'store');
    Route::patch('/program-participants/{id}', 'update');
    Route::delete('/program-participants/{id}', 'destroy');
});

// });
