<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;

class RoleController extends Controller
{
    public function attach(Request $request, User $user)
    {
        $roleId = $request->role_id;
        $userId = $request->user;
        $user = User::find($userId);
        $user->roles()->attach($roleId);
        return response()->json();
    }

    public function detach(Request $request)
    {
        $roleId = $request->role_id;
        $userId = $request->user;
        $user = User::find($userId);
        $user->roles()->detach($roleId);
        return response()->json();
    }
}
