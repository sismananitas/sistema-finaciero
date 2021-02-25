<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [ WelcomeController::class, 'render' ])->name('welcome');

Route::get('/dashboard', [ HomeController::class, 'render' ])->name('dashboard');

Route::get('/cuentas', [ AccountsController::class, 'render' ])->name('accounts');
Route::post('/accounts', [ AccountsController::class, 'store' ])->name('accounts.store');

Route::get('/movimientos', [ TransactionsController::class, 'render' ])->name('transactions');
Route::post('/transactions', [ TransactionsController::class, 'store' ])->name('transactions.store');

Route::get('/panel-control', [ ControlPanelController::class, 'render' ])->name('control.panel');

Route::get('/permisos', [ PermissionsController::class, 'render' ])->name('permissions.render');
Route::post('/permissions', [ PermissionsController::class, 'store' ])->name('permissions.store');
Route::put('/permissions/{permission}', [ PermissionsController::class, 'update' ])->name('permissions.update');
Route::delete('/permissions/{permission}', [ PermissionsController::class, 'destroy' ])->name('permissions.destroy');

Route::get('/roles', [ RolesController::class, 'render' ])->name('roles.render');
Route::get('/roles/{role}', [ RolesController::class, 'show' ])->name('roles.show');
Route::post('/roles', [ RolesController::class, 'store' ])->name('roles.store');
Route::put('/roles/{role}', [ RolesController::class, 'update' ])->name('roles.update');
Route::delete('/roles/{role}', [ RolesController::class, 'destroy' ])->name('roles.destroy');

Route::post('/agregar-permiso/role/{role}', [ RolePermissionController::class, 'givePermission' ])->name('give.permission.role');
Route::post('/quitar-permiso/role/{role}',  [ RolePermissionController::class, 'revokePermission' ])->name('revoke.permission.role');