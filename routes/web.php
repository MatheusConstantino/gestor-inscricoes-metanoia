<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrganizationController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', function () {
        return view('home'); // Or a dedicated dashboard view
    })->name('dashboard');

    Route::post('organizations/{organization}/toggle-status', [OrganizationController::class, 'toggleStatus'])->name('organizations.toggleStatus');
    Route::resource('organizations', OrganizationController::class);
});
