<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Member;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $members = Member::all();
        return response()->json([
            'status' => 'success',
            'member' => $members,
        ], 201);
    }

    public function store_member(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|integer|min:20',
            'address' => 'string|max:255',
            'done_exchange_sampah' => 'integer|min:11',
            'total_transaction' => 'integer|min:11',
            // 'member_status' => 'string'
        ]);

        $member = Member::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'done_exchange_sampah' => $request->done_exchange_sampah,
            'total_transaction' => $request->total_transaction,
            'member_status' => $request->member_status
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'berhasil menambah member',
            'member' => $member,
        ], 201);
    }

    public function show($id)
    {
        $member = Member::find($id);
        return response()->json([
            'status' => 'success',
            'member' => $member,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|integer|min:20',
            'address' => 'string|max:255',
            'done_exchange_sampah' => 'integer|min:11',
            'total_transaction' => 'integer|min:11',
            'member_status' => 'enum'
        ]);

        $member = Member::find($id);
        $member-> name = $request->name;
        $member-> phone = $request->phone;
        $member->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil memperbarui data member',
            'member' => $member

        ], 201);
    }

    public function delete($id)
    {
        $member = Member::find($id);
        $member->delete();

        return response()->json([
            'status' => 'success', 
            'message' => 'Berhasil menghapus member',
            'member' => $member
        ], 201);
    }
}
