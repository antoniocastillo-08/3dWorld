<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilamentPrinter extends Model
{
    protected $table = 'filaments_printers';

    protected $fillable = [
        'printer_user_id',
        'filament_user_id',
    ];

    public function filament()
    {
        return $this->belongsTo(Filament::class, 'filament_user_id');
    }

    public function printer()
    {
        return $this->belongsTo(UserPrinter::class, 'printer_user_id');
    }   
}
