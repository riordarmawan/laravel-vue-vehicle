<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

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
}
