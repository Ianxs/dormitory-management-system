<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->get('/test-api', function (Request $request) {
    return response()->json(['message' => 'API route is working']);
});
Route::get('/available-rooms', [AdminController::class, 'getAvailableRooms']);
Route::post('/add-tenant', [AdminController::class, 'storeTenant']);
