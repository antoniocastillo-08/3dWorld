<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Model3d extends Model
{
    /** @use HasFactory<\Database\Factories\Model3dFactory> */
    use HasFactory;
    protected $fillable = ['name', 'description', 'author', 'file', 'image'];

    // Relación con los usuarios que dieron me gusta al modelo 3D
    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'like')->withTimestamps();
    }

    // Relación con el usuario que creó el modelo 3D
    public function user()
    {
        return $this->belongsTo(User::class, 'author'); // 'author' es la clave foránea
    }

}
