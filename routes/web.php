<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MangaController;

Route::get('/', function () {
    return redirect()->route('mangas.index');
});

Route::resource('mangas', MangaController::class);
