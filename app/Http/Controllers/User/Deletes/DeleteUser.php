<?php

namespace App\Http\Controllers\User\Deletes;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class DeleteUser
{
    public function show($user_id)
    {
        $data = User::findorFail($user_id);

        return inertia(
            'User/DeleteUser',
            [
                'data' => $data
            ]
        );
    }

    public function showDeleteUserRole($user_id, $role_id)
    {
        
        $role = Role::findorFail($role_id);

        return inertia(
            'User/DeleteUserRole',
            [
                'user_id' => $user_id,
                'role' => $role
            ]
        );
    }

    public function delete($user_id)
    {
        $user = User::findorFail($user_id);
        $user->roles()->detach();
        $user->delete();

        return response()->json(
            [
                'success' => 'Delete successfully!',
                'data' => $user
            ]
        );
    }
}
