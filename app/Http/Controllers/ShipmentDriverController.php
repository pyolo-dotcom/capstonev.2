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
    
// In your ShipmentDriverController
public function generateQRCode(Request $request)
{
    // Ensure all parameters are properly URL encoded
    $queryParams = http_build_query($request->all());
    $qrData = url('/cargo/store-via-scan?') . $queryParams;

    // Generate QR code with error correction
    $qrCode = QrCode::size(300)
                ->margin(4)
                ->errorCorrection('H') // High error correction
                ->generate($qrData);

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

        // Return a view with SweetAlert instead of JSON
        return view('driver.qr-scan-response', [
            'success' => true,
            'message' => 'Cargo details stored via QR code scan!',
            'cargo' => $cargo
        ]);
    }
}