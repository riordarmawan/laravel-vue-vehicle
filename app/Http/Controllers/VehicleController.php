<?php

namespace App\Http\Controllers;

use App\Models\UploadedFile;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VehicleController extends Controller
{

    public function index()
    {
        return Inertia::render('ListVehicles/Index');
    }

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

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'brand' => 'required|string|max:255',
    //         'name' => 'required|string|max:255',
    //         'price' => 'required|numeric',
    //         'seat' => 'required|integer',
    //         'transmission' => 'required|string',
    //         'type' => 'required|string',
    //     ]);

    //     Vehicle::create([
    //         'brand' => $request->brand,
    //         'name' => $request->name,
    //         'price' => $request->price,
    //         'seat' => $request->seat,
    //         'transmission' => $request->transmission,
    //         'type' => $request->type,
    //     ]);

    //     return response()->json([
    //         'message' => 'Create successfully'
    //     ]);
    // }


    // public function createVehicle()
    // {
    //     return Inertia::render('ListVehicles/Create'); // Mengarahkan ke halaman create
    // }

    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'seat' => 'required|integer',
            'transmission' => 'required|string|max:50',
            'type' => 'required|string|max:50',
        ]);

        Vehicle::create($request->all());

        return redirect()->route('listVehicle.vehicle');
    }


    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($request->only(['brand', 'name', 'price', 'seat', 'transmission', 'type']));

        return response()->json([
            'message' => 'update successfully'
        ]);
    }

    public function dataUploaded()
    {
        $allData = UploadedFile::all();

        return response()->json([
            'data' => $allData
        ]);
    }

    public function upload(Request $request)
    {
        // dd($request->all());
        $request->validate([
            // 'text' => 'required|string',
            'description' => 'required|string', // Validasi teks deskripsi (opsional)
            'file' => 'required|file|max:10240', // Maksimal 10MB
        ]);

        // Simpan file ke direktori storage/app/uploads
        $file = $request->file('file');
        $filePath = $file->store('uploads', 'public');

        // Simpan metadata file ke database
        $uploadedFile = UploadedFile::create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'file_type' => $file->getMimeType(),
            // 'text' => $request->input('text'), // Menyimpan teks ke database
            // 'description' => $request->input('description'), // Menyimpan deskripsi ke database
            // 'text' => $request->text,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'File uploaded and saved successfully',
            'file' => $uploadedFile,
            // 'text' => $request->text,
            'description' => $request->description
        ]);
    }
}
