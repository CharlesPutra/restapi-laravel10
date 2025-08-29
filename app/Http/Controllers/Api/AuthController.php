<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //coba nampilin semua data user
    public function index() {
        return response()->json(User::all());
    }
    //Register api
    public function register(Request $request) {
        //validasi
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6'
        ]);
        //store ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        //bikin token api
        $token = $user->createToken('token')->plainTextToken;
        //nampilkan token di postman
        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    //Login api
    public function login(Request $request) {
        //mencari request email
        $user = User::where('email', $request->email)->first(); //ambil satu data pertama yang cocok. Kalau tidak ada, hasilnya null.
        // filtering atau validasi password ketika user atau password tidak ada data 
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['massage' => 'Invalid credentials'], 401);
        }
        //bikin token 
        $token = $user->createToken('token')->plainTextToken;
        //menapilkan response
        return response()->json(['user' => $user, 'token' => $token]);
    }

    //Logout api
    public function logout(Request $request) {
        //hapus token user ketika logout
        $request->user()->tokens()->delete(); //hapus token di semua device user ketika login
        //response ketika logout
        return response()->json(['massage' => 'telah logout']);
    }
}
