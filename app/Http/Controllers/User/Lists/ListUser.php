<?php

namespace App\Http\Controllers\User\Lists;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Resources\UserRoleResource;

class ListUser
{
    public function show()
    {
        $data = DB::select('SELECT a.id, a.name, a.email, GROUP_CONCAT(b.name) as roles_names
        FROM users as a
        LEFT JOIN role_to_user as c ON a.id = c.user_id
        LEFT JOIN roles as b ON c.role_id = b.id
        WHERE a.deleted_at IS NULL
        GROUP BY a.id, a.name, a.email
        ORDER BY a.name ASC');

        return inertia('User/ListUser', [
            'users' => $data,
        ]);
    }

    public function showUserRole($user_id)
    {

        $data = DB::select("SELECT a.*, b.role_id as role_id, c.name as role_name
                        FROM users as a, role_to_user b, roles c
                        WHERE a. id = b.user_id
                        AND b.role_id = c.id
                        AND a.id= :user_id
                        ORDER BY role_name ASC", array(
            'user_id' => $user_id,
        ));

        $data = UserRoleResource::collection($data);

        return inertia(
            'User/ListUserRole',
            [
                'user_id' => $user_id,
                'roles_array' => $data
            ]
        );
    }

    public function list()
    {

        $data = DB::select('SELECT a.id, a.name, a.email, GROUP_CONCAT(b.name) as roles_names
        FROM users as a
        LEFT JOIN role_to_user as c ON a.id = c.user_id
        LEFT JOIN roles as b ON c.role_id = b.id
        WHERE a.deleted_at IS NULL
        GROUP BY a.id, a.name, a.email
        ORDER BY a.name ASC');

        return $data;
    }
}
