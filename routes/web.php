<?php

use App\Livewire\Dashboard;
use App\Livewire\ListTables;
use App\Livewire\UssdHandler;
use App\Livewire\ManageOrders;
use App\Livewire\ManageTables;
use App\Livewire\ListBeverages;
use App\Livewire\ManageBeverages;
use App\Livewire\ManageReservations;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\ussdClientController;
Route::view('/admin', 'welcome');

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
    Route::get('/', ListBeverages::class)->name('client.beverages');
    Route::get('/client/tables', ListTables::class)->name('client.tables');
   Route::post('/ussd', function (Request $request) {
    $text =request('text');
    $phoneNumber = request('phoneNumber');

    // Create an instance of the component and set the properties
    $component = app(UssdHandler::class);
    $component->mount($text, $phoneNumber);

    return $component->render();
});
require __DIR__.'/auth.php';