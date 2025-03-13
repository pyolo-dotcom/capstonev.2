<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeliveryRecordsController;
use App\Http\Controllers\ManageTripController;
use App\Http\Controllers\ManageGPSController;
use App\Http\Controllers\FuelController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActiveController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DeliveryManagerController;
use App\Http\Controllers\ManageTripManagerController;
use App\Http\Controllers\GPSControlController;
use App\Http\Controllers\FuelManagerController;
use App\Http\Controllers\ProfileManagerController;
use App\Http\Controllers\ArchiveManagerController;
use App\Http\Controllers\HelpManagerController;
use App\Http\Controllers\DeliveryDriverController;
use App\Http\Controllers\FuelDriverController;
use App\Http\Controllers\ShipmentDriverController;
use App\Http\Controllers\ProfileDriverController;
use App\Http\Controllers\HelpDriverController;
use App\Http\Controllers\AuthController;

// Login Routes
Route::get('/', [LoginController::class, 'showLogin'])->name('login');
Route::post('/', [LoginController::class, 'processLogin'])->name('login.post');

// Admin Routes
Route::get('admin/deliveryrecords', [DeliveryRecordsController::class, 'showDeliveryRecords'])->name('admin.deliveryrecords');
Route::get('admin/managetrip', [ManageTripController::class, 'showManageTrip'])->name('admin.managetrip');
Route::get('admin/managegps', [ManageGPSController::class, 'showManageGPS'])->name('admin.managegps');
Route::get('admin/fuel', [FuelController::class, 'showFuel'])->name('admin.fuel');
Route::get('admin/profile', [ProfileController::class, 'showProfile'])->name('admin.profile');
Route::get('admin/activeaccount', [ActiveController::class, 'showActive'])->name('admin.activeaccount');
Route::get('admin/help', [HelpController::class, 'showHelp'])->name('admin.help');

// Profit Routes
Route::get('admin/profit', [ProfitController::class, 'showProfit'])->name('admin.profit');
Route::post('admin/profit/store', [ProfitController::class, 'store'])->name('admin.profit.store');
Route::get('admin/profit/edit/{id}', [ProfitController::class, 'edit'])->name('admin.profit.edit');
Route::put('admin/profit/update/{id}', [ProfitController::class, 'update'])->name('admin.profit.update');
Route::delete('admin/profit/archive/{id}', [ProfitController::class, 'archive'])->name('admin.profit.archive'); // Idinagdag
Route::delete('admin/profit/delete/{id}', [ProfitController::class, 'destroy'])->name('admin.profit.delete');

// Archive Routes
Route::get('admin/archive', [ArchiveController::class, 'showArchive'])->name('admin.archive');
Route::delete('admin/archive/account/{id}', [ArchiveController::class, 'archiveAccount'])->name('admin.archive.account');
Route::put('admin/archive/restore/account/{id}', [ArchiveController::class, 'restoreAccount'])->name('admin.archive.restore.account');
Route::delete('admin/archive/delete/account/{id}', [ArchiveController::class, 'destroyAccount'])->name('admin.archive.delete.account');
Route::delete('admin/archive/profit/{id}', [ArchiveController::class, 'archiveProfit'])->name('admin.archive.profit');
Route::put('admin/archive/restore/profit/{id}', [ArchiveController::class, 'restoreProfit'])->name('admin.archive.restore.profit');
Route::delete('admin/archive/delete/profit/{id}', [ArchiveController::class, 'destroyProfit'])->name('admin.archive.delete.profit');

// Manager Routes
Route::get('manager/deliveryrecords', [DeliveryManagerController::class, 'showDeliveryManager'])->name('manager.deliveryrecords');
Route::get('manager/managetrip', [ManageTripManagerController::class, 'showManageTripManager'])->name('manager.managetrip');
Route::get('manager/gpscontrol', [GPSControlController::class, 'showGPSControl'])->name('manager.gpscontrol');
Route::get('manager/fuel', [FuelManagerController::class, 'showFuelManager'])->name('manager.fuel');
Route::get('manager/profile', [ProfileManagerController::class, 'showProfileManager'])->name('manager.profile');
Route::get('manager/archive', [ArchiveManagerController::class, 'showArchiveManager'])->name('manager.archive');
Route::get('manager/helpmanager', [HelpManagerController::class, 'showHelpManager'])->name('manager.helpmanager');

// Driver Routes
Route::get('driver/deliveryrecords', [DeliveryDriverController::class, 'showDeliveryDriver'])->name('driver.deliveryrecords');
Route::get('driver/fuel', [FuelDriverController::class, 'showFuelDriver'])->name('driver.fuel');
Route::get('driver/shipment', [ShipmentDriverController::class, 'showShipmentDriver'])->name('driver.shipment');
Route::get('driver/profile', [ProfileDriverController::class, 'showProfileDriver'])->name('driver.profile');
Route::get('driver/helpdriver', [HelpDriverController::class, 'showHelpDriver'])->name('driver.helpdriver');

// Authentication & Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin');
    Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])->name('manager');
    Route::get('/driver/dashboard', [DriverDashboardController::class, 'index'])->name('dashboard');
});

// Create Account Route
Route::post('admin/activeaccount', [AuthController::class, 'register'])->name('addaccount');

// Edit Account Route
Route::put('admin/activeaccount/{id}', [ActiveController::class, 'edit'])->name('editaccount');

// Archive Account Route
Route::delete('admin/activeaccount/{id}', [ActiveController::class, 'archive'])->name('archiveaccount');

//GPS
Route::post('/api/gps-data', [ManageGPSController::class, 'storeGpsData'])->name('gps.store');
Route::get('/api/gps-data', [ManageGPSController::class, 'fetchGpsData'])->name('gps.fetch');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/profile', [ProfileController::class, 'showProfile'])->name('admin.profile');
    Route::put('/admin/profile/update', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');
});