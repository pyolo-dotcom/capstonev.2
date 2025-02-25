<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeliveryRecordsController;
use App\Http\Controllers\ManageTripController;
use App\Http\Controllers\ManageGPS;
use App\Http\Controllers\FuelController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActiveController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\LoginController;

Route::get('/', [LoginController::class, 'showLogin'])->name('login');

Route::get('admin/deliveryrecords', [DeliveryRecordsController::class, 'showDeliveryRecords'])->name('admin.deliveryrecords');
Route::get('admin/managetrip', [ManageTripController::class, 'showManageTrip'])->name('admin.managetrip');
Route::get('admin/managegps', [ManageGPS::class, 'showManageGPS'])->name('admin.managegps');
Route::get('admin/fuel', [FuelController::class, 'showFuel'])->name('admin.fuel');
Route::get('admin/profit', [ProfitController::class, 'showProfit'])->name('admin.profit');
Route::get('admin/profile', [ProfileController::class, 'showProfile'])->name('admin.profile');
Route::get('admin/activeaccount', [ActiveController::class, 'showActive'])->name('admin.activeaccount');
Route::get('admin/archive', [ArchiveController::class, 'showArchive'])->name('admin.archive');
Route::get('admin/help', [HelpController::class, 'showHelp'])->name('admin.help');