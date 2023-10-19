<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BbmStoring extends Model
{
    use HasFactory;
    protected $fillable = [
        'km',
        'biaya_vendor',
        'biaya_mekanik',
    ];
}
