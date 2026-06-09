<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $vehicleTypes = VehicleType::when($search, function ($q) use ($search) {
            $q->where('jenis', 'like', "%{$search}%");
        })->orderBy('id')->get();

        return view('vehicle-types.index', compact('vehicleTypes', 'search'));
    }

    public function create()
    {
        $existingJenis = VehicleType::pluck('jenis')->toArray();
        $allJenis = ['motorcycle', 'car', 'other'];
        $availableJenis = array_diff($allJenis, $existingJenis);

        return view('vehicle-types.create', compact('availableJenis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis'              => 'required|in:motorcycle,car,other|unique:parkir_vehicle__types,jenis',
            'perjam_pertama'     => 'required|integer|min:0',
            'perjam_berikutnya'  => 'required|integer|min:0',
            'max_perhari'        => 'required|integer|min:0',
        ]);

        VehicleType::create($request->only(['jenis', 'perjam_pertama', 'perjam_berikutnya', 'max_perhari']));

        return redirect()->route('vehicle-types.index')->with('success', 'New Vehicle Type was successfully saved!');
    }

    public function edit(VehicleType $vehicleType)
    {
        return view('vehicle-types.edit', compact('vehicleType'));
    }

    public function update(Request $request, VehicleType $vehicleType)
    {
        $request->validate([
            'perjam_pertama'    => 'required|integer|min:0',
            'perjam_berikutnya' => 'required|integer|min:0',
            'max_perhari'       => 'required|integer|min:0',
        ]);

        $vehicleType->update($request->only(['perjam_pertama', 'perjam_berikutnya', 'max_perhari']));

        return redirect()->route('vehicle-types.index')->with('success', 'Vehicle Type was successfully updated!');
    }

    public function destroy(VehicleType $vehicleType)
    {
        $vehicleType->delete();
        return redirect()->route('vehicle-types.index')->with('success', 'Vehicle Type deleted.');
    }
}
