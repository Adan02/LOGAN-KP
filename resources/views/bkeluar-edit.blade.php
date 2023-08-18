@extends('layouts.mainlayout')

@section('title', 'Transaksi Barang Keluar')

@section('content')

    <div class="col-lg-6 col m-auto mb-3" id="success_message"></div>
    <div class="row h-100">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Edit Transaksi Barang Keluar</h5>
                        <a class="btn btn-primary" type="button" href="/logan/input-data/barang-keluar"><i class="fa-solid fa-left-long"></i></a>
                    </div>
                    <form action="{{ $bkeluar->id }}" method="post" class="row g-3 bkeluar_form">
                        @csrf
                        @method('PUT')
                        <div class="mt-3">
                            <label for="kebutuhan" class="form-label">Kebutuhan</label>
                            <input type="text" class="form-control" id="kebutuhan" name="kebutuhan" value="{{ $bkeluar->kebutuhan }}">
                            <span class="text-danger error-text kebutuhan_error"></span>
                        </div>
                        <div class="mt-3">
                            <h4>Pemberi</h4>
                            <div>
                                <label for="instansi-pemberi" class="form-label">Instansi</label>
                                <input type="text" class="form-control" id="instansi-pemberi" name="instansi_pemberi" value="{{ $bkeluar->instansi_pemberi }}">
                                <span class="text-danger error-text instansi_pemberi_error"></span>
                            </div>
                            <div class="mt-3">
                                <label for="nama-pemberi" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama-pemberi" name="nama_pemberi" value="{{ $bkeluar->nama_pemberi }}">
                                <span class="text-danger error-text nama_pemberi_error"></span>
                            </div>
                            <div class="mt-3">
                                <label for="nik-pemberi" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik-pemberi" name="nik_pemberi" value="{{ $bkeluar->nik_pemberi }}">
                                <span class="text-danger error-text nik_pemberi_error"></span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h4>Penerima</h4>
                            <div>
                                <label for="instansi-penerima" class="form-label">Instansi</label>
                                <input type="text" class="form-control" id="instansi-penerima" name="instansi_penerima" value="{{ $bkeluar->instansi_penerima }}">
                                <span class="text-danger error-text instansi_penerima_error"></span>
                            </div>
                            <div class="mt-3">
                                <label for="nama-penerima" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama-penerima" name="nama_penerima" value="{{ $bkeluar->nama_penerima }}">
                                <span class="text-danger error-text nama_penerima_error"></span>
                            </div>
                            <div class="mt-3">
                                <label for="nik-penerima" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik-penerima" name="nik_penerima" value="{{ $bkeluar->nik_penerima }}">
                                <span class="text-danger error-text nik_penerima_error"></span>
                            </div>
                        </div>
                        <div class="mt-3">
                            @if (Session::get('bkeluar_id'))
                                <div class="d-flex flex-column gap-2">
                                    <a class="btn btn-primary" type="button" href="pilih-barang">Lanjut</a>
                                    <a class="btn btn-warning" type="button" href="selesai-pilih">Selesai</a>
                                </div>
                            @else
                                <div>
                                    <button class="btn btn-primary w-100" type="submit">Simpan</button>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        $(".bkeluar_form").on('submit', function(e) {
            event.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $('#success_message').removeClass('alert alert-success');
                    $('#success_message').text("");
                    $(document).find('span.error-text').text('');
                    $('[class*="error"]').removeClass('error');
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                            $('[name="' + prefix + '"]').addClass('error');
                        });
                    } else {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(data.msg);
                    }
                }
            });
        });
    </script>
@endsection
@endsection
