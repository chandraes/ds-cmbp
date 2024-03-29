<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapBarang extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal',
        'jenis_transaksi',
        'barang_id',
        'nama_barang',
        'jumlah',
        'harga_satuan',
        'total',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function dataTahun()
    {
        return $this->selectRaw('YEAR(tanggal) tahun')->groupBy('tahun')->orderBy('tahun', 'desc')->get();
    }

    public function getRekapBarang($month, $year)
    {
        return $this->with(['barang', 'barang.kategori_barang'])
                    ->whereMonth('tanggal', $month)->whereYear('tanggal', $year)->get();
    }

}
