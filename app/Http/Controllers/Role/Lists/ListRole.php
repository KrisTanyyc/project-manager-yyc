<?php

namespace App\Http\Controllers\Role\Lists;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Resources\RoleResource;

class ListRole
{
    public function show()
    {
        $data = Role::latest()->get();
        $data = RoleResource::collection($data);
        return inertia('Role/ListRole',[
            'roles_array' => $data,
        ]);
    }

    public function list()
    {
        $data = Role::latest()->get();
        return RoleResource::collection($data);
    }

}