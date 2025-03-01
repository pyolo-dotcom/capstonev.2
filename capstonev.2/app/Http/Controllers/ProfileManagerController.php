<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileManagerController extends Controller
{
    public function showProfileManager(){
        return view('manager.profilemanagement');
    }
}
