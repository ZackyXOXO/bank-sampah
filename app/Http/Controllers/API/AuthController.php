<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $credentials = $request->only('email', 'password');
        $token = auth()->guard('api')->attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Login Gagal',
            ], 401);
        }

        $user = auth()->guard('api')->user();
        return response()->json([
            'user' => $user, 
            'authorization' => [
                'token' => $token, 
                'type' => 'bearer',
                'expires_in' => auth()->guard('api')->factory()->getTTL()*60
            ]
            ], 200);
    }
    
    public function register (Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'string|',
            'role' => 'required',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        if(!$user){
            return response()->json([
                'success' => false,
            ], 409);
      }

      return response()->json([
        'message' => 'User Baru Berhasil ditambahkan',
        'user' => $user
    ],201);
    }

    public function logout()
    {
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());
        if($removeToken){
            return response()->json([
              'message' => 'Sukses Keluar Akun',
            ]);
        }else{
              return response()->json([
                  'success' => false,
                  'message' => 'Gagal Keluar Akun',
              ], 409);
        }
    }

    public function refresh()
    {
        $token = auth()->guard('api')->refresh();
        if($token){
            return response()->json([
                'user' => auth()->guard('api')->user(),
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60
                ]
            ]);
        }else{
              return response()->json([
                  'success' => false,
                  'message' => 'Gagal Memperbarui Token',
              ], 409);
        }
    }

    public function count_superadmin(Request $request)
    {
        $superadmin = User::query()->where('role' , '!=', 'admin')->select()->count();
        error_log( $superadmin);
        return response()->json([
            "status" => "Success",
            "c_superadmin" => $superadmin
        ]);
    }

    public function count_admin(Request $request)
    {
        $admin = User::query()->where('role' , '!=', 'superadmin')->select()->count();
        error_log($admin);
        return response()->json([
            "status" => "Success",
            "c_admin" => $admin
        ]);
    }

    public function update (Request $request)
    {
        $user = Auth::user();
        $user->has_bank = $request->has_bank;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil',
            'user' => $user
        ], 201);
    }

    public function update_data (Request $request) 
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Memperbarui Data',
            'user' => $user
        ], 201);
    }
}