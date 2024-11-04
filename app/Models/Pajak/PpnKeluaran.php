<?php

namespace App\Models\Pajak;

use App\Models\InvoiceTagihan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpnKeluaran extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function invoiceTagihan()
    {
        return $this->belongsTo(InvoiceTagihan::class, 'invoice_tagihan_id');
    }
}
