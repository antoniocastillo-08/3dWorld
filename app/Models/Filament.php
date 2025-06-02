<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filament extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'material',
        'brand',
        'color',
        'diameter',
        'weight',
        'amount',
        'workstation_id',
    ];


    //Relación con Workstation
    public function workstation()
    {
        return $this->belongsTo(Workstation::class, 'workstation_id');
    }
    // Relación con UserPrinter
    public function printers()
    {
        return $this->belongsToMany(UserPrinter::class, 'filaments_printers', 'filament_user_id', 'printer_user_id');
    }

}
