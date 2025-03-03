<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelpManagerController extends Controller
{
    public function showHelpManager(){
        return view('manager.helpmanager');
    }
}
