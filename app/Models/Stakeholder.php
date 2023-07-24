<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stakeholder extends Model
{
    protected $table = 'stakeholders';
    protected $primaryKey = 'id';
    protected $fillable = ['name','project_id','order'];

    use HasFactory,SoftDeletes;

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function actions(){
        return $this->belongsToMany(Action::class,'action_to_stakeholder')->withTimestamps();
    }
}
