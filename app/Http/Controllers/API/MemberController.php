<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Member;
use App\Models\Todo;


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
            'phone' => 'required|string|max:255',
            'address' => 'string|max:255',
        ]);

        $member = Member::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Todo created successfully',
            'member' => $member,
        ]);
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
            // 'name' => 'required|string|max:255',
            // 'phone' => 'required|string|min:20',
            // 'address' => 'string|max:255',
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
