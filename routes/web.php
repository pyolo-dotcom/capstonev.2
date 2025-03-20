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

// Login Routes
Route::get('/', [LoginController::class, 'showLogin'])->name('login');
Route::post('/', [LoginController::class, 'processLogin'])->name('login.post');

// Admin Routes
Route::get('admin/deliveryrecords', [DeliveryRecordsController::class, 'showDeliveryRecords'])->name('admin.deliveryrecords');
Route::get('admin/get-trip-counts', [DeliveryManagerController::class, 'getTripCounts']);
Route::put('/trips/update/{id}', [DeliveryRecordsController::class, 'update'])->name('trips.update');
Route::delete('/trips/reset', [DeliveryRecordsController::class, 'reset'])->name('trips.reset');
Route::get('admin/managetrip', [ManageTripController::class, 'ShowManageTrip'])->name('admin.managetrip');
Route::put('/admin/update-trip/{id}', [ManageTripController::class, 'UpdateManageTrip'])->name('admin.updateTrip');
Route::get('admin/managegps', [ManageGPSController::class, 'showManageGPS'])->name('admin.managegps');
Route::get('admin/fuel', [FuelController::class, 'showFuel'])->name('admin.fuel');
Route::get('admin/profile', [ProfileController::class, 'showProfile'])->name('admin.profile');
Route::get('admin/activeaccount', [ActiveController::class, 'showActive'])->name('admin.activeaccount');
Route::get('admin/help', [HelpController::class, 'showHelp'])->name('admin.help');
Route::get('/get-locations', function () {
    $locations = DB::table('trackings')
        ->join('users', 'users.truck_id', '=', 'trackings.truck_id')
        ->select('users.fullname', 'trackings.truck_id', 'trackings.latitude', 'trackings.longitude')
        ->where('users.role', 'driver')
        ->get();

    return response()->json($locations);
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
Route::get('manager/deliveryrecords', [DeliveryManagerController::class, 'showDeliveryManager'])->name('manager.deliveryrecords');
Route::get('manager/managetrip', [ManageTripManagerController::class, 'index'])->name('manager.managetrip');
Route::put('/manager/update-trip/{id}', [ManageTripManagerController::class, 'update'])->name('manager.updateTrip');
Route::get('manager/gpscontrol', [GPSControlController::class, 'showGPSControl'])->name('manager.gpscontrol');
Route::get('manager/fuel-manager', [FuelManagerController::class, 'showFuelManager'])->name('manager.fuel');
Route::get('manager/profile', [ProfileManagerController::class, 'showProfileManager'])->name('manager.profile');
Route::get('/manager/archive', [ManageTripManagerController::class, 'archivePage'])->name('trip.archivePage');
Route::get('manager/helpmanager', [HelpManagerController::class, 'showHelpManager'])->name('manager.helpmanager');
Route::get('manager/get-trip-counts', [DeliveryManagerController::class, 'getTripCounts']);
Route::post('/trips/store', [DeliveryManagerController::class, 'store'])->name('trips.store');
Route::put('/trips/update/{id}', [DeliveryManagerController::class, 'update'])->name('trips.update');
Route::delete('/trips/reset', [DeliveryManagerController::class, 'reset'])->name('trips.reset');
Route::post('/manager/archive-trip/{id}', [ManageTripManagerController::class, 'archive'])->name('trip.archive');
Route::get('/manager/archive', [ManageTripManagerController::class, 'archivePage'])->name('manager.archive');
Route::put('/cargo/restore/{id}', [ManageTripManagerController::class, 'restore'])->name('cargo.restore');
Route::delete('/cargo/{id}/delete', [ManageTripManagerController::class, 'destroy'])->name('cargo.delete');
Route::post('/fuel-consumption', [FuelManagerController::class, 'store'])->name('fuel.store');
Route::get('/fuel-analytics', [FuelManagerController::class, 'getFuelAnalytics']);
Route::get('/fuel-analytics', [FuelManagerController::class, 'getFuelAnalytics']);
Route::get('/gpscontrol', [GPSControlController::class, 'showGPSControl']); // ✅ New route for multiple trucks
Route::get('/get-locations', function () {
    $locations = DB::table('trackings')
        ->join('users', 'users.truck_id', '=', 'trackings.truck_id')
        ->select('users.fullname', 'trackings.truck_id', 'trackings.latitude', 'trackings.longitude')
        ->where('users.role', 'driver')
        ->get();

    return response()->json($locations);
});
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
Route::post('/update-location', [DriverTrackingController::class, 'updateLocation']);
Route::get('/tracking', function () {
    return view('Driver.tracking');
});


Route::post('admin/activeaccount', [AuthController::class, 'register'])->name('addaccount');
// Edit Account Route
Route::put('admin/activeaccount/{id}', [ActiveController::class, 'edit'])->name('editaccount');

// Archive Account Route
Route::delete('admin/activeaccount/{id}', [ActiveController::class, 'archive'])->name('archiveaccount');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/profile', [ProfileController::class, 'showProfile'])->name('admin.profile');
    Route::put('/admin/profile/update', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');
});

// New Route for Creating Account with Truck ID
Route::post('admin/activeaccount/store', [ActiveController::class, 'store'])->name('admin.activeaccount.store');

//Profile Management
Route::put('/profile/change-password', [ProfileController::class, 'changePassword'])->name('admin.profile.change-password');

// Manager Profile Routes
Route::get('manager/profile', [ProfileManagerController::class, 'showProfileManager'])->name('manager.profile');
Route::put('manager/profile/update', [ProfileManagerController::class, 'updateProfileManager'])->name('manager.profile.update');
Route::put('manager/profile/change-password', [ProfileManagerController::class, 'changePasswordManager'])->name('manager.profile.change-password');

// Driver Profile Routes
Route::get('driver/profile', [ProfileDriverController::class, 'showProfileDriver'])->name('driver.profile');
Route::put('driver/profile/update', [ProfileDriverController::class, 'updateProfileDriver'])->name('driver.profile.update');
Route::put('driver/profile/change-password', [ProfileDriverController::class, 'changePasswordDriver'])->name('driver.profile.change-password');
Route::put('driver/profile/update-license', [ProfileDriverController::class, 'updateDriverLicense'])->name('driver.profile.update-license');

//Fuel Route
Route::get('admin/fuel/edit/{id}', [FuelController::class, 'edit'])->name('admin.fuel.edit');
Route::put('admin/fuel/update/{id}', [FuelController::class, 'update'])->name('admin.fuel.update');
Route::delete('admin/fuel/archive/{id}', [FuelController::class, 'archive'])->name('admin.fuel.archive');

//Fuel Route
Route::put('admin/archive/restore/fuel/{id}', [ArchiveController::class, 'restoreFuel'])->name('admin.archive.restore.fuel');
Route::delete('admin/archive/delete/fuel/{id}', [ArchiveController::class, 'destroyFuel'])->name('admin.archive.delete.fuel');

//Fuel Route
Route::get('admin/fuel/edit/{id}', [FuelController::class, 'edit'])->name('admin.fuel.edit');
Route::put('admin/fuel/update/{id}', [FuelController::class, 'update'])->name('admin.fuel.update');

//Admin Trip Records Archive
Route::post('/admin/archive-trip/{id}', [ManageTripController::class, 'archiveTrip'])->name('admin.archive.trip');

//Archive Trip Records Restore & Delete
Route::put('/admin/archive/restore/trip/{id}', [ArchiveController::class, 'restoreTrip'])->name('admin.archive.restore.trip');
Route::delete('/admin/archive/delete/trip/{id}', [ArchiveController::class, 'destroyTrip'])->name('admin.archive.delete.trip');