<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Snapshot extends Model
{
    protected $table = 'snapshots';
    protected $primaryKey = 'id';
    protected $casts = [
        'data' => 'array'
    ];
    protected $fillable = ['name', 'project_id', 'order', 'data'];

    use HasFactory, SoftDeletes;

    public function project() 
    {
        return $this->belongsTo(Project::class);    
    }
}
