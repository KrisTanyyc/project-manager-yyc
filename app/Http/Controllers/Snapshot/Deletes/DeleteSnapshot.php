<?php

namespace App\Http\Controllers\Snapshot\Deletes;

use App\Models\Project;
use App\Models\Snapshot;
use Illuminate\Http\Request;

class DeleteSnapshot
{
    //
    public function show($project_id, $snapshot_id)
    {
        $project = Project::select('id')->where('id', $project_id)->first();
        $snapshot = Snapshot::select('id', 'name')->where('id', $snapshot_id)->first();

        return inertia(
            'Snapshot/DeleteSnapshot',
            [
                'project' => $project,
                'snapshot' => $snapshot
            ]
        );
    }

    public function delete($project_id, $snapshot_id) {
        $snapshot = Snapshot::where('id',$snapshot_id)->first();

        $snapshot->delete();

        return response()->json(
            [
                'success' => 'Delete successfully!',
                'data' => $snapshot
            ]
        );
    }
}
