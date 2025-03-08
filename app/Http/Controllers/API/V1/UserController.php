<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Users\UserUpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Tools\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);

        return Response::success('Users data found.', ['users'=> $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Response::success('Please use register endpoint here "/api/v1/register"');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return Response::success('User data found.', ['user'=> $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        if($request->role == $user->role && $request->status == $user->status)
        {
            return Response::success('Nothing to update.');
        }

        DB::transaction(function () use ($user, $request) {
            $user->role = $request->role;
            $user->status = $request->status;
            $user->save();
        });

        return Response::success('User data updated successfully.', ['user'=> $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        DB::transaction(function () use ($user) {
            $user->delete();
        });
        return Response::success('User Deleted Successfully.');
    }
}
