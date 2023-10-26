@extends('layouts.doc-nologo-1')
@section('content')
<div class="container-fluid">
    <center>
        <h2>NOTA TAGIHAN</h2>
        <h2><u>{{$customer->nama}} ({{$customer->singkatan}})</u></h2>
    </center>
    @php
        $total_tagihan = $data ? $data->sum('nominal_tagihan') : 0;
        $ppn = $customer->ppn == 1 && $data ? $data->sum('nominal_tagihan') * 0.11 : 0;
        $pph = $customer->pph == 1 && $data ? $data->sum('nominal_tagihan') * 0.02 : 0;
        $profit = $data->sum('profit');
        $profit_persen = count($data) > 0 ? ($data->sum('profit') / $data->sum('nominal_bayar')) * 100 : 0;
    @endphp
</div>
<div class="container-fluid table-responsive ml-3 text-pdf">
    <div class="row mt-3">
        <table class="table table-hover table-bordered text-pdf">
            <thead class="table-pdf text-pdf table-success">
                <tr class="table-pdf text-pdf">
                    <th class="table-pdf text-pdf text-center align-middle">No</th>
                    <th class="table-pdf text-pdf text-center align-middle">Tanggal UJ</th>
                    <th class="table-pdf text-pdf text-center align-middle">Kode</th>
                    <th class="table-pdf text-pdf text-center align-middle">Nomor Lambung</th>
                    <th class="table-pdf text-pdf text-center align-middle">Vendor</th>
                    <th class="table-pdf text-pdf text-center align-middle">Rute</th>
                    <th class="table-pdf text-pdf text-center align-middle">Jarak (Km)</th>
                    <th class="table-pdf text-pdf text-center align-middle">Harga</th>
                    @if ($customer->tanggal_muat == 1)
                    <th class="table-pdf text-pdf text-center align-middle">Tanggal Muat</th>
                    @endif
                    @if ($customer->nota_muat == 1)
                    <th class="table-pdf text-pdf text-center align-middle">Nota Muat</th>
                    @endif
                    @if ($customer->tonase == 1)
                    <th class="table-pdf text-pdf text-center align-middle">Tonase Muat</th>
                    @endif
                    @if ($customer->tanggal_bongkar == 1)
                    <th class="table-pdf text-pdf text-center align-middle">Tanggal Bongkar</th>
                    @endif
                    <th class="table-pdf text-pdf text-center align-middle">Nota Bongkar</th>
                    <th class="table-pdf text-pdf text-center align-middle">Tonase Bongkar</th>
                    @if ($customer->selisih == 1)
                    <th class="table-pdf text-pdf text-center align-middle">Selisih (Ton)</th>
                    <th class="table-pdf text-pdf text-center align-middle">Selisih (%)</th>
                    @endif
                    <th class="table-pdf text-pdf text-center align-middle">Tagihan</th>

