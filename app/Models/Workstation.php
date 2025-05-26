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


    public function company()
    {
        return $this->belongsTo(related: Company::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }

    
    public function filaments()
    {
        return $this->hasMany(Filament::class);
    }

    public function printers(
    ) {
        return $this->hasMany(UserPrinter::class);
    }

}
