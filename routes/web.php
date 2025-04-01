<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeliveryRecordsController;
use App\Http\Controllers\ManageTripController;
use App\Http\Controllers\ManageGPSController;
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
use App\Http\Controllers\AuthController;
use App\Models\Tracking;
use App\Models\User;
use App\Http\Controllers\DriverTrackingController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\TruckController;

// Authentication Routes
Route::get('/', [LoginController::class, 'showLogin'])->name('login');
Route::post('/', [OTPController::class, 'sendOTP'])->name('login.post');
Route::get('/verify-otp', [OTPController::class, 'showOTPForm'])->name('verify.otp.view');
Route::post('/verify-otp', [OTPController::class, 'verifyOTP'])->name('verify.otp');
Route::post('/send-otp', [OTPController::class, 'sendOTP'])->name('send.otp');

// Password Reset Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

// Shared GPS Routes
Route::get('/get-locations', function () {
    $locations = DB::table('trackings')
        ->join('users', 'trackings.truck_id', '=', 'users.truck_id')
        ->select(
            'trackings.truck_id',
            'trackings.latitude',
            'trackings.longitude',
            'trackings.total_distance',
            'users.fullname'
        )
        ->where('users.role', 'driver')
        ->get();
    return response()->json($locations);
});

// Admin Routes Group
Route::prefix('admin')->group(function () {
    // Delivery Records
    Route::get('deliveryrecords', [DeliveryRecordsController::class, 'showDeliveryRecords'])->name('admin.deliveryrecords');
    Route::get('get-trip-counts', [DeliveryRecordsController::class, 'getTripCounts']);
    Route::put('/trips/update/{id}', [DeliveryRecordsController::class, 'update'])->name('trips.update');
    Route::delete('/trips/reset', [DeliveryRecordsController::class, 'reset'])->name('trips.reset');
    
    // Manage Trip
    Route::get('managetrip', [ManageTripController::class, 'ShowManageTrip'])->name('admin.managetrip');
    Route::put('update-trip/{id}', [ManageTripController::class, 'update'])->name('admin.updateTrip');
    Route::post('archive-trip/{id}', [ManageTripController::class, 'archiveTrip'])->name('admin.archive.trip');
    
    // GPS Management
    Route::get('managegps', [ManageGPSController::class, 'showManageGPS'])->name('admin.managegps');
    Route::post('reset-distance/{truck_id}', [ManageGPSController::class, 'resetDistance']);
    
    // Fuel Management
    Route::get('fuel', [FuelController::class, 'showFuel'])->name('admin.fuel');
    Route::get('fuel/edit/{id}', [FuelController::class, 'edit'])->name('admin.fuel.edit');
    Route::put('fuel/update/{id}', [FuelController::class, 'update'])->name('admin.fuel.update');
    Route::delete('fuel/archive/{id}', [FuelController::class, 'archive'])->name('admin.fuel.archive');
    
    // Truck Management
    Route::get('truckdetails', [TruckController::class, 'showTruck'])->name('admin.truckdetails');
    Route::post('truckdetails/store', [TruckController::class, 'store'])->name('admin.truckdetails.store');
    Route::put('truckdetails/{id}', [TruckController::class, 'update'])->name('admin.truckdetails.update');
    Route::delete('truckdetails/{id}', [TruckController::class, 'destroy'])->name('admin.truckdetails.destroy');
    Route::delete('truckdetails/archive/{id}', [ArchiveController::class, 'archiveTruck'])->name('admin.truckdetails.archive');
    
    // Profit Management
    Route::get('profit', [ProfitController::class, 'showProfit'])->name('admin.profit');
    Route::post('profit/store', [ProfitController::class, 'store'])->name('admin.profit.store');
    Route::get('profit/edit/{id}', [ProfitController::class, 'edit'])->name('admin.profit.edit');
    Route::put('profit/update/{id}', [ProfitController::class, 'update'])->name('admin.profit.update');
    Route::delete('profit/archive/{id}', [ProfitController::class, 'archive'])->name('admin.profit.archive');
    Route::delete('profit/delete/{id}', [ProfitController::class, 'destroy'])->name('admin.profit.delete');
    
    // Archive Management
    Route::get('archive', [ArchiveController::class, 'showArchive'])->name('admin.archive');
    Route::delete('archive/account/{id}', [ArchiveController::class, 'archiveAccount'])->name('admin.archive.account');
    Route::put('archive/restore/account/{id}', [ArchiveController::class, 'restoreAccount'])->name('admin.archive.restore.account');
    Route::delete('archive/delete/account/{id}', [ArchiveController::class, 'destroyAccount'])->name('admin.archive.delete.account');
    Route::delete('archive/profit/{id}', [ArchiveController::class, 'archiveProfit'])->name('admin.archive.profit');
    Route::put('archive/restore/profit/{id}', [ArchiveController::class, 'restoreProfit'])->name('admin.archive.restore.profit');
    Route::delete('archive/delete/profit/{id}', [ArchiveController::class, 'destroyProfit'])->name('admin.archive.delete.profit');
    Route::put('archive/restore/fuel/{id}', [ArchiveController::class, 'restoreFuel'])->name('admin.archive.restore.fuel');
    Route::delete('archive/delete/fuel/{id}', [ArchiveController::class, 'destroyFuel'])->name('admin.archive.delete.fuel');
    Route::put('archive/restore/trip/{id}', [ArchiveController::class, 'restoreTrip'])->name('admin.archive.restore.trip');
    Route::delete('archive/delete/trip/{id}', [ArchiveController::class, 'destroyTrip'])->name('admin.archive.delete.trip');
    Route::put('archive/restore/truck/{id}', [ArchiveController::class, 'restoreTruck'])->name('admin.archive.restore.truck');
    Route::delete('archive/delete/truck/{id}', [ArchiveController::class, 'destroyTruck'])->name('admin.archive.delete.truck');
    
    // User Management
    Route::get('activeaccount', [ActiveController::class, 'showActive'])->name('admin.activeaccount');
    Route::post('activeaccount', [AuthController::class, 'register'])->name('addaccount');
    Route::post('activeaccount/store', [ActiveController::class, 'store'])->name('admin.activeaccount.store');
    Route::put('activeaccount/{id}', [ActiveController::class, 'edit'])->name('editaccount');
    Route::delete('activeaccount/{id}', [ActiveController::class, 'archive'])->name('archiveaccount');
    
    // Profile Management
    Route::get('profile', [ProfileController::class, 'showProfile'])->name('admin.profile');
    Route::put('profile/update', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');
    Route::put('profile/change-password', [ProfileController::class, 'changePassword'])->name('admin.profile.change-password');
    
    // Help
    Route::get('help', [HelpController::class, 'showHelp'])->name('admin.help');
});

// Manager Routes Group
Route::prefix('manager')->group(function () {
    // Delivery Records
    Route::get('deliveryrecords', [DeliveryManagerController::class, 'showDeliveryManager'])->name('manager.deliveryrecords');
    Route::get('get-trip-counts', [DeliveryManagerController::class, 'getTripCounts']);
    Route::post('trips/store', [DeliveryManagerController::class, 'store'])->name('trips.store');
    Route::put('trips/update/{id}', [DeliveryManagerController::class, 'update'])->name('trips.update');
    Route::delete('trips/reset', [DeliveryManagerController::class, 'reset'])->name('trips.reset');
    
    // Trip Management
    Route::get('managetrip', [ManageTripManagerController::class, 'index'])->name('manager.managetrip');
    Route::put('update-trip/{id}', [ManageTripManagerController::class, 'update'])->name('manager.updateTrip');
    Route::post('archive-trip/{id}', [ManageTripManagerController::class, 'archive'])->name('trip.archive');
    Route::get('archive', [ManageTripManagerController::class, 'archivePage'])->name('manager.archive');
    Route::put('cargo/restore/{id}', [ManageTripManagerController::class, 'restore'])->name('cargo.restore');
    Route::delete('cargo/{id}/delete', [ManageTripManagerController::class, 'destroy'])->name('cargo.delete');
    
    // GPS Control
    Route::get('gpscontrol', [GPSControlController::class, 'showGPSControl'])->name('manager.gpscontrol');
    Route::post('reset-distance/{truck_id}', [GPSControlController::class, 'resetDistance']);
    Route::get('get-truck-distance', [GPSControlController::class, 'getTruckDistances']);
    
    // Fuel Management
    Route::get('fuel-manager', [FuelManagerController::class, 'showFuelManager'])->name('manager.fuel');
    Route::post('fuel-consumption', [FuelManagerController::class, 'store'])->name('fuel.store');
    Route::get('fuel-analytics', [FuelManagerController::class, 'getFuelAnalytics']);
    
    // Profile Management
    Route::get('profile', [ProfileManagerController::class, 'showProfileManager'])->name('manager.profile');
    Route::put('profile/update', [ProfileManagerController::class, 'updateProfileManager'])->name('manager.profile.update');
    Route::put('profile/change-password', [ProfileManagerController::class, 'changePasswordManager'])->name('manager.profile.change-password');
    
    // Help
    Route::get('helpmanager', [HelpManagerController::class, 'showHelpManager'])->name('manager.helpmanager');
    
    // QR Scanner
    Route::get('qrscanner', function () {
        return view('Manager.qrscanner');
    })->name('manager.qrscanner');
    Route::post('cargo/scanned', [ShipmentDriverController::class, 'storeScannedData']);
});

// Driver Routes Group
Route::prefix('driver')->group(function () {
    // Delivery Records
    Route::get('deliveryrecords', [DeliveryDriverController::class, 'index'])->name('driver.deliveryrecords');
    Route::get('get-trip-counts', [DeliveryDriverController::class, 'getTripCounts']);
    Route::post('trips/store', [DeliveryDriverController::class, 'store'])->name('trips.store');
    
    // Fuel Management
    Route::get('fuel', [FuelDriverController::class, 'showFuelDriver'])->name('driver.fuel');
    
    // Shipment Management
    Route::get('shipment', [ShipmentDriverController::class, 'showShipmentDriver'])->name('driver.shipment');
    Route::get('cargo', [ShipmentDriverController::class, 'index']);
    Route::post('cargo', [ShipmentDriverController::class, 'store']);
    Route::get('cargo/qrcode', [ShipmentDriverController::class, 'generateQRCode']);
    Route::get('cargo/store-via-scan', [ShipmentDriverController::class, 'storeViaScan']);
    
    // Profile Management
    Route::get('profile', [ProfileDriverController::class, 'showProfileDriver'])->name('driver.profile');
    Route::put('profile/update', [ProfileDriverController::class, 'updateProfileDriver'])->name('driver.profile.update');
    Route::put('profile/change-password', [ProfileDriverController::class, 'changePasswordDriver'])->name('driver.profile.change-password');
    Route::put('profile/update-license', [ProfileDriverController::class, 'updateDriverLicense'])->name('driver.profile.update-license');
    
    // Help
    Route::get('helpdriver', [HelpDriverController::class, 'showHelpDriver'])->name('driver.helpdriver');
    
    // Tracking
    Route::post('update-location', [DriverTrackingController::class, 'updateLocation']);
    Route::get('tracking', function () {
        return view('Driver.tracking');
    });
});

// Auth Middleware Group
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/profile', [ProfileController::class, 'showProfile'])->name('admin.profile');
});