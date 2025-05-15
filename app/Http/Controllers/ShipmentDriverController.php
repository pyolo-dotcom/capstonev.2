<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cargo;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;
use App\Models\Truck;

class ShipmentDriverController extends Controller
{
    public function showShipmentDriver(){
        // Get the current authenticated user
        $user = Auth::user();
        
        // Get all plate numbers from Truck model
        $plateNumbers = Truck::pluck('plate_number')->unique()->sort()->values()->all();
        
        return view('driver.shipment', [
            'plateNumber' => $user->truck_id,
            'driverName' => $user->fullname,
            'plateNumbers' => $plateNumbers
        ]);
    }
    
    public function generateQRCode(Request $request)
    {
        // Create an array of all the data
        $qrData = [
            'plate_no' => $request->plate_no,
            'eir_no' => $request->eir_no,
            'container_van_no' => $request->container_van_no,
            'size' => $request->size,
            'shipper_consignee' => $request->shipper_consignee,
            'voyage_vessel' => $request->voyage_vessel,
            'voyage_no' => $request->voyage_no,
            'pickup_location' => $request->pickup_location,
            'delivery_location' => $request->delivery_location
        ];

        // Encode as JSON for the QR code
        $jsonData = json_encode($qrData);

        // Generate QR code with error correction
        $qrCode = QrCode::size(300)
                    ->margin(4)
                    ->errorCorrection('H')
                    ->generate($jsonData);

        return response($qrCode)->header('Content-Type', 'image/svg+xml');
    }  
    
    public function storeScannedData(Request $request)
    {
        try {
            // Validate required fields
            $validated = $request->validate([
                'plate_no' => 'required|string',
                'eir_no' => 'required|string',
                'container_van_no' => 'required|string',
                'size' => 'required|string',
                'shipper_consignee' => 'required|string',
                'voyage_vessel' => 'required|string',
                'voyage_no' => 'required|string',
                'pickup_location' => 'required|string',
                'delivery_location' => 'required|string',
            ]);
    
            // Save data to the database
            $cargo = Cargo::create([
                'plate_no' => $validated['plate_no'],
                'eir_no' => $validated['eir_no'],
                'container_van_no' => $validated['container_van_no'],
                'size' => $validated['size'],
                'shipper_consignee' => $validated['shipper_consignee'],
                'voyage_vessel' => $validated['voyage_vessel'],
                'voyage_no' => $validated['voyage_no'],
                'pickup_location' => $validated['pickup_location'],
                'delivery_location' => $validated['delivery_location'],
                'status' => 'Pending'
            ]);
    
            return response()->json([
                'message' => 'Cargo data saved successfully',
                'cargo' => $cargo
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error processing cargo data',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}