<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

// Login Routes
Route::get('/', [LoginController::class, 'showLogin'])->name('login');
Route::post('/', [OTPController::class, 'sendOTP'])->name('login.post');

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::post('/reset-distance/{truck_id}', [ManageGPSController::class, 'resetDistance']);
Route::get('admin/deliveryrecords', [DeliveryRecordsController::class, 'showDeliveryRecords'])->name('admin.deliveryrecords');
Route::get('/admin/get-trip-counts', [DeliveryRecordsController::class, 'getTripCounts'])->name('admin.get-trip-counts');
Route::put('/trips/update/{id}', [DeliveryRecordsController::class, 'update'])->name('trips.update');
Route::delete('/trips/reset', [DeliveryRecordsController::class, 'reset'])->name('trips.reset');
Route::get('admin/managetrip', [ManageTripController::class, 'ShowManageTrip'])->name('admin.managetrip');
Route::put('/admin/update-trip/{id}', [ManageTripController::class, 'update'])->name('admin.updateTrip');
Route::get('admin/managegps', [ManageGPSController::class, 'showManageGPS'])->name('admin.managegps');
Route::get('admin/fuel', [FuelController::class, 'showFuel'])->name('admin.fuel');
Route::get('admin/truckdetails', [TruckController::class, 'showTruck'])->name('admin.truckdetails');
Route::get('admin/profile', [ProfileController::class, 'showProfile'])->name('admin.profile');
Route::get('admin/activeaccount', [ActiveController::class, 'showActive'])->name('admin.activeaccount');
Route::get('admin/help', [HelpController::class, 'showHelp'])->name('admin.help');

// GPS Tracking Routes
Route::get('/get-locations', function () {
    $locations = DB::table('trackings')
        ->join('users', 'trackings.truck_id', '=', 'users.truck_id')
        ->select(
            'trackings.truck_id',
            'trackings.latitude',
            'trackings.longitude',
            'trackings.total_distance',
            'trackings.speed',
            'users.fullname',
            'users.driver_license_number'
        )
        ->where('users.role', 'driver')
        ->get();
    return response()->json($locations);
});

Route::get('/get-truck-distance', function() {
    $distances = DB::table('trackings')
        ->join('users', 'trackings.truck_id', '=', 'users.truck_id')
        ->select(
            'trackings.truck_id',
            'trackings.total_distance',
            'users.fullname'
        )
        ->where('users.role', 'driver')
        ->get();
    return response()->json($distances);
});

// Profit Routes
Route::get('admin/profit', [ProfitController::class, 'showProfit'])->name('admin.profit');
Route::post('admin/profit/store', [ProfitController::class, 'store'])->name('admin.profit.store');
Route::get('admin/profit/edit/{id}', [ProfitController::class, 'edit'])->name('admin.profit.edit');
Route::put('admin/profit/update/{id}', [ProfitController::class, 'update'])->name('admin.profit.update');
Route::delete('admin/profit/archive/{id}', [ProfitController::class, 'archive'])->name('admin.profit.archive');
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
Route::post('/manager/reset-distance/{truck_id}', [GPSControlController::class, 'resetDistance']);
Route::get('manager/deliveryrecords', [DeliveryManagerController::class, 'showDeliveryManager'])->name('manager.deliveryrecords');
Route::get('manager/managetrip', [ManageTripManagerController::class, 'index'])->name('manager.managetrip');
Route::put('/manager/update-trip/{id}', [ManageTripManagerController::class, 'update'])->name('manager.updateTrip');
Route::get('manager/gpscontrol', [GPSControlController::class, 'showGPSControl'])->name('manager.gpscontrol');
Route::get('manager/fuel-manager', [FuelManagerController::class, 'showFuelManager'])->name('manager.fuel');
Route::get('manager/profile', [ProfileManagerController::class, 'showProfileManager'])->name('manager.profile');
Route::get('/manager/archive', [ManageTripManagerController::class, 'archivePage'])->name('trip.archivePage');
Route::get('manager/helpmanager', [HelpManagerController::class, 'showHelpManager'])->name('manager.helpmanager');
Route::get('manager/get-trip-counts', [DeliveryManagerController::class, 'getTripCounts']);
Route::get('manager/get-trip-counts', [DeliveryManagerController::class, 'getTripCounts'])->name('manager.get-trip-counts');
Route::post('/trips/store', [DeliveryManagerController::class, 'store'])->name('trips.store');
Route::put('/trips/update/{id}', [DeliveryManagerController::class, 'update'])->name('trips.update');
Route::delete('/trips/reset', [DeliveryManagerController::class, 'reset'])->name('trips.reset');
Route::delete('/trips/reset-all', [DeliveryManagerController::class, 'resetAll'])->name('trips.reset-all');
Route::post('/manager/archive-trip/{id}', [ManageTripManagerController::class, 'archive'])->name('trip.archive');
Route::get('/manager/archive', [ManageTripManagerController::class, 'archivePage'])->name('manager.archive');
Route::put('/cargo/restore/{id}', [ManageTripManagerController::class, 'restore'])->name('cargo.restore');
Route::delete('/cargo/{id}/delete', [ManageTripManagerController::class, 'destroy'])->name('cargo.delete');
Route::post('/fuel-consumption', [FuelManagerController::class, 'store'])->name('fuel.store');
Route::get('/fuel-analytics', [FuelManagerController::class, 'getFuelAnalytics']);
Route::get('/gpscontrol', [GPSControlController::class, 'showGPSControl']);
Route::get('/get-truck-distance', [GPSControlController::class, 'getTruckDistances']);
Route::get('/manager/qrscanner', function () {
    return view('manager.qrscanner');
})->name('manager.qrscanner');
Route::post('/cargo/scanned', [ShipmentDriverController::class, 'storeScannedData']);

// Driver Routes
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
Route::middleware(['auth'])->group(function() {
    Route::post('/update-location', [DriverTrackingController::class, 'updateLocation']);
    Route::get('/tracking', function () {
        return view('driver.tracking');
    })->name('tracking');
});
// Temporary debugging route - remove after testing
Route::post('/debug-update-location', [DriverTrackingController::class, 'updateLocation'])
    ->withoutMiddleware('auth');

// Account Management Routes
Route::post('admin/activeaccount/store', [ActiveController::class, 'store'])->name('admin.activeaccount.store');
Route::put('admin/activeaccount/{id}', [ActiveController::class, 'edit'])->name('admin.activeaccount.update');
Route::delete('admin/activeaccount/{id}', [ActiveController::class, 'archive'])->name('admin.activeaccount.archive');

// Profile Management
Route::middleware(['auth'])->group(function () {
    // Admin Profile
    Route::prefix('admin')->group(function () {
        Route::get('/profile', [ProfileController::class, 'showProfile'])->name('admin.profile');
        Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');
        Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('admin.profile.change-password');
        Route::post('/profile/remove-image', [ProfileController::class, 'removeImage'])->name('admin.profile.remove-image');
    });

    // Manager Profile
    Route::prefix('manager')->group(function () {
        Route::get('/profile', [ProfileManagerController::class, 'showProfileManager'])->name('manager.profile');
        Route::put('/profile/update', [ProfileManagerController::class, 'updateProfile'])->name('manager.profile.update');
        Route::post('/profile/change-password', [ProfileManagerController::class, 'changePassword'])->name('manager.profile.change-password');
    });

    // Driver Profile
    Route::prefix('driver')->group(function () {
        Route::get('/profile', [ProfileDriverController::class, 'showProfileDriver'])->name('driver.profile');
        Route::put('/profile/update', [ProfileDriverController::class, 'updateProfileDriver'])->name('driver.profile.update');
        Route::post('/profile/change-password', [ProfileDriverController::class, 'changePasswordDriver'])->name('driver.profile.change-password');
        Route::put('/profile/update-license', [ProfileDriverController::class, 'updateDriverLicense'])->name('driver.profile.update-license');
    });
});

// Fuel Routes
Route::post('/fuel-consumption', [FuelController::class, 'store']);
Route::get('/admin/fuel/edit/{id}', [FuelController::class, 'edit'])->name('admin.fuel.edit');
Route::put('/admin/fuel/update/{id}', [FuelController::class, 'update'])->name('admin.fuel.update'); // Change to PUT
Route::post('/admin/fuel/archive/{id}', [FuelController::class, 'archive'])->name('admin.fuel.archive');
Route::put('admin/archive/restore/fuel/{id}', [ArchiveController::class, 'restoreFuel'])->name('admin.archive.restore.fuel');
Route::delete('admin/archive/delete/fuel/{id}', [ArchiveController::class, 'destroyFuel'])->name('admin.archive.delete.fuel');

