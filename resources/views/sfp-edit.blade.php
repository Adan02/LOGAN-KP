@extends('layouts.mainlayout')

@section('title', 'Edit Sfp')

@section('content')

    <div class="col-lg-6 col m-auto mb-3" id="success_message"></div>
    <div class="row h-100">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Sfp {{ $sfp->bkeluar_id ? 'Keluar' : 'Masuk' }}</h5>
                    <form action="{{ $sfp->id }}" method="post" class="row g-3 main_form">
                        @csrf
                        @method('PUT')
                        <div class="mt-3">
                            <label for="jenis" class="form-label">Jenis</label>
                            <select name="jenis" id="jenis" class="form-control" value="{{ $sfp->jenis }}">
                                <option selected disabled>Pilih Jenis</option>
                                <option value="SFP" {{ $sfp->jenis === 'SFP' ? 'selected' : '' }}>SFP</option>
                                <option value="SFP+" {{ $sfp->jenis === 'SFP+' ? 'selected' : '' }}>SFP+</option>
                                <option value="XFP" {{ $sfp->jenis === 'XFP' ? 'selected' : '' }}>XFP</option>
                                <option value="QSFP" {{ $sfp->jenis === 'QSFP' ? 'selected' : '' }}>QSFP</option>
                            </select>
                            <span class="text-danger error-text jenis_error"></span>
                        </div>
                        <div class="mt-3">
                            <label for="vendor" class="form-label">Vendor</label>
                            <input type="text" class="form-control" id="vendor" name="vendor" value="{{ $sfp->vendor }}" style="text-transform:uppercase">
                            <span class="text-danger error-text vendor_error"></span>
                        </div>
                        <div class="mt-3">
                            <label for="bandwidth" class="form-label">Bandwidth (G)</label>
                            <input type="text" class="form-control" id="bandwidth" name="bandwidth" readonly value={{ $sfp->bandwidth ? "$sfp->bandwidth" : "" }}>
                            <span class="text-danger error-text bandwidth_error"></span>
                        </div>
                        <div class="mt-3">
                            <label for="lambda" class="form-label">Lambda (nm)</label>
                            <input type="text" class="form-control" id="lambda" name="lambda" readonly value={{ $sfp->lambda ? "$sfp->lambda" : "" }}>
                            <span class="text-danger error-text lambda_error"></span>
                        </div>
                        <div class="mt-3">
                            <label for="jarak" class="form-label">Jarak (KM)</label>
                            <select name="jarak" id="jarak" class="form-control" value="{{ $sfp->jarak }}">
                                <option selected disabled>Pilih Jarak</option>
                                <option value="10" {{ $sfp->jarak == '10' ? 'selected' : '' }}>10</option>
                                <option value="40" {{ $sfp->jarak == '40' ? 'selected' : '' }}>40</option>
                                <option value="80" {{ $sfp->jarak == '80' ? 'selected' : '' }}>80</option>
                            </select>
                            <span class="text-danger error-text jarak_error"></span>
                        </div>
                        <div class="mt-3">
                            <label for="serial-number" class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="serial-number" name="serial_number" value="{{ $sfp->serial_number }}">
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
            $('#jenis').on('change', function() {
                if (this.value === 'SFP') {
                    $('#bandwidth').val('1');
                } else if (this.value === 'SFP+' || this.value === 'XFP') {
                    $('#bandwidth').val('10');
                } else if (this.value === 'QSFP') {
                    $('#bandwidth').val('100');
                }
            })
            $('#jarak').on('change', function() {
                if (this.value === '10') {
                    $('#lambda').val(1310);
                } else if (this.value === '40' || this.value === '80') {
                    $('#lambda').val(1550);
                }
            })
        })
    </script>
@endsection

@endsection
