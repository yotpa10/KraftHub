<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) 
    {
        $request->validate([
            "agreement" => "accepted",
            "first_name" => "required|string",
            "last_name" => "required|string",
            "email"=> "required|string|email|unique:users,email",
            "password" => "required|string|confirmed",
            'cellphone_number' => "required|string",
            'house_info'=> "required|string",
            // 'street_name'=> "required|string",
            // 'barangay'=> "required|string",
            // 'city'=> "required|string",
            'zipcode'=> "required|string",
        ]);

        $user = User::create([
            "first_name" => $request->input('first_name'),
            "last_name" => $request->input('last_name'),
            "middle_name" => $request->input('middle_name'),
            "phone_number" => $request->input('phone_number'),
            "cellphone_number" => $request->input('cellphone_number'),
            "house_info" => $request->input('house_info'),
            "street_name" => $request->input('street_name', ''),
            "barangay" => $request->input('barangay', ''),
            "city" => $request->input('city', ''),
            "zipcode" => $request->input('zipcode', ''),
            "email" => $request->input('email', ''),
            "password" => bcrypt($request->input('password')),
            "access_level" => 1
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 200);
    }

    public function login(Request $request) 
    {
        $request->validate([
            "email"=> "required|string|email",
            "password" => "required|string",
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response([
                'message' => 'User name and password does not matched',
                'status' => '401'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response([
            "token" => $token,
            "user" => $user
        ], 200);
    }

    public function logout() 
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
