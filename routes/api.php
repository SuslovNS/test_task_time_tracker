<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware'=>'auth:sanctum'], function (){
   Route::get('/projects', [\App\Http\Controllers\ProjectController::class, 'index']);
   Route::post('/projects', [\App\Http\Controllers\ProjectController::class, 'store']);
   Route::delete('/projects/{project}/delete', [\App\Http\Controllers\ProjectController::class, 'delete']);
   Route::get('/projects/{project}', [\App\Http\Controllers\ProjectController::class, 'show']);
   Route::patch('/projects/{project}/update', [\App\Http\Controllers\ProjectController::class, 'update']);
   Route::get('/projects/{project}/tasks', [\App\Http\Controllers\TaskController::class, 'index']);
   Route::post('/projects/{project}/tasks', [\App\Http\Controllers\TaskController::class, 'store']);
   Route::get('/projects/{project}/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'show']);
   Route::patch('/projects/{project}/tasks/{task}/start', [\App\Http\Controllers\TaskController::class, 'start']);
   Route::patch('/projects/{project}/tasks/{task}/pause', [\App\Http\Controllers\TaskController::class, 'pause']);
   Route::patch('/projects/{project}/tasks/{task}/stop', [\App\Http\Controllers\TaskController::class, 'stop']);
   Route::patch('/projects/{project}/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'update']);
   Route::delete('/projects/{project}/tasks/{task}/delete', [\App\Http\Controllers\TaskController::class, 'delete']);
});
