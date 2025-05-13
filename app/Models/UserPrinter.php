<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function printer()
    {
        return $this->belongsTo(Printer::class);
    }
}
