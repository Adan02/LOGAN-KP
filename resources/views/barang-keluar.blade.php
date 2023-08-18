@extends('layouts.mainlayout')

@section('title', 'Barang Keluar')

@section('content')

    <div class="col-lg-6 col m-auto mb-3" id="success_message"></div>
    <div class="row h-100">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Barang Keluar</h5>
                    <form action="bkeluar" method="post" class="row g-3 bkeluar_form">
                        @csrf
                        <div class="mt-3">
                            <label for="kebutuhan" class="form-label">Kebutuhan</label>
                            <input type="text" class="form-control" id="kebutuhan" name="kebutuhan" value="{{ old('kebutuhan') }}" {{ Session::get('bkeluar_id') ? 'disabled' : '' }}>
                            <span class="text-danger error-text kebutuhan_error"></span>
                        </div>
                        <div class="mt-3">
                            <h4>Pemberi</h4>
                            <div>
                                <label for="instansi-pemberi" class="form-label">Instansi</label>
                                <input type="text" class="form-control" id="instansi-pemberi" name="instansi_pemberi" value="{{ old('instansi-pemberi') }}" {{ Session::get('bkeluar_id') ? 'disabled' : '' }}>
                                <span class="text-danger error-text instansi_pemberi_error"></span>
                            </div>
                            <div class="mt-3">
                                <label for="nama-pemberi" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama-pemberi" name="nama_pemberi" value="{{ old('nama-pemberi') }}" {{ Session::get('bkeluar_id') ? 'disabled' : '' }}>
                                <span class="text-danger error-text nama_pemberi_error"></span>
                            </div>
                            <div class="mt-3">
                                <label for="nik-pemberi" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik-pemberi" name="nik_pemberi" value="{{ old('nik-pemberi') }}" {{ Session::get('bkeluar_id') ? 'disabled' : '' }}>
                                <span class="text-danger error-text nik_pemberi_error"></span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h4>Penerima</h4>
                            <div>
                                <label for="instansi-penerima" class="form-label">Instansi</label>
                                <input type="text" class="form-control" id="instansi-penerima" name="instansi_penerima" value="{{ old('instansi-penerima') }}" {{ Session::get('bkeluar_id') ? 'disabled' : '' }}>
                                <span class="text-danger error-text instansi_penerima_error"></span>
                            </div>
                            <div class="mt-3">
                                <label for="nama-penerima" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama-penerima" name="nama_penerima" value="{{ old('nama-penerima') }}" {{ Session::get('bkeluar_id') ? 'disabled' : '' }}>
                                <span class="text-danger error-text nama_penerima_error"></span>
                            </div>
                            <div class="mt-3">
                                <label for="nik-penerima" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik-penerima" name="nik_penerima" value="{{ old('nik-penerima') }}" {{ Session::get('bkeluar_id') ? 'disabled' : '' }}>
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
                                    <button class="btn btn-primary w-100" type="submit">Lanjut</button>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header mb-3 d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Barang Keluar</h4>
                    <button class="btn btn-secondary shadow sharp reload-btn"><i class="fa-solid fa-arrows-rotate"></i></button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatables" class="table display w-100">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kebutuhan</th>
                                    <th>Instansi Pemberi</th>
                                    <th>Nama Pemberi</th>
                                    <th>NIK Pemberi</th>
                                    <th>Instansi Penerima</th>
                                    <th>Nama Penerima</th>
                                    <th>NIK Penerima</th>
                                    <th>Tanggal Keluar</th>
                                    <th>Sfp</th>
                                    <th>Patchcord</th>
                                    <th>Modul</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Barang -->
    <input type="hidden" name="jenis_barang" id="jenis_barang">
    <input type="hidden" name="barang_id" id="barang_id">
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-primary setuju-hapus-btn">Ya</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus BKeluar-->
    <input type="hidden" name="bkeluar_id" id="bkeluar_id">
    <div class="modal fade" id="deleteBKeluarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-primary setuju-hapus-bkeluar">Ya</button>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        $(function() {
            var table = $('#datatables').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '/logan/input-data/barang-keluar/jsonBKeluar',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kebutuhan',
                        name: 'kebutuhan'
                    },
                    {
                        data: 'instansi_pemberi',
                        name: 'instansi_pemberi'
                    },
                    {
                        data: 'nama_pemberi',
                        name: 'nama_pemberi'
                    },
                    {
                        data: 'nik_pemberi',
                        name: 'nik_pemberi'
                    },
                    {
                        data: 'instansi_penerima',
                        name: 'instansi_penerima'
                    },
                    {
                        data: 'nama_penerima',
                        name: 'nama_penerima'
                    },
                    {
                        data: 'nik_penerima',
                        name: 'nik_penerima'
                    },
                    {
                        data: 'tanggal_keluar',
                        name: 'tanggal_keluar'
                    },
                    {
                        data: 'sfps_count',
                        name: 'sfps_count'
                    },
                    {
                        data: 'patchcords_count',
                        name: 'patchcords_count'
                    },
                    {
                        data: 'moduls_count',
                        name: 'moduls_count'
                    },
                    {
                        data: 'Aksi',
                        name: 'Aksi',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [8, 'desc']
                ],
                lengthMenu: [
                    [10, 25, 50, 100, 250, 500, -1],
                    [10, 25, 50, 100, 250, 500, 'All'],
                ],
                language: {
                    paginate: {
                        next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                        previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                    }
                }
            });
        });

        $(document).ready(function() {
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
                            $('.bkeluar_form')[0].reset();
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(data.msg);
                            window.location.href = '/input-data/pilih-barang';
                        }
                    }
                });
            });

            $(document).on('click', '.hapus-btn', function() {
                var barang_id = $(this).val();
                var jenis_barang = $(this).data('jenis');
                $('#deleteModal').modal('show');
                $('.modal-title').text('Hapus ' + jenis_barang);
                $('.modal-body').text('Lanjut menghapus barang ini?');
                $('#barang_id').val(barang_id);
                $('#jenis_barang').val(jenis_barang);
            });

            $(document).on('click', '.setuju-hapus-btn', function() {
                event.preventDefault();
                var data = {
                    'jenis_barang': $('#jenis_barang').val(),
                    'barang_id': $('#barang_id').val()
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'PUT',
                    url: '/logan/input-data/hapus-barang',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                            $('#deleteModal').modal('hide');
                        } else {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#deleteModal').modal('hide');
                            $('#hapus-btn-' + data.barang_id).prop('disabled', true);
                        }
                    }
                })
            });

            $(document).on('click', '.delete-bkeluar', function() {
                var bkeluar_id = $(this).val();
                $('#deleteBKeluarModal').modal('show');
                $('.modal-title').text('Hapus Transaksi Barang Keluar');
                $('.modal-body').text('Lanjut menghapus transaksi ini?');
                $('#bkeluar_id').val(bkeluar_id);
            });

            $(document).on('click', '.setuju-hapus-bkeluar', function() {
                event.preventDefault();
                var id = $('#bkeluar_id').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: "/logan/input-data/bkeluar-delete/" + id,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                            $('#deleteBKeluarModal').modal('hide');
                        } else {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#deleteBKeluarModal').modal('hide');
                            $('#tambah-bkeluar-' + id).prop('disabled', true);
                            $('#delete-bkeluar-' + id).prop('disabled', true);
                            $('#edit-bkeluar-' + id).addClass('disabled');
                            $('#detail-bkeluar-' + id).addClass('disabled');
                            $('#cetakpdf-bkeluar-' + id).addClass('disabled');
                        }
                    }
                })
            });

            $(document).on('click', '.reload-btn', function() {
                var table = $('#datatables').DataTable();
                table.ajax.reload();
            });
        });

        window.addEventListener("pageshow", function(event) {
            var historyTraversal = event.persisted || (typeof window.performance != "undefined" &&
                window.performance.navigation.type === 2);
            if (historyTraversal) {
                // Handle page restore.
                window.location.reload();
            }
        });
    </script>
@endsection

@endsection
