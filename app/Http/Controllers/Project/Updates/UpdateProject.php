<?php

namespace App\Http\Controllers\Project\Updates;

use App\Models\Project;
use Illuminate\Http\Request;

class UpdateProject 
{
    //
    public function show($project_id)
    {

        $project = Project::findorFail($project_id);

        return inertia('Project/UpdateProject',[
            'data' => $project
        ]);
    }

    public function update($project_id, Request $request)
    {
        $project = Project::findorFail($project_id);
        $project->name = $request->input('name');
        $project->save();

        return response()->json([
            'success' => 'Update successfully!',
            'data' => $project
        ]);

    }
}
