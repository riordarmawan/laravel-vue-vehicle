<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VehicleController extends Controller
{
    public function listVehicle()
    {
        $data = Vehicle::select('id', 'brand', 'name', 'price', 'seat', 'transmission', 'type')
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function create()
    {
        return Inertia::render('ListVehicles/Create');
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($request->only(['brand', 'name', 'price', 'seat', 'transmission', 'type']));

        return response()->json([
            'message' => 'update successfully'
        ]);
    }
}
