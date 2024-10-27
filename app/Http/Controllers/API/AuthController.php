<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        // try {
        //     $data = $request->all();
        //     $user = new User();
        //     $user->name = $data['name'];
        //     $user->email = $data['email'];
        //     $user->password = $data['password'];
        //     $user->save();
        //     return response()->json(['msg' => "Accuount Created Successfuly", "success" => true, "data" => ["user" => $user]]);
        // } catch (Exception $e) {
        //     return response()->json(['msg' => $e->getMessage(), "success" => false, "data" => [""]]);
        // }
    }

    // public function login(Request $request)
    // {
    //     $creds=$request->only(['email', 'password']);
    //     $email=$creds['email'];
    //     $password=$creds['password'];
    //     //check user by email
    //     $userExists=User::where('email',$email)->first();
    //     if(!userExists) {
    //         return response()->json(['msg' =>"invalid credentials", "success" => false, "data" =>[]],401);
    //     }
    //     //check password
    //     if(!Hash::check($passowrd,$userExists->password))
    //     {
    //         return response()->json(['msg' =>"invalid credentials", "success" => false, "data" =>[]],401);

    //     }

    //     //generate tokec
    //     $token=$userExists->createToken()->plainTextToken;
    //     return response()->json(["msg"=>"logged in successfully","success"=>true, "data","data"[
    //         "token"=>$token,
    //         "user"=>$userExists
    //     ]])
    // }
}
