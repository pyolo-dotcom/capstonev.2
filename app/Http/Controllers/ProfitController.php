<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profit;

class ProfitController extends Controller
{
    // Show the Profit Reports page
    public function showProfit()
    {
        $profits = Profit::all();
        return view('admin.profitreports', compact('profits'));
    }

    // Store new profit record
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'total_income' => 'required|numeric',
            'total_expenses' => 'required|numeric',
        ]);

        Profit::create([
            'date' => $request->date,
            'total_income' => $request->total_income,
            'total_expenses' => $request->total_expenses,
            'total_profit' => $request->total_income - $request->total_expenses,
        ]);

        return redirect()->route('admin.profitreports')->with('success', 'Profit record added successfully.');
    }
}
