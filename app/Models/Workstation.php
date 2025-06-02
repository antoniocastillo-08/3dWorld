<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workstation extends Model
{
    /** @use HasFactory<\Database\Factories\WorkstationFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'company_id',
    ];

    // Relación con la empresa
    public function company()
    {
        return $this->belongsTo(related: Company::class);
    }

    // Relación con los usuarios
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relación con los filamentos
    public function filaments()
    {
        return $this->hasMany(Filament::class);
    }

    // Relación con los impresoras de usuario
    public function printers(
    ) {
        return $this->hasMany(UserPrinter::class);
    }

}
