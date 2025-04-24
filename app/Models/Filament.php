<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filament extends Model
{
    /** @use HasFactory<\Database\Factories\FilamentFactory> */
    use HasFactory;
    public function users()
    {
    return $this->belongsToMany(User::class, 'filament_user')->withPivot('quantity');
    }

    public function printers()
    {
    return $this->belongsToMany(Printer::class, 'filament_printer');
    }
}
