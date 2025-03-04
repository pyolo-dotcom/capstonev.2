<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cargo;

class ArchiveManagerController extends Controller
{
    public function showArchiveManager(){
        return view('manager.archive');
    }
    public function archiveIndex()
    {
        $archivedCargos = Cargo::where('is_archived', 1)->get();
        return view('manager.archive', compact('archivedCargos'));
    }    
}
