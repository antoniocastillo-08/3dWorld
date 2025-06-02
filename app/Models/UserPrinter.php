<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Printer;
use App\Models\User;
use App\Models\FilamentPrinter;

class UserPrinter extends Model
{
    protected $table = 'print_users';

    protected $fillable = [
        'workstation_id',
        'printer_id',
        'name',
        'status',
        'nozzle_size',
    ];

    // Relación con los puestsos de trabajo
    public function workstation()
    {
        return $this->belongsTo(related: Workstation::class);
    }

    // Relación con la impresora
    public function printer()
    {
        return $this->belongsTo(Printer::class);
    }

    // Relación con los filamentos
    public function filaments() {
        return $this->belongsToMany(FilamentPrinter::class);
    }
}
