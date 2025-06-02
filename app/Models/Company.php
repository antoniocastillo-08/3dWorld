<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'website',
    ];

    // Relación con el modelo User
    public function workstations(){
        return $this->hasMany(Workstation::class);
    }
    // Relación con el modelo JoinRequest
    public function joinRequests()
    {
        return $this->hasMany(JoinRequest::class);
    }
}
