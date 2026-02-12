<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\SuperAdminController;

Route::middleware(['auth', 'super_admin'])->prefix('super-admin')->name('super_admin.')->group(function () {
    Route::get('/', [SuperAdminController::class, 'index'])->name('dashboard');

    // Gyms Management
    Route::get('/gyms', [SuperAdminController::class, 'indexGyms'])->name('gyms.index');
    Route::get('/gyms/create', [SuperAdminController::class, 'createGym'])->name('gyms.create');
    Route::post('/gyms', [SuperAdminController::class, 'storeGym'])->name('gyms.store');
    Route::get('/gyms/{gym}', [SuperAdminController::class, 'showGymDetails'])->name('gyms.show');
    Route::get('/gyms/{gym}/edit', [SuperAdminController::class, 'editGym'])->name('gyms.edit');
    Route::put('/gyms/{gym}', [SuperAdminController::class, 'updateGym'])->name('gyms.update');
    Route::patch('/gyms/{gym}/toggle', [SuperAdminController::class, 'toggleGymStatus'])->name('gyms.toggle');
    Route::patch('/gyms/{gym}/extend', [SuperAdminController::class, 'extendSubscription'])->name('gyms.extend');
    Route::delete('/gyms/{gym}', [SuperAdminController::class, 'destroyGym'])->name('gyms.destroy');
    Route::post('/gyms/{id}/restore', [SuperAdminController::class, 'restoreGym'])->name('gyms.restore');
    Route::post('/gyms/bulk-destroy', [SuperAdminController::class, 'bulkDestroyGym'])->name('gyms.bulk_destroy');

    // Users Management
    Route::get('/users', [SuperAdminController::class, 'indexUsers'])->name('users.index');

    // Reports
    Route::get('/reports', [SuperAdminController::class, 'indexReports'])->name('reports.index');
});
