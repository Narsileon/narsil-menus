<?php

#region USE

use Illuminate\Support\Facades\Route;
use Narsil\Tables\Http\Controllers\ResourceCreateController;
use Narsil\Tables\Http\Controllers\ResourceEditController;

#endregion

Route::prefix('backend')->name('backend.')->middleware([
    'web',
    'auth',
    'verified',
    'can:backend_view',
])->group(function ()
{
    Route::get('menus/create', ResourceCreateController::class)
        ->name('resources.create');
    Route::get('menus/{id}/edit', ResourceEditController::class)
        ->name('resources.edit');
});
