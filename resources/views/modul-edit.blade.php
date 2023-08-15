@extends('layouts.mainlayout')

@section('title', 'Edti Modul')

@section('content')

    <div class="col-lg-6 col m-auto mb-3" id="success_message"></div>
    <div class="row h-100">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Input Modul {{ $modul->bkeluar_id ? 'Keluar' : 'Masuk' }}</h5>
                    <form action="{{ $modul->id }}" method="post" class="row g-3 main_form">
                        @csrf
                        @method('PUT')
                        <div class="mt-3">
                            <label for="vendor" class="form-label">Vendor</label>
                            <input type="text" class="form-control" id="vendor" name="vendor" value="{{ $modul->vendor }}" style="text-transform:uppercase">
                            <span class="text-danger error-text vendor_error"></span>
                        </div>
                        <div class="mt-3">
                            <label for="tipe-board" class="form-label">Tipe Board</label>
                            <input type="text" class="form-control" id="tipe-board" name="tipe_board" value="{{ $modul->tipe_board }}">
                            <span class="text-danger error-text tipe_board_error"></span>
                        </div>
                        <div class="mt-3">
                            <label for="serial-number" class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="serial-number" name="serial_number" value="{{ $modul->serial_number }}">
                            <span class="text-danger error-text serial_number_error"></span>
                            <div class="col-12 text-center mt-3">
                                <div class="d-inline-block" id="reader"></div>
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

@section('scripts')
    <script>
        const scanner = new Html5QrcodeScanner('reader', {
            // Scanner will be initialized in DOM inside element with id of 'reader'
            qrbox: {
                width: 250,
                height: 250,
            }, // Sets dimensions of scanning box (set relative to reader element width)
            fps: 10, // Frames per second to attempt a scan
        });


        scanner.render(success, error);
        // Starts scanner

        function success(result) {
            document.getElementById('serial-number').value = result;
            // Prints result as a link inside result element

            // scanner.render(success, error);
            // scanner.clear();
            // Clears scanning instance

            // document.getElementById('reader').remove();
            // Removes reader element from DOM since no longer needed
        }

        function error(err) {
            // console.error(err);
            // Prints any errors to the console
        }

        $(document).ready(function() {
            $('#vendor').keyup(function() {
                $(this).val($(this).val().toUpperCase());
            });
        })
    </script>
@endsection

@endsection
