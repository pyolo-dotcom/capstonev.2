<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageTripController extends Controller
{
    public function showManageTrip(){
        return view('admin.managetrip');
    }
}
