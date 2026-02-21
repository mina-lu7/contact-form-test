<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', [ContactController::class, 'index']);
Route::post('/confirm', [ContactController::class, 'confirm']);
Route::post('/thanks', [ContactController::class, 'store']);
Route::post('/back', [ContactController::class, 'back']);

Route::get('/thanks', function () {
    return view('contact.thanks');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminContactController::class, 'index']);
    Route::get('/search', [AdminContactController::class, 'search']);
    Route::get('/reset', [AdminContactController::class, 'index']);
    Route::get('/admin/contacts/{id}', [AdminContactController::class, 'show']);
    Route::post('/delete', [AdminContactController::class, 'destroy']);
    Route::get('/export', [AdminContactController::class, 'export'])->name('export');
});
