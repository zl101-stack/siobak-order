<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/menu/{table}', [MenuController::class, 'index']);
