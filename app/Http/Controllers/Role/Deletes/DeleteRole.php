<?php

namespace App\Http\Controllers\Role\Deletes;

use Illuminate\Http\Request;
use App\Models\Role;

class DeleteRole
{
    public function show($role_id)
    {
        $data = Role::findorFail($role_id);


        return inertia(
            'Role/DeleteRole',
            [
                'data' => $data
            ]
        );
    }

    public function delete($role_id)
    {
        $data = Role::findorFail($role_id);

        $data->users()->detach();

        $data->delete();

        return response()->json(
            [
                'success' => 'Delete successfully!',
                'data' => $data
            ]
        );
    }
}
