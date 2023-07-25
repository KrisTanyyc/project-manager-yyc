<?php

namespace App\Http\Controllers\Snapshot\Creates;

use App\Models\Project;
use App\Models\Snapshot;
use Illuminate\Http\Request;

class CreateSnapshot
{
    //
    public function show($project_id)
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

        return inertia(
            'Snapshot/CreateSnapshot',
            [
                'project' => $project,
                'smodules' => $modules,
                'actions' => $actions,
                'stakeholders' => $stakeholders,
                'authorizations' => $authorizations
            ]
        );
    }

    public function create($project_id, Request $request)
    {  
        $snapshot = Snapshot::create([
            'name' => $request->input('name'),
            'project_id' => $project_id,
            'data' => $request->input('data')
        ]);

        $snapshot['order'] = $snapshot->id;
        $snapshot->save();

        return response()->json(
            [
                'success' => 'Created successfully',
                'data' => $snapshot
            ]
        );
    }

    public function showabc()
    {
        $snapshot = Snapshot::select('id','name')->where('project_id',31)->get();

        return response()->json(
            [
                'success' => 'Created successfully',
                'data' => $snapshot
            ]
        );
    }
}
