<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    use HasFactory, SoftDeletes;

    public function modules(){
        return $this->hasMany(Module::class);
    }

    public function stakeholders(){
        return $this->hasMany(Stakeholder::class);
    }

    public function snapshots(){
        return $this->hasMany(Snapshot::class);
    }
}
