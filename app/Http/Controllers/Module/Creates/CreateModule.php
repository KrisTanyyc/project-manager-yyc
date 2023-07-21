<?php

namespace App\Http\Controllers\Module\Creates;

use Illuminate\Http\Request;
use App\Models\Module;

class CreateModule
{
    //
    public function show($project_id)
    {
        return inertia(
            'Module/CreateModule',
            [
                'project_id' => $project_id
            ]
        );
    }

    public function create($project_id, Request $request)
    {
        $module = Module::create([
            'name' => $request->input('module_name'),
            'project_id' => $project_id
        ]);

        $module['order'] = $module->id;
        $module->save();

        return response()->json(
            [
                'success' => 'Created successfully',
                'data' => $module
            ]
        );
    }
}
