<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryManagerController extends Controller
{
    public function showDeliveryManager(){
        return view ('manager.deliveryrecords');
    }
}
