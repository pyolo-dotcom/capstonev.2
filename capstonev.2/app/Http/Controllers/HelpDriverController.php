<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelpDriverController extends Controller
{
    public function showHelpDriver(){
        return view('driver.help');
    }
}
