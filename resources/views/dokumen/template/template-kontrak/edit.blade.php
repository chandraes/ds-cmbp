@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center mb-5">
        <div class="col-md-12 text-center">
            <h1><u>Tambah Halaman SPK</u></h1>
        </div>
    </div>
</div>
<div class="container">
    <form action="{{route('template-kontrak.update', $data->id)}}" method="post">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-3">
                <div class="mb-3">
                    <label for="nama" class="form-label">Judul Halaman</label>
                    <input type="text" class="form-control" name="nama" id="nama" required value="{{$data->nama}}">
                </div>
            </div>
            <div class="col-3">
                <div class="mb-3">
                    <label for="urutan" class="form-label">Urutan Ke </label>
                    <input type="number" class="form-control" name="urutan" id="urutan" required
                        value="{{$data->urutan}}">
                </div>
            </div>
            <div class="col-3 text-center">
                <div class="mb-3">
                    <label for="" class="form-label">.</label>
                    <button type="submit" class="form-control btn btn-primary">Simpan</button>
                </div>
            </div>
            <div class="col-3 text-center">
                <div class="mb-3">
                    <label for="" class="form-label">.</label>
                    <a href="{{route('template-kontrak.index')}}" class="form-control btn btn-secondary">Keluar</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label for="content" class="form-label">Isi Halaman</label>
                    <textarea class="form-control" name="content" id="content" rows="100">{!! $data->content !!}</textarea>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@push('css')
<link rel="stylesheet" href="{{asset('assets/plugins/richtexteditor/rte_theme_default.css')}}">
<style>
    .table-pdf {
            border: 1px solid;
            padding-left: 5px;
            padding-right: 5px;
        }
        .text-pdf {
            font-size: 9pt;
        }
        .text-10 {
            font-size: 10pt;
        }
        .page-break {
            page-break-after: always;
        }
        .column-pdf {
            float: left;
            width: 50%;
        }
        .row-pdf:after {
            content: "";
            display: table;
            clear: both;
        }
        .column-4 {
            float: left;
            width: 25%;
        }
</style>
@endpush
@push('js')
<script src="{{asset('assets/plugins/richtexteditor/rte.js')}}"></script>
<script type="text/javascript" src={{asset('assets/plugins/richtexteditor/plugins/all_plugins.js')}}></script>
<script>
    var editor = new RichTextEditor("#content", {
            skin: "bootstrap",
            toolbar: "full",
        });
</script>
@endpush
