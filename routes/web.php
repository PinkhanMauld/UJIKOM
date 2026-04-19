<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Operator\ItemController as OperatorItemController;
use App\Http\Controllers\Operator\UserController as OperatorUserController;
use App\Http\Controllers\Operator\LendingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'role:admin')->prefix('admin')->group(function (){
    Route::resource('categories', CategoryController::class);
    Route::resource('items', ItemController::class);
    Route::get('items{item}/lendings', [ItemController::class, 'lendings'])->name('item.lendings');
    Route::get('users/operators', [UserController::class, 'operatorIndex'])->name('users.operators');
    Route::post('users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::resource('users', UserController::class);
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('items-export', [ItemController::class, 'export'])->name('items.export');
    Route::get('users-export/admin', [UserController::class, 'exportAdmin'])->name('users.export.admin');
    Route::get('users-export/operator', [UserController::class, 'exportOperator'])->name('users.export.operator');

});

Route::middleware('auth', 'role:operator')->prefix('operator')->group(function () {
    Route::get('/operator/dashboard', function () {
        return 'HALAMAN OPERATOR';
    });
    // Route::resource('lendings', LendingController::class);
    Route::resource('lendings', LendingController::class);
    Route::put('lendings/{lending}/return', [LendingController::class, 'return'])->name('lendings.return');
    Route::get('items', [OperatorItemController::class, 'index'])->name('operator.items.index');
    Route::get('users', [OperatorUserController::class, 'edit'])->name('operator.users.edit');
    Route::put('users', [OperatorUserController::class, 'update'])->name('operator.users.update');
    Route::get('/{lending}/return', [LendingController::class, 'returnForm'])->name('lendings.return.form');
    Route::post('/{lending}/return', [LendingController::class, 'processReturn'])->name('lendings.return.process');
    Route::get('lendings-export', [LendingController::class, 'export'])->name('lendings.export');
});
require __DIR__.'/auth.php';
