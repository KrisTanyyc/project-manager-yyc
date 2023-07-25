<?php

namespace App\Http\Controllers\Snapshot\Updates;

use App\Models\Project;
use App\Models\Snapshot;
use Illuminate\Http\Request;




class UpdateSnapshot
{
    public function show($project_id, $snapshot_id)
    {
        $snapshot = Snapshot::where('id', $snapshot_id)->first();
        $project = Project::select('id','name')->where('id',$project_id)->first();

        return inertia('Snapshot/UpdateSnapshot', [
            'snapshot' => $snapshot,
            'project' => $project
        ]);
    }

    public function update($project_id, $snapshot_id, Request $request) 
    {
        $snapshot = Snapshot::where('id',$snapshot_id)->first();

        $snapshot->name = $request->input('snapshot_name');
        $snapshot->save();

        return response()->json([
            'success' => 'Update successfully!',
            'data' => $snapshot
        ]);
    }
}