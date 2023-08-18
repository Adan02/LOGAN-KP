<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sfp;
use App\generatePDF;
use App\Models\Modul;
use App\Models\BKeluar;
use App\Models\Patchcord;
use Codedge\Fpdf\Fpdf\Fpdf;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BKeluarController extends Controller
{
    public function show()
    {
        return view('barang-keluar');
    }

    public function jsonBKeluar()
    {
        return DataTables::of(BKeluar::with(['sfps', 'patchcords', 'moduls'])->withCount(['sfps', 'patchcords', 'moduls']))
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                if (Session::get('bkeluar_id') == $row->id) {
                    return '<div class="d-flex flex-column gap-1">
                    <div class="d-flex flex-row gap-1"><a href="bkeluar-edit/' . $row->id . '" id="edit-bkeluar-' . $row->id . '" type="button" class="btn btn-primary shadow sharp disabled"><i class="fa fa-pencil"></i></a> <form action="bkeluar-tambah" method="post" class="d-inline"><input type="hidden" name="_token" value="' . Session::token() . '" /><input type="hidden" name="bkeluar_id" value="' . $row->id . '"><button id="tambah-bkeluar-' . $row->id . '" class="btn btn-success shadow sharp" type="submit" disabled><i class="fa-solid fa-plus"></i></button></form> <button id="delete-bkeluar-' . $row->id . '" type="button" value="' . $row->id . '" class="btn btn-danger delete-bkeluar" disabled><i class="fa fa-trash"></i></button></div>
                    <div class="d-flex flex-row gap-1"><a href="bkeluar-cetakpdf/' . $row->id . '" id="cetakpdf-bkeluar-' . $row->id . '" type="button" class="btn btn-secondary shadow sharp disabled" target="_blank"><i class="fa-solid fa-print"></i></a> <a href="bkeluar-detail-barang/' . $row->id . '" id="detail-bkeluar-' . $row->id . '" type="button" class="btn btn-dark shadow sharp disabled"><i class="fa-solid fa-print"></i></a></div>
                    </div>';
                } else {
                    return '<div class="d-flex flex-column gap-1">
                    <div class="d-flex flex-row gap-1"><a href="bkeluar-edit/' . $row->id . '" id="edit-bkeluar-' . $row->id . '" type="button" class="btn btn-primary shadow sharp"><i class="fa fa-pencil"></i></a> <form action="bkeluar-tambah" method="post" class="d-inline"><input type="hidden" name="_token" value="' . Session::token() . '" /><input type="hidden" name="bkeluar_id" value="' . $row->id . '"><button id="tambah-bkeluar-' . $row->id . '" class="btn btn-success shadow sharp" type="submit"><i class="fa-solid fa-plus"></i></button></form> <button id="delete-bkeluar-' . $row->id . '" type="button" value="' . $row->id . '" class="btn btn-danger delete-bkeluar"><i class="fa fa-trash"></i></button></div>
                    <div class="d-flex flex-row gap-1"><a href="bkeluar-cetakpdf/' . $row->id . '" id="cetakpdf-bkeluar-' . $row->id . '" type="button" class="btn btn-secondary shadow sharp" target="_blank" data-bs-toggle="tooltip" data-bs-title="Default tooltip"><i class="fa-solid fa-print"></i></a> <a href="bkeluar-detail-barang/' . $row->id . '" id="detail-bkeluar-' . $row->id . '" type="button" class="btn btn-dark shadow sharp"><i class="fa-solid fa-receipt"></i></a></div> 
                    </div>';
                }
            })
            ->rawColumns(['Aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kebutuhan' => 'required',
            'instansi_pemberi' => 'required',
            'nama_pemberi' => 'required|max:100',
            'nik_pemberi' => 'required',
            'instansi_penerima' => 'required',
            'nama_penerima' => 'required|max:100',
            'nik_penerima' => 'required',
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $request['tanggal_keluar'] = Carbon::now();
            $bkeluar = BKeluar::create($request->all());
            Session::put('bkeluar_id', $bkeluar->id);

            if ($bkeluar) {
                return response()->json(['status' => 1, 'msg' => 'Berhasil menambahkan transaksi barang keluar ' . $bkeluar->instansi_penerima . '_' . $bkeluar->nama_penerima . '_' . $bkeluar->nik_penerima . '_' . $bkeluar->kebutuhan]);
            }
        }
    }

    public function pilihBarang()
    {
        return view('pilih-barang');
    }

    public function selesaiPilih()
    {
        Session::put('bkeluar_id', null);
        return redirect('logan/input-data/barang-keluar');
    }

    public function ambilBarang(Request $request)
    {
        $arrSfp = json_decode($request->idSfp, true);
        $arrPatchcord = json_decode($request->idPatchcord, true);
        $arrModul = json_decode($request->idModul, true);
        $success = false;

        if ($arrSfp) {
            $sfp = Sfp::whereIn("id", array_keys($arrSfp))->get();
            foreach ($sfp as $item) {
                $item->update([
                    'bkeluar_id' => $request->bkeluar_id,
                    'hasil' => $arrSfp[$item->id],
                ]);
            }
            $success = true;
        }
        if ($arrPatchcord) {
            $patchcord = Patchcord::whereIn("id", array_keys($arrPatchcord))->get();
            foreach ($patchcord as $item) {
                $item->update([
                    'bkeluar_id' => $request->bkeluar_id,
                    'hasil' => $arrPatchcord[$item->id],
                ]);
            }
            $success = true;
        }
        if ($arrModul) {
            $modul = Modul::whereIn("id", array_keys($arrModul))->get();
            foreach ($modul as $item) {
                $item->update([
                    'bkeluar_id' => $request->bkeluar_id,
                    'hasil' => $arrModul[$item->id],
                ]);
            }
            $success = true;
        }

        if ($success) {
            Session::flash('status', 'success');
            Session::flash('message', 'ambil barang sukses!');
            Session::put('bkeluar_id', null);
            return response()->json([
                'status' => 200,
                'message' => 'Pengambilan barang berhasil'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Pengambilan gagal. Tidak ada barang yang dipilih.'
            ]);
        }
    }

    public function hapusBarang(Request $request)
    {
        if ($request->jenis_barang === 'sfp') {
            $sfp = Sfp::findOrFail($request->barang_id);
            $sfp->update([
                'bkeluar_id' => null,
                'hasil' => null,
            ]);
            if ($sfp) {
                Session::flash('status', 'success');
                Session::flash('message', 'hapus sfp sukses!');
                return response()->json([
                    'status' => 200,
                    'message' => 'Pembatalan' . $request->jenis_barang . ' ' . $sfp->jenis . '_' . $sfp->vendor . '_' . $sfp->bandwidth . '_' . $sfp->jarak . '_' . $sfp->serial_number . ' berhasil'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Gagal Membatalkan. Barang tidak tersedia.'
                ]);
            }
        } elseif ($request->jenis_barang === 'patchcord') {
            $patchcord = Patchcord::findOrFail($request->barang_id);
            $patchcord->update([
                'bkeluar_id' => null,
                'hasil' => null,
            ]);
            if ($patchcord) {
                Session::flash('status', 'success');
                Session::flash('message', 'hapus patchcord sukses!');
                return response()->json([
                    'status' => 200,
                    'message' => 'Pembatalan ' . $request->jenis_barang . ' ' . $patchcord->jenis . '_' . $patchcord->konektor . '_' . $patchcord->jarak . '_' . $patchcord->tipe_kabel . ' berhasil'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Gagal Membatalkan. Barang tidak tersedia.'
                ]);
            }
        } else {
            $modul = Modul::findOrFail($request->barang_id);
            $modul->update([
                'bkeluar_id' => null,
                'hasil' => null,
            ]);
            if ($modul) {
                Session::flash('status', 'success');
                Session::flash('message', 'ambil modul sukses!');
                return response()->json([
                    'status' => 200,
                    'message' => 'Pembatalan ' . $request->jenis_barang . ' ' . $modul->vendor . '_' . $modul->tipe_board . '_' . $modul->serial_number . ' berhasil'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Gagal Membatalkan. Barang tidak tersedia.'
                ]);
            }
        }
    }

    public function edit($id)
    {
        $bkeluar = BKeluar::findOrFail($id);
        return view('bkeluar-edit', ['bkeluar' => $bkeluar]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kebutuhan' => 'required',
            'instansi_pemberi' => 'required',
            'nama_pemberi' => 'required|max:100',
            'nik_pemberi' => 'required',
            'instansi_penerima' => 'required',
            'nama_penerima' => 'required|max:100',
            'nik_penerima' => 'required',
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $bkeluar = BKeluar::findOrFail($id);
            $bkeluar->update($request->all());

            if ($bkeluar) {
                return response()->json(['status' => 1, 'msg' => 'Berhasil mengedit transaksi barang keluar ' . $bkeluar->instansi_penerima . '_' . $bkeluar->nama_penerima . '_' . $bkeluar->nik_penerima . '_' . $bkeluar->kebutuhan]);
            }
        }
    }

    public function tambah(Request $request)
    {
        Session::put('bkeluar_id', $request->bkeluar_id);
        return redirect('logan/input-data/pilih-barang');
    }

    public function detailBarang($id)
    {
        Session::put('bkeluar_id', $id);
        return view('bkeluar-detail-barang', compact('id'));
    }

    public function cetakPdf($id)
    {
        $bkeluar = BKeluar::findOrFail($id);
        $sfp = Sfp::where('bkeluar_id', '=', $id)->orderBy('jenis', 'ASC')->get();
        $patchcord = Patchcord::where('bkeluar_id', '=', $id)->orderBy('jenis', 'DESC')->get();
        $modul = Modul::where('bkeluar_id', '=', $id)->orderBy('vendor', 'ASC')->get();

        $buatpdf = new generatePDF();

        $buatpdf->AliasNbPages();
        $buatpdf->AddPage();
        $buatpdf->Cell(50);
        $buatpdf->Cell(30, 10, 'BERITA ACARA KELUAR MASUK BARANG', 'C');
        $buatpdf->SetLineWidth(1);
        $buatpdf->Line(61, 41, 149, 41);
        $buatpdf->SetLineWidth(0.3);
        $buatpdf->Ln(15);
        $buatpdf->SetFont('Arial', '', 11);
        $buatpdf->Cell(15);
        $buatpdf->Cell(0, 9, 'Kebutuhan        : ' . $bkeluar->kebutuhan);
        $buatpdf->Ln(7);
        $buatpdf->Cell(15);
        $buatpdf->Cell(0, 9, 'Dari                   : ' . $bkeluar->instansi_pemberi);
        $buatpdf->Ln(7);
        $buatpdf->Cell(15);
        $buatpdf->Cell(0, 9, 'Kepada             : ' . $bkeluar->instansi_penerima);
        $buatpdf->Ln(7);
        $buatpdf->Cell(15);

        //Tabel
        $buatpdf->Ln(5);
        $buatpdf->Cell(10);
        $buatpdf->cell(15, 9, 'Perangkat yang dimaksud dengan rincian sebagai berikut :');

        if ($sfp->isNotEmpty()) {
            $buatpdf->Ln(8);
            $buatpdf->Cell(11);
            $buatpdf->SetFont('Arial', 'B', 10);
            $buatpdf->SetFillColor(245, 236, 220);
            $buatpdf->Cell(170, 9, 'SFP', 1, 0, 'C', true);
            $buatpdf->Ln(9);
            $buatpdf->Cell(11);
            $buatpdf->SetFont('Arial', 'B', 7);
            $buatpdf->SetFillColor(245, 236, 220);
            $buatpdf->Cell(10, 9, 'No', 1, 0, 'C', true);
            $buatpdf->Cell(20, 9, 'Jenis', 1, 0, 'C', true);
            $buatpdf->Cell(25, 9, 'Vendor', 1, 0, 'C', true);
            $buatpdf->Cell(20, 9, 'Bandwidth(G)', 1, 0, 'C', true);
            $buatpdf->Cell(20, 9, 'Lambda(nm)', 1, 0, 'C', true);
            $buatpdf->Cell(20, 9, 'Jarak (KM)', 1, 0, 'C', true);
            $buatpdf->Cell(30, 9, 'Serial Number', 1, 0, 'C', true);
            $buatpdf->Cell(25, 9, 'Hasil', 1, 0, 'C', true);
            $j = 1;
            foreach ($sfp as $key) {
                $buatpdf->SetFont('Arial', '', 7);
                $buatpdf->Ln(9);
                $buatpdf->Cell(11);
                $buatpdf->Cell(10, 9, '' . $j++ . '', 1, 0, 'C');
                $buatpdf->Cell(20, 9, '' . $key->jenis, 1, 0, 'C');
                $buatpdf->Cell(25, 9, '' . $key->vendor, 1, 0, 'C');
                $buatpdf->Cell(20, 9, '' . $key->bandwidth, 1, 0, 'C');
                $buatpdf->Cell(20, 9, '' . $key->lambda, 1, 0, 'C');
                $buatpdf->Cell(20, 9, '' . $key->jarak, 1, 0, 'C');
                $buatpdf->Cell(30, 9, '' . $key->serial_number, 1, 0, 'C');
                $buatpdf->Cell(25, 9, '' . $key->hasil . '', 1, 0, 'C');
            }
            $buatpdf->Ln(7);
        }

        if ($patchcord->isNotEmpty()) {
            $buatpdf->Ln(8);
            $buatpdf->Cell(11);
            $buatpdf->SetFont('Arial', 'B', 10);
            $buatpdf->SetFillColor(245, 236, 220);
            $buatpdf->Cell(170, 9, 'PATCHCORD', 1, 0, 'C', true);
            $buatpdf->Ln(9);
            $buatpdf->Cell(11);
            $buatpdf->SetFont('Arial', 'B', 7);
            $buatpdf->SetFillColor(245, 236, 220);
            $buatpdf->Cell(10, 9, 'No', 1, 0, 'C', true);
            $buatpdf->Cell(24, 9, 'Jenis', 1, 0, 'C', true);
            $buatpdf->Cell(24, 9, 'Konektor', 1, 0, 'C', true);
            $buatpdf->Cell(23, 9, 'Jarak(M)', 1, 0, 'C', true);
            $buatpdf->Cell(24, 9, 'Tipe Kabel', 1, 0, 'C', true);
            $buatpdf->Cell(35, 9, 'Serial Number', 1, 0, 'C', true);
            $buatpdf->Cell(30, 9, 'Hasil', 1, 0, 'C', true);
            $i = 1;
            foreach ($patchcord as $key) {
                $buatpdf->SetFont('Arial', '', 7);
                $buatpdf->Ln(9);
                $buatpdf->Cell(11);
                $buatpdf->Cell(10, 9, '' . $i++ . '', 1, 0, 'C');
                $buatpdf->Cell(24, 9, '' . $key->jenis, 1, 0, 'C');
                $buatpdf->Cell(24, 9, '' . $key->konektor, 1, 0, 'C');
                $buatpdf->Cell(23, 9, '' . $key->jarak, 1, 0, 'C');
                $buatpdf->Cell(24, 9, '' . $key->tipe_kabel, 1, 0, 'C');
                $buatpdf->Cell(35, 9, '' . $key->serial_number, 1, 0, 'C');
                $buatpdf->Cell(30, 9, '' . $key->hasil . '', 1, 0, 'C');
            }
            $buatpdf->Ln(7);
        }

        if ($modul->isNotEmpty()) {
            $buatpdf->Ln(8);
            $buatpdf->Cell(11);
            $buatpdf->SetFont('Arial', 'B', 10);
            $buatpdf->SetFillColor(245, 236, 220);
            $buatpdf->Cell(170, 9, 'MODUL', 1, 0, 'C', true);
            $buatpdf->Ln(9);
            $buatpdf->Cell(11);
            $buatpdf->SetFont('Arial', 'B', 7);
            $buatpdf->SetFillColor(245, 236, 220);
            $buatpdf->Cell(10, 9, 'No', 1, 0, 'C', true);
            $buatpdf->Cell(40, 9, 'Vendor', 1, 0, 'C', true);
            $buatpdf->Cell(35, 9, 'Tipe Board', 1, 0, 'C', true);
            $buatpdf->Cell(45, 9, 'Serial Number', 1, 0, 'C', true);
            $buatpdf->Cell(40, 9, 'Hasil', 1, 0, 'C', true);
            $k = 1;
            foreach ($modul as $key) {
                $buatpdf->SetFont('Arial', '', 7);
                $buatpdf->Ln(9);
                $buatpdf->Cell(11);
                $buatpdf->Cell(10, 9, '' . $k++ . '', 1, 0, 'C');
                $buatpdf->Cell(40, 9, '' . $key->vendor, 1, 0, 'C');
                $buatpdf->Cell(35, 9, '' . $key->tipe_board, 1, 0, 'C');
                $buatpdf->Cell(45, 9, '' . $key->serial_number, 1, 0, 'C');
                $buatpdf->Cell(40, 9, '' . $key->hasil . '', 1, 0, 'C');
            }
        }

        $buatpdf->Ln(10);
        $buatpdf->Cell(10);
        $buatpdf->SetFont('Arial', '', 11);
        $buatpdf->cell(15, 9, 'Demikian Berita Acara ini dibuat dengan sebenarnya, untuk dipergunakan sebagaimana mestinya.');
        $buatpdf->Ln(15);

        $tanggal_keluar = Carbon::create($bkeluar->tanggal_keluar);

        $buatpdf->SetFont('Arial', '', 11);
        $buatpdf->cell(135);
        $buatpdf->cell(0, 9, 'Makassar, ' . $tanggal_keluar->translatedFormat('d F Y'));
        $buatpdf->Ln(6);
        $buatpdf->Cell(15);
        $buatpdf->SetFont('Arial', '', 11);
        $buatpdf->cell(15, 9, 'Yang Menerima,');
        $buatpdf->cell(105);
        $buatpdf->cell(0, 9, 'Yang Menyerahkan,');
        $buatpdf->Ln(30);
        $buatpdf->Cell(15);
        $buatpdf->SetFont('Arial', '', 11);
        $buatpdf->cell(15, 9, $bkeluar->nama_penerima);
        $buatpdf->cell(105);
        $buatpdf->cell(0, 9, $bkeluar->nama_pemberi);
        $buatpdf->Ln(5);
        $buatpdf->Cell(15);
        $buatpdf->SetFont('Arial', '', 11);
        $buatpdf->cell(15, 9, $bkeluar->nik_penerima);
        $buatpdf->cell(105);
        $buatpdf->cell(0, 9, $bkeluar->nik_pemberi);

        $buatpdf->Output('', 'Barang Keluar_' . $tanggal_keluar->format('d-m-Y H-i-s') . '_ID_' . $bkeluar->id);
    }

    public function delete($id)
    {
        $bkeluar = BKeluar::findOrFail($id);
        $sfp = Sfp::where('bkeluar_id', '=', $id)->update([
            'bkeluar_id' => null,
            'hasil' => null,
        ]);
        $patchcord = Patchcord::where('bkeluar_id', '=', $id)->update([
            'bkeluar_id' => null,
            'hasil' => null,
        ]);
        $modul = Modul::where('bkeluar_id', '=', $id)->update([
            'bkeluar_id' => null,
            'hasil' => null,
        ]);

        $bkeluar->delete();

        if ($bkeluar) {
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil menghapus transaksi barang keluar ' . $bkeluar->instansi_penerima . '_' . $bkeluar->nama_penerima . '_' . $bkeluar->nik_penerima . '_' . $bkeluar->kebutuhan
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Gagal menghapus transaksi. Transaksi tidak tersedia.'
            ]);
        }
    }

    public function jsonSfpMasuk()
    {
        return DataTables::of(Sfp::whereNull('bkeluar_id'))
            ->addIndexColumn()
            ->addColumn('hasil', function ($row) {
                return '<select name="hasil" id="hasil-sfp-btn-' . $row->id . '" class="form-control select-hasil" value="-" data-id="' . $row->id . '" data-jenis="sfp"><option value="-">Pilih Hasil</option><option value="BAIK">BAIK</option><option value="KURANG BAIK">KURANG BAIK</option><option value="BURUK">BURUK</option></select>';
            })
            ->addColumn('Aksi', function ($row) {
                return '<button id="ambil-sfp-btn-' . $row->id . '" type="button" data-jenis="sfp" value="' . $row->id . '" class="btn btn-success ambil-btn shadow sharp" disabled><i class="fa-solid fa-right-from-bracket"></i></button> <button id="batal-sfp-btn-' . $row->id . '" type="button" data-jenis="sfp" value="' . $row->id . '" class="btn btn-danger batal-btn shadow sharp visually-hidden"><i class="fa-solid fa-xmark"></i></button>';
            })
            ->rawColumns(['hasil', 'Aksi'])
            ->make(true);
    }

    public function jsonPatchcordMasuk()
    {
        return DataTables::of(Patchcord::whereNull('bkeluar_id'))
            ->addIndexColumn()
            ->addColumn('hasil', function ($row) {
                return '<select name="hasil" id="hasil-patchcord-btn-' . $row->id . '" class="form-control select-hasil" value="-" data-id="' . $row->id . '" data-jenis="patchcord"><option value="-">Pilih Hasil</option><option value="BAIK">BAIK</option><option value="KURANG BAIK">KURANG BAIK</option><option value="BURUK">BURUK</option></select>';
            })
            ->addColumn('Aksi', function ($row) {
                return '<button id="ambil-patchcord-btn-' . $row->id . '" type="button" data-jenis="patchcord" value="' . $row->id . '" class="btn btn-success ambil-btn shadow sharp " disabled><i class="fa-solid fa-right-from-bracket"></i></button> <button id="batal-patchcord-btn-' . $row->id . '" type="button" data-jenis="patchcord" value="' . $row->id . '" class="btn btn-danger batal-btn shadow sharp visually-hidden"><i class="fa-solid fa-xmark"></i></button>';
            })
            ->rawColumns(['hasil', 'Aksi'])
            ->make(true);
    }

    public function jsonModulMasuk()
    {
        return DataTables::of(Modul::whereNull('bkeluar_id'))
            ->addIndexColumn()
            ->addColumn('hasil', function ($row) {
                return '<select name="hasil" id="hasil-modul-btn-' . $row->id . '" class="form-control select-hasil" value="-" data-id="' . $row->id . '" data-jenis="modul"><option value="-">Pilih Hasil</option><option value="BAIK">BAIK</option><option value="KURANG BAIK">KURANG BAIK</option><option value="BURUK">BURUK</option></select>';
            })
            ->addColumn('Aksi', function ($row) {
                return '<button id="ambil-modul-btn-' . $row->id . '" type="button" data-jenis="modul" value="' . $row->id . '" class="btn btn-success ambil-btn shadow sharp " disabled><i class="fa-solid fa-right-from-bracket"></i></button> <button id="batal-modul-btn-' . $row->id . '" type="button" data-jenis="modul" value="' . $row->id . '" class="btn btn-danger batal-btn shadow sharp visually-hidden"><i class="fa-solid fa-xmark"></i></button>';
            })
            ->rawColumns(['hasil', 'Aksi'])
            ->make(true);
    }

    public function jsonSfpHapus()
    {
        return DataTables::of(Sfp::where('bkeluar_id', '=', Session::get('bkeluar_id')))
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                return '<button id="hapus-btn-' . $row->id . '" type="button" data-jenis="sfp" value="' . $row->id . '" class="btn btn-danger shadow sharp hapus-btn"><i class="fa fa-trash"></i></button>';
            })
            ->rawColumns(['hasil', 'Aksi'])
            ->make(true);
    }

    public function jsonPatchcordHapus()
    {
        return DataTables::of(Patchcord::where('bkeluar_id', '=', Session::get('bkeluar_id')))
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                return '<button id="hapus-btn-' . $row->id . '" type="button" data-jenis="patchcord" value="' . $row->id . '" class="btn btn-danger shadow sharp hapus-btn"><i class="fa fa-trash"></i></button>';
            })
            ->rawColumns(['Aksi'])
            ->make(true);
    }

    public function jsonModulHapus()
    {
        return DataTables::of(Modul::where('bkeluar_id', '=', Session::get('bkeluar_id')))
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                return '<button id="hapus-btn-' . $row->id . '" type="button" data-jenis="modul" value="' . $row->id . '" class="btn btn-danger shadow sharp hapus-btn"><i class="fa fa-trash"></i></button>';
            })
            ->rawColumns(['Aksi'])
            ->make(true);
    }
}
