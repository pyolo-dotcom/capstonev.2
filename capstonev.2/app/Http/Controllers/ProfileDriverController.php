<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileDriverController extends Controller
{
    public function showProfileDriver(){
        return view('driver.profilemanagement');
    }
}
