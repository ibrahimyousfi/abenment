<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GymAdmin\MemberController;
use App\Http\Controllers\GymAdmin\TrainingTypeController;
use App\Http\Controllers\GymAdmin\PlanController;
use App\Http\Controllers\GymAdmin\ProductController;
use App\Http\Controllers\GymAdmin\DashboardController;
use App\Http\Controllers\GymAdmin\TrainingSessionController;
use App\Http\Controllers\GymAdmin\TrainerController;
use App\Http\Controllers\GymAdmin\InvoiceController;
use App\Http\Controllers\GymAdmin\ExpenseController;
use App\Http\Controllers\GymAdmin\FinancialReportController;
use App\Http\Controllers\GymAdmin\EquipmentController;
use App\Http\Controllers\GymAdmin\MaintenanceLogController;
use App\Http\Controllers\GymAdmin\SettingController;

Route::middleware(['auth', 'verified', 'gym_subscription'])->prefix('gym-admin')->name('gym.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Settings
    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Members
    Route::resource('members', MemberController::class);
    Route::get('/members/{member}/renew', [MemberController::class, 'renew'])->name('members.renew');
    Route::post('/members/{member}/renew', [MemberController::class, 'storeRenewal'])->name('members.storeRenewal');
    Route::put('/subscriptions/{subscription}', [MemberController::class, 'updateSubscription'])->name('subscriptions.update');
    Route::get('/members/export', [MemberController::class, 'export'])->name('members.export');
    Route::post('/members/bulk-message', [MemberController::class, 'bulkMessage'])->name('members.bulk_message');

    // Training Types & Plans
    Route::resource('training-types', TrainingTypeController::class);
    Route::resource('plans', PlanController::class)->except(['index', 'show']);

    // Trainers & Sessions
    Route::resource('trainers', TrainerController::class);
    Route::resource('sessions', TrainingSessionController::class);
    Route::post('/sessions/{session}/book', [TrainingSessionController::class, 'addBooking'])->name('sessions.book');
    Route::delete('/bookings/{booking}', [TrainingSessionController::class, 'removeBooking'])->name('bookings.destroy');

    // Invoices & Payments
    Route::resource('invoices', InvoiceController::class);
    Route::post('/invoices/{invoice}/payment', [InvoiceController::class, 'addPayment'])->name('invoices.payment');
    Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');

    // Expenses
    Route::resource('expenses', ExpenseController::class);

    // Equipment & Maintenance
    Route::resource('equipment', EquipmentController::class);
    Route::post('/equipment/{equipment}/maintenance', [MaintenanceLogController::class, 'store'])->name('equipment.maintenance.store');
    Route::put('/maintenance/{maintenanceLog}', [MaintenanceLogController::class, 'update'])->name('maintenance.update');
    Route::delete('/maintenance/{maintenanceLog}', [MaintenanceLogController::class, 'destroy'])->name('maintenance.destroy');

    // Products
    Route::resource('products', ProductController::class);

    // POS & Reports
    Route::get('/pos', [\App\Http\Controllers\GymAdmin\PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/checkout', [\App\Http\Controllers\GymAdmin\PosController::class, 'store'])->name('pos.store');
    Route::get('/pos/reports', [\App\Http\Controllers\GymAdmin\PosController::class, 'reports'])->name('pos.reports');

    // Financial Reports
    Route::get('/reports/financial', [FinancialReportController::class, 'index'])->name('reports.financial');
});
