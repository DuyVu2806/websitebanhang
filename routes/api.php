<?php

use App\Http\Controllers\ImageClassificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/train-model', [ImageClassificationController::class, 'trainModel']);
Route::post('/classify-image', [ImageClassificationController::class, 'classifyImage']);
