@extends('layouts.mainlayout')

@section('title', 'Dashboard')

@section('content')

<div class="">
    <h1 class="mb-4 fw-semibold">SFP</h1>
    <div class="dashboard row d-flex justify-content-center gap-4 row-gap-2">
        @foreach ($sfpDashboard as $sfp)
        <div class="card info-card col-lg-2 col-md-3 col-sm-4 col-12 bg-danger">
            <div class="card-body">
                <h5 class="card-title">{{$sfp->jenis}} | {{$sfp->bandwidth}} G | {{$sfp->jarak}} KM</h5>
                <div class="d-flex align-items-center">
                    <h6>{{$sfp->count}} pcs</h6>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<hr class="border border-danger border-2 opacity-50">

<div class="row">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="fw-semibold">Patchcord</h1>
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePatchcord"
            aria-expanded="true" aria-controls="collapsePatchcord">
            Detail
        </button>
    </div>
    <div class="col-12 collapse" id="collapsePatchcord">
        <div class="card">
            <div class="card-body pt-4 pb-1">
                <div class="table-responsive">
                    <table class="table display w-100" id="patchcordTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis</th>
                                <th>Konektor</th>
                                <th>Jarak (m)</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patchcordDashboard as $patchcord)
                            <tr>
                                <td></td>
                                <td>{{$patchcord->jenis}}</td>
                                <td>{{$patchcord->konektor}}</td>
                                <td>{{$patchcord->jarak}}</td>
                                <td>{{$patchcord->count}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<hr class="border border-primary border-2 opacity-50">

<div class="row">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="fw-semibold">Modul</h1>
        <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseModul"
            aria-expanded="true" aria-controls="collapseModul">
            Detail
        </button>
    </div>
    <div class="col-12 collapse text-center" id="collapseModul">
        <div class="card">
            <div class="card-body pt-4 pb-1">
                <div class="table-responsive">
                    <table class="table display w-100" id="modulTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Vendor</th>
                                <th>Tipe Board</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modulDashboard as $modul)
                            <tr>
                                <td></td>
                                <td>{{$modul->vendor}}</td>
                                <td>{{$modul->tipe_board}}</td>
                                <td>{{$modul->count}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<hr class="border border-success border-2 opacity-50">

@section('scripts')
    <script>
        $(document).ready(function () {
            $(window).resize(function(){
                $('#patchcordTable').DataTable().columns.adjust();
                $('#modulTable').DataTable().columns.adjust();
            });

            $('#collapsePatchcord').on('shown.bs.collapse', function () {
                $('#patchcordTable').DataTable().columns.adjust();
            });

            $('#collapseModul').on('shown.bs.collapse', function () {
                $('#modulTable').DataTable().columns.adjust();
            });

            var pTable = $('#patchcordTable').DataTable({
                processing: true,
                scrollX: true,            
                columnDefs: [{ 
                    className: "dt-center", 
                    targets: '_all'
                },{ 
                    searchable: false,
                    orderable: false,
                    targets: 0,
                }],
                order: [[1, 'desc']],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'All'],
                ],
                language: {
                    paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>' 
                    }
                },
            });

            var mTable = $('#modulTable').DataTable({
                processing: true,
                scrollX: true,            
                columnDefs: [{ 
                    className: "dt-center", 
                    targets: '_all'
                },{ 
                    searchable: false,
                    orderable: false,
                    targets: 0,
                }],
                order: [[1, 'asc']],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'All'],
                ],
                language: {
                    paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>' 
                    }
                },
            });

            pTable.on('order.dt search.dt', function () {
                let i = 1;
                pTable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                    this.data(i++);
                });
            }).draw();

            mTable.on('order.dt search.dt', function () {
                let i = 1;
                mTable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                    this.data(i++);
                });
            }).draw();
        })

    </script>
@endsection
@endsection