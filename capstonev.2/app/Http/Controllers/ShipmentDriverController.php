<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShipmentDriverController extends Controller
{
    public function showShipmentDriver(){
        return view('driver.shipment');
    }
}
