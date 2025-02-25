<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryDriverController extends Controller
{
    public function showDeliveryDriver(){
        return view('driver.deliveryrecords');
    }
}
