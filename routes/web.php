<?php

use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/bukus/kategori/{kategori_id}', [BukuController::class, 'cari']);
