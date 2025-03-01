<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActiveController extends Controller
{
    public function showActive(){
        return view('admin.activeaccount');
    }
}
