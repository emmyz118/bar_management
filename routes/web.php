<?php

use App\Livewire\Dashboard;
use App\Livewire\ListBeverages;
use App\Livewire\ManageOrders;
use App\Livewire\ManageTables;
use App\Livewire\ManageBeverages;
use App\Livewire\ManageReservations;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'livewire.admin.profile')
    ->middleware(['auth'])
    ->name('profile');
    Route::get('/admin/beverages', ManageBeverages::class)->middleware(['auth', 'verified'])->name('admin.beverages');
     Route::get('/admin/tables', ManageTables::class)->middleware(['auth', 'verified'])->name('admin.tables');
    Route::get('/admin/orders', ManageOrders::class)->middleware(['auth', 'verified'])->name('admin.orders');
    Route::get('/admin/reservations', ManageReservations::class)->middleware(['auth', 'verified'])->name('admin.reservations');
    Route::get('/client/beverages', ListBeverages::class)->name('client.beverages');
require __DIR__.'/auth.php';