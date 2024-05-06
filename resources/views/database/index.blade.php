@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
         <h1><u>Database</u></h1>
        </div>
    </div>
    <div class="row justify-content-left">
        <h3>Customer</h3>
        @if (auth()->user()->role === 'admin')
        <div class="col-md-3 text-center mt-3 mb-3">
            <a href="{{route('rute.index')}}" class="text-decoration-none">
                <img src="{{asset('images/rute.svg')}}" alt="" width="80">
                <h3>Rute</h3>
            </a>
        </div>
        <div class="col-md-3 text-center mt-3 mb-3">
            <a href="{{route('customer.index')}}" class="text-decoration-none">
                <img src="{{asset('images/company.svg')}}" alt="" width="80">
                <h3>Customer</h3>
            </a>
        </div>
        {{-- <div class="col-md-3 text-center mt-3 mb-3">
            <a href="{{route('bbm-storing.index')}}" class="text-decoration-none">
                <img src="{{asset('images/bbm.svg')}}" alt="" width="80">
                <h3>BBM Storing</h3>
            </a>
        </div> --}}
        @endif
    </div>
    <hr>
    <div class="row justify-content-left">
        <h3>VENDOR</h3>
        <div class="col-md-3 text-center mt-3 mb-3">
            <a href="{{route('sponsor.index')}}" class="text-decoration-none">
                <img src="{{asset('images/sponsor.svg')}}" alt="" width="80">
                <h3>Sponsor</h3>
            </a>
        </div>
        <div class="col-md-3 text-center mt-3 mb-3">
            <a href="{{route('vendor.index')}}" class="text-decoration-none">
                <img src="{{asset('images/vendor.svg')}}" alt="" width="80">
                <h3>Vendor</h3>
            </a>
        </div>
        <div class="col-md-3 text-center mt-3 mb-3">
            <a href="{{route('vehicle.index')}}" class="text-decoration-none">
                <img src="{{asset('images/dumptruckempty.svg')}}" alt="" width="80">
                <h3>Vehicle</h3>
            </a>
        </div>
        <div class="col-md-3 text-center mt-3 mb-3">
            <a href="{{route('database.upah-gendong')}}" class="text-decoration-none">
                <img src="{{asset('images/upah-gendong.svg')}}" alt="" width="80">
                <h3 class="mt-3">UPAH GENDONG</h3>
            </a>
        </div>
    </div>
    <hr>
    <div class="row justify-content-left">
        <h3>BIODATA</h3>
        <div class="col-md-3 text-center mt-3 mb-3">
            <a href="{{route('karyawan.index')}}" class="text-decoration-none">
                <img src="{{asset('images/karyawan.svg')}}" alt="" width="80">
                <h3>Staff</h3>
            </a>
        </div>
        <div class="col-md-3 text-center mt-3 mb-3">
            <a href="{{route('direksi.index')}}" class="text-decoration-none">
                <img src="{{asset('images/direksi.svg')}}" alt="" width="80">
                <h3>Direksi</h3>
            </a>
        </div>
        <div class="col-md-3 text-center mt-3 mb-3">
            <a href="{{route('pemegang-saham.index')}}" class="text-decoration-none">
                <img src="{{asset('images/saham.svg')}}" alt="" width="80">
                <h3>Pemegang Saham</h3>
            </a>
        </div>
    </div>
    <hr>
    <div class="row justify-content-left">
        <h3>OTHERS</h3>
        <div class="col-md-3 text-center mt-3 mb-3">
            <a href="{{route('rekening.index')}}" class="text-decoration-none">
                <img src="{{asset('images/akun-bank.svg')}}" alt="" width="80">
                <h3>Nomor Rekening Transaksi</h3>
            </a>
        </div>
        {{-- <div class="col-md-3 text-center mt-3 mb-3">
            <a href="{{route('kategori-barang.index')}}" class="text-decoration-none">
                <img src="{{asset('images/stock.svg')}}" alt="" width="80">
                <h3>Kategori Barang</h3>
            </a>
        </div> --}}

        <div class="col-md-3 text-center mt-3 mb-3">
            <a href="{{route('home')}}" class="text-decoration-none">
                <img src="{{asset('images/dashboard.svg')}}" alt="" width="80">
                <h3>Dashboard</h3>
            </a>
        </div>
    </div>
</div>
@endsection
