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
// use App\Http\Controllers\ArchiveController;
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

Route::get('/', [DeliveryManagerController::class, 'showDeliveryManager'])->name('manager.deliveryrecords');

// Login Routes
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'processLogin'])->name('login.post');

// Admin Routes
Route::get('admin/deliveryrecords', [DeliveryRecordsController::class, 'showDeliveryRecords'])->name('admin.deliveryrecords');
Route::get('admin/get-trip-counts', [DeliveryManagerController::class, 'getTripCounts']);
Route::put('/trips/update/{id}', [DeliveryRecordsController::class, 'update'])->name('trips.update');
Route::delete('/trips/reset', [DeliveryRecordsController::class, 'reset'])->name('trips.reset');
Route::get('admin/managetrip', [ManageTripController::class, 'ShowManageTrip'])->name('admin.managetrip');
Route::put('/admin/update-trip/{id}', [ManageTripController::class, 'UpdateManageTrip'])->name('admin.updateTrip');
Route::get('admin/managegps', [ManageGPS::class, 'showManageGPS'])->name('admin.managegps');
Route::get('admin/fuel', [FuelController::class, 'showFuel'])->name('admin.fuel');
Route::get('admin/profit', [ProfitController::class, 'showProfit'])->name('admin.profit');
Route::get('admin/profile', [ProfileController::class, 'showProfile'])->name('admin.profile');
Route::get('admin/activeaccount', [ActiveController::class, 'showActive'])->name('admin.activeaccount');
Route::get('admin/archive', [ArchiveController::class, 'showArchive'])->name('admin.archive');
Route::get('admin/help', [HelpController::class, 'showHelp'])->name('admin.help');
Route::get('/get-locations', function () {
    $locations = DB::table('trackings')
        ->join('users', 'users.truck_id', '=', 'trackings.truck_id')
        ->select('users.fullname', 'trackings.truck_id', 'trackings.latitude', 'trackings.longitude')
        ->where('users.role', 'driver')
        ->get();

    return response()->json($locations);
});

// Manager Routes
Route::get('manager/deliveryrecords', [DeliveryManagerController::class, 'showDeliveryManager'])->name('manager.deliveryrecords');
Route::get('manager/managetrip', [ManageTripManagerController::class, 'index'])->name('manager.managetrip');
Route::put('/manager/update-trip/{id}', [ManageTripManagerController::class, 'update'])->name('manager.updateTrip');
Route::get('manager/gpscontrol', [GPSControlController::class, 'showGPSControl'])->name('manager.gpscontrol');
Route::get('/fuel-manager', [FuelManagerController::class, 'showFuelManager'])->name('manager.fuel');
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
