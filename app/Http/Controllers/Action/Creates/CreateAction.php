<?php

namespace App\Http\Controllers\Action\Creates;

use App\Models\Action;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CreateAction
{
    //
    public function show($project_id, $module_id)
    {
        return inertia(
            'Action/CreateAction',
            [
                'project_id' => $project_id,
                'module_id' => $module_id
            ]
        );
    }

    public function create($module_id, Request $request)
    {
        $action = Action::create([
            'name' => $request->input('action_name'),
            'module_id' => $module_id
        ]);

        $action['order'] = $action->id;
        $action->save();

        return response()->json(
            [
                'success' => 'Created successfully',
                'data' => $action
            ]
        );
    }

    public function createBREAD($module_id) 
    {

        $data = [
            ['name' => 'Browse', 'module_id' => $module_id, 'order' => 0, 'created_at' => now()->toDateTimeString(), 'updated_at' => now()->toDateTimeString()],
            ['name' => 'Read', 'module_id' => $module_id, 'order' => 1, 'created_at' => now()->toDateTimeString(), 'updated_at' => now()->toDateTimeString()],
            ['name' => 'Add', 'module_id' => $module_id, 'order' => 2, 'created_at' => now()->toDateTimeString(), 'updated_at' => now()->toDateTimeString()],
            ['name' => 'Edit', 'module_id' => $module_id, 'order' => 3, 'created_at' => now()->toDateTimeString(), 'updated_at' => now()->toDateTimeString()],
            ['name' => 'Delete', 'module_id' => $module_id, 'order' => 4, 'created_at' => now()->toDateTimeString(), 'updated_at' => now()->toDateTimeString()]
        ];

        $action = Action::insert($data);

        

        return response()->json(
            [
                'success' => 'Created successfully',
                'data' => $action
            ]
        );
    }
}
