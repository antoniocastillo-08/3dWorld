<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\UserPrinter;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relacion con los puestos de trabajo
    public function workstation(){
        return $this->belongsTo(Workstation::class);
    }

    // Relacion con los modelos 3D que se les dio me gusta
    public function likedModels()
    {
        return $this->belongsToMany(Model3d::class, 'like')->withTimestamps();
    }

    // Relacion con JoinRequest
    public function joinRequests()
    {
        return $this->hasMany(JoinRequest::class);
    }
    

    protected static function booted()
    {
        static::created(function ($user) {
            // Asignar el rol 'user' por defecto a los nuevos usuarios
            if ($user->roles->isEmpty()) {
                $user->assignRole('user');
            }
        });
    }
}
