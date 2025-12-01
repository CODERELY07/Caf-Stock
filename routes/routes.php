<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseOrderController;

Route::prefix('inventory')->group(function () {
    Route::get('/', [InventoryController::class, 'index']);
    Route::post('/', [InventoryController::class, 'store']);
    Route::post('/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::get('/{id}', [InventoryController::class, 'show'])->name('inventory.show');
    Route::get('/edit{id}', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

    Route::get('/alerts/low-stock', [InventoryController::class, 'lowStock'])->name('inventory.low-stock');;
    Route::get('/alerts/expiring', [InventoryController::class, 'expiringSoon'])->name('inventory.expiring');;
});

Route::middleware(['auth','role:admin,cordinator'])->group(function () {
    Route::post('/suppliers', [SupplierController::class, 'store']);
    Route::put('/suppliers/{id}', [SupplierController::class, 'update']);
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy']);
});

// Everyone logged in can view suppliers
Route::middleware(['auth','role:admin,staff,cordinator,auditor'])->group(function () {
    Route::get('/suppliers', [SupplierController::class, 'index']);
    Route::get('/suppliers/{id}', [SupplierController::class, 'show']);
});

// Purchase Order routes
// Create / update / receive / delete only admin and procurement
Route::middleware(['auth','role:admin,cordinator'])->group(function () {
  Route::post('/purchase-orders', [PurchaseOrderController::class, 'store']);

    Route::put('/purchase-orders/{id}', [PurchaseOrderController::class, 'update']); 
    Route::post('/purchase-orders/{id}/receive', [PurchaseOrderController::class, 'receive']);
    Route::delete('/purchase-orders/{id}', [PurchaseOrderController::class, 'destroy']);
});

// View POs all authenticated (read access)
Route::middleware(['auth','role:admin,staff,cordinator,auditor'])->group(function () {
    Route::get('/purchase-orders', [PurchaseOrderController::class, 'index']);
    Route::get('/purchase-orders/{id}', [PurchaseOrderController::class, 'show']);
});

