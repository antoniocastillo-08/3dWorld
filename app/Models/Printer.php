<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    /** @use HasFactory<\Database\Factories\PrintersFactory> */
    use HasFactory;

    public function users(){
        return $this->belongsToMany('App\Models\User', 'print_user', 'printer_id','user_id');
    }
    public function filaments()
    {
    return $this->belongsToMany(Filament::class, 'filament_printer');
    }
}
