<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KasUangJalan extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['id_tanggal', 'hari'];

    public function jenis_transaksi()
    {
        return $this->belongsTo(JenisTransaksi::class);
    }

    public function getHariAttribute()
    {
        return Carbon::parse($this->tanggal)->locale('id')->isoFormat('dddd');
    }

    public function getIdTanggalAttribute()
    {
        return date('d-m-Y', strtotime($this->tanggal));
    }

    public function getTanggalAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function rute()
    {
        return $this->belongsTo(Rute::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function getKasUangJalan($month, $year)
    {
        return $this->with(['jenis_transaksi', 'vendor', 'vehicle', 'customer', 'rute'])
                    ->whereMonth('tanggal', $month)->whereYear('tanggal', $year)->get();
    }

    public function kasByMonth($month, $year)
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

    public function getLatest($month, $year)
    {
        return $this->whereMonth('tanggal', $month)->whereYear('tanggal', $year)->latest()->orderBy('id', 'desc')->first() ??
                $this->orderBy('id', 'desc')->first();
    }

    public function saldoTerakhir()
    {
        return $this->latest()->orderBy('id', 'desc')->first()->saldo ?? 0;
    }

    public function dataTahun()
    {
        return $this->selectRaw('YEAR(tanggal) tahun')->groupBy('tahun')->orderBy('tahun', 'desc')->get();
    }

    public function pengembalian($data)
    {
        $data['tanggal'] = date('Y-m-d');
        $data['nominal_transaksi'] = str_replace('.', '', $data['nominal_transaksi']);



        $saldoUangJalan = $this->saldoTerakhir();

        if ($saldoUangJalan < $data['nominal_transaksi']) {
            return ['status' => 'error', 'message' => 'Saldo tidak mencukupi'];
        }

        $data['uraian'] = 'Pengembalian Kas Uang Jalan';
        $rekening = Rekening::where('untuk', 'kas-besar')->first();

        try {
            DB::beginTransaction();

            $store = $this->create([
                'tanggal' => $data['tanggal'],
                'nominal_transaksi' => $data['nominal_transaksi'],
                'uraian' => $data['uraian'],
                'jenis_transaksi_id' => 2,
                'saldo' => $saldoUangJalan - $data['nominal_transaksi'],
                'transfer_ke' => $rekening->nama_rekening,
                'bank' => $rekening->nama_bank,
                'no_rekening' => $rekening->nomor_rekening,
            ]);

            $dbKas = new KasBesar();
            $saldoKas = $dbKas->saldoTerakhir();
            // dd($saldoKas);

            $storeKas = $dbKas->create([
                'tanggal' => $data['tanggal'],
                'uraian' => $data['uraian'],
                'jenis_transaksi_id' => 1,
                'nominal_transaksi' => $data['nominal_transaksi'],
                'saldo' => $saldoKas + $data['nominal_transaksi'],
                'transfer_ke' => $rekening->nama_rekening,
                'bank' => $rekening->nama_bank,
                'no_rekening' => $rekening->nomor_rekening,
                'modal_investor_terakhir' => $dbKas->modalInvestorTerakhir(),
            ]);

            DB::commit();

            $pesan =    "🔵🔵🔵🔵🔵🔵🔵🔵🔵\n".
                        "*Form Pengembalian Kas Uang Jalan*\n".
                        "🔵🔵🔵🔵🔵🔵🔵🔵🔵\n\n".
                        "Uraian : ".$storeKas->uraian."\n".
                        "Nilai :  *Rp. ".number_format($storeKas->nominal_transaksi, 0, ',', '.')."*\n\n".
                        "Ditransfer ke rek:\n\n".
                        "Bank      : ".$storeKas->bank."\n".
                        "Nama    : ".$storeKas->transfer_ke."\n".
                        "No. Rek : ".$storeKas->no_rekening."\n\n".
                        "==========================\n".
                        "Sisa Saldo Kas Besar : \n".
                        "Rp. ".number_format($storeKas->saldo, 0, ',', '.')."\n\n".
                        "Total Modal Investor : \n".
                        "Rp. ".number_format($storeKas->modal_investor_terakhir, 0, ',', '.')."\n\n".
                        "Terima kasih 🙏🙏🙏\n";

            $tujuan = GroupWa::where('untuk', 'kas-besar')->first()->nama_group;

            $dbKas->sendWa($tujuan, $pesan);

            return ['status' => 'success', 'message' => 'Pengembalian Dana berhasil'];


        } catch (\Throwable $th) {
            DB::rollBack();
            return ['status' => 'error', 'message' => $th->getMessage()];
        }
    }
}
