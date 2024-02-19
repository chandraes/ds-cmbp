<div class="modal fade" id="edit-{{$d->id}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Edit Sponsor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('sponsor.update', $d->id)}}" method="post">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" aria-describedby="helpId"
                                placeholder="" required value="{{$d->nama}}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="nomor_wa" class="form-label">Nomor WA</label>
                            <input type="text" class="form-control" name="nomor_wa" id="nomor_wa"
                                aria-describedby="helpId" placeholder="" required value="{{$d->nomor_wa}}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="nama" class="form-label">Persentase Bonus</label>
                            <div class="input-group mb-3">
                                <input
                                    type="number"
                                    name="persen_bonus"
                                    id="persen_bonus"
                                    class="form-control" placeholder="" value="{{$d->persen_bonus}}"
                                    aria-describedby="prefixId"
                                />
                                <span class="input-group-text" id="prefixId">%</span>
                            </div>
                        </div>
                        <hr>
                        <h4>INFO REKENING</h4>
                        <hr>
                        <div class="col-md-4 mb-3">
                            <label for="nama_bank" class="form-label">Nama Bank</label>
                            <input type="text" class="form-control" name="nama_bank" id="nama_bank"
                                aria-describedby="helpId" placeholder="" required value="{{$d->nama_bank}}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="nomor_rekening" class="form-label">Nomor Rekening</label>
                            <input type="text" class="form-control" name="nomor_rekening" id="nomor_rekening"
                                aria-describedby="helpId" placeholder="" required value="{{$d->nomor_rekening}}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="transfer_ke" class="form-label">Nama Rekening</label>
                            <input type="text" class="form-control" name="transfer_ke" id="transfer_ke"
                                aria-describedby="helpId" placeholder="" required value="{{$d->transfer_ke}}">
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
