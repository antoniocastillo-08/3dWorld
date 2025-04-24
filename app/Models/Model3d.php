<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Model3d extends Model
{
    /** @use HasFactory<\Database\Factories\Model3dFactory> */
    use HasFactory;
    public function users(){
    return $this->belongsToMany(User::class, 'model3d_user');
    }
}
