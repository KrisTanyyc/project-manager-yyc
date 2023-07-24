<?php

namespace App\Http\Controllers\Snapshot\Deletes;

use Illuminate\Http\Request;

class DeleteSnapshot
{
    //
    public function show()
    {
        return inertia(
            'Snapshot/DeleteSnapshot'
        );
    }
}
