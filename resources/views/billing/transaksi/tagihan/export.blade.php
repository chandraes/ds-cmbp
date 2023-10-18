<table class="table table-bordered table-hover" id="">
    <thead class="table-success">
        <tr>
            <th class="text-center align-middle">No</th>
            <th class="text-center align-middle">Tanggal</th>
            <th class="text-center align-middle">Kode</th>
            <th class="text-center align-middle">Nomor Lambung</th>
            <th class="text-center align-middle">Vendor</th>
            <th class="text-center align-middle">Rute</th>
            @if ($data->first()->kas_uang_jalan->customer->tanggal_muat == 1)
            <th class="text-center align-middle">Tanggal Muat</th>
            @endif
            @if ($data->first()->kas_uang_jalan->customer->nota_muat == 1)
            <th class="text-center align-middle">Nota Muat</th>
            @endif
            @if ($data->first()->kas_uang_jalan->customer->tonase == 1)
            <th class="text-center align-middle">Timbangan Muat</th>
            @endif
            @if ($data->first()->kas_uang_jalan->customer->tanggal_bongkar == 1)
            <th class="text-center align-middle">Tanggal Bongkar</th>
            @endif
            <th class="text-center align-middle">Nota Bongkar</th>
            <th class="text-center align-middle">Timbangan Bongkar</th>
            @if ($data->first()->kas_uang_jalan->customer->selisih == 1)
            <th class="text-center align-middle">Selisih (Ton)</th>
            <th class="text-center align-middle">Selisih (%)</th>
            @endif
            <th class="text-center align-middle">Tagihan</th>
            <th class="text-center align-middle">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $d)
        <tr>
            <td class="text-center align-middle">{{$loop->iteration}}</td>
            <td class="text-center align-middle">{{$d->kas_uang_jalan->tanggal}}</td>
            <td class="align-middle">

                <div class="modal fade" id="uj{{$d->id}}" tabindex="-1" data-bs-backdrop="static"
                    data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
                        role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitleId">Nota Tagihan
                                    {{$d->kas_uang_jalan->vehicle->nomor_lambung}}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{route('transaksi.nota-bongkar.update', $d->id)}}" method="post"
                                id="masukForm{{$d->id}}">
                                @csrf
                                @method('PATCH')
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-4 mb-3">
                                            <label for="tanggal_muat" class="form-label">Kode</label>
                                            <input type="text" class="form-control" name="tanggal_muat"
                                                id="tanggal_muat" placeholder="" value="UJ{{sprintf(" %02d",
                                                $d->kas_uang_jalan->nomor_uang_jalan)}}" readonly>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label for="tanggal_muat" class="form-label">Tanggal</label>
                                            <input type="text" class="form-control" name="tanggal_uang_jalan"
                                                id="tanggal_muat" placeholder=""
                                                value="{{$d->kas_uang_jalan->tanggal}}" readonly>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label for="no_lambung" class="form-label">Nomor Lambung</label>
                                            <input type="text" class="form-control" name="no_lambung"
                                                id="no_lambung" placeholder=""
                                                value="{{$d->kas_uang_jalan->vehicle->nomor_lambung}}" readonly>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label for="vendor" class="form-label">Vendor</label>
                                            <input type="text" class="form-control" name="vendor" id="vendor"
                                                placeholder="" value="{{$d->kas_uang_jalan->vendor->nickname}}"
                                                readonly>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label for="tambang" class="form-label">Tambang</label>
                                            <input type="text" class="form-control" name="tambang" id="tambang"
                                                placeholder="" value="{{$d->kas_uang_jalan->customer->singkatan}}"
                                                readonly>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label for="rute" class="form-label">Rute</label>
                                            <input type="text" class="form-control" name="rute" id="rute"
                                                placeholder="" value="{{$d->kas_uang_jalan->rute->nama}}" readonly>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-4 mb-3">
                                            <label for="nota_muat" class="form-label">Nota Muat</label>
                                            <input type="text" class="form-control" name="nota_muat" id="nota_muat"
                                                placeholder="" value="{{$d->nota_muat}}" required>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label for="tonase" class="form-label">Timbangan Muat</label>
                                            <input type="text" class="form-control" name="tonase" id="tonase"
                                                placeholder="" value="{{$d->tonase}}" required>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label for="tonase" class="form-label">Tanggal Muat</label>
                                            <input type="text" class="form-control" name="tonase" id="tonase"
                                                placeholder="" value="{{$d->tanggal_muat}}" required>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-4 mb-3">
                                            <label for="nota_bongkar" class="form-label">Nota Bongkar</label>
                                            <input type="text" class="form-control" name="nota_bongkar"
                                                id="nota_bongkar" placeholder=""
                                                value="{{$d->nota_bongkar ? $d->nota_bongkar : ''}}"
                                                {{$d->nota_bongkar ? 'readonly' : ''}} required>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label for="timbangan_bongkar" class="form-label">Timbangan
                                                Bongkar</label>
                                            <input type="text" class="form-control" name="timbangan_bongkar"
                                                id="timbangan_bongkar" placeholder=""
                                                value="{{$d->timbangan_bongkar ? $d->timbangan_bongkar : ''}}"
                                                {{$d->timbangan_bongkar ? 'readonly' : ''}} required>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label for="tonase" class="form-label">Tanggal Bongkar</label>
                                            <input type="text" class="form-control" name="tonase" id="tonase"
                                                placeholder="" value="{{date('d M Y')}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#uj{{$d->id}}"> <strong>UJ{{sprintf("%02d",
                            $d->kas_uang_jalan->nomor_uang_jalan)}}</strong></a>
                </div>
            </td>
            <td class="text-center align-middle">{{$d->kas_uang_jalan->vehicle->nomor_lambung}}</td>
            <td class="text-center align-middle">{{$d->kas_uang_jalan->vendor->nickname}}</td>
            <td class="text-center align-middle">{{$d->kas_uang_jalan->rute->nama}}</td>
            @if ($data->first()->kas_uang_jalan->customer->tanggal_muat == 1)
            <td class="text-center align-middle">{{$d->tanggal_muat}}</td>
            @endif
            @if ($data->first()->kas_uang_jalan->customer->nota_muat == 1)
            <td class="text-center align-middle">{{$d->nota_muat}}</td>
            @endif
            @if ($data->first()->kas_uang_jalan->customer->tonase == 1)
            <td class="text-center align-middle">{{$d->tonase}}</td>
            @endif
            @if ($data->first()->kas_uang_jalan->customer->tanggal_bongkar == 1)
            <td class="text-center align-middle">{{$d->tanggal_bongkar}}</td>
            @endif
            <td class="text-center align-middle">{{$d->nota_bongkar}}</td>
            <td class="text-center align-middle">{{$d->timbangan_bongkar}}</td>
            @if ($data->first()->kas_uang_jalan->customer->selisih == 1)
            <td class="text-center align-middle">{{$d->tonase - $d->timbangan_bongkar}}</td>
            <td class="text-center align-middle">{{($d->tonase - $d->timbangan_bongkar)*0.1}}</td>
            @endif
            <td class="text-center align-middle">
                @if ($d->kas_uang_jalan->customer->tagihan_dari == 1)
                {{number_format(($d->nominal_tagihan), 0, ',', '.')}}
                @elseif ($d->kas_uang_jalan->customer->tagihan_dari == 2)
                {{number_format(($d->nominal_tagihan), 0, ',', '.')}}
                @endif
            </td>
            <td class="text-center align-middle">
                <button class="btn btn-warning btn-block">Void</button>
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
            <td class="text-center align-middle"
                colspan="{{7 + ($data->first()->kas_uang_jalan->customer->tanggal_muat == 1 ? 1 : 0) + ($data->first()->kas_uang_jalan->customer->nota_muat == 1 ? 1 : 0) + ($data->first()->kas_uang_jalan->customer->tonase == 1 ? 1 : 0) +
                                                            ($data->first()->kas_uang_jalan->customer->tanggal_bongkar == 1 ? 1 : 0) + ($data->first()->kas_uang_jalan->customer->selisih == 1 ? 2 : 0)}}"></td>
            <td class="text-center align-middle"><strong>Total</strong></td>
            <td align="right" class="align-middle">{{number_format($data->sum('nominal_tagihan'), 2, ',', '.')}}
            </td>
        </tr>
        <tr>
            <td class="text-center align-middle"
                colspan="{{7 + ($data->first()->kas_uang_jalan->customer->tanggal_muat == 1 ? 1 : 0) + ($data->first()->kas_uang_jalan->customer->nota_muat == 1 ? 1 : 0) + ($data->first()->kas_uang_jalan->customer->tonase == 1 ? 1 : 0) +
                                                            ($data->first()->kas_uang_jalan->customer->tanggal_bongkar == 1 ? 1 : 0) + ($data->first()->kas_uang_jalan->customer->selisih == 1 ? 2 : 0)}}"></td>
            <td class="text-center align-middle"><strong>PPN</strong></td>
            <td align="right" class="align-middle">
                @if ($data->first()->kas_uang_jalan->customer->ppn == 1)
                {{number_format($data->sum('nominal_tagihan') * 0.11, 2, ',', '.')}}
                @endif
            </td>
        </tr>
        <tr>
            <td class="align-middle"
                colspan="{{7 + ($data->first()->kas_uang_jalan->customer->tanggal_muat == 1 ? 1 : 0) + ($data->first()->kas_uang_jalan->customer->nota_muat == 1 ? 1 : 0) + ($data->first()->kas_uang_jalan->customer->tonase == 1 ? 1 : 0) +
                                                            ($data->first()->kas_uang_jalan->customer->tanggal_bongkar == 1 ? 1 : 0) + ($data->first()->kas_uang_jalan->customer->selisih == 1 ? 2 : 0)}}">
            </td>
            <td class="text-center align-middle"><strong>PPh</strong></td>
            <td align="right" class="align-middle">
                @if ($data->first()->kas_uang_jalan->customer->pph == 1)
                {{number_format($data->sum('nominal_tagihan') * 0.2, 2, ',', '.')}}
                @else
                0
                @endif
            </td>
        </tr>
        <tr>
            <td class="align-middle"
                colspan="{{7 + ($data->first()->kas_uang_jalan->customer->tanggal_muat == 1 ? 1 : 0) + ($data->first()->kas_uang_jalan->customer->nota_muat == 1 ? 1 : 0) + ($data->first()->kas_uang_jalan->customer->tonase == 1 ? 1 : 0) +
                                                            ($data->first()->kas_uang_jalan->customer->tanggal_bongkar == 1 ? 1 : 0) + ($data->first()->kas_uang_jalan->customer->selisih == 1 ? 2 : 0)}}">
            </td>
            <td class="text-center align-middle"><strong>Tagihan</strong></td>
            <td align="right" class="align-middle">
                {{number_format($data->sum('nominal_tagihan') - ($data->first()->kas_uang_jalan->customer->pph == 1 ? $data->sum('nominal_tagihan')
                * 0.2 : 0) + ($data->first()->kas_uang_jalan->customer->ppn == 1 ? $data->sum('nominal_tagihan') * 0.11 : 0), 2, ',', '.')}}
            </td>
        </tr>
    </tfoot>
</table>