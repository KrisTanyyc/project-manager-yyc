<?php

namespace App\Http\Controllers\Project\Creates;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateProject
{
    //
    public function show()
    {
        return inertia('Project/CreateProject');
    }

    public function create(Request $request)
    {
        $project = Project::create([
            'name' => $request->input('name'),
        ]);

        return response()->json(
            [
                'success' => 'Created successfully',
                'data' => $project
            ]
        );
    }
}
