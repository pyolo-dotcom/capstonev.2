<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;
use Carbon\Carbon;

class ManageTripController extends Controller
{
    /**
     * Display a listing of trips based on filters.
     */
    public function ShowManageTrip(Request $request)
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

        return view('admin.managetrip', compact('cargos', 'plateNo', 'filter'));
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
     * Archive a cargo trip record.
     */
    public function archiveTrip($id)
    {
        $cargo = Cargo::findOrFail($id);
        $cargo->update(['is_archived' => 1]);

        return response()->json(['success' => 'Trip archived successfully.']);
    }
}