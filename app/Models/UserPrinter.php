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
        'user_id',
        'printer_id',
        'name',
        'status',
        'nozzle_size',
    ];

    public function workstation()
    {
        return $this->belongsTo(related: Workstation::class);
    }

    public function printer()
    {
        return $this->belongsTo(Printer::class);
    }
    public function filaments() {
        return $this->belongsToMany(FilamentPrinter::class);
    }
}
