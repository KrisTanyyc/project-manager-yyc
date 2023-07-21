<?php

namespace App\Http\Controllers\Action\Deletes;

use App\Models\Action;
use Illuminate\Http\Request;

class DeleteAction
{
    //
    public function show($project_id, $module_id, $action_id)
    {
        $action = Action::where('module_id', $module_id)
            ->where('id', $action_id)->first();

        return inertia(
            'Action/DeleteAction',
            [
                'data' => $action,
                'project_id' => $project_id
            ]
        );
    }

    public function delete($module_id, $action_id)
    {
        $action = Action::where('module_id', $module_id)
            ->where('id', $action_id)->first();

        $action->delete();

        return response()->json(
            [
                'success' => 'Delete successfully!',
                'data' => $action
            ]
        );
    }
}
