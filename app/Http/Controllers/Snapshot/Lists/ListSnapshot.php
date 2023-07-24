<?php

namespace App\Http\Controllers\Snapshot\Lists;


use Illuminate\Http\Request;




class ListSnapshot
{

    //
    public function show()
    {
        return inertia('Snapshot/Snapshot');
    }

   
}