{{--
                    <th class="table-pdf text-pdf text-center align-middle" style="height: 35px">Tanggal</th>
                    <th class="table-pdf text-pdf text-center align-middle">Uraian</th>
                    <th class="table-pdf text-pdf text-center align-middle">Deposit</th>
                    <th class="table-pdf text-pdf text-center align-middle">Kas Kecil</th>
                    <th class="table-pdf text-pdf text-center align-middle">Kas Uang Jalan</th>
                    <th class="table-pdf text-pdf text-center align-middle">Tagihan</th>
                    <th class="table-pdf text-pdf text-center align-middle">Masuk</th>
                    <th class="table-pdf text-pdf text-center align-middle">Keluar</th>
                    <th class="table-pdf text-pdf text-center align-middle">Saldo</th>
                    <th class="table-pdf text-pdf text-center align-middle">Transfer Ke Rekening</th>
                    <th class="table-pdf text-pdf text-center align-middle">Bank</th>
                    <th class="table-pdf text-pdf text-center align-middle">Modal Investor</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>

                    <td class="table-pdf text-pdf text-center align-middle">{{$loop->iteration}}</td>
                    <td class="table-pdf text-pdf text-center align-middle">{{$d->kas_uang_jalan->tanggal}}</td>
                    <td class="table-pdf text-pdf text-center align-middle">
                        <strong>UJ{{sprintf("%02d",
                            $d->kas_uang_jalan->nomor_uang_jalan)}}</strong>
                    </td>
                    <td class="table-pdf text-pdf text-center align-middle">{{$d->kas_uang_jalan->vehicle->nomor_lambung}}</td>
                    <td class="table-pdf text-pdf text-center align-middle">{{$d->kas_uang_jalan->vendor->nickname}}</td>
                    <td class="table-pdf text-pdf text-center align-middle">{{$d->kas_uang_jalan->rute->nama}}</td>
                    <td class="table-pdf text-pdf text-center align-middle">{{$d->kas_uang_jalan->rute->jarak}}</td>
                    <td class="table-pdf text-pdf text-center align-middle">
                        {{number_format($d->kas_uang_jalan->customer->customer_tagihan->where('customer_id', $d->kas_uang_jalan->customer_id)
                                                                        ->where('rute_id', $d->kas_uang_jalan->rute_id)
                                                                        ->first()->harga_tagihan, 0, ',', '.')}}
                    </td>
                    @if ($customer->tanggal_muat == 1)
                    <td class="table-pdf text-pdf text-center align-middle">{{$d->tanggal_muat}}</td>
                    @endif
                    @if ($customer->nota_muat == 1)
                    <td class="table-pdf text-pdf text-center align-middle">{{$d->nota_muat}}</td>
                    @endif
                    @if ($customer->tonase == 1)
                    <td class="table-pdf text-pdf text-center align-middle">{{$d->tonase}}</td>
                    @endif
                    @if ($customer->tanggal_bongkar == 1)
                    <td class="table-pdf text-pdf text-center align-middle">{{$d->tanggal_bongkar}}</td>
                    @endif
                    <td class="table-pdf text-pdf text-center align-middle">{{$d->nota_bongkar}}</td>
                    <td class="table-pdf text-pdf text-center align-middle">{{$d->timbangan_bongkar}}</td>
                    @if ($customer->selisih == 1)
                    <td class="table-pdf text-pdf text-center align-middle">{{number_format($d->tonase - $d->timbangan_bongkar, 2, ',','.')}}</td>
                    <td class="table-pdf text-pdf text-center align-middle">{{number_format(($d->tonase - $d->timbangan_bongkar)*0.1, 2, ',','.')}}</td>
                    @endif
                    <td class="table-pdf text-pdf text-center align-middle">
                        @if ($d->kas_uang_jalan->customer->tagihan_dari == 1)
                        {{number_format(($d->nominal_tagihan), 0, ',', '.')}}
                        @elseif ($d->kas_uang_jalan->customer->tagihan_dari == 2)
                        {{number_format(($d->nominal_tagihan), 0, ',', '.')}}
                        @endif
                    </td>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-center align-middle"
                        colspan="{{9 + ($customer->tanggal_muat == 1 ? 1 : 0) + ($customer->nota_muat == 1 ? 1 : 0) + ($customer->tonase == 1 ? 1 : 0) +
                                                                    ($customer->tanggal_bongkar == 1 ? 1 : 0) + ($customer->selisih == 1 ? 2 : 0)}}"></td>
                    <td class="table-pdf text-pdf text-center align-middle"><strong>Total</strong></td>
                    <td align="right" class="table-pdf text-pdf align-middle">{{number_format($total_tagihan, 0, ',', '.')}}
                    </td>
                </tr>
                <tr>
                    <td class="text-center align-middle"
                        colspan="{{9 + ($customer->tanggal_muat == 1 ? 1 : 0) + ($customer->nota_muat == 1 ? 1 : 0) + ($customer->tonase == 1 ? 1 : 0) +
                                                                    ($customer->tanggal_bongkar == 1 ? 1 : 0) + ($customer->selisih == 1 ? 2 : 0)}}"></td>
                    <td class="table-pdf text-pdf text-center align-middle"><strong>PPN</strong></td>
                    <td align="right" class="table-pdf text-pdf align-middle">

                        {{number_format($ppn, 0, ',', '.')}}

                    </td>
                </tr>
                <tr>
                    <td class="align-middle"
                        colspan="{{9 + ($customer->tanggal_muat == 1 ? 1 : 0) + ($customer->nota_muat == 1 ? 1 : 0) + ($customer->tonase == 1 ? 1 : 0) +
                                                                    ($customer->tanggal_bongkar == 1 ? 1 : 0) + ($customer->selisih == 1 ? 2 : 0)}}">
                    </td>
                    <td class="table-pdf text-pdf text-center align-middle"><strong>PPh</strong></td>
                    <td align="right" class="table-pdf text-pdf align-middle">

                        {{number_format($pph, 0, ',', '.')}}

                    </td>
                </tr>
                <tr>
                    <td class="align-middle"
                        colspan="{{9 + ($customer->tanggal_muat == 1 ? 1 : 0) + ($customer->nota_muat == 1 ? 1 : 0) + ($customer->tonase == 1 ? 1 : 0) +
                                                                    ($customer->tanggal_bongkar == 1 ? 1 : 0) + ($customer->selisih == 1 ? 2 : 0)}}">
                    </td>
                    <td class="table-pdf text-pdf text-center align-middle"><strong>Tagihan</strong></td>
                    <td align="right" class="table-pdf text-pdf align-middle"> <strong>
                        {{number_format($total_tagihan-$pph+$ppn, 0, ',', '.')}}</strong>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
