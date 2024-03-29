<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vendor_uang_jalan()
    {
        return $this->hasMany(VendorUangJalan::class);
    }

    public function rute()
    {
        return $this->belongsToMany(Rute::class, 'vendor_uang_jalans');
    }

    public function vehicle()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function kas_vendor()
    {
        return $this->hasMany(KasVendor::class);
    }

    
}