// Trip Archive Routes
Route::post('/admin/archive-trip/{id}', [ManageTripController::class, 'archiveTrip'])->name('admin.archive.trip');
Route::put('/admin/archive/restore/trip/{id}', [ArchiveController::class, 'restoreTrip'])->name('admin.archive.restore.trip');
Route::delete('/admin/archive/delete/trip/{id}', [ArchiveController::class, 'destroyTrip'])->name('admin.archive.delete.trip');

// Forgot Password Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

// OTP Verification Routes
Route::get('/verify-otp', [OTPController::class, 'showOTPForm'])->name('verify.otp.view');
Route::post('/verify-otp', [OTPController::class, 'verifyOTP'])->name('verify.otp');
Route::post('/send-otp', [OTPController::class, 'sendOTP'])->name('send.otp');
Route::post('/resend-otp', [OTPController::class, 'resendOTP'])->name('resend.otp');

// Truck Routes
Route::post('admin/truckdetails/store', [TruckController::class, 'store'])->name('admin.truckdetails.store');
Route::put('admin/truckdetails/{id}', [TruckController::class, 'update'])->name('admin.truckdetails.update');
Route::delete('admin/truckdetails/{id}', [TruckController::class, 'destroy'])->name('admin.truckdetails.destroy');
Route::delete('admin/truckdetails/archive/{id}', [ArchiveController::class, 'archiveTruck'])->name('admin.truckdetails.archive');
Route::put('admin/archive/restore/truck/{id}', [ArchiveController::class, 'restoreTruck'])->name('admin.archive.restore.truck');
Route::delete('admin/archive/delete/truck/{id}', [ArchiveController::class, 'destroyTruck'])->name('admin.archive.delete.truck');

// Field Validation Routes
Route::middleware(['web'])->group(function() {
    Route::get('/check-username', function(Request $request) {
        $username = $request->input('username');
        $exists = \App\Models\User::where('username', $username)->exists();
        return response()->json(['exists' => $exists]);
    });

    Route::get('/check-email', function(Request $request) {
        $email = $request->input('email');
        $exists = \App\Models\User::where('email', $email)->exists();
        return response()->json(['exists' => $exists]);
    });

    Route::get('/check-mobile_number', function(Request $request) {
        $mobile = $request->input('mobile_number');
        $exists = \App\Models\User::where('mobile_number', $mobile)->exists();
        return response()->json(['exists' => $exists]);
    });

    Route::get('/check-truck', function(Request $request) {
        $truckId = $request->input('truck');
        $exists = \App\Models\User::where('truck_id', $truckId)
                                 ->where('role', 'driver')
                                 ->exists();
        return response()->json(['assigned' => $exists]);
    });
});

// Additional GPS Tracking Routes
Route::get('/get-driver-location/{truck_id}', function($truck_id) {
    $location = DB::table('trackings')
        ->join('users', 'trackings.truck_id', '=', 'users.truck_id')
        ->select(
            'trackings.truck_id',
            'trackings.latitude',
            'trackings.longitude',
            'trackings.total_distance',
            'trackings.speed',
            'users.fullname'
        )
        ->where('trackings.truck_id', $truck_id)
        ->where('users.role', 'driver')
        ->first();
        
    return response()->json($location);
});

Route::get('/get-active-drivers', function() {
    $drivers = DB::table('users')
        ->leftJoin('trackings', 'users.truck_id', '=', 'trackings.truck_id')
        ->select(
            'users.id',
            'users.fullname',
            'users.truck_id',
            'trackings.latitude',
            'trackings.longitude',
            'trackings.total_distance'
        )
        ->where('users.role', 'driver')
        ->whereNotNull('users.truck_id')
        ->get();
        
    return response()->json($drivers);
});

// Add these new routes
Route::get('/live-tracking', [ManageGPSController::class, 'showLiveTracking'])->name('live.tracking');
Route::get('/get-live-locations', [ManageGPSController::class, 'getLiveLocations']);

// Add these routes
Route::get('/get-driver-location/{truck_id}', [ManageGPSController::class, 'getDriverLocation']);
Route::post('/reset-distance/{truck_id}', [ManageGPSController::class, 'resetDistance'])
    ->name('reset.distance');

// Add these new routes for WebSocket authentication
Route::post('/broadcasting/auth', function () {
    return Broadcast::auth(request());
});

// Pusher WebHook for presence channels (optional)
Route::post('/pusher/webhook', function (Request $request) {
    // Verify webhook signature if needed
    return response()->json(['status' => 'success']);
});

Route::get('/admin/activeaccount/{id}/edit-form', [ActiveController::class, 'editForm']);