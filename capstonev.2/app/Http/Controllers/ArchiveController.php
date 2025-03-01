<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function showArchive(){
        return view('admin.archive');
    }
}
