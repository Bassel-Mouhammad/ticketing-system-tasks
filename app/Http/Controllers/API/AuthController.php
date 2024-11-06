<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = new User();
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            $user->save();

            return response()->json([
                'msg' => "Account Created Successfully",
                "success" => true,
                "data" => ["user" => $user]
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'msg' => $e->getMessage(),
                "success" => false,
                "data" => [""]
            ]);
        }
    }


    public function login(Request $request)
    {
        $creds = $request->only(['email', 'password']);
        $email = $creds['email'];
        $password = $creds['password'];
        //check user by email
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'msg' => "invalid credentials",
                "success" => false,
                "data" => []
            ], 401);
        }
        //check password
        if (!Hash::check($creds["password"], $user->password)) {
            return response()->json([
                'msg' => "invalid credentials",
                "success" => false,
                "data" => []
            ], 401);
        }

        //generate tokec
        // Generate token
        $token = $user->createToken("login")->plainTextToken;
        // Return the token with json response
        return response()->json([
            "msg" => "logged in successfully",
            "success" => true,
            "data" => [
                "token" => $token,
                "user" => $user
            ]
        ]);
    }
    public function logout(Request $request)
    {
        try {
            // Get the authenticated user
            $user = $request->user();

            // Check if user is authenticated
            if (!$user) {
                return response()->json([
                    "success" => false,
                    "msg" => "No authenticated user found.",
                    "data" => []
                ], 401);
            }

            // Delete the user's current access token
            $user->currentAccessToken()->delete();

            return response()->json([
                "success" => true,
                "msg" => "Logged out successfully",
                "data" => ["user" => $user]
            ]);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "msg" => $e->getMessage(),
                "data" => []
            ], 500);
        }
    }
}
