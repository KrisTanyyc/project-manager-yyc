<?php

namespace App\Http\Controllers\Module\Lists;

use App\Http\Resources\ModuleResource;
use Illuminate\Http\Request;
use App\Models\Module;



class ListModule
{
    public function list($project_id)
    {
        
        $data = Module::where('project_id',$project_id)->get();
        return ModuleResource::collection($data);
    }

}