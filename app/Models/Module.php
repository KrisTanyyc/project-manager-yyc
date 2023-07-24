<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    protected $table = 'modules';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'project_id', 'order'];

    use HasFactory,SoftDeletes;

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }

   
}
