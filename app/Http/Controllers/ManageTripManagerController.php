<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cargo;
use Carbon\Carbon;

class ManageTripManagerController extends Controller
{
    public function index(Request $request)
    {
        $plateNo = $request->input('plate_no');
        $filter = $request->input('filter'); // Weekly, Monthly, Annually
    
        $query = Cargo::query();
    
        // Filter by Plate Number if selected
        if (!empty($plateNo) && $plateNo !== "All Trucks") {
            $query->where('plate_no', $plateNo);
        }
    
        // Filter by Date Range
        if (!empty($filter)) {
            $today = Carbon::now();
    
            if ($filter === 'weekly') {
                $startDate = Carbon::now()->startOfWeek();  // Start of the week (Monday)
                $endDate = Carbon::now()->endOfWeek();      // End of the week (Sunday)
            } elseif ($filter === 'monthly') {
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
            } elseif ($filter === 'annually') {
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
            }
    
            // Debugging: Check date range in Laravel log
            \Log::info("Filtering cargos from $startDate to $endDate");
    
            // Apply date filter
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
    
        $cargos = $query->get();
    
        // Debugging: Check if any data is retrieved
        \Log::info("Retrieved cargos:", $cargos->toArray());
    
        return view('manager.managetrip', compact('cargos', 'plateNo', 'filter'));
    }
    public function update(Request $request, $id)
{
    $cargo = Cargo::findOrFail($id);

    $cargo->eir_no = $request->eir_no;
    $cargo->container_van_no = $request->container_van_no;
    $cargo->size = $request->size;
    $cargo->shipper_consignee = $request->shipper_consignee;
    $cargo->voyage_vessel = $request->voyage_vessel;
    $cargo->voyage_no = $request->voyage_no;
    $cargo->pickup_location = $request->pickup_location;
    $cargo->delivery_location = $request->delivery_location;

    $cargo->save();

    return redirect()->route('manager.managetrip')->with('success', 'Trip updated successfully.');
}
}