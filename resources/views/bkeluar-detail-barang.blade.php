@extends('layouts.mainlayout')

@section('title', 'Detail Transaksi Barang Keluar')

@section('content')

    <div id="success_message"></div>
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1>Detail Barang Keluar</h1>
        <a class="btn btn-primary" type="button" href="/logan/input-data/selesai-pilih"><i class="fa-solid fa-left-long"></i></a>
    </div>

    <div class="row" id="collapseSfp">
        <div class="col-12">
            <div class="card">
                <div class="card-header mb-3 d-flex justify-content-between align-items-center">
                    <h4 class="card-title">List Sfp</h4>
                    <button class="btn btn-secondary shadow sharp sfp-reload-btn"><i class="fa-solid fa-arrows-rotate"></i></button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="sfpTable" class="table display w-100">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Jenis</th>
                                    <th>Vendor</th>
                                    <th>Bandwidth</th>
                                    <th>Lambda</th>
                                    <th>Jarak</th>
                                    <th>Serial Number</th>
                                    <th>Tanggal Masuk</th>
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

    <div class="row" id="collapsePatchcord">
        <div class="col-12">
            <div class="card">
                <div class="card-header mb-3 d-flex justify-content-between align-items-center">
                    <h4 class="card-title">List Patchcord</h4>
                    <button class="btn btn-secondary shadow sharp patchcord-reload-btn"><i class="fa-solid fa-arrows-rotate"></i></button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="patchcordTable" class="table display w-100">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Jenis</th>
                                    <th>Konektor</th>
                                    <th>Jarak</th>
                                    <th>Tipe Kabel</th>
                                    <th>Tanggal Masuk</th>
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

    <div class="row" id="collapseModul">
        <div class="col-12">
            <div class="card">
                <div class="card-header mb-3 d-flex justify-content-between align-items-center">
                    <h4 class="card-title">List Modul</h4>
                    <button class="btn btn-secondary shadow sharp modul-reload-btn"><i class="fa-solid fa-arrows-rotate"></i></button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="modulTable" class="table display w-100">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Vendor</th>
                                    <th>Tipe Board</th>
                                    <th>Serial Number</th>
                                    <th>Tanggal Masuk</th>
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

@section('scripts')
    <script>
        $(function() {
            $('#sfpTable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '/logan/input-data/detail-barang/jsonSfpHapus',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'jenis',
                        name: 'jenis'
                    },
                    {
                        data: 'vendor',
                        name: 'vendor'
                    },
                    {
                        data: 'bandwidth',
                        name: 'bandwidth'
                    },
                    {
                        data: 'lambda',
                        name: 'lambda'
                    },
                    {
                        data: 'jarak',
                        name: 'jarak'
                    },
                    {
                        data: 'serial_number',
                        name: 'serial_number'
                    },
                    {
                        data: 'tanggal_masuk',
                        name: 'tanggal_masuk'
                    },
                    {
                        data: 'Aksi',
                        name: 'Aksi',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [7, 'desc']
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
                },
            });

            $('#patchcordTable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '/logan/input-data/detail-barang/jsonPatchcordHapus',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'jenis',
                        name: 'jenis'
                    },
                    {
                        data: 'konektor',
                        name: 'konektor'
                    },
                    {
                        data: 'jarak',
                        name: 'jarak'
                    },
                    {
                        data: 'tipe_kabel',
                        name: 'tipe_kabel'
                    },
                    {
                        data: 'tanggal_masuk',
                        name: 'tanggal_masuk'
                    },
                    {
                        data: 'Aksi',
                        name: 'Aksi',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [5, 'desc']
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
                },
            });

            $('#modulTable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '/logan/input-data/detail-barang/jsonModulHapus',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'vendor',
                        name: 'vendor'
                    },
                    {
                        data: 'tipe_board',
                        name: 'tipe_board'
                    },
                    {
                        data: 'serial_number',
                        name: 'serial_number'
                    },
                    {
                        data: 'tanggal_masuk',
                        name: 'tanggal_masuk'
                    },
                    {
                        data: 'Aksi',
                        name: 'Aksi',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [4, 'desc']
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
                },
            });
        });

        $(document).ready(function() {
            $(window).resize(function(){
                $('#sfpTable').DataTable().columns.adjust();
                $('#sfpTable').DataTable().ajax.reload();
                $('#patchcordTable').DataTable().columns.adjust();
                $('#patchcordTable').DataTable().ajax.reload();
                $('#modulTable').DataTable().columns.adjust();
                $('#modulTable').DataTable().ajax.reload();
            });

            $(document).on('click', '.hapus-btn', function() {
                var barang_id = $(this).val();
                var jenis_barang = $(this).data('jenis');
                $('#deleteModal').modal('show');
                $('.modal-title').text('Hapus ' + jenis_barang);
                $('.modal-body').text('Lanjut membatalkan pengambilan barang ini?');
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
                    url: '/logan/input-data/bkeluar-hapus-barang',
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

            $(document).on('click', '.sfp-reload-btn', function() {
                var table = $('#sfpTable').DataTable();
                table.ajax.reload();
            });

            $(document).on('click', '.patchcord-reload-btn', function() {
                var table = $('#patchcordTable').DataTable();
                table.ajax.reload();
            });

            $(document).on('click', '.modul-reload-btn', function() {
                var table = $('#modulTable').DataTable();
                table.ajax.reload();
            });
        });
    </script>
@endsection

@endsection
