<?php

namespace App\Http\Controllers\Stakeholder\Updates;

use App\Models\Stakeholder;
use Illuminate\Http\Request;

class UpdateStakeholder
{
    //
    public function show($project_id, $stakeholder_id)
    {
        $stakeholder = Stakeholder::where('project_id', $project_id)
            ->where('id', $stakeholder_id)->first();

        return inertia(
            'Stakeholder/UpdateStakeholder',
            [
                'data' => $stakeholder,
            ]
        );
    }

    public function update($project_id, $stakeholder_id, Request $request)
    {

        $stakeholder = Stakeholder::where('project_id', $project_id)
            ->where('id', $stakeholder_id)->first();

        $stakeholder->name = $request->input('stakeholder_name');
        $stakeholder->save();

        return response()->json([
            'success' => 'Update successfully!',
            'data' => $stakeholder
        ]);
    }

    public function orderUpdate(Request $request)
    {

        $updatedStakeholders = $request->input('updatedStakeholders');

        
        foreach ($updatedStakeholders  as $stakeholders) {
            $data = Stakeholder::findorFail($stakeholders ['id']);
            $data->order = $stakeholders['order'];
            $data->save();
        }

        return response()->json([
            'success' => 'Update successfully!'
        ]);
    }
}
