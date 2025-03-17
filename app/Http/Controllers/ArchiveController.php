<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Gamitin ang User model para sa mga account
use App\Models\Profit; // Gamitin ang Profit model para sa mga profit records
use App\Models\FuelConsumption;
use App\Models\Cargo;

class ArchiveController extends Controller
{
    // Ipakita ang archived accounts
    public function showArchive()
    {
        $archivedUsers = User::onlyTrashed()->get(); // Kunin ang mga archived accounts
        $archivedProfits = Profit::onlyTrashed()->get(); // Kunin ang mga archived profit records
        $archivedFuel = FuelConsumption::onlyTrashed()->get(); // Kunin ang mga archived fuel consumption records
        $archivedTrips = Cargo::where('is_archived', 1)->get(); // Kunin ang mga archived trips

        return view('admin.archive', compact('archivedUsers', 'archivedProfits', 'archivedFuel', 'archivedTrips'));
    }

    // I-archive ang account
    public function archiveAccount($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Soft delete ang account
        return redirect()->back()->with('success', 'Account archived successfully.');
    }

    // I-restore ang archived account
    public function restoreAccount($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore(); // I-restore ang account
        return redirect()->route('admin.archive')->with('success', 'Account restored successfully.');
    }

    // Permanenteng tanggalin ang archived account
    public function destroyAccount($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete(); // Permanenteng tanggalin ang account
        return redirect()->route('admin.archive')->with('success', 'Account permanently deleted.');
    }

    // I-archive ang profit record
    public function archiveProfit($id)
    {
        $profit = Profit::findOrFail($id);
        $profit->delete(); // Soft delete ang profit record
        return redirect()->back()->with('success', 'Profit record archived successfully.');
    }

    // I-restore ang archived profit record
    public function restoreProfit($id)
    {
        $profit = Profit::onlyTrashed()->findOrFail($id);
        $profit->restore(); // I-restore ang profit record
        return redirect()->route('admin.archive')->with('success', 'Profit record restored successfully.');
    }

    // Permanenteng tanggalin ang archived profit record
    public function destroyProfit($id)
    {
        $profit = Profit::onlyTrashed()->findOrFail($id);
        $profit->forceDelete(); // Permanenteng tanggalin ang profit record
        return redirect()->route('admin.archive')->with('success', 'Profit record permanently deleted.');
    }

    public function restoreFuel($id)
    {
        $fuel = FuelConsumption::onlyTrashed()->findOrFail($id);
        $fuel->restore();
        return redirect()->route('admin.archive')->with('success', 'Fuel consumption restored successfully.');
    }

    public function destroyFuel($id)
    {
        $fuel = FuelConsumption::onlyTrashed()->findOrFail($id);
        $fuel->forceDelete();
        return redirect()->route('admin.archive')->with('success', 'Fuel consumption permanently deleted.');
    }

    // I-restore ang archived trip
    public function restoreTrip($id)
    {
        $trip = Cargo::findOrFail($id);
        $trip->update(['is_archived' => 0]); // I-restore ang trip
        return redirect()->route('admin.archive')->with('success', 'Trip restored successfully.');
    }

    // Permanenteng tanggalin ang archived trip
    public function destroyTrip($id)
    {
        $trip = Cargo::findOrFail($id);
        $trip->delete(); // Permanenteng tanggalin ang trip
        return redirect()->route('admin.archive')->with('success', 'Trip permanently deleted.');
    }
}