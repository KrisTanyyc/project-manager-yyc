<?php

namespace App\Http\Controllers\Module\Updates;

use App\Models\Module;
use Illuminate\Http\Request;

class UpdateModule
{
    //
    public function show($project_id, $module_id)
    {
        $module = Module::where('project_id', $project_id)
            ->where('id', $module_id)->first();

        return inertia(
            'Module/UpdateModule',
            [
                'data' => $module,
            ]
        );
    }

    public function update($project_id, $module_id, Request $request)
    {

        $module = Module::where('project_id', $project_id)
            ->where('id', $module_id)->first();

        $module->name = $request->input('module_name');
        $module->save();

        return response()->json([
            'success' => 'Update successfully!',
            'data' => $module
        ]);
    }

    public function orderUpdate(Request $request)
    {
        $updatedModules = $request->input('updatedModules');


        foreach ($updatedModules  as $modules) {
            $data = Module::findorFail($modules['id']);
            $data->order = $modules['order'];
            $data->save();
        }

        return response()->json([
            'success' => 'Update successfully!'
        ]);
    }
}
