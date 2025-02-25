<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FuelController extends Controller
{
    public function showFuel(){
        return view('admin.fuel');
    }
}
