<?php

namespace App\Http\Controllers\Authorization\Updates;

use App\Models\Action;
use App\Models\Module;
use App\Models\Project;
use App\Models\Stakeholder;
use Illuminate\Http\Request;

class UpdateAuthorization
{
    //
    public function showEdit($project_id)
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

        return inertia('Authorization/EditAuthorizations', [
            'project' => $project,
            'smodules' => $modules,
            'actions' => $actions,
            'stakeholders' => $stakeholders,
            'authorizations' => $authorizations
        ]);
    }

    public function updateAll(Request $request)
    {
        $checkedArrays = $request->input('checkedArray');

        
        foreach ($checkedArrays as $key => $values) {
            $action = Action::find($key);
            $authorizedArray = [];
            // $addIds[$key] = [];
            // $deleteIds[$key] = [];
            $addIds = [];
            $deleteIds = [];

            foreach ($action->stakeholders as $stake) {
                array_push($authorizedArray, $stake->pivot->stakeholder_id);
            }

            $temp_arr = [];
           
            foreach ($values as $stake_id => $value) {
                // if (!in_array($value, $authorizedArray)) {
                //     array_push($addIds, $value);
                // }
                
                if ($value) {
                    array_push($temp_arr, $stake_id);
                };
                
            }

            foreach ($temp_arr as $checkedId) {
                if (!in_array($checkedId, $authorizedArray)) {
                    array_push($addIds, $checkedId);
                }
            }

            foreach ($authorizedArray as $element) {
                if (!in_array($element, $temp_arr)) {
                    array_push($deleteIds, $element);
                }
            }


            if (count($addIds) !== 0) {
                $action->stakeholders()->syncWithoutDetaching($addIds);
            }

            if (count($deleteIds) !== 0) {
                $action->stakeholders()->detach($deleteIds);
            }
        };

        return response()->json(
            [
                'success' => 'successfully updated!'
            ]
        );
    }
}
