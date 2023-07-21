<?php

namespace App\Http\Controllers\RoleToUser;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserRoleResource;



class RoleToUserController extends Pivot
{
    public function displayRolesName()
    {
        $data = DB::select('SELECT * FROM roles WHERE id != 1 AND deleted_at IS NULL');

        return RoleResource::collection($data);
    }

    // public function listUserRoles($user_id)
    // {
    //     $data = DB::select("SELECT a.*, b.role_id as role_id, c.name as role_name
    //                     FROM users as a, role_to_user b, roles c
    //                     WHERE a. id = b.user_id
    //                     AND b.role_id = c.id
    //                     AND a.id= :user_id
    //                     ORDER BY role_name ASC", array(
    //         'user_id' => $user_id,
    //     ));


    //     return UserRoleResource::collection($data);
    // }


    public function listUserAssignRoles($user_id)
    {
        $user = User::findorFail($user_id);

        $roles = $user->roles()->get(['id']);

        $roles_id = [1];

        foreach ($roles as $role) {
            array_push($roles_id, $role->id);
        }

        $data = Role::whereNotIn('id', $roles_id)->get();

        // // $data = DB::select("SELECT * FROM roles WHERE id NOT IN " . $role_id . " AND deleted_at IS NULL");


        return RoleResource::collection($data);
    }

    public function assignUserRole(Request $request)
    {
        $user_id = $request->input('user_id');
        $roles_id = $request->input('roles_id');

        $user = User::findorFail($user_id);
        $user->roles()->syncWithoutDetaching($roles_id);

        return response()->json(
            [
                'success' => 'Role Assigned!',
                'data' => $user
            ]
        );
    }

    public function removeUserRole(Request $request)
    {
        $role_id = $request->input('role_id');
        $user_id = $request->input('user_id');

        $user = User::findorFail($user_id);
        $user->roles()->detach($role_id);

        return response()->json(
            [
                'success' => 'successfully deleted!',
                'data' => $user
            ]
        );
    }
}
