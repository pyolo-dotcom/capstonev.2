<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;
use Carbon\Carbon;

class ManageTripManagerController extends Controller
{
    /**
     * Display a listing of trips based on filters.
     */
    public function index(Request $request)
    {
        $plateNo = $request->input('plate_no');
        $filter = $request->input('filter'); // Weekly, Monthly, Annually

        $query = Cargo::where('is_archived', 0); // Exclude archived cargos

        // Filter by Plate Number if selected
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

        $cargos = $query->get();

        return view('manager.managetrip', compact('cargos', 'plateNo', 'filter'));
    }

    /**
     * Update a cargo trip record.
     */
    public function update(Request $request, $id)
    {
        $cargo = Cargo::findOrFail($id);

        $cargo->update([
            'eir_no' => $request->eir_no,
            'container_van_no' => $request->container_van_no,
            'size' => $request->size,
            'shipper_consignee' => $request->shipper_consignee,
            'voyage_vessel' => $request->voyage_vessel,
            'voyage_no' => $request->voyage_no,
            'pickup_location' => $request->pickup_location,
            'delivery_location' => $request->delivery_location,
        ]);

        return redirect()->route('manager.managetrip')->with('success', 'Trip updated successfully.');
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