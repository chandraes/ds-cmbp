@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
            <h1><u>Nota Tagihan</u></h1>
        </div>
    </div>
    @php
        // $selectedData = [];
        $total_tagihan = $data ? $data->sum('nominal_tagihan') : 0;
        $ppn = $customer->ppn == 1 && $data ? $data->sum('nominal_tagihan') * 0.11 : 0;
        $pph = $customer->pph == 1 && $data ? $data->sum('nominal_tagihan') * 0.02 : 0;
        $profit = $data->sum('profit');
        $profit_persen = count($data) > 0 ? ($data->sum('profit') / $data->sum('nominal_bayar')) * 100 : 0;
    @endphp
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
            <h1><u>{{$customer->nama}} ({{$customer->singkatan}})</u></h1>
        </div>
    </div>
    @include('swal')
    {{-- if errors has any --}}
    @if ($errors->any())
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Whoops!</strong> Ada kesalahan saat input data, yaitu:
                <ul>
                    @foreach ($errors->all() as $error)
                    <li><strong>{{$error}}</strong></li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    <div class="flex-row justify-content-between mt-3">
        <div class="col-md-6">
            <table class="table">
                <tr class="text-center">
                    <td><a href="{{route('home')}}"><img src="{{asset('images/dashboard.svg')}}" alt="dashboard"
                                width="30"> Dashboard</a></td>
                    <td><a href="{{route('billing.index')}}"><img src="{{asset('images/billing.svg')}}"
                                alt="dokumen" width="30"> Billing</a></td>
                    <td class="align-middle"><a href="{{route('transaksi.nota-tagihan.keranjang', ['customer' => $customer->id])}}"><i class="fa fa-cart-arrow-down me-2" style="font-size: 30px"></i> Keranjang @if ($keranjang > 0) <span
                        class="badge bg-danger">{{$keranjang}}</span> @endif</a></td>
                </tr>
            </table>
        </div>
    </div>
</div>
@include('billing.transaksi.tagihan.filter')
@include('billing.transaksi.tagihan.show-new')
<div class="container-fluid mt-3 table-responsive ">
    <table class="table table-bordered table-hover" id="notaTable">
        <thead class="table-success">
            <tr>
                <th class="text-center align-middle">
                    Select
                    {{-- select all --}}
                    <input style="height: 25px; width:25px" type="checkbox" onclick="checkAll(this)" id="checkAll">
                </th>

                <th class="text-center align-middle">Tanggal UJ</th>
                <th class="text-center align-middle">Kode</th>
                <th class="text-center align-middle">NOLAM</th>
                <th class="text-center align-middle">Vendor</th>
                <th class="text-center align-middle">Rute</th>
                <th class="text-center align-middle">Jarak (Km)</th>
                <th class="text-center align-middle">Harga</th>
                @if ($customer->tanggal_muat == 1)
                <th class="text-center align-middle">Tanggal Muat</th>
                @endif
                @if ($customer->nota_muat == 1)
                <th class="text-center align-middle">Nota Muat</th>
                @endif
                @if ($customer->tonase == 1)
                <th class="text-center align-middle">Tonase Muat</th>
                @endif
                @if ($customer->tanggal_bongkar == 1)
                <th class="text-center align-middle">Tanggal Bongkar</th>
                @endif
                <th class="text-center align-middle">Nota Bongkar</th>
                <th class="text-center align-middle">Tonase Bongkar</th>
                @if ($customer->selisih == 1)
                <th class="text-center align-middle">Selisih (Ton)</th>
                <th class="text-center align-middle">Selisih (%)</th>
                @endif
                <th class="text-center align-middle">Tagihan</th>
                <th class="text-center align-middle">Profit</th>
                <th class="text-center align-middle">Profit (%)</th>
                <th class="text-center align-middle">DO Fisik</th>
                <th class="text-center align-middle">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
            <tr>
                {{-- check list --}}
                <td class="text-center align-middle">
                    {{-- checklist on check push $d->id to $selectedData --}}
                    <input style="height: 25px; width:25px" type="checkbox" value="{{$d->id}}" data-tagihan="{{$d->nominal_tagihan}}" onclick="check(this, {{$d->id}})" id="idSelect-{{$d->id}}" {{$d->nota_fisik == 0 ? 'disabled' : ''}}>
                </td>
                <td class="text-center align-middle">{{$d->kas_uang_jalan->tanggal}}</td>
                <td class="align-middle">
                    <div class="text-center">
                        {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#uj{{$d->id}}"> <strong>UJ{{sprintf("%02d",
                                $d->kas_uang_jalan->nomor_uang_jalan)}}</strong></a> --}}
                        <a href="#" data-bs-toggle="modal" data-bs-target="#showModal" onclick="updateShow({{$d}})"> <strong>UJ{{sprintf("%02d",
                            $d->kas_uang_jalan->nomor_uang_jalan)}}</strong></a>
                    </div>
                    {{-- @include('billing.transaksi.tagihan.show') --}}
                </td>
                <td class="text-center align-middle">{{$d->kas_uang_jalan->vehicle->nomor_lambung}}</td>
                <td class="text-center align-middle">{{$d->kas_uang_jalan->vendor->nickname}}</td>
                <td class="text-center align-middle">{{$d->kas_uang_jalan->rute->nama}}</td>
                <td class="text-center align-middle">{{$d->kas_uang_jalan->rute->jarak}}</td>
                <td class="text-center align-middle">
                    {{number_format($d->harga_customer, 0, ',', '.')}}
                </td>
                @if ($customer->tanggal_muat == 1)
                <td class="text-center align-middle">{{$d->id_tanggal_muat}}</td>
                @endif
                @if ($customer->nota_muat == 1)
                <td class="text-center align-middle">{{$d->nota_muat}}</td>
                @endif
                @if ($customer->tonase == 1)
                <td class="text-center align-middle">{{$d->tonase}}</td>
                @endif
                @if ($customer->tanggal_bongkar == 1)
                <td class="text-center align-middle">{{$d->id_tanggal_bongkar}}</td>
                @endif
                <td class="text-center align-middle">{{$d->nota_bongkar}}</td>
                <td class="text-center align-middle">{{$d->timbangan_bongkar}}</td>
                @if ($customer->selisih == 1)
                <td class="text-center align-middle">{{number_format($d->tonase - $d->timbangan_bongkar, 2, ',','.')}}</td>
                <td class="text-center align-middle">{{number_format(($d->tonase - $d->timbangan_bongkar)*0.1, 2, ',','.')}}</td>
                @endif
                <td class="text-end align-middle">
                    @if ($d->kas_uang_jalan->customer->tagihan_dari == 1)
                    {{number_format(($d->nominal_tagihan), 0, ',', '.')}}
                    @elseif ($d->kas_uang_jalan->customer->tagihan_dari == 2)
                    {{number_format(($d->nominal_tagihan), 0, ',', '.')}}
                    @endif
                </td>
                <td class="text-end align-middle">
                   {{number_format($d->profit, 0, ',', '.')}}

                </td>
                <td class="text-center align-middle">
                    {{number_format((($d->profit/$d->nominal_bayar)*100), 2, ',','.')}}%
                </td>
                <td class="text-center align-middle">
                    @if ($d->nota_fisik == 0)
                        <form action="{{route('transaksi.nota-tagihan.check', $d->id)}}" method="get">
                            <input style="height: 25px; width:25px" type="checkbox" {{ $d->nota_fisik == 1 ? 'checked' : '' }} onchange="this.form.submit()">
                        </form>
                    @else
                    <input style="height: 25px; width:25px" type="checkbox" {{ $d->nota_fisik == 1 ? 'checked' : '' }} onclick="event.preventDefault(); showUncheckModal({{$d}}).catch(() => this.checked = true)">
                    @endif
                    @if ($d->nota_fisik == 1 && $d->do_checker_id != null)
                    <br>
                    Checker: <strong>{{$d->do_checker->name}}</strong>
                    @endif
                </td>
                <td class="text-center align-middle">
                    @if (auth()->user()->role === 'admin')
                    <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" data-bs-target="#backModal-{{$d->id}}">
                        Edit
                      </button>

                      <!-- Modal Body -->
                      <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                      <div class="modal fade" id="backModal-{{$d->id}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="Title-{{$d->id}}" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="Title-{{$d->id}}">Masukkan Password</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form action="{{route('transaksi.nota-tagihan.edit', $d)}}" method="post">
                                      @csrf
                                  <div class="modal-body">
                                      <input type="password" class="form-control" id="password" name="password"
                                          placeholder="Password" aria-label="Password" aria-describedby="password"
                                          required>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                      <button type="submit" class="btn btn-primary">Lanjutkan</button>
                                  </div>
                              </form>
                              </div>
                          </div>
                      </div>

                    <button class="btn btn-warning btn-block m-2" type="button" data-bs-toggle="modal" data-bs-target="#modalVoid-{{$d->id}}">Void</button>

                    <div class="modal fade" id="modalVoid-{{$d->id}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTitleId">Masukan Password </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('transaksi.tagihan.void', $d->id)}}" method="post">
                                    @csrf
                                <div class="modal-body">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" aria-label="Password" aria-describedby="password" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    @endif

                </td>
            </tr>
            <script>
                $('#masukForm{{$d->id}}').submit(function(e){
                  e.preventDefault();

                  Swal.fire({
                      title: 'Apakah anda yakin data sudah benar?',
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#6c757d',
                      confirmButtonText: 'Ya, simpan!'
                      }).then((result) => {
                      if (result.isConfirmed) {
                          this.submit();
                      }
                  })
              });
            </script>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td class=""
                    colspan="{{9 + ($customer->tanggal_muat == 1 ? 1 : 0) + ($customer->nota_muat == 1 ? 1 : 0) + ($customer->tonase == 1 ? 1 : 0) +
                                                                ($customer->tanggal_bongkar == 1 ? 1 : 0) + ($customer->selisih == 1 ? 2 : 0)}}">
                    <div class="row text-center">
                        <div class="col-md-4 mt-2">
                            <label for="" class="form-label">Total Tagihan Dipilih : </label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input type="text" class="form-control text-bold" name="total_tagih_diplay" id="total_tagihan_display">
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-center align-middle"><strong>Total</strong></td>
                <td class="text-end align-middle">{{number_format($total_tagihan, 0, ',', '.')}}
                </td>
                <td class="text-end align-middle">{{number_format($profit, 0, ',', '.')}}</td>
                <td class="text-end align-middle">{{number_format($profit_persen, 2, ',', '.')}}%</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="text-center align-middle"
                    colspan="{{9 + ($customer->tanggal_muat == 1 ? 1 : 0) + ($customer->nota_muat == 1 ? 1 : 0) + ($customer->tonase == 1 ? 1 : 0) +
                                                                ($customer->tanggal_bongkar == 1 ? 1 : 0) + ($customer->selisih == 1 ? 2 : 0)}}"></td>
                <td class="text-center align-middle"><strong>PPN</strong></td>
                <td class="text-end align-middle">

                    {{number_format($ppn, 0, ',', '.')}}

                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="align-middle"
                    colspan="{{9 + ($customer->tanggal_muat == 1 ? 1 : 0) + ($customer->nota_muat == 1 ? 1 : 0) + ($customer->tonase == 1 ? 1 : 0) +
                                                                ($customer->tanggal_bongkar == 1 ? 1 : 0) + ($customer->selisih == 1 ? 2 : 0)}}">
                </td>
                <td class="text-center align-middle"><strong>PPh</strong></td>
                <td class="text-end align-middle">

                    {{number_format($pph, 0, ',', '.')}}

                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="align-middle"
                    colspan="{{9 + ($customer->tanggal_muat == 1 ? 1 : 0) + ($customer->nota_muat == 1 ? 1 : 0) + ($customer->tonase == 1 ? 1 : 0) +
                                                                ($customer->tanggal_bongkar == 1 ? 1 : 0) + ($customer->selisih == 1 ? 2 : 0)}}">
                </td>
                <td class="text-center align-middle"><strong>Tagihan</strong></td>
                <td class="text-end align-middle"> <strong>
                    {{number_format($total_tagihan-$pph+$ppn, 0, ',', '.')}}</strong>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
<input type="hidden" name="total_tagihan" id="total_tagihan" value="0">
<div class="container-fluid mt-3 mb-3">
    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
        <form action="{{route('transaksi.nota-tagihan.lanjut-pilih', $customer)}}" method="post" id="lanjutForm">
            @csrf
            <input type="hidden" name="selectedData" required>
            <button class="btn btn-primary me-md-3 btn-lg" type="submit">Lanjutkan Pilihan</button>
        </form>
        <form target="_blank" action="{{route('transaksi.nota-tagihan.export', $customer)}}" method="get">
            <input type="hidden" name="rute_id" value="{{$rute_id}}">
            <button class="btn btn-success btn-lg" type="submit">Export</button>
        </form>
      </div>
</div>

@endsection
@push('css')
<link href="{{asset('assets/css/dt.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/js/flatpickr/flatpickr.min.css')}}">
@endpush
@push('js')
<script src="{{asset('assets/js/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/plugins/date-picker/date-picker.js')}}"></script>
<script src="{{asset('assets/js/dt-font.js')}}"></script>
<script src="{{asset('assets/js/dt5.min.js')}}"></script>
<script>


$(document).ready(function() {
        var table = $('#notaTable').DataTable({
            "paging": false,
            "ordering": false,
            "scrollCollapse": true,
            "scrollY": "550px",
            "fixedColumns": {
                "leftColumns": 3,
                "rightColumns": 1
            },
        });

    });

    function check(checkbox, id) {
        var totalTagihan = parseFloat($('#total_tagihan').val()) || 0;
        var tagihan = parseFloat($(checkbox).data('tagihan'));

        if (checkbox.checked) {
            totalTagihan += tagihan;
            $('input[name="selectedData"]').val(function(i, v) {
                // if end of string, remove comma
                return v + id + ',';

            });
        } else {
            totalTagihan -= tagihan;

            $('input[name="selectedData"]').val(function(i, v) {
                // remove id from string
                return v.replace(id + ',', '');
            });
        }

        $('#total_tagihan').val(totalTagihan);
        $('#total_tagihan_display').val(totalTagihan.toLocaleString('id-ID'));

        value = $('input[name="selectedData"]').val();

        if(value.slice(-1) == ','){
            // remove comma from last number
            value = value.slice(0, -1);
        }
        console.log(value);
    }

    // check all checkbox and push all id to $selectedData and check all checkbox
    function checkAll(checkbox, id) {
        $('#total_tagihan').val(0);
        $('#total_tagihan_display').val(0);
        var totalTagihan = parseFloat($('#total_tagihan').val()) || 0;

        if (checkbox.checked) {
            $('input[name="selectedData"]').val(function(i, v) {
                // if end of string, remove comma
                @foreach ($data as $d)
                if({{$d->nota_fisik}} == 1) {
                var tagihan = parseFloat($('#idSelect-{{$d->id}}').data('tagihan'));
                totalTagihan += tagihan;

                    v = v + {{$d->id}} + ',';
                    $('#idSelect-{{$d->id}}').prop('checked', true);
                }
                @endforeach
                return v;
            });
        } else {
            $('input[name="selectedData"]').val(function(i, v) {
                // remove id from string
                @foreach ($data as $d)
                    v = v.replace({{$d->id}} + ',', '');
                    $('#idSelect-{{$d->id}}').prop('checked', false);
                @endforeach
                return v;
            });
            totalTagihan = 0;
        }

        $('#total_tagihan').val(totalTagihan);
        $('#total_tagihan_display').val(totalTagihan.toLocaleString('id-ID'));

        value = $('input[name="selectedData"]').val();

        if(value.slice(-1) == ','){
            // remove comma from last number
            value = value.slice(0, -1);
        }
        console.log(value);
    }


    $('#lanjutForm').submit(function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
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

        document.getElementById('filter_date').onchange = function() {
                document.getElementById('tanggal_filter').required = this.value !== '';
            };
        document.getElementById('tanggal_filter').onchange = function() {
            document.getElementById('filter_date').required = this.value !== '';
        };

        flatpickr("#tanggal_filter", {
            mode: "range",
            dateFormat: "d-m-Y",
        });

        function updateShow(data) {
        // Update the content of the 'show.blade.php' with the data
            document.getElementById('modalTitleId').innerText = `Nota Tagihan NOLAM ${data.kas_uang_jalan.vehicle.nomor_lambung}`;
            document.getElementById('kode').value = `UJ${(data.kas_uang_jalan.nomor_uang_jalan)}`;
            document.getElementById('tanggal_uang_jalan').value = data.kas_uang_jalan.tanggal;
            document.getElementById('no_lambung').value = data.kas_uang_jalan.vehicle.nomor_lambung;
            document.getElementById('vendor').value = data.kas_uang_jalan.vendor.nickname;
            document.getElementById('tambang').value = data.kas_uang_jalan.customer.singkatan;
            document.getElementById('rute').value = data.kas_uang_jalan.rute.nama;
            document.getElementById('nota_muat').value = data.nota_muat;
            document.getElementById('tonase').value = data.tonase;
            document.getElementById('id_tanggal_muat').value = data.id_tanggal_muat;
            document.getElementById('nota_bongkar').value = data.nota_bongkar;
            document.getElementById('timbangan_bongkar').value = data.timbangan_bongkar;
            document.getElementById('id_tanggal_bongkar').value = data.id_tanggal_bongkar;

        }

        function showUncheckModal(data) {
            Swal.fire({
                title: "Masukan Password",
                input: "password",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                confirmButtonText: "Lanjutkan",
                showLoaderOnConfirm: true,
                preConfirm: async (password) => {
                    const response = await fetch(`/transaksi/nota-tagihan/${data.id}/uncheck`, { // replace with your endpoint
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // for CSRF protection in Laravel
                        },
                        body: JSON.stringify({
                            password: password,
                        })
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || response.statusText);
                    }

                    return response.json();
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Data Berhasil disimpan.',
                        icon: 'success'
                    }).then(() => {
                        $('#spinner').show();
                        location.reload();
                    });
                }
            }).catch(error => {
                Swal.fire('Error!', error.message, 'error');
            });
        }
</script>
@endpush
