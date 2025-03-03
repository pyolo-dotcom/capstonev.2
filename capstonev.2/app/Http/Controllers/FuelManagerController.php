<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FuelManagerController extends Controller
{
    public function showFuelManager(){
        return view('manager.fuel');
    }
}
