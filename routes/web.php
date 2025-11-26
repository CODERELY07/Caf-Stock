<?php


use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuditorController;
use App\Http\Controllers\CordinatorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Multi dashboard auth
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware(['auth', 'role:admin']);
Route::get('/staff/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard')->middleware(['auth', 'role:staff']);
Route::get('/cordinator/dashboard', [CordinatorController::class, 'dashboard'])->name('cordinator.dashboard')->middleware(['auth', 'role:cordinator']);
Route::get('/auditor/dashboard', [AuditorController::class, 'dashboard'])->name('auditor.dashboard')->middleware(['auth', 'role:auditor']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
