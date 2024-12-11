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

    // Detail Assistance
    Route::resource('detailAssistance', App\Http\Controllers\Admin\DetailAssistanceController::class);
    Route::get('export/assistance', [App\Http\Controllers\Admin\DetailAssistanceController::class, 'export'])->name('export.assistance');

    // Work
    // Route::resource('work', App\Http\Controllers\Admin\WorkController::class);

    // Person
    Route::resource('person', App\Http\Controllers\Admin\PersonController::class);
    Route::get('preview/person', [App\Http\Controllers\Admin\PersonController::class, 'previewAll'])->name('preview.all');
    Route::get('preview/low-income', [App\Http\Controllers\Admin\PersonController::class, 'previewLowIncome'])->name('preview.low_income');
    Route::get('export/person', [App\Http\Controllers\Admin\PersonController::class, 'exportAll'])->name('export.all');
    Route::get('export/low-income', [App\Http\Controllers\Admin\PersonController::class, 'exportLowIncome'])->name('export.low_income');

    // Recipient
    Route::resource('recipient', App\Http\Controllers\Admin\RecipientController::class);
    Route::get('/qr-code/scan', [App\Http\Controllers\Admin\RecipientController::class, 'showScanPage'])->name('qr-code.scan');
    Route::get('/qr-code/barcode/{recipient}', [App\Http\Controllers\Admin\RecipientController::class, 'showBarcodePage'])->name('qr-code.barcode');
    Route::post('/qr-code/verification', [App\Http\Controllers\Admin\RecipientController::class, 'verificationQrCode'])->name('qr-code.verification');
    Route::post('/qr-code/scanned/{recipient}', [App\Http\Controllers\Admin\RecipientController::class, 'scanned']);
    Route::get('export/recipient', [App\Http\Controllers\Admin\RecipientController::class, 'export'])->name('export.recipient');
    Route::put('reset/recipient/{recipient}', [App\Http\Controllers\Admin\RecipientController::class, 'reset'])->name('reset.recipient');

    // Recipient Log
    Route::get('log/recipient', [App\Http\Controllers\Admin\RecipientLogController::class, 'index'])->name('log.recipient');
    Route::get('log/export', [App\Http\Controllers\Admin\RecipientLogController::class, 'export'])->name('log.export');

    // Information
    Route::resource('information', App\Http\Controllers\Admin\InformationController::class);

    // Profile
    Route::resource('profile', App\Http\Controllers\Admin\ProfileController::class);

    // User
    Route::resource('user', App\Http\Controllers\Admin\UserController::class);

    // Role
    Route::resource('role', App\Http\Controllers\Admin\RoleController::class);
});
