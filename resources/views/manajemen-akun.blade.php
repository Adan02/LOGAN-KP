@extends('layouts.mainlayout')

@section('title', 'Manajemen Akun')

@section('content')

    <div class="col-lg-6 col m-auto mb-3" id="success_message"></div>
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Input Akun Baru</h5>
                    <form action="/manajemen-akun/akun-buat" method="post" class="row g-3 main_form">
                        @csrf
                        <div class="mt-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="name" autocomplete="off">
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="mt-3">
                            <label for="role_id" class="form-label">Role</label>
                            <select name="role_id" id="role_id" class="form-control" autocomplete="off">
                                <option selected disabled value="">Pilih Role</option>
                                <option value="1">Admin</option>
                                <option value="2">Mitra</option>
                            </select>
                            <span class="text-danger error-text role_id_error"></span>
                        </div>
                        <div class="mt-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="username" autocomplete="off">
                            <span class="text-danger error-text username_error"></span>
                        </div>
                        <div class="mt-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" name="password" class="form-control hide-password" id="password" autocomplete="off">
                            <span class="text-danger error-text password_error"></span>
                            <div class="form-check mt-1">
                                <input class="form-check-input" type="checkbox" value="" id="show-password" autocomplete="off">
                                <label class="form-check-label" for="show-password">
                                    Show Password
                                </label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-primary w-100" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-12 m-auto mb-3" id="success_message_list"></div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header mb-3 d-flex justify-content-between align-items-center">
                    <h4 class="card-title">List Akun</h4>
                    <button class="btn btn-secondary shadow sharp reload-btn"><i class="fa-solid fa-arrows-rotate"></i></button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatables" class="table display w-100">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Tanggal Pembuatan</th>
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

    <!-- Modal Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Akun</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="duar">
                    <span>Apakah Anda yakin ingin menghapus akun?</span>
                    <input type="hidden" id="toDelete_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-primary delete_akun">Ya</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <form action="/manajemen-akun/akun-edit" method="post" class="row g-3">
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            @csrf
            @method('PUT')
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Akun</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <input type="hidden" name="akun_id" id="akun_id" autocomplete="off">
                    <div class="modal-body" id="duar">
                        <div>
                            <label for="edit_name" class="form-label">Name</label>
                            <input type="text" name="edit_name" class="form-control" id="edit_name" autocomplete="off">
                            <span class="text-danger error-text edit_name_error"></span>
                        </div>
                        <div class="mt-3">
                            <label for="edit_role_id" class="form-label">Role</label>
                            <select name="edit_role_id" id="edit_role_id" class="form-control" autocomplete="off">
                                <option selected disabled>Pilih Role</option>
                                <option value="1">Admin</option>
                                <option value="2">Mitra</option>
                            </select>
                            <span class="text-danger error-text edit_role_id_error"></span>
                        </div>
                        <div class="mt-3">
                            <label for="edit_username" class="form-label">Username</label>
                            <input type="text" name="edit_username" class="form-control" id="edit_username" autocomplete="off">
                            <span class="text-danger error-text edit_username_error"></span>
                        </div>
                        <div class="mt-3">
                            <label for="edit_password" class="form-label">Password Baru (opsional)</label>
                            <input type="text" name="edit_password" class="form-control hide-password" id="edit_password" autocomplete="off">
                            <span class="text-danger error-text edit_password_error"></span>
                            <div class="form-check mt-1">
                                <input class="form-check-input" type="checkbox" value="" id="edit_show_password" autocomplete="off">
                                <label class="form-check-label" for="edit_show_password">
                                    Show Password
                                </label>
                            </div>
                        </div>
                        <hr class="border border-secondary border-2 opacity-50">
                        <div class="mt-3 text-center">
                            <label for="edit_admin_password" class="form-label">Password Akun <strong>{{auth()->user()->name}}</strong></label>
                            <input type="text" name="edit_admin_password" class="form-control hide-password" id="edit_admin_password" autocomplete="off">
                            <span class="text-danger error-text edit_admin_password_error"></span>
                            <div class="form-check mt-1 d-flex justify-content-center gap-2">
                                <input class="form-check-input" type="checkbox" value="" id="show-admin_password" autocomplete="off">
                                <label class="form-check-label" for="show-admin_password">
                                    Show Password
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button class="btn btn-primary edit_akun" type="submit">Ya</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#datatables').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '/logan/manajemen-akun/jsonAkun',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'role.name',
                        name: 'role.name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'Aksi',
                        name: 'Aksi',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [4, 'asc']
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

            if ($('#password').hasClass('hide-password')) {
                $('#password').on("copy", function(e) {
                    event.preventDefault();
                });
            }

            $('#show-password').on('change', function() {
                if ($('#show-password').prop('checked')) {
                    $('#password').removeClass('hide-password');
                    $('#password').unbind('copy');
                } else {
                    $('#password').addClass('hide-password');
                    $('#password').on("copy", function(e) {
                        event.preventDefault();
                    });
                }
            });

            if ($('#edit_password').hasClass('hide-password')) {
                $('#edit_password').on("copy", function(e) {
                    event.preventDefault();
                });
            }

            $('#edit_show_password').on('change', function() {
                if ($('#edit_show_password').prop('checked')) {
                    $('#edit_password').removeClass('hide-password');
                    $('#edit_password').unbind('copy');
                } else {
                    $('#edit_password').addClass('hide-password');
                    $('#edit_password').on("copy", function(e) {
                        event.preventDefault();
                    });
                }
            });

            if ($('#edit_admin_password').hasClass('hide-password')) {
                $('#edit_admin_password').on("copy", function(e) {
                    event.preventDefault();
                });
            }

            $('#show-admin_password').on('change', function() {
                if ($('#show-admin_password').prop('checked')) {
                    $('#edit_admin_password').removeClass('hide-password');
                    $('#edit_admin_password').unbind('copy');
                } else {
                    $('#edit_admin_password').addClass('hide-password');
                    $('#edit_admin_password').on("copy", function(e) {
                        event.preventDefault();
                    });
                }
            });

            $(document).on('click', '.delete-btn', function() {
                var akun_id = $(this).val();
                $('#deleteModal').modal('show');
                $('#toDelete_id').val(akun_id);
            });

            $(document).on('click', '.delete_akun', function(e) {
                event.preventDefault();
                var id = $('#toDelete_id').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: "/logan/manajemen-akun/akun-delete/" + id,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 404) {
                            $('#success_message_list').addClass('alert alert-danger');
                            $('#success_message_list').text(response.message);
                            $('#deleteModal').modal('hide');
                        } else if (response.status == 201) {
                            window.location.href = '/login';
                        } else {
                            $('#success_message_list').addClass('alert alert-success');
                            $('#success_message_list').text(response.message);
                            $('#deleteModal').modal('hide');
                            $('#delete-btn-' + id).prop('disabled', true);
                            $('#edit-btn-' + id).addClass('disabled');
                        }
                    }
                });
            });

            $(document).on('click', '.edit-btn', function() {
                var data = table.row($(this).parents('tr')).data();
                var akun_id = data.id;
                $('#akun_id').val(akun_id);
                $('#editModal').modal('show');
                $('#edit_name').val(data.name);
                $('#edit_role_id').val(data.role_id);
                $('#edit_username').val(data.username);
                $('#edit_password').val("");
                $('#edit_admin_password').val("");
            });

            $(document).on('click', '.edit_akun', function() {
                event.preventDefault();
                var data = {
                    'akun_id': $('#akun_id').val(),
                    'name': $('#edit_name').val(),
                    'username': $('#edit_username').val(),
                    'role_id': $('#edit_role_id').val(),
                    'password': $('#edit_password').val(),
                    'admin_password': $('#edit_admin_password').val()
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/logan/manajemen-akun/akun-edit',
                    method: 'PUT',
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#success_message_list').removeClass('alert alert-success');
                        $('#success_message_list').text("");
                        $(document).find('span.error-text').text('');
                        $('[class*="error"]').removeClass('error');
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            $.each(data.error, function(prefix, val) {
                                $('span.edit_' + prefix + '_error').text(val[0]);
                                $('[name="edit_' + prefix + '"]').addClass('error');
                            });
                        } else {
                            $('#editModal').modal('hide');
                            $('#success_message_list').addClass('alert alert-success');
                            $('#success_message_list').text(data.msg);
                            $('#edit_show_password').prop('checked', false);
                            $('#edit_password').addClass('hide-password');
                            $('#show-admin_password').prop('checked', false);
                            $('#edit_admin_password').addClass('hide-password');
                            $('#datatables').DataTable().ajax.reload();
                        }
                    }
                });
            });

            $('#editModal').on('show.bs.modal', function(e) {
                $(document).find('span.error-text').text('');
                $('[class*="error"]').removeClass('error');
                $('#edit_show_password').prop('checked', false);
                $('#edit_password').addClass('hide-password');
                $('#show-admin_password').prop('checked', false);
                $('#edit_admin_password').addClass('hide-password');
            })


            $(document).on('click', '.reload-btn', function() {
                $('#datatables').DataTable().ajax.reload();
            });
        });
    </script>
@endsection

@endsection
