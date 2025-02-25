<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArchiveManagerController extends Controller
{
    public function showArchiveManager(){
        return view('manager.archive');
    }
}
