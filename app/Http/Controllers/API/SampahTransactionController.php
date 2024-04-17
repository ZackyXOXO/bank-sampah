<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\SampahTransaction;
use App\Models\Member;


use Illuminate\Http\Request;

class SampahTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index() {
        $transaksi = SampahTransaction::all();
        $member = DB::table('members');

        return response()->json([
            "status" => "success",
            "transaksi" => $transaksi,
            "member" => $member
        ]);
    }
}
