<div class="modal fade" id="editSaham-{{$k->id}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Edit Pemegang Saham</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('pemegang-saham.update', $k)}}" method="post">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                               <div class="mb-3">
                                <label for="persentase_awal_id" class="form-label">Persentase Awal</label>
                                <select class="form-select" name="persentase_awal_id" id="persentase_awal_id">
                                    <option value=""> -- Pilih -- </option>
                                    @foreach ($persen as $i)
                                    <option value="{{$i->id}}" @if ($k->persentase_awal_id == $i->id)
                                        selected
                                    @endif>{{$i->nama}} ({{$i->persentase}}%)</option>
                                    @endforeach
                                </select>
                               </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama" aria-describedby="helpId"
                                    placeholder="" value="{{$k->nama}}" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="persentase" class="form-label">Persentase</label>
                                <input type="number" class="form-control" name="persentase" id="persentase"
                                    aria-describedby="helpId" placeholder="" value="{{$k->persentase}}" required>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h2>Informasi Rekening</h2>
                    <div class="row mt-3">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="bank" class="form-label">Nama Bank</label>
                                <input type="text" class="form-control @if ($errors->has('bank')) is-invalid @endif"
                                    name="bank" id="bank" value="{{$k->bank}}" required>
                                @if ($errors->has('bank'))
                                <div class="invalid-feedback">
                                    {{$errors->first('bank')}}
                                </div>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="nomor_rekening" class="form-label">Nomor Rekening</label>
                                <input type="text"
                                    class="form-control @if ($errors->has('nomor_rekening')) is-invalid @endif"
                                    name="nomor_rekening" id="nomor_rekening" value="{{$k->nomor_rekening}}" required>
                                @if ($errors->has('nomor_rekening'))
                                <div class="invalid-feedback">
                                    {{$errors->first('nomor_rekening')}}
                                </div>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="nama_rekening" class="form-label">Nama Rekening</label>
                                <input type="text"
                                    class="form-control @if ($errors->has('nama_rekening')) is-invalid @endif"
                                    name="nama_rekening" id="nama_rekening" value="{{$k->nama_rekening}}" required>
                                @if ($errors->has('nama_rekening'))
                                <div class="invalid-feedback">
                                    {{$errors->first('nama_rekening')}}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
