<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;
use Carbon\Carbon;
use App\Models\Truck;

class ManageTripManagerController extends Controller
{
    /**
     * Display a listing of trips based on filters.
     */
    public function index(Request $request)
    {
        $plateNo = $request->input('plate_no', 'All Trucks'); // Default to "All Trucks"
        $filter = $request->input('filter');

        // Get all distinct plate numbers from the trucks table
        $plateNumbers = Truck::pluck('plate_number')->unique()->sort()->values()->all();

        // Start the query to fetch active (non-archived) cargos
        $query = Cargo::where('is_archived', 0);

        // Handle the "All Trucks" case
        if (!empty($plateNo) && $plateNo !== "All Trucks") {
            $query->where('plate_no', $plateNo);
        }

        // Filter by Date Range
        if (!empty($filter)) {
            $startDate = null;
            $endDate = null;

            if ($filter === 'weekly') {
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
            } elseif ($filter === 'monthly') {
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
            } elseif ($filter === 'annually') {
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
            }

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        // Fetch the records
        $cargos = $query->orderBy('created_at', 'desc')->get();

        // Pass the data to the view
        return view('manager.managetrip', compact('cargos', 'plateNo', 'filter', 'plateNumbers'));
    }

    /**
     * Update a cargo trip record.
     */
    public function update(Request $request, $id)
    {
        try {
            $cargo = Cargo::findOrFail($id);
    
            $validatedData = $request->validate([
                'plate_no' => 'required',
                'eir_no' => 'required',
                'container_van_no' => 'required',
                'size' => 'required',
                'shipper_consignee' => 'required',
                'voyage_vessel' => 'required',
                'voyage_no' => 'required',
                'pickup_location' => 'required',
                'delivery_location' => 'required'
            ]);
    
            $cargo->update($validatedData);
    
            return response()->json([
                'success' => true,
                'message' => 'Trip updated successfully'
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating trip: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Archive a cargo trip.
     */
    public function archive($id)
    {
        $cargo = Cargo::findOrFail($id);
        $cargo->update(['is_archived' => 1]);

        return redirect()->route('manager.archive')->with('success', 'Cargo archived successfully.');
    }

    /**
     * Show archived cargo trips.
     */
    public function archivePage()
    {
        $archivedCargos = Cargo::where('is_archived', 1)->get();
        return view('manager.archive', compact('archivedCargos'));
    }

    public function restore($id)
    {
        $cargo = Cargo::findOrFail($id);
        $cargo->update(['is_archived' => 0]); // Set is_archived to 0 (active)
    
        return redirect()->back()->with('success', 'Cargo restored successfully!');
    }    
    public function manageTrips()
{
    $activeCargos = Cargo::where('is_archived', 0)->get();
    return view('manager.manage_trips', compact('activeCargos'));
}
public function destroy($id)
{
    $cargo = Cargo::findOrFail($id);
    $cargo->delete();

    return redirect()->back()->with('success', 'Cargo record deleted successfully.');
}
}