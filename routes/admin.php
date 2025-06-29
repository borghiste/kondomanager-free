<?php

use App\Http\Controllers\Anagrafiche\AnagraficaController;
use App\Http\Controllers\Comunicazioni\ComunicazioneApprovalController;
use App\Http\Controllers\Comunicazioni\ComunicazioneController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Documenti\CategoriaDocumentoController;
use App\Http\Controllers\Documenti\DocumentoApprovalController;
use App\Http\Controllers\Documenti\DocumentoController;
use App\Http\Controllers\Documenti\FetchCategorieController;
use App\Http\Controllers\Notifications\NotificationPreferenceController;
use App\Http\Controllers\Segnalazioni\SegnalazioneApprovalController;
use App\Http\Controllers\Segnalazioni\SegnalazioneController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->middleware(['auth', 'verified', 'role_or_permission:amministratore|collaboratore|Accesso pannello amministratore'])->group(function () {

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/fetch-categorie-documenti', FetchCategorieController::class)
        ->name('categorie.documenti');
    
    Route::resource('anagrafiche', AnagraficaController::class);
   
    Route::resource('segnalazioni', SegnalazioneController::class)->parameters([
        'segnalazioni' => 'segnalazione'
    ]);
    
    Route::resource('comunicazioni', ComunicazioneController::class)->parameters([
        'comunicazioni' => 'comunicazione'
    ]);

    Route::resource('documenti', DocumentoController::class)->parameters([
        'documenti' => 'documento'
    ]);

    Route::post('documenti/{documento}', [DocumentoController::class, 'update'])
    ->name('documenti.update'); // Same name used by Inertia

    Route::get('documenti/{documento}/download', [DocumentoController::class, 'download'])
        ->name('documenti.download');

    Route::post('/categorie-documento', [CategoriaDocumentoController::class, 'store'])->name('categorie.store');

    Route::put('documenti/{documento}/toggle-approval', DocumentoApprovalController::class)
        ->name('documenti.toggle-approval');

    Route::put('comunicazioni/{comunicazione}/toggle-approval', ComunicazioneApprovalController::class)
        ->name('comunicazioni.toggle-approval');

    Route::put('segnalazioni/{segnalazione}/toggle-approval', SegnalazioneApprovalController::class)
        ->name('segnalazioni.toggle-approval');
    
    Route::post('segnalazioni/{segnalazione}/toggle-resolve', [SegnalazioneController::class, 'toggleResolve'])
        ->name('segnalazioni.toggleResolve');
   
    Route::get('settings/notifications', [NotificationPreferenceController::class, 'index'])
        ->name('settings.notifications.index');
    
    Route::put('settings/notifications', [NotificationPreferenceController::class, 'update'])
        ->name('settings.notifications.update');
});