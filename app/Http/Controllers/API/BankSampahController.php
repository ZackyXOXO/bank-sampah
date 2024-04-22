<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Models\BankSampah;
use Illuminate\Support\Facades\Auth;


class BankSampahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        error_log(Auth::user()->id);

        $banks = BankSampah::all();
        return response()->json([
            'status' => 'success',
            'bank' => $banks,
        ], 201);
    }

    public function store_sampah(Request $request) 
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'string|max:255',
            'phone_number' => 'required|string|max:255',
            'desc_bank_sampah' => 'required|string|max:255',

        ]);

        $bank = BankSampah::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'desc_bank_sampah' => $request->desc_bank_sampah,
            'created_by' => Auth::user()->name
        ]);

        $user = Auth::user();
        $user->has_bank = 1;
        $user->save();


        return response()->json([
            'status' => 'Success',
            'message' => 'Bank Sampah Berhasil ditambah!',
            'bank' => $bank,
            'user' => $user
        ]);
    }

    public function show($id)
    {
        $bank = BankSampah::find($id);
        return response()->json([
            'status' => 'success',
            'bank' => $bank,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'string|max:255',
            'phone_number' => 'required|string|max:255',
            'desc_bank_sampah' => 'required|string|max:255',
            'coordinat_bank_sampah' => 'string|max:255',
        ]);

        $bank = BankSampah::find($id);
        $bank-> name = $request->name;
        $bank-> address = $request->address;
        $bank-> phone_number = $request->phone_number;
        $bank-> desc_bank_sampah = $request->desc_bank_sampah;
        $bank->coordinat_bank_sampah = $request->coordinat_bank_sampah;
        $bank->save();

        return response()->json([
            'status' => 'Success',
            'message' => 'Berhasil memperbarui data Bank Sampah',
            'bank' => $bank

        ], 201);
    }

    public function delete($id)
    {
        $bank = BankSampah::find($id);
        $bank->delete();

        return response()->json([
            'status' => 'Success', 
            'message' => 'Berhasil Menghapus Data Bank Sampah',
            'bank_deleted' => $bank
        ], 201);
    }

}
