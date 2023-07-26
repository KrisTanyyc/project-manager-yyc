<?php

namespace App\Http\Controllers\Project\Lists;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\ModuleResource;
use App\Models\Module;
use App\Models\Snapshot;

class ListProject
{

    //
    public function show()
    {
        $data = Project::latest()->get();
        $data = ProjectResource::collection($data);

        return inertia('Project/ListProject', [
            'project_array' => $data
        ]);
    }

    public function print()
    {
        return inertia('Project/Print');
    }



    public function list()
    {
        $data = Project::latest()->get();

        return ProjectResource::collection($data);
    }


    public function showCertainProject($project_id)
    {
        $project = Project::findorFail($project_id);
        $modules = $project->modules->sortBy('order')->values();
        
        $stakeholders = $project->stakeholders->sortBy('order')->values();

        

        $actions = [];
        $authorizations = [];


        foreach ($modules as $key => $value) {
            $actions[$key] = $value->actions->sortBy('order')->values();
        }

        for ($i = 0; $i < count($actions); $i++) {
            $authorizations[$i] = [];

            foreach ($actions[$i] as $action) {
                $tempArray = [];
                foreach ($action->stakeholders as $element) {
                    array_push($tempArray, $element->pivot->stakeholder_id);
                }
                array_push($authorizations[$i], $tempArray);
            }
        }

        $snapshot = Snapshot::select('id','name')->where('project_id',$project_id)->get();

        return inertia('Project/NewProject', [
            'project' => $project,
            'smodules' => $modules,
            'actions' => $actions,
            'stakeholders' => $stakeholders,
            'authorizations' => $authorizations,
            'snapshots' => $snapshot
        ]);
    }

    public function test()
    {
        return inertia('Authorization/Test');
    }
}
