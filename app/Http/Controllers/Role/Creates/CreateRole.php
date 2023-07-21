<?php

namespace App\Http\Controllers\Role\Creates;

use Illuminate\Http\Request;
use App\Models\Role;

class CreateRole
{
    public function show()
    {
        return inertia('Role/CreateRole');
    }

    public function create(Request $request)
    {

        $role = Role::create([
            'name' => $request->input('role_name')
        ]);

        return response()->json(
            [
                'success' => 'Created successfully',
                'data' => $role
            ]
        );
    }
}