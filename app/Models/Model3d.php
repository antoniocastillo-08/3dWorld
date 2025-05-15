<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Model3d extends Model
{
    /** @use HasFactory<\Database\Factories\Model3dFactory> */
    use HasFactory;
    protected $fillable = ['name', 'description', 'author', 'file', 'image'];

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'model3d_users')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author'); // 'author' es la clave foránea
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'model3d_user');
    }

}
