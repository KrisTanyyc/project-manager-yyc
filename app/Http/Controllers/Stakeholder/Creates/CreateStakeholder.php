<?php

namespace App\Http\Controllers\Stakeholder\Creates;

use App\Models\Stakeholder;
use Illuminate\Http\Request;

class CreateStakeholder
{
    //
    public function show($project_id)
    {
        return inertia(
            'Stakeholder/CreateStakeholder',
            [
                'project_id' => $project_id
            ]
        );
    }

    public function create($project_id, Request $request)
    {
        $stakeholder = Stakeholder::create([
            'name' => $request->input('stakeholder_name'),
            'project_id' => $project_id
        ]);

        $stakeholder['order'] = $stakeholder->id;
        $stakeholder->save();

        return response()->json(
            [
                'success' => 'Created successfully',
                'data' => $stakeholder
            ]
        );
    }
}
