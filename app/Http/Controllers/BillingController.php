<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\InvoiceBayar;
use App\Models\InvoiceBonus;
use App\Models\InvoiceCsr;
use App\Models\InvoiceTagihan;
use App\Models\RekapGaji;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        $check = RekapGaji::orderBy('id', 'desc')->first();

        if ($check) {
            $bulan = $check->bulan + 1 == 13 ? 1 : $check->bulan + 1;
            $tahun = $check->bulan + 1 == 13 ? $check->tahun + 1 : $check->tahun;
        } else {
            $bulan = date('m');
            $tahun = date('Y');
        }

        $customer = Customer::all();

        $invoice = InvoiceTagihan::where('lunas', 0)->count();
        $bayar = InvoiceBayar::where('lunas', 0)->count();
        $bonus = InvoiceBonus::where('lunas', 0)->count();
        $invoice_csr = InvoiceCsr::where('lunas', 0)->count();

        $data = Transaksi::join('kas_uang_jalans as kuj', 'transaksis.kas_uang_jalan_id', 'kuj.id')
                ->leftJoin('vehicles as v', 'kuj.vehicle_id', 'v.id')
                ->select('transaksis.*', 'kuj.customer_id as customer_id', 'v.vendor_id as vendor_id')
                ->where('transaksis.void', 0)->get();

        $vendor = Transaksi::join('kas_uang_jalans as kuj', 'transaksis.kas_uang_jalan_id', 'kuj.id')
                        ->where('status', 3)
                        ->where('transaksis.bayar', 0)
                        ->where('transaksis.void', 0)
                        ->get()->unique('vendor_id');

        $sponsor = Transaksi::join('kas_uang_jalans as kuj', 'transaksis.kas_uang_jalan_id', 'kuj.id')
                        ->join('vendors as v', 'kuj.vendor_id', 'v.id')
                        ->join('sponsors as s', 'v.sponsor_id', 's.id')
                        ->where('transaksis.bonus', 0)
                        ->where('transaksis.status', 3)
                        ->where('transaksis.void', 0)
                        ->get()->unique('sponsor_id');

        $csr = Transaksi::join('kas_uang_jalans as kuj', 'transaksis.kas_uang_jalan_id', 'kuj.id')
                        ->join('customers as c', 'kuj.customer_id', 'c.id')
                        ->where('transaksis.csr', 0)
                        ->where('transaksis.status', 3)
                        ->where('transaksis.void', 0)
                        ->where('c.csr', 1)
                        ->get()->unique('customer_id');

        return view('billing.index',
        [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'data' => $data,
            'customer' => $customer,
            'vendor' => $vendor,
            'sponsor' => $sponsor,
            'invoice' => $invoice,
            'bayar' => $bayar,
            'bonus' => $bonus,
            'csr' => $csr,
            'invoice_csr' => $invoice_csr,
        ]);
    }
}
