@extends('layouts.mainlayout')

@section('title', 'List Deleted Patchcord Masuk')

@section('content')
<h1>List Deleted Patchcord</h1>
<div id="success_message"></div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header mb-3 d-flex justify-content-between align-items-center">
                <h4 class="card-title">Patchcord Masuk</h4>
                <button class="btn btn-secondary shadow sharp reload-btn"><i class="fa-solid fa-arrows-rotate"></i></button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatables" class="table display w-100">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis</th>
                                <th>Konektor</th>
                                <th>Jarak</th>
                                <th>Tipe Kabel</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Hapus</th>
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Pulihkan Patchcord</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="duar">
                <span>Apakah Anda yakin ingin memulihkan data?</span>
                <input type="hidden" id="toRestore_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-primary restore_patchcord">Ya</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModal">Hapus Permanen Patchcord</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="duar">
                <span>Apakah Anda yakin ingin menghapus permanen data?</span>
                <input type="hidden" id="toDelete_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-primary delete_patchcord">Ya</button>
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
            ajax: '/logan/list-data/patchcord-masuk/jsonPatchcordMasukDeleted',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'jenis', name: 'jenis'},
                {data: 'konektor', name: 'konektor'},
                {data: 'jarak', name: 'jarak'},
                {data: 'tipe_kabel', name: 'tipe_kabel'},
                {data: 'tanggal_masuk', name: 'tanggal_masuk'},
                {data: 'deleted_at', name: 'deleted_at'},
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
                var patchcord_id = $(this).val();
                $('#restoreModal').modal('show');
                $('#toRestore_id').val(patchcord_id);
            });

            $(document).on('click', '.restore_patchcord', function (e) {
                event.preventDefault();
                var id = $('#toRestore_id').val();                

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "GET",
                    url: "/logan/list-data/patchcord-restore/" + id,
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
                var patchcord_id = $(this).val();
                $('#deleteModal').modal('show');
                $('#toDelete_id').val(patchcord_id);
            });

            $(document).on('click', '.delete_patchcord', function (e) {
                event.preventDefault();
                var id = $('#toDelete_id').val();             

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: "/logan/list-data/patchcord-delete-permanent/" + id,
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