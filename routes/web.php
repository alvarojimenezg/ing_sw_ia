<?php

use App\Http\Controllers\RoleController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::get('/roles', [RoleController::class, 'index'])
        ->name('roles.dashboard')
        ->middleware(IsAdmin::class);

    Route::get('/roles/edit', [RoleController::class, 'create'])
        ->name('roles.create')
        ->middleware(IsAdmin::class);

    Route::put('/roles/edit', [RoleController::class, 'store'])
        ->name('roles.store')
        ->middleware(IsAdmin::class);

    Route::get('/roles/{id}', [RoleController::class, 'edit'])
        ->name('roles.edit')
        ->middleware(IsAdmin::class);;

    Route::put('/roles/{id}', [RoleController::class, 'update'])
        ->name('roles.update')
        ->middleware(IsAdmin::class);;

    Route::delete('/roles/{id}/delete', [RoleController::class, 'destroy'])
        ->name('roles.delete')
        ->middleware(IsAdmin::class);
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
