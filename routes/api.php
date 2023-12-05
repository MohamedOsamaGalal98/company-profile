<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ClientOpinionController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/projects', [ProjectController::class, 'index']);
// Route::post('/projects', [ProjectController::class, 'store']);
Route::get('/projects/{id}', [ProjectController::class, 'show']);
// Route::put('/projects/{id}', [ProjectController::class, 'update']);
// Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);


Route::get('/clientsopinion', [ClientOpinionController::class, 'index']);
// Route::post('/clientsopinion', [ClientOpinionController::class, 'store']);
Route::get('/clientsopinion/{id}', [ClientOpinionController::class, 'show']);
// Route::put('/clientsopinion/{id}', [ClientOpinionController::class, 'update']);
// Route::delete('/clientsopinion/{id}', [ClientOpinionController::class, 'destroy']);


// Route::get('/contactus', [ContactUsController::class, 'index']);
Route::post('/contactus', [ContactUsController::class, 'store']);
// Route::get('/contactus/{id}', [ContactUsController::class, 'show']);
// Route::put('/contactus/{id}', [ContactUsController::class, 'update']);
// Route::delete('/contactus/{id}', [ContactUsController::class, 'destroy']);

Route::get('/team', [TeamController::class, 'index']);
// Route::post('/team', [TeamController::class, 'store']);
Route::get('/team/{id}', [TeamController::class, 'show']);
// Route::put('/team/{id}', [TeamController::class, 'update']);
// Route::delete('/team/{id}', [TeamController::class, 'destroy']);
