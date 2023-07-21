<?php

namespace App\Http\Controllers\Stakeholder\Lists;

use App\Http\Resources\StakeholderResource;
use Illuminate\Http\Request;
use App\Models\Stakeholder;



class ListStakeholder
{
    public function list($project_id)
    {
        
        $data = Stakeholder::where('project_id',$project_id)->get();
        return StakeholderResource::collection($data);
    }

}