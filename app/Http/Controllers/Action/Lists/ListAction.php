<?php

namespace App\Http\Controllers\Action\Lists;

use App\Http\Resources\ActionResource;
use App\Models\Action;
use App\Models\Project;
use App\Models\Module;
use Illuminate\Http\Request;

class ListAction
{
    //
    public function show($project_id, $module_id)
    {
        $project = Project::where('id', $project_id)->first();
        $module = Module::where('id', $module_id)->first();

        return inertia(
            'Action/ListAction',
            [
                'project' => $project,
                'smodule' => $module,
                'actions_array' => ActionResource::collection(Action::where('module_id', $module_id)->get())
            ]
        );
    }

    // public function list($project_id,$module_id)
    // {
    //     $data = Action::where('module_id', $module_id)->get();
    //     return ActionResource::collection($data);
    // }
}
