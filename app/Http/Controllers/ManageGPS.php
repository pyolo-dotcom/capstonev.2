<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ManageGPS extends Controller
{
    public function showManageGPS(){
        return view('admin.managegps');
    }
}