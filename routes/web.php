<?php

use App\Http\Controllers\ArchiveController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\USERSController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\LandingController;


Route::get('/', [LandingController::class, 'index']);
// API routes are defined in api.php
Route::get('/test-route', function () {
    return response()->json(['message' => 'API is working!']);
});

// Authentication Routes
Route::get('/login', [LandingController::class, 'login'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/add-tenant', [AdminController::class, 'addTenant'])->name('add-tenant');
    Route::post('/store-tenant', [AdminController::class, 'storeTenant'])->name('store-tenant');
    Route::post('/archive-tenant/{id}', [AdminController::class, 'archiveTenant'])->name('archive-tenant');
    Route::post('/extend-tenant/{id}', [AdminController::class, 'extendTenant'])->name('extend-tenant');
    Route::post('/clear-tenant-data', [AdminController::class, 'clearTenantData'])->name('clear-tenant-data');
    Route::get('/archive', [AdminController::class, 'showArchive'])->name('archive');
    Route::get('/maintenance-requests', [AdminController::class, 'maintenanceRequests'])->name('maintenance-requests');
    Route::post('/maintenance-requests/{id}/update-status', [AdminController::class, 'updateRequestStatus'])->name('update-request-status');
    Route::match(['delete', 'post'], '/maintenance-requests/{id}', [AdminController::class, 'deleteMaintenanceRequest'])->name('delete-maintenance-request');
    Route::get('/manage-dorm', [AdminController::class, 'manageDorm'])->name('manage-dorm');
    Route::post('/update-dorm-settings', [AdminController::class, 'updateDormSettings'])->name('update-dorm-settings');
    Route::get('/payment-history', [AdminController::class, 'paymentHistory'])->name('payment-history');
    Route::post('/record-payment', [AdminController::class, 'recordPayment'])->name('record-payment');
    Route::delete('/delete-tenant/{id}', [AdminController::class, 'deleteTenantById'])->name('delete-tenant');
    Route::delete('/delete-archived-tenant/{id}', [AdminController::class, 'deleteArchivedTenant'])->name('delete-archived-tenant');
    Route::post('/tenants', [AdminController::class, 'store'])->name('store-tenants');
});

// Tenant Routes
Route::prefix('tenant')->name('tenant.')->middleware('auth:tenant')->group(function () {
    Route::get('/homepage', [TenantController::class, 'homepage'])->name('homepage');
    Route::get('/dorm-rules', [TenantController::class, 'dormRules'])->name('dorm-rules');
    Route::get('/request', [TenantController::class, 'maintenanceRequest'])->name('request');
    Route::post('/submit-request', [TenantController::class, 'submitRequest'])->name('submit-request');
    Route::post('/change-password', [TenantController::class, 'changePassword'])->name('change-password');
});

// Dashboard redirect based on user type
Route::get('/dashboard', function() {
    if (auth()->guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    } elseif (auth()->guard('tenant')->check()) {
        return redirect()->route('tenant.homepage');
    } else {
        return redirect('/');
    }
})->name('dashboard');
