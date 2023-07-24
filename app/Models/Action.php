<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Action extends Model
{
    protected $table = 'actions';
    protected $primaryKey = 'id';
    protected $fillable = ['name','module_id','order'];

    use HasFactory,SoftDeletes;

    public function module(){
        return $this->belongsTo(Module::class);
    }

    public function stakeholders(){
        return $this->belongsToMany(Stakeholder::class,'action_to_stakeholder')->withTimestamps();
    }
}
