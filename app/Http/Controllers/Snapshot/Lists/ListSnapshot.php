<?php

namespace App\Http\Controllers\Snapshot\Lists;

use App\Models\Project;
use App\Models\Snapshot;
use Illuminate\Http\Request;




class ListSnapshot
{

    //
    public function show($project_id, $snapshot_id)
    {
        $snapshot = Snapshot::where('id', $snapshot_id)->first();
        $project = Project::select('id','name')->where('id',$project_id)->first();

        return inertia('Snapshot/Snapshot', [
            'snapshot' => $snapshot,
            'project' => $project
        ]);
    }
}
