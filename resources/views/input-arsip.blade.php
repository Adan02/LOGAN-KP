@extends('layouts.mainlayout')

@section('title', 'Input Arsip')

@section('content')

    <div class="col-lg-6 col m-auto mb-3" id="success_message"></div>
    <div class="row h-100">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Input Arsip</h5>
                    <form action="arsip" method="post" enctype="multipart/form-data" class="row g-3 main_form">
                        @csrf
                        <div class="">
                            <label for="jenis" class="form-label">Jenis Arsip</label>
                            <input type="text" class="form-control" id="jenis" name="jenis" value="{{ old('jenis') }}">
                            <span class="text-danger error-text jenis_error"></span>
                        </div>
                        <div class="">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}">
                            <span class="text-danger error-text judul_error"></span>
                        </div>
                        <div class="">
                            <label for="vendor" class="form-label">Vendor</label>
                            <input type="text" class="form-control" id="vendor" name="vendor" value="{{ old('vendor') }}">
                            <span class="text-danger error-text vendor_error"></span>
                        </div>
                        <div class="">
                            <label for="nomor-arsip" class="form-label">No. Arsip</label>
                            <input type="text" class="form-control" id="nomor-arsip" name="nomor_arsip" value="{{ old('nomor_arsip') }}">
                            <span class="text-danger error-text nomor_arsip_error"></span>
                        </div>
                        <div class="">
                            <label for="tanggal-arsip" class="form-label">Tanggal Arsip</label>
                            <input type="date" class="form-control" id="tanggal-arsip" name="tanggal_arsip" value="{{ old('tanggal_arsip') }}">
                            <span class="text-danger error-text tanggal_arsip_error"></span>
                        </div>
                        <div class="">
                            <label for="file" class="form-label">File Arsip</label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="file" name="file">
                            </div>
                        </div>
                        <div class="">
                            <button class="btn btn-primary w-100" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
