<?php

namespace App\Http\Controllers\Project\Deletes;

use App\Models\Project;
use Illuminate\Http\Request;

class DeleteProject 
{
    //
    public function show($project_id)
    {
        $project = Project::findorFail($project_id);

        return inertia('Project/DeleteProject',[
            'data' => $project
        ]);
    }

    public function delete($project_id)
    {
        $project = Project::findorFail($project_id);
        $project->delete();

        return response()->json(
            [
                'success' => 'Delete successfully!',
                'data' => $project
            ]
        );

    }
}
