<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserPrinter;

class Printer extends Model
{
    /** @use HasFactory<\Database\Factories\PrintersFactory> */
    use HasFactory;

    public function userPrinters()
    {
        return $this->hasMany(UserPrinter::class);
    }
    
}
