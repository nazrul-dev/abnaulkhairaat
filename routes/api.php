<?php


use App\Http\Controllers\GetLocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('get-district', GetLocationController::class)->name('get-district');
