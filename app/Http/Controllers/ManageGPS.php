<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageGPS extends Controller
{
    public function showManageGPS(){
        return view('admin.managegps');
    }
}
