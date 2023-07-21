<?php

namespace App\Http\Controllers\User\Creates;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\http\Resources\UserResource;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class CreateUser
{
    public function show()
    {
        return inertia('User/CreateUser');
    }

    public function listUser()
    {
        $data = DB::select('SELECT * FROM users');


        return UserResource::collection($data);
    }

    public function create(Request $request)
    {
        try {
            $model = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);


            $model->roles()->attach($request->input('role_id'));

            return response()->json(
                [
                    'success' => 'Created Successfully',
                    'data' => $model
                ]
            );
        } catch (\Exception $e) {
            logger($e);
        }
    }
}
