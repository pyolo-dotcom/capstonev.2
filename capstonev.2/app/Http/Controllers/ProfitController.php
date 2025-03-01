<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    public function showProfit(){
        return view('admin.profitreports');
    }
}
