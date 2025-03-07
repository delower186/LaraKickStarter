<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request){

        $token = "";
        $user = "";

        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()],422);
        }

        DB::transaction(function() use ($request, &$user, &$token){

            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            $token = $user->createToken('AuthToken')->plainTextToken;

        });

        return response()->json([
            'message' => 'User Created, Please Login to continue.',
            'user'=> $user,
            'token' => $token
        ]);
    }

    public function login(Request $request){}
    public function user(Request $request){}
    public function logout(Request $request){}
}
