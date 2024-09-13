<?php

#region USE

use Illuminate\Support\Facades\Route;
use Narsil\Menus\Http\Controllers\MenuCreateController;
use Narsil\Menus\Http\Controllers\MenuEditController;

#endregion

Route::prefix('backend')->name('backend.')->middleware([
    'web',
    'auth',
    'verified',
    'can:backend_view',
])->group(function ()
{
    Route::get('menus/create', MenuCreateController::class)
        ->name('menus.create');
    Route::get('menus/{id}/edit', MenuEditController::class)
        ->name('menus.edit');
});
