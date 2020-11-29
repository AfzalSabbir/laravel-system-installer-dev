<?php


Route::get('/', [AfzalSabbir\SystemInstaller\Http\Controllers\SystemInstallerController::class, 'index'])->name('system.installer.init');
Route::get('/requirments', [AfzalSabbir\SystemInstaller\Http\Controllers\SystemInstallerController::class, 'requirments'])->name('system.installer.requirments');
Route::get('/directories', [AfzalSabbir\SystemInstaller\Http\Controllers\SystemInstallerController::class, 'directories'])->name('system.installer.directories');
Route::get('/setups', [AfzalSabbir\SystemInstaller\Http\Controllers\SystemInstallerController::class, 'setups'])->name('system.installer.setups');
Route::post('/finish', [AfzalSabbir\SystemInstaller\Http\Controllers\SystemInstallerController::class, 'finish'])->name('system.installer.finish');

Route::get('/migration', [AfzalSabbir\SystemInstaller\Http\Controllers\SystemInstallerController::class, 'migration'])->name('system.installer.migration');
Route::get('/check-database', [AfzalSabbir\SystemInstaller\Http\Controllers\SystemInstallerController::class, 'checkDatabase'])->name('system.installer.check.database');
Route::get('/check-mail', [AfzalSabbir\SystemInstaller\Http\Controllers\SystemInstallerController::class, 'checkMail'])->name('system.installer.check.mail');