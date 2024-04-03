<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Models\CategorySampah;

class CategorySampahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $category = CategorySampah::all();
        return response()->json([
            'status' => 'Success',
            'category_sampah' => $category,
        ], 201);
    }

    public function store_category(Request $request)
    {
        $request->validate([
            'category_name' => 'string|max:255',
            'category_desc' => 'string|max:255',
        ]);
        

        $category = CategorySampah::create([
            'category_name' => $request->category_name,
            'category_desc' => $request->category_desc,
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'Kategori Sampah Berhasil ditambah',
            'category_sampah' => $category,
        ]);
    }

    public function show($id)
    {
        $category = CategorySampah::find($id);
        return response()->json([
            'status' => 'success',
            'category_sampah' => $category,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'string|max:255',
            'category_desc' => 'string|max:255',
        ]);

        $category = CategorySampah::find($id);
        $category->category_name = $request->category_name;
        $category->category_desc = $request->category_desc;
        $category->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori Sampah Berhasil diperarui',
            'category_sampah' => $category,
        ]);
    }

    public function destroy($id)
    {
        $category = Categorysampah::find($id);
        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori terhapus!',
            'category' => $category,
        ]);
    }

}
