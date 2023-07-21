<?php

namespace App\Http\Controllers\Role\Updates;

use Illuminate\Http\Request;
use App\Models\Role;

class UpdateRole
{
    public function show($role_id)
    {
        $data = Role::findorFail($role_id);

        return inertia(
            'Role/UpdateRole',
            [
                'data' => $data,
            ]
        );
    }

    public function update($role_id, Request $request)
    {
        $data = Role::findorFail($role_id);
        $data->name = $request->input('role_name');
        $data->save();

        return response()->json([
            'success' => 'Update successfully!',
            'data' => $data
        ]);
    }

}
