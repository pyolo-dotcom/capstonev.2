<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeliveryRecordsController;
use App\Http\Controllers\ManageTripController;
use App\Http\Controllers\ManageGPS;
use App\Http\Controllers\FuelController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActiveController;
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

Route::get('/', [LoginController::class, 'showLogin'])->name('login');

//Admin
Route::get('admin/deliveryrecords', [DeliveryRecordsController::class, 'showDeliveryRecords'])->name('admin.deliveryrecords');
Route::get('admin/managetrip', [ManageTripController::class, 'showManageTrip'])->name('admin.managetrip');
Route::get('admin/managegps', [ManageGPS::class, 'showManageGPS'])->name('admin.managegps');
Route::get('admin/fuel', [FuelController::class, 'showFuel'])->name('admin.fuel');
Route::get('admin/profit', [ProfitController::class, 'showProfit'])->name('admin.profit');
Route::get('admin/profile', [ProfileController::class, 'showProfile'])->name('admin.profile');
Route::get('admin/activeaccount', [ActiveController::class, 'showActive'])->name('admin.activeaccount');
Route::get('admin/archive', [ArchiveController::class, 'showArchive'])->name('admin.archive');
Route::get('admin/help', [HelpController::class, 'showHelp'])->name('admin.help');

//Manager
Route::get('manager/deliveryrecords', [DeliveryManagerController::class, 'showDeliveryManager'])->name('manager.deliveryrecords');
Route::get('manager/managetrip', [ManageTripManagerController::class, 'index'])->name('manager.managetrip');
Route::put('/manager/update-trip/{id}', [ManageTripManagerController::class, 'update'])->name('manager.updateTrip');
Route::get('manager/gpscontrol', [GPSControlController::class, 'showGPSControl'])->name('manager.gpscontrol');
Route::get('manager/fuel', [FuelManagerController::class, 'showFuelManager'])->name('manager.fuel');
Route::get('manager/profile', [ProfileManagerController::class, 'showProfileManager'])->name('manager.profile');
Route::get('manager/archive', [ArchiveManagerController::class, 'showArchiveManager'])->name('manager.archive');
Route::get('manager/helpmanager', [HelpManagerController::class, 'showHelpManager'])->name('manager.helpmanager');
Route::get('manager/get-trip-counts', [DeliveryManagerController::class, 'getTripCounts']);
Route::post('/trips/store', [DeliveryManagerController::class, 'store'])->name('trips.store');
Route::put('/trips/update/{id}', [DeliveryManagerController::class, 'update'])->name('trips.update');
Route::delete('/trips/reset', [DeliveryManagerController::class, 'reset'])->name('trips.reset');

//Driver
Route::get('driver/deliveryrecords', [DeliveryDriverController::class, 'index'])->name('driver.deliveryrecords');
Route::get('driver/fuel', [FuelDriverController::class, 'showFuelDriver'])->name('driver.fuel');
Route::get('driver/shipment', [ShipmentDriverController::class, 'showShipmentDriver'])->name('driver.shipment');
Route::get('driver/profile', [ProfileDriverController::class, 'showProfileDriver'])->name('driver.profile');
Route::get('driver/helpdriver', [HelpDriverController::class, 'showHelpDriver'])->name('driver.helpdriver');
Route::post('/trips/store', [DeliveryDriverController::class, 'store'])->name('trips.store');
Route::get('/get-trip-counts', [DeliveryDriverController::class, 'getTripCounts']);
Route::get('/cargo', [ShipmentDriverController::class, 'index']);
Route::post('/cargo', [ShipmentDriverController::class, 'store']);
Route::get('/cargo/qrcode', [ShipmentDriverController::class, 'generateQRCode']);
Route::get('/cargo/store-via-scan', [ShipmentDriverController::class, 'storeViaScan']);