<?php

namespace App\Http\Controllers\Module\Deletes;

use App\Models\Module;
use Illuminate\Http\Request;

class DeleteModule
{
    //
    public function show($project_id, $module_id)
    {
        $module = Module::where('project_id', $project_id)
            ->where('id', $module_id)->first();

        return inertia(
            'Module/DeleteModule',
            [
                'data' => $module
            ]
        );
    }

    public function delete($project_id, $module_id)
    {
        $module = Module::where('project_id', $project_id)
            ->where('id', $module_id)->first();

            $module->delete();

            return response()->json(
                [
                    'success' => 'Delete successfully!',
                    'data' => $module
                ]
            );
    }
}
