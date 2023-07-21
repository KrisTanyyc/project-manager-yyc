<?php

namespace App\Http\Controllers\User\Updates;

use Illuminate\Http\Request;
use App\Models\User;

class UpdateUser
{
    public function show($user_id)
    {
        $data = User::findorFail($user_id);

        return inertia('User/UpdateUser', [
            'data' => $data
        ]);
    }

    public function showAssignRole($user_id)
    {
        $user = User::findorFail($user_id);

        return inertia('User/AssignUserRole',[
            'user' => $user
        ]);
    }

    public function update($user_id, Request $request)
    {
        $data = User::findorFail($user_id);
        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->save();

        return response()->json([
            'success' => 'Update successfully!',
            'data' => $data
        ]);
    }
}
