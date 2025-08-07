<?php

use App\Actions\ExportTranslations;
use App\Http\Controllers\Orion\TranslationController;
use Illuminate\Support\Facades\Route;
use Orion\Facades\Orion;

Route::middleware('auth:sanctum')->group(function () {
    Orion::resource('translations', TranslationController::class)->only('store', 'update', 'index', 'search', 'show');
});

Route::namespace('\App\Actions')->group(function () {
    Route::post('/translations/export/{lang?}', ExportTranslations::class)->middleware(['auth:sanctum', \App\Http\Middleware\ApiLocalization::class]);
});
