<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FuelDriverController extends Controller
{
    public function showFuelDriver(){
        return view('driver.fuel');
    }
}
