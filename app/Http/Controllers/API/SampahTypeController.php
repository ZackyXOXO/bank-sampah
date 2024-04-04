<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\SampahType;

class SampahTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $type = SampahType::all();
        return response()->json([
            'status' => 'Success',
            'type' => $type,
        ], 201);
    }

    public function store_type(Request $request)
    {
        $request->validate([
            'sampah_type_name' => 'required|string|max:255',
            'price_kg' => 'max:11',
        ]);

        $type = SampahType::create([
            'sampah_type_name' => $request->sampah_type_name,
            'price_kg' => $request->price_kg,
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'Tipe Sampah Berhasil ditambah!',
            'type' => $type,
        ]);
    }

    public function show($id)
    {
        $type = SampahType::find($id);
        return response()->json([
            'status' => 'Success',
            'type' => $type,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sampah_type_name' => 'required|string|max:255',
            'price_kg' => 'integer|max:255',
        ]);

        $type = SampahType::find($id);
        $type->sampah_type_name = $request->sampah_type_name;
        $type->price_kg = $request->price_kg;
        $type->save();

        return response()->json([
            'status' => 'Success',
            'message' => 'Tipe Sampah berhasil diperbarui!',
            'type' => $type,
        ]);
    } 

    public function delete($id)
    {
        $type = SampahType::find($id);
        $type->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'Tipe Smpah dihapus!',
            'type' => $type,
        ]);
    }
}
