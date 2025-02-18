<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', fn() => redirect()->route('filament.admin.pages.dashboard'));
Route::get('storageLink', function () {
    Artisan::call('storage:link');
});
Route::get('migrate', function () {
    Artisan::call('migrate');
});
