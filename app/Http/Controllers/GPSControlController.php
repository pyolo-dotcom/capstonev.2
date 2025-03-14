<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
class GPSControlController extends Controller
{   public function showGPSControl()
    {
        return view('manager.gpscontrol');
    }
}
