<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faker extends Model
{
    use HasFactory;

    protected $table = 'fakers';
    protected $primaryKey = 'id';
    protected $fillable = ['model', 'model_id'];
}
