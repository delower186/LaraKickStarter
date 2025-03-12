<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Users\UserUpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Tools\Response;
use App\Tools\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize(Permission::format("view", 'user'), User::class);
        return Response::success('Users data found.', ['users'=> User::paginate(10)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize(Permission::format("create", 'user'), User::class);
        return Response::success('Please use register endpoint here "/api/v1/register"');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize(Permission::format("view", 'user'), User::class);
        return Response::success('User data found.', ['user'=> $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->authorize(Permission::format("update", 'user'), User::class);
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
        $this->authorize(Permission::format("delete", 'user'), User::class);
        DB::transaction(function () use ($user) {
            $user->delete();
        });
        return Response::success('User Deleted Successfully.');
    }
}
