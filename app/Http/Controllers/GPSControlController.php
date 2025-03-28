<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class GPSControlController extends Controller
{   public function showGPSControl()
    {
        return view('manager.gpscontrol');
    }
    public function resetDistance($truck_id)
    {
        $updated = DB::table('trackings')
                    ->where('truck_id', $truck_id)
                    ->update(['total_distance' => 0.00]);
    
        return response()->json(['success' => $updated]);
    }
}
