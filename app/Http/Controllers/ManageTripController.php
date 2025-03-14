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
    public function UpdateManageTrip(Request $request, $id)
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

        return redirect()->route('admin.managetrip')->with('success', 'Trip updated successfully.');
    }
}