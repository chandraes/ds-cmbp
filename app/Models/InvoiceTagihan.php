<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceTagihan extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = ['id_tanggal'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getIdTanggalAttribute()
    {
        return date('d-m-Y', strtotime($this->tanggal));
    }

    // has many transaksi from pivot table invoice_tagihan_details
    public function invoice_tagihan_details()
    {
        return $this->hasMany(InvoiceTagihanDetail::class);
    }


    public function transaksi()
    {
        return $this->hasManyThrough(
            Transaksi::class,
            InvoiceTagihanDetail::class,
            'invoice_tagihan_id',
            'id',
            'id',
            'transaksi_id'
        );
    }

}
