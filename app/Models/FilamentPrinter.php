<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilamentPrinter extends Model
{
    protected $table = 'filament_printer';

    protected $fillable = [
        'printer_id',
        'filament_id',
    ];

    public function printer()
    {
        return $this->belongsTo(Printer::class);
    }

    public function filament()
    {
        return $this->belongsTo(Filament::class);
    }   
}
