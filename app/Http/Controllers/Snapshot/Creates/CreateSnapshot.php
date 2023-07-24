<?php

namespace App\Http\Controllers\Snapshot\Creates;


use Illuminate\Http\Request;

class CreateSnapshot
{
    //
    public function show()
    {
        return inertia(
            'Snapshot/CreateSnapshot'
        );
    }

    
}
