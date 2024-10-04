<?php

namespace App\Models;

use App\Services\StarSender;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasBesar extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = ['nf_nominal_transaksi', 'nf_saldo', 'nf_modal_investor_terakhir'];

    public function lastKasBesar()
    {
        return $this->orderBy('id', 'desc')->first();
    }

    public function kasBesarByMonth($month, $year)
    {
        $data = $this->whereMonth('tanggal', $month)
                    ->whereYear('tanggal', $year)
                    ->orderBy('id', 'desc')
                    ->first();

        if (!$data) {
        $data = $this->where('tanggal', '<', Carbon::create($year, $month, 1))
                ->orderBy('id', 'desc')
                ->first();
        }

        return $data;
    }

    public function kasBesar($month, $year)
    {
        return $this->whereMonth('tanggal', $month)->whereYear('tanggal', $year)->get();
    }

    public function saldoTerakhir()
    {
        return $this->orderBy('id', 'desc')->first()->saldo ?? 0;
    }

    public function dataTahun()
    {
        return $this->selectRaw('YEAR(tanggal) as tahun')->groupBy('tahun')->get();
    }

    public function modalInvestorTerakhir()
    {
        return $this->orderBy('id', 'desc')->first()->modal_investor_terakhir ?? 0;
    }

    public function getNfNominalTransaksiAttribute()
    {
        return number_format($this->nominal_transaksi, 0, ',', '.');
    }

    public function getNfSaldoAttribute()
    {
        return number_format($this->saldo, 0, ',', '.');
    }

    public function getNfModalInvestorTerakhirAttribute()
    {
        return number_format($this->modal_investor_terakhir, 0, ',', '.');
    }


    public function jenis_transaksi()
    {
        return $this->belongsTo(JenisTransaksi::class);
    }

    public function getTanggalAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function setTanggalAttribute($value)
    {
        $this->attributes['tanggal'] = date('Y-m-d', strtotime($value));
    }

    public function insert_bypass($data)
    {
        $data['tanggal'] = date('Y-m-d');
        $data['nominal_transaksi'] = str_replace('.', '', $data['nominal_transaksi']);

        if($data['jenis_transaksi_id'] == 1){
            $data['saldo'] = $this->lastKasBesar()->saldo + $data['nominal_transaksi'];
        } elseif($data['jenis_transaksi_id'] == 2){

            $data['saldo'] = $this->lastKasBesar()->saldo - $data['nominal_transaksi'];
        }

        $data['transfer_ke'] = '-';
        $data['bank'] = '-';
        $data['no_rekening'] = '-';

        $data['modal_investor_terakhir'] = $this->lastKasBesar()->modal_investor_terakhir;

        $store = $this->create($data);

        return $store;

    }

    public function sendWa($tujuan, $pesan)
    {
        $storeWa = PesanWa::create([
            'pesan' => $pesan,
            'tujuan' => $tujuan,
            'status' => 0,
        ]);

        $send = new StarSender($tujuan, $pesan);
        $res = $send->sendGroup();

        if ($res == 'true') {
            $storeWa->update(['status' => 1]);
        }

    }

}
