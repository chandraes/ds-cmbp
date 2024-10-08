@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center mb-5">
        <div class="col-md-12 text-center">
            <h1><u>Form Deviden</u></h1>
        </div>
    </div>
    @include('swal')
    <div class="row justify-content-center">
        @php
            // $total1 = $modalInvestor+$ppn;
            // $total2 = $totalTitipan+$totalTagihan+$kasBesar;
            // $estimasi = $total2-$total1;
        @endphp
        <div class="col-md-6">
            <table class="table table-striped table-hover">
                <tbody>
                    <tr>
                        <th>Estimasi Profit</th>
                        <th>:</th>
                        <th class="text-end align-middle">{{number_format($estimasi, 0,',','.')}}</th>
                    </tr>
                    <tr>
                        <td>Modal Investor</td>
                        <td>:</td>
                        <td class="text-end align-middle"> {{number_format($modalInvestor, 0,',','.')}}</td>
                    </tr>
                    <tr>
                        <td>Total PPN Belum Bayar</td>
                        <td>:</td>
                        <td class="text-end align-middle"> {{number_format($ppn, 0,',','.')}}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th>:</th>
                        <th class="text-end align-middle"> {{number_format($modalInvestor+$ppn+$estimasi, 0,',','.')}}</th>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Saldo Kas</td>
                        <td>:</td>
                        <td class="text-end align-middle"> {{number_format($kasBesar, 0,',','.')}}</td>
                    </tr>
                    <tr>
                        <td>Total Tagihan</td>
                        <td>:</td>
                        <td class="text-end align-middle"> {{number_format($totalTagihan, 0,',','.')}}</td>
                    </tr>
                    <tr>
                        <td>Titipan Supplier</td>
                        <td>:</td>
                        <td class="text-end align-middle"> {{number_format($totalTitipan, 0,',','.')}}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th>:</th>
                        <th class="text-end align-middle"> {{number_format($total2, 0,',','.')}}</th>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
    <form action="{{route('billing.deviden.store')}}" method="post" id="masukForm">
        @csrf
        <div class="row">
            <div class="col-md-2 mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="text" class="form-control @if ($errors->has('tanggal'))
                    is-invalid
                @endif" name="tanggal" id="tanggal" value="{{date('d-m-Y')}}" disabled>
            </div>
            <div class="col-md-4 mb-3">
                <label for="nominal_transaksi" class="form-label">Nominal</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Rp</span>
                    <input type="text" class="form-control @if ($errors->has('nominal_transaksi'))
                    is-invalid
                @endif" name="nominal_transaksi" id="nominal_transaksi" required data-thousands=".">
                </div>
                @if ($errors->has('nominal_transaksi'))
                <div class="invalid-feedback">
                    {{$errors->first('nominal_transaksi')}}
                </div>
                @endif
            </div>
            <div class="col-md-6 mb-3">
                <label for="uraian" class="form-label">Uraian</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control @if ($errors->has('uraian'))
                    is-invalid
                @endif" name="uraian" id="uraian" required maxlength="20">
                </div>
                @if ($errors->has('uraian'))
                <div class="invalid-feedback">
                    {{$errors->first('uraian')}}
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            @foreach ($persen as $i)
            <div class="col-md-12 mb-3">
                <h2 class="text-center"><label for="persentase_awal_id" class="form-label">{{$i->nama}} ({{$i->persentase}}%)</label></h2>
                <hr>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">Rp</span>
                    <input type="text" class="form-control" name="nilai-{{$i->id}}" id="nilai-{{$i->id}}" disabled
                        data-thousands=".">
                </div>
            </div>
            <br>
            <hr>
            @foreach ($i->pemegang_saham as $d)
            <div class="col-md-6 mb-3">
                <label for="persentase_awal_id" class="form-label">{{$d->nama}} ({{$d->persentase}}%)</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">Rp</span>
                    <input type="text" class="form-control" name="nilai-{{$i->id}}-{{$d->id}}" id="nilai-{{$i->id}}-{{$d->id}}" disabled
                        data-thousands=".">
                </div>
            </div>
            @endforeach
            <hr>
            @endforeach
        </div>
        <hr>
        <div class="d-grid gap-3 mt-3">
            <button class="btn btn-success" type="submit">Simpan</button>
            <a href="{{route('billing.index')}}" class="btn btn-secondary" type="button">Batal</a>
        </div>
    </form>
</div>
@endsection
@push('js')
<script src="{{asset('assets/js/moment.min.js')}}"></script>
<script>
        $(function() {
            var nominal = new Cleave('#nominal_transaksi', {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
                numeralDecimalMark: ',',
                delimiter: '.'
            });
        });


         $('#nominal_transaksi').on('keyup', function(){
             let val = $(this).val();
             val = val.replace(/\./g,'');
             let dataPersen = {!! json_encode($persen) !!};
            //  each dataPersen
            $.each(dataPersen, function(index, value){
                let persen = value.persentase;
                let hasil = val * persen / 100;
                $('#nilai-'+value.id).maskMoney({
                    thousands: '.',
                    decimal: ',',
                    precision: 0
                });
                $('#nilai-'+value.id).maskMoney('mask', hasil);
                // each pemegang saham
                $.each(value.pemegang_saham, function(i, v){
                    let persen = v.persentase;
                    let hasil2 = hasil * persen / 100;
                    $('#nilai-'+value.id+'-'+v.id).maskMoney({
                        thousands: '.',
                        decimal: ',',
                        precision: 0
                    });
                    $('#nilai-'+value.id+'-'+v.id).maskMoney('mask', hasil2);
                });
            });
        });


        // masukForm on submit, sweetalert confirm
        $('#masukForm').submit(function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Apakah data sudah benar?',
                text: "Pastikan data sudah benar sebelum disimpan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, simpan!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $('#spinner').show();
                    this.submit();
                }
            })
        });
</script>
@endpush
