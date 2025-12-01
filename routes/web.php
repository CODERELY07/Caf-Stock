<?php


use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuditorController;
use App\Http\Controllers\CordinatorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'staff') {
        return redirect()->route('staff.dashboard');
    } elseif ($user->role === 'cordinator') {
        return redirect()->route('cordinator.dashboard');
    } elseif ($user->role === 'auditor') {
        return redirect()->route('auditor.dashboard');
    }
    

    abort(403, 'Unauthorized access to dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Multi dashboard auth
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware(['auth', 'role:admin']);
Route::get('/staff/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard')->middleware(['auth', 'role:staff']);
Route::get('/cordinator/dashboard', [CordinatorController::class, 'dashboard'])->name('cordinator.dashboard')->middleware(['auth', 'role:cordinator']);
Route::get('/auditor/dashboard', [AuditorController::class, 'dashboard'])->name('auditor.dashboard')->middleware(['auth', 'role:auditor']);

// admin
Route::prefix('admin')->group(function(){
    Route::get('/users', function(){
        return view('admin.users');
    })->name('admin.users');
  
});
// staff
Route::prefix('staff')->group(function(){
    Route::get('/tasks', function (){
        return view('staff.tasks');
    })->name('staff.tasks');

});
// cordinator
Route::prefix('cordinator')->group(function(){
    Route::get('/projects', function (){
        return view('cordinator.projects');
    })->name('cordinator.projects');

});

// auditor
Route::prefix('auditor')->group(function(){
    Route::get('/reports', function (){
        return view('auditor.reports');
    })->name('auditor.reports');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/routes.php';
require __DIR__.'/auth.php';
