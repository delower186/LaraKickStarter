<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Http\Controllers\Controller;

use App\Tools\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function register(RegisterRequest $request){

        $token = "";
        $user = "";

        DB::transaction(function() use ($request, &$user, &$token){

            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            $token = $user->createToken('AuthToken')->plainTextToken;

        });
        return Response::success('User Created, Please Login to continue', ['user' => $user, 'token'=>$token]);
    }

    public function login(LoginRequest $request){

        $token = "";

        $user = User::where('email', $request['email'])->first();

        if(!$user || !Hash::check($request->password, $user->password)){

            return Response::error('Invalid login details',[],401);
        }

        DB::transaction(function() use ($user, &$token){

            $token = $user->createToken('AuthToken')->plainTextToken;

        });
        return Response::success('Login Successull.', ['user' => $user, 'token'=>$token]);
    }
    public function user(Request $request){

        return Response::success('User data found', ['user'=> $request->user()]);
    }
    public function logout(Request $request){

        $request->user()->tokens()->delete();

        return Response::success('Logged out successfully.');
    }
}
