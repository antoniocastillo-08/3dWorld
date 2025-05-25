<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filament extends Model
{
    /** @use HasFactory<\Database\Factories\FilamentFactory> */
    use HasFactory;
    public function user()
    {
    return $this->belongsTo(User::class, 'filament_user_id');
    }
    public function printers()
{
    return $this->belongsToMany(UserPrinter::class, 'filaments_printers', 'filament_user_id', 'printer_user_id');
}

}
