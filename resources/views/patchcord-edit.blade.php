@extends('layouts.mainlayout')

@section('title', 'Edit Patchcord')

@section('content')

    <div class="col-lg-6 col m-auto mb-3" id="success_message"></div>
    <div class="row h-100">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Patchcord {{ $patchcord->bkeluar_id ? 'Keluar' : 'Masuk' }}</h5>
                    <form action="{{ $patchcord->id }}" method="post" class="row g-3 main_form">
                        @csrf
                        @method('PUT')
                        <div class="mt-3">
                            <label for="jenis" class="form-label">Jenis</label>
                            <select name="jenis" id="jenis" class="form-control" value="{{ $patchcord->jenis }}">
                                <option selected disabled>Pilih Jenis</option>
                                <option value="Single Mode" {{ $patchcord->jenis === 'Single Mode' ? 'selected' : '' }}>Single Mode</option>
                                <option value="Multimode" {{ $patchcord->jenis === 'Multimode' ? 'selected' : '' }}>Multimode</option>
                            </select>
                            <span class="text-danger error-text jenis_error"></span>
                        </div>
                        <div class="mt-3">
                            <label for="konektor" class="form-label">Konektor</label>
                            <select name="konektor" id="konektor" class="form-control" value="{{ $patchcord->konektor }}">
                                <option selected disabled>Pilih Konektor</option>
                                <option value="FC-FC" {{ $patchcord->konektor === 'FC-FC' ? 'selected' : '' }}>FC-FC</option>
                                <option value="FC-LC" {{ $patchcord->konektor === 'FC-LC' ? 'selected' : '' }}>FC-LC</option>
                                <option value="FC-SC" {{ $patchcord->konektor === 'FC-SC' ? 'selected' : '' }}>FC-SC</option>
                                <option value="LC-FC" {{ $patchcord->konektor === 'LC-FC' ? 'selected' : '' }}>LC-FC</option>
                                <option value="LC-LC" {{ $patchcord->konektor === 'LC-LC' ? 'selected' : '' }}>LC-LC</option>
                                <option value="LC-SC" {{ $patchcord->konektor === 'LC-SC' ? 'selected' : '' }}>LC-SC</option>
                                <option value="SC-FC" {{ $patchcord->konektor === 'SC-FC' ? 'selected' : '' }}>SC-FC</option>
                                <option value="SC-LC" {{ $patchcord->konektor === 'SC-LC' ? 'selected' : '' }}>SC-LC</option>
                                <option value="SC-SC" {{ $patchcord->konektor === 'SC-SC' ? 'selected' : '' }}>SC-SC</option>
                            </select>
                            <span class="text-danger error-text konektor_error"></span>
                        </div>
                        <div class="mt-3">
                            <label for="jarak" class="form-label">Jarak (m)</label>
                            <input type="number" class="form-control" id="jarak" name="jarak" value="{{ $patchcord->jarak }}">
                            <span class="text-danger error-text jarak_error"></span>
                        </div>
                        <div class="mt-3">
                            <label for="tipe-kabel" class="form-label">Tipe Kabel</label>
                            <select name="tipe_kabel" id="tipe-kabel" class="form-control" value="{{ $patchcord->tipe_kabel }}">
                                <option selected disabled>Pilih Tipe Kabel</option>
                                <option value="Simplex" {{ $patchcord->tipe_kabel === 'Simplex' ? 'selected' : '' }}>Simplex</option>
                                <option value="Duplex" {{ $patchcord->tipe_kabel === 'Duplex' ? 'selected' : '' }}>Duplex</option>
                            </select>
                            <span class="text-danger error-text tipe_kabel_error"></span>
                        </div>
                        <div class="mt-3">
                            <label for="serial-number" class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="serial-number" name="serial_number" value="{{ $patchcord->serial_number }}">
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
    </script>
@endsection

@endsection
