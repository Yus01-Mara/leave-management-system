<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\KetuaPegawaiApprovalController;
use App\Http\Controllers\PenolongPengarahApprovalController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('leave-requests', LeaveRequestController::class)->only([
        'index', 'create', 'store'
    ]);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('departments', DepartmentController::class)->except(['show']);
    Route::resource('leave-types', LeaveTypeController::class)->except(['show']);

    Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    Route::post('/approvals/{id}/approve', [ApprovalController::class, 'approve'])->name('approvals.approve');
    Route::post('/approvals/{id}/reject', [ApprovalController::class, 'reject'])->name('approvals.reject');

    Route::get('/reports/leave', [ReportController::class, 'leaveReport'])->name('reports.leave');
});

// Ketua Pegawai
Route::middleware(['auth'])->group(function () {
    Route::get('/ketua-approvals', [KetuaPegawaiApprovalController::class, 'index'])->name('ketua.approvals');
    Route::post('/ketua-approve/{id}', [KetuaPegawaiApprovalController::class, 'approve'])->name('ketua.approve');
    Route::post('/ketua-reject/{id}', [KetuaPegawaiApprovalController::class, 'reject'])->name('ketua.reject');
});

// Penolong Pengarah
Route::middleware(['auth'])->group(function () {
    Route::get('/penolong-approvals', [PenolongPengarahApprovalController::class, 'index'])->name('penolong.approvals');
    Route::post('/penolong-approve/{id}', [PenolongPengarahApprovalController::class, 'approve'])->name('penolong.approve');
    Route::post('/penolong-reject/{id}', [PenolongPengarahApprovalController::class, 'reject'])->name('penolong.reject');
});



require __DIR__.'/auth.php';