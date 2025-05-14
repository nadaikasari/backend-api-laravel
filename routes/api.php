<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\NoteItemController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('jwt.auth')->group(function () {
    Route::get('/checklist', [NoteController::class, 'index']);
    Route::post('/checklist', [NoteController::class, 'store']);
    Route::put('/checklist/{id}', [NoteController::class, 'update']);
    Route::delete('/checklist/{id}', [NoteController::class, 'destroy']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/checklist/{noteId}/items', [NoteItemController::class, 'index']);
    Route::get('/checklist/{noteId}/item/{childNoteId}', [NoteItemController::class, 'getItemDetail']);
    Route::post('/checklist/{noteId}/items', [NoteItemController::class, 'store']);
    Route::delete('/checklist/{noteId}/item/{childNoteId}', [NoteItemController::class, 'deleteChildItem']);
});
