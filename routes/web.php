<?php

use Illuminate\Support\Facades\Route;

Route::get('/',  ['App\Http\Controllers\User\DashboardController', 'index'])->name('user.dashboard');
Route::get('/search', ['App\Http\Controllers\User\DashboardController', 'search'])->name('user.search');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {

    // Dashboard
    Route::get('/dashboard', ['App\Http\Controllers\Admin\DashboardController', 'index'])->name('dashboard');

    // Village
    Route::resource('village', App\Http\Controllers\Admin\VillageController::class);

    // Assistance
    Route::resource('assistance', App\Http\Controllers\Admin\AssistanceController::class);

    // Work
    Route::resource('work', App\Http\Controllers\Admin\WorkController::class);

    // Person
    Route::resource('person', App\Http\Controllers\Admin\PersonController::class);
    Route::get('export/person', [App\Http\Controllers\Admin\PersonController::class, 'exportAll'])->name('export.all');
    Route::get('export/low-income', [App\Http\Controllers\Admin\PersonController::class, 'exportLowIncome'])->name('export.low_income');

    // Recipient
    Route::resource('recipient', App\Http\Controllers\Admin\RecipientController::class);
    Route::get('qr-code/{recipient}', [App\Http\Controllers\Admin\RecipientController::class, 'download'])->name('qr-code');
    Route::get('qr-code/refresh/{recipient}', [App\Http\Controllers\Admin\RecipientController::class, 'refreshQrCode']);
    Route::post('/qr-code/verification', [App\Http\Controllers\Admin\RecipientController::class, 'verificationQrCode'])->name('qr-code.verification');
    Route::post('/qr-code/status', [App\Http\Controllers\Admin\RecipientController::class, 'checkQrCodeStatus'])->name('qr-code.status');
    Route::get('export/recipient', [App\Http\Controllers\Admin\RecipientController::class, 'export'])->name('export.recipient');

    // Profile
    Route::resource('profile', App\Http\Controllers\Admin\ProfileController::class);

    // User
    Route::resource('user', App\Http\Controllers\Admin\UserController::class);

    // Role
    Route::resource('role', App\Http\Controllers\Admin\RoleController::class);
});
