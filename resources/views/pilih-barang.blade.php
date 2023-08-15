@extends('layouts.mainlayout')

@section('title', 'Pilih Barang Keluar')

@section('content')
    <div id="success_message"></div>
    <h1>Pilih Barang Keluar</h1>
    <div class="d-flex flex-column flex-sm-row justify-content-between gap-1 mb-5">
        <div class="d-flex align-items-center gap-1">
            <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSfp" aria-expanded="true" aria-controls="collapseSfp">
                SFP
            </button>
            <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePatchcord" aria-expanded="true" aria-controls="collapsePatchcord">
                Patchcord
            </button>
            <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseModul" aria-expanded="true" aria-controls="collapseModul">
                Modul
            </button>
        </div>
        <div class="d-flex align-items-center gap-1">
            <a class="btn btn-primary" type="button" href="/logan/input-data/selesai-pilih">Kembali</a>
            <a class="btn btn-primary selesai-btn" type="button" href="javascript:void(0)">Ambil</a>
        </div>
    </div>

    <div class="row collapse" id="collapseSfp">
        <div class="col-12">
            <div class="card">
                <div class="card-header mb-3 d-flex justify-content-between align-items-center">
                    <h4 class="card-title">List Sfp</h4>
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex flex-column">
                            <button id="sfpScanner" class="btn btn-dark"><i class="fa-solid fa-barcode"></i></button>
                            <button id="closeSfp" class="btn btn-danger d-none"><i class="fa-solid fa-xmark"></i></button>
                            <div class="d-inline-block" id="readerSfp"></div>
                        </div>
                        <button class="btn btn-secondary shadow sharp sfp-reload-btn"><i class="fa-solid fa-arrows-rotate"></i></button>
                    </div>
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
                                    <th>Hasil</th>
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

    <div class="row collapse" id="collapsePatchcord">
        <div class="col-12">
            <div class="card">
                <div class="card-header mb-3 d-flex justify-content-between align-items-center">
                    <h4 class="card-title">List Patchcord</h4>
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex flex-column">
                            <button id="patchcordScanner" class="btn btn-dark"><i class="fa-solid fa-barcode"></i></button>
                            <button id="closePatchcord" class="btn btn-danger d-none"><i class="fa-solid fa-xmark"></i></button>
                            <div class="d-inline-block" id="readerPatchcord"></div>
                        </div>
                        <button class="btn btn-secondary shadow sharp patchcord-reload-btn"><i class="fa-solid fa-arrows-rotate"></i></button>
                    </div>
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
                                    <th>Hasil</th>
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

    <div class="row collapse" id="collapseModul">
        <div class="col-12">
            <div class="card">
                <div class="card-header mb-3 d-flex justify-content-between align-items-center">
                    <h4 class="card-title">List Modul</h4>
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex flex-column">
                            <button id="modulScanner" class="btn btn-dark"><i class="fa-solid fa-barcode"></i></button>
                            <button id="closeModul" class="btn btn-danger d-none"><i class="fa-solid fa-xmark"></i></button>
                            <div class="d-inline-block" id="readerModul"></div>
                        </div>
                        <button class="btn btn-secondary shadow sharp modul-reload-btn"><i class="fa-solid fa-arrows-rotate"></i></button>
                    </div>
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
                                    <th>Hasil</th>
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

    <input type="hidden" name="jenis_barang" id="jenis_barang" autocomplete="off">
    <input type="hidden" name="barang_id" id="barang_id" autocomplete="off">
    <input type="hidden" name="idSfp" id="idSfp" autocomplete="off">
    <input type="hidden" name="idPatchcord" id="idPatchcord" autocomplete="off">
    <input type="hidden" name="idModul" id="idModul" autocomplete="off">
    <input type="hidden" name="bkeluar_id" id="bkeluar_id" value="{{ Session::get('bkeluar_id') }}" autocomplete="off">

    <!-- Modal -->
    <div class="modal fade" id="modalSelesai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ambil Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Selesai mengambil barang?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-primary setuju-ambil-btn">Ya</button>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        const scannerSfp = new Html5QrcodeScanner('readerSfp', {
            qrbox: {
                width: 250,
                height: 250,
            },
            fps: 10,
        });

        const scannerPatchcord = new Html5QrcodeScanner('readerPatchcord', {
            qrbox: {
                width: 250,
                height: 250,
            },
            fps: 10,
        });

        const scannerModul = new Html5QrcodeScanner('readerModul', {
            qrbox: {
                width: 250,
                height: 250,
            },
            fps: 10,
        });

        function scanSfp(scannerSfp) {
            scannerSfp.render(successSfp, errorSfp);

            function successSfp(result) {
                let filter = document.getElementById('sfpTable_filter');
                let search = filter.getElementsByTagName('input');
                search[0].value = result;
                search[0].focus();
            }

            function errorSfp(err) {
                // console.error(err);
            }
        }

        function scanPatchcord(scannerPatchcord) {
            scannerPatchcord.render(successPatchcord, errorPatchcord);

            function successPatchcord(result) {
                let filter = document.getElementById('patchcordTable_filter');
                let search = filter.getElementsByTagName('input');
                search[0].value = result;
                search[0].focus();
            }

            function errorPatchcord(err) {
                // console.error(err);
            }
        }

        function scanModul(scannerModul) {
            scannerModul.render(successModul, errorModul);

            function successModul(result) {
                let filter = document.getElementById('modulTable_filter');
                let search = filter.getElementsByTagName('input');
                search[0].value = result;
                search[0].focus();
            }

            function errorModul(err) {
                // console.error(err);
            }
        }

        const ambilSfp = {};
        const ambilPatchcord = {};
        const ambilModul = {};

        $(function() {
            $('#sfpTable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '/logan/input-data/pilih-barang/jsonSfpMasuk',
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
                        data: 'hasil',
                        name: 'hasil',
                        orderable: false,
                        searchable: false
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
                drawCallback: function(settings) {
                    const arrSfp = Object.entries(ambilSfp);

                    for ([key, value] of arrSfp) {
                        $('#batal-sfp-btn-' + key).removeClass('visually-hidden');
                        $('#ambil-sfp-btn-' + key).addClass('visually-hidden');
                        $('#hasil-sfp-btn-' + key).val(value);
                        $('#hasil-sfp-btn-' + key).prop('disabled', true);
                    }
                }
            });

            $('#patchcordTable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '/logan/input-data/pilih-barang/jsonPatchcordMasuk',
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
                        data: 'hasil',
                        name: 'hasil',
                        orderable: false,
                        searchable: false
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
                drawCallback: function(settings) {
                    const arrPatchcord = Object.entries(ambilPatchcord);

                    for ([key, value] of arrPatchcord) {
                        $('#batal-patchcord-btn-' + key).removeClass('visually-hidden');
                        $('#ambil-patchcord-btn-' + key).addClass('visually-hidden');
                        $('#hasil-patchcord-btn-' + key).val(value);
                        $('#hasil-patchcord-btn-' + key).prop('disabled', true);
                    }
                }
            });

            $('#modulTable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '/logan/input-data/pilih-barang/jsonModulMasuk',
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
                        data: 'hasil',
                        name: 'hasil',
                        orderable: false,
                        searchable: false
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
                drawCallback: function(settings) {
                    const arrModul = Object.entries(ambilModul);

                    for ([key, value] of arrModul) {
                        $('#batal-modul-btn-' + key).removeClass('visually-hidden');
                        $('#ambil-modul-btn-' + key).addClass('visually-hidden');
                        $('#hasil-modul-btn-' + key).val(value);
                        $('#hasil-modul-btn-' + key).prop('disabled', true);
                    }
                }
            });
        });

        $(document).ready(function() {
            $(window).resize(function() {
                $('#sfpTable').DataTable().columns.adjust();
                $('#sfpTable').DataTable().ajax.reload();
                $('#patchcordTable').DataTable().columns.adjust();
                $('#patchcordTable').DataTable().ajax.reload();
                $('#modulTable').DataTable().columns.adjust();
                $('#modulTable').DataTable().ajax.reload();
            });

            $('#collapseSfp').on('shown.bs.collapse', function() {
                $('#sfpTable').DataTable().columns.adjust();
            });

            $('#collapsePatchcord').on('shown.bs.collapse', function() {
                $('#patchcordTable').DataTable().columns.adjust();
            });

            $('#collapseModul').on('shown.bs.collapse', function() {
                $('#modulTable').DataTable().columns.adjust();
            });

            $(document).on('click', '#sfpScanner', function() {
                scanSfp(scannerSfp);
                $('#closeSfp').removeClass('d-none');
                $('#sfpScanner').addClass('d-none');
                $('#patchcordScanner').prop('disabled', true);
                $('#modulScanner').prop('disabled', true);
            })

            $(document).on('click', '#closeSfp', function() {
                scannerSfp.clear();
                $('#readerSfp').empty();
                $('#closeSfp').addClass('d-none');
                $('#sfpScanner').removeClass('d-none');
                $('#patchcordScanner').prop('disabled', false);
                $('#modulScanner').prop('disabled', false);
            })

            $(document).on('click', '#patchcordScanner', function() {
                scanPatchcord(scannerPatchcord);
                $('#closePatchcord').removeClass('d-none');
                $('#patchcordScanner').addClass('d-none');
                $('#sfpScanner').prop('disabled', true);
                $('#modulScanner').prop('disabled', true);
            })

            $(document).on('click', '#closePatchcord', function() {
                scannerPatchcord.clear();
                $('#readerPatchcord').empty();
                $('#closePatchcord').addClass('d-none');
                $('#patchcordScanner').removeClass('d-none');
                $('#sfpScanner').prop('disabled', false);
                $('#modulScanner').prop('disabled', false);
            })

            $(document).on('click', '#modulScanner', function() {
                scanModul(scannerModul);
                $('#closeModul').removeClass('d-none');
                $('#modulScanner').addClass('d-none');
                $('#patchcordScanner').prop('disabled', true);
                $('#sfpScanner').prop('disabled', true);
            })

            $(document).on('click', '#closeModul', function() {
                scannerModul.clear();
                $('#readerModul').empty();
                $('#closeModul').addClass('d-none');
                $('#modulScanner').removeClass('d-none');
                $('#patchcordScanner').prop('disabled', false);
                $('#sfpScanner').prop('disabled', false);
            })

            $(document).on('change', '.select-hasil', function() {
                var id = $(this).data('id');
                var jenis_barang = $(this).data('jenis');

                if (jenis_barang === 'sfp') {
                    if (this.value != '-') {
                        var id = $(this).data('id');
                        $('#ambil-sfp-btn-' + id).prop('disabled', false);
                    } else {
                        $('#ambil-sfp-btn-' + id).prop('disabled', true);
                        $('#batal-sfp-btn-' + id).addClass('visually-hidden');
                        $('#ambil-sfp-btn-' + id).removeClass('visually-hidden');
                    }
                } else if (jenis_barang === 'patchcord') {
                    if (this.value != '-') {
                        var id = $(this).data('id');
                        $('#ambil-patchcord-btn-' + id).prop('disabled', false);
                    } else {
                        $('#ambil-patchcord-btn-' + id).prop('disabled', true);
                        $('#batal-patchcord-btn-' + id).addClass('visually-hidden');
                        $('#ambil-patchcord-btn-' + id).removeClass('visually-hidden');
                    }
                } else {
                    if (this.value != '-') {
                        var id = $(this).data('id');
                        $('#ambil-modul-btn-' + id).prop('disabled', false);
                    } else {
                        $('#ambil-modul-btn-' + id).prop('disabled', true);
                        $('#batal-modul-btn-' + id).addClass('visually-hidden');
                        $('#ambil-modul-btn-' + id).removeClass('visually-hidden');
                    }
                }
                // console.log($('#idSfp').val());
                // console.log($('#idPatchcord').val());
                // console.log($('#idModul').val());
            });

            $(document).on('click', '.ambil-btn', function() {
                var barang_id = $(this).val();
                var jenis_barang = $(this).data('jenis');
                if (jenis_barang === 'sfp') {
                    ambilSfp[barang_id] = $('#hasil-sfp-btn-' + barang_id).val();
                    $('#idSfp').val(JSON.stringify(ambilSfp));
                    $('#batal-sfp-btn-' + barang_id).removeClass('visually-hidden');
                    $('#ambil-sfp-btn-' + barang_id).addClass('visually-hidden');
                    $('#hasil-sfp-btn-' + barang_id).prop('disabled', true);
                } else if (jenis_barang === 'patchcord') {
                    ambilPatchcord[barang_id] = $('#hasil-patchcord-btn-' + barang_id).val();
                    $('#idPatchcord').val(JSON.stringify(ambilPatchcord));
                    $('#batal-patchcord-btn-' + barang_id).removeClass('visually-hidden');
                    $('#ambil-patchcord-btn-' + barang_id).addClass('visually-hidden');
                    $('#hasil-patchcord-btn-' + barang_id).prop('disabled', true);
                } else {
                    ambilModul[barang_id] = $('#hasil-modul-btn-' + barang_id).val();
                    $('#idModul').val(JSON.stringify(ambilModul));
                    $('#batal-modul-btn-' + barang_id).removeClass('visually-hidden');
                    $('#ambil-modul-btn-' + barang_id).addClass('visually-hidden');
                    $('#hasil-modul-btn-' + barang_id).prop('disabled', true);
                }
                $('#barang_id').val(barang_id);
                $('#jenis_barang').val(jenis_barang);
                // console.log($('#idSfp').val());
                // console.log($('#idPatchcord').val());
                // console.log($('#idModul').val());
            });

            $(document).on('click', '.batal-btn', function() {
                var barang_id = $(this).val();
                var jenis_barang = $(this).data('jenis');
                if (jenis_barang === 'sfp') {
                    delete ambilSfp[barang_id];
                    $('#idSfp').val(JSON.stringify(ambilSfp));
                    $('#batal-sfp-btn-' + barang_id).addClass('visually-hidden');
                    $('#ambil-sfp-btn-' + barang_id).removeClass('visually-hidden');
                    $('#ambil-sfp-btn-' + barang_id).prop('disabled', false);
                    $('#hasil-sfp-btn-' + barang_id).prop('disabled', false);
                } else if (jenis_barang === 'patchcord') {
                    delete ambilPatchcord[barang_id];
                    $('#idPatchcord').val(JSON.stringify(ambilPatchcord));
                    $('#batal-patchcord-btn-' + barang_id).toggleClass('visually-hidden');
                    $('#ambil-patchcord-btn-' + barang_id).toggleClass('visually-hidden');
                    $('#ambil-patchcord-btn-' + barang_id).prop('disabled', false);
                    $('#hasil-patchcord-btn-' + barang_id).prop('disabled', false);
                } else {
                    delete ambilModul[barang_id];
                    $('#idModul').val(JSON.stringify(ambilModul));
                    $('#batal-modul-btn-' + barang_id).toggleClass('visually-hidden');
                    $('#ambil-modul-btn-' + barang_id).toggleClass('visually-hidden');
                    $('#ambil-modul-btn-' + barang_id).prop('disabled', false);
                    $('#hasil-modul-btn-' + barang_id).prop('disabled', false);
                }
                // console.log($('#idSfp').val());
                // console.log($('#idPatchcord').val());
                // console.log($('#idModul').val());
            });

            $(document).on('click', '.selesai-btn', function() {
                $('#modalSelesai').modal('show');
            });

            $(document).on('click', '.setuju-ambil-btn', function() {
                event.preventDefault();
                var data = {
                    'idSfp': $('#idSfp').val(),
                    'idPatchcord': $('#idPatchcord').val(),
                    'idModul': $('#idModul').val(),
                    'bkeluar_id': $('#bkeluar_id').val()
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'PUT',
                    url: '/logan/input-data/ambil-barang',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                            $('#modalSelesai').modal('hide');
                        } else {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#modalSelesai').modal('hide');
                            $('#ambil-btn-' + data.barang_id).prop('disabled', true);
                            window.location.href = '/input-data/barang-keluar';
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
