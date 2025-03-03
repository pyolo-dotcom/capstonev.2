<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GPSControlController extends Controller
{
    public function showGPSControl(){
        return view('manager.gpscontrol');
    }
}
