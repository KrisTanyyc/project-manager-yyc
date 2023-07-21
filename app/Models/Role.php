<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    use HasFactory, SoftDeletes;

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_to_user')->withTimestamps();
    }
}
