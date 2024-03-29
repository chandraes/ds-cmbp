<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemegangSaham extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function persentase_awal()
    {
        return $this->belongsTo(PersentaseAwal::class);
    }
}
