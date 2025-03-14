<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cargo;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class ShipmentDriverController extends Controller
{
    public function showShipmentDriver(){
        return view('driver.shipment');
    }
    public function generateQRCode(Request $request)
{
    $qrData = url('/cargo/store-via-scan?') . http_build_query($request->all());

    $qrCode = QrCode::size(200)->generate($qrData);

    return response($qrCode)->header('Content-Type', 'image/svg+xml');
}    
    // Store Cargo when QR Code is scanned
    public function storeViaScan(Request $request)
    {
        $cargo = Cargo::create([
            'plate_no' => $request->plate_no,
            'eir_no' => $request->eir_no,
            'container_van_no' => $request->container_van_no,
            'size' => $request->size,
            'shipper_consignee' => $request->shipper_consignee,
            'voyage_vessel' => $request->voyage_vessel,
            'voyage_no' => $request->voyage_no,
            'pickup_location' => $request->pickup_location,
            'delivery_location' => $request->delivery_location,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cargo details stored via QR code scan!',
            'cargo' => $cargo
        ]);
    }
}    
