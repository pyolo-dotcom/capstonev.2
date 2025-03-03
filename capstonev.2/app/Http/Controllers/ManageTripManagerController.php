<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageTripManagerController extends Controller
{
    public function showManageTripManager(){
        return view('manager.managetrip');
    }
}
