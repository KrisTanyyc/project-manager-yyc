<?php

namespace App\Http\Controllers\Authorization\Lists;

use App\Models\Action;
use App\Models\Module;
use App\Models\Project;
use App\Models\Stakeholder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListAuthorization
{
    //
    public function show($project_id, $module_id, $action_id)
    {
        $project = Project::findorFail($project_id);
        $module = Module::findorFail($module_id);
        $action = Action::findorFail($action_id);
        $stakeholder = Stakeholder::where('project_id', $project_id)->get();



        return inertia(
            'Authorization/ListAuthorization',
            [
                'project' => $project,
                'smodule' => $module,
                'action' => $action,
                'stakeholders' => $stakeholder
            ]
        );
    }

    public function list($action_id)
    {
        $actions = Action::find($action_id);
        $array = [];

        foreach ($actions->stakeholders as $action) {
            array_push($array, $action->pivot->stakeholder_id);
        }
        return $array;
    }

}
