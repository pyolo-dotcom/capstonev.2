<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profit;

class ProfitController extends Controller
{
    // Ipakita ang Profit Reports page
    public function showProfit()
    {
        $profits = Profit::all(); // Kunin ang lahat ng profit records
        $plateNumbers = Profit::pluck('plate_number')->unique(); // Kunin ang lahat ng unique plate numbers
        return view('admin.profitreports', compact('profits', 'plateNumbers')); // I-pasa ang $profits at $plateNumbers sa view
    }

    // Mag-store ng bagong profit record
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'plate_number' => 'required|string',
            'total_income' => 'required|numeric',
            'total_expenses' => 'required|numeric',
            'total_profit' => 'required|numeric',
        ]);

        try {
            Profit::create([
                'date' => $request->date,
                'plate_number' => $request->plate_number,
                'total_income' => $request->total_income,
                'total_expenses' => $request->total_expenses,
                'total_profit' => $request->total_profit,
            ]);
            return redirect()->back()->with('success', 'Profit added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error saving profit: ' . $e->getMessage());
        }
    }

    // Ipakita ang edit form
    public function edit($id)
    {
        $profit = Profit::findOrFail($id); // Kunin ang profit record base sa ID
        return view('admin.edit_profit', compact('profit')); // I-pasa ang $profit sa edit view
    }

    // I-update ang profit record
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'plate_number' => 'required|string',
            'total_income' => 'required|numeric',
            'total_expenses' => 'required|numeric',
            'total_profit' => 'required|numeric',
        ]);

        $profit = Profit::findOrFail($id);
        $profit->update([
            'date' => $request->date,
            'plate_number' => $request->plate_number,
            'total_income' => $request->total_income,
            'total_expenses' => $request->total_expenses,
            'total_profit' => $request->total_profit,
        ]);

        return redirect()->route('admin.profit')->with('success', 'Profit record updated successfully.');
    }

    // I-delete ang profit record
    public function destroy($id)
    {
        $profit = Profit::findOrFail($id);
        $profit->delete();

        return redirect()->route('admin.profit')->with('success', 'Profit record deleted successfully.');
    }

    // I-archive ang profit record (Soft Delete)
    public function archive($id)
    {
        $profit = Profit::findOrFail($id);
        $profit->delete(); // Gamitin ang Soft Deletes
        return redirect()->back()->with('success', 'Profit record archived successfully.');
    }
}