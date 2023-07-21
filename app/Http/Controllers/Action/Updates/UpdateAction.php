<?php

namespace App\Http\Controllers\Action\Updates;

use App\Models\Action;
use Illuminate\Http\Request;

class UpdateAction
{
    //
    public function show($project_id, $module_id, $action_id)
    {
        $action = Action::where('module_id', $module_id)
            ->where('id', $action_id)->first();

        return inertia(
            'Action/UpdateAction',
            [
                'data' => $action,
                'project_id' => $project_id
            ]
        );
    }

    public function update($module_id,$action_id, Request $request)
    {
        $action = Action::where('module_id', $module_id)
            ->where('id', $action_id)->first();

        $action->name = $request->input('action_name');
        $action->save();

        return response()->json([
            'success' => 'Update successfully!',
            'data' => $action
        ]);
    }

    public function orderUpdate(Request $request)
    {
        $updatedActions = $request->input('updatedActions');


        foreach ($updatedActions  as $actions) {
            $data = Action::findorFail($actions['id']);
            $data->order = $actions['order'];
            $data->save();
        }

        return response()->json([
            'success' => 'Update successfully!'
        ]);
    }
}
