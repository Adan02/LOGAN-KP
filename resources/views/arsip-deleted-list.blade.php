@extends('layouts.mainlayout')

@section('title', 'List Deleted Arsip')

@section('content')
<h1>List Deleted Arsip</h1>
<div id="success_message"></div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header mb-3 d-flex justify-content-between align-items-center">
                <h4 class="card-title">Arsip</h4>
                <button class="btn btn-secondary shadow sharp reload-btn"><i class="fa-solid fa-arrows-rotate"></i></button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatables" class="table display w-100">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis</th>
                                <th>Judul</th>
                                <th>Vendor</th>
                                <th>Nomor Arsip</th>
                                <th>Tanggal Arsip</th>
                                <th>Tanggal Hapus</th>
                                <th>File Arsip</th>
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

<!-- Modal Restore -->
<div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Pulihkan Arsip</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="duar">
                <span>Apakah Anda yakin ingin memulihkan data?</span>
                <input type="hidden" id="toRestore_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-primary restore_arsip">Ya</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModal">Hapus Permanen Arsip</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="duar">
                <span>Apakah Anda yakin ingin menghapus permanen data?</span>
                <input type="hidden" id="toDelete_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-primary delete_arsip">Ya</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(function (){
        $('#datatables').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            ajax: '/logan/list-data/arsip/jsonArsipDeleted',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'jenis', name: 'jenis'},
                {data: 'judul', name: 'judul'},
                {data: 'vendor', name: 'vendor'},
                {data: 'nomor_arsip', name: 'nomor_arsip'},
                {data: 'tanggal_arsip', name: 'tanggal_arsip'},
                {data: 'deleted_at', name: 'deleted_at'},
                {data: 'file_arsip', name: 'file_arsip'},
                {data: 'Aksi', name: 'Aksi', orderable: false, searchable: false}
            ],
            order: [[6, 'desc']],
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

    $(document).ready(function () {
            $(document).on('click', '.restore-btn', function () {
                var arsip_id = $(this).val();
                $('#restoreModal').modal('show');
                $('#toRestore_id').val(arsip_id);
            });

            $(document).on('click', '.restore_arsip', function (e) {
                event.preventDefault();
                var id = $('#toRestore_id').val();                

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "GET",
                    url: "/logan/list-data/arsip-restore/" + id,
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                            $('#restoreModal').modal('hide');
                        } else {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#restoreModal').modal('hide');
                            $('#delete-btn-'+id).prop('disabled', true);
                            $('#restore-btn-'+id).prop('disabled', true);
                        }
                    }
                });
            });

            $(document).on('click', '.delete-btn', function () {
                var arsip_id = $(this).val();
                $('#deleteModal').modal('show');
                $('#toDelete_id').val(arsip_id);
            });

            $(document).on('click', '.delete_arsip', function (e) {
                event.preventDefault();
                var id = $('#toDelete_id').val();             

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: "/logan/list-data/arsip-delete-permanent/" + id,
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                            $('#deleteModal').modal('hide');
                        } else {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#deleteModal').modal('hide');
                            $('#delete-btn-'+id).prop('disabled', true);
                            $('#restore-btn-'+id).prop('disabled', true);
                        }
                    }
                });
            });
            
            $(document).on('click', '.reload-btn', function () {
                var table = $('#datatables').DataTable();
                table.ajax.reload();
            });
        });
</script>
@endsection
@endsection