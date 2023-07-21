<?php

namespace App\Http\Controllers\Stakeholder\Deletes;

use App\Models\Stakeholder;
use Illuminate\Http\Request;

class DeleteStakeholder
{
    //
    public function show($project_id, $stakeholder_id)
    {
        $stakeholder = Stakeholder::where('project_id', $project_id)
            ->where('id', $stakeholder_id)->first();

        return inertia('Stakeholder/DeleteStakeholder',
        [
            'data' => $stakeholder
        ]);
    }

    public function delete($project_id, $stakeholder_id)
    {
        $stakeholder = Stakeholder::where('project_id', $project_id)
            ->where('id', $stakeholder_id)->first();

            $stakeholder->delete();

            return response()->json(
                [
                    'success' => 'Delete successfully!',
                    'data' => $stakeholder
                ]
            );
    }
}
