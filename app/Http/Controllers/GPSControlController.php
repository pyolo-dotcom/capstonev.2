<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class GPSControlController extends Controller
{   public function showGPSControl()
    {
        return view('manager.gpscontrol');
    }
}
