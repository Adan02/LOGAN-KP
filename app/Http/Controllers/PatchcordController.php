<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Patchcord;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PatchcordController extends Controller
{
    public function index()
    {
        return view('input-patchcord-masuk');
    }

    public function store(Request $request)
    {
        // $request['tanggal_masuk'] = Carbon::now();
        // $patchcord = Patchcord::create($request->all());

        // return response()->json([
        //     'message'=>'Berhasil menambahkan Patchcord '.$patchcord->jenis.'_'.$patchcord->konektor.'_'.$patchcord->jarak.'_'.$patchcord->tipe_kabel
        // ]);

        // return redirect('logan/input-data/patchcord-masuk');

        $validator = Validator::make($request->all(), [
            'jenis' => 'required|max:30',
            'konektor' => 'required|max:30',
            'jarak' => 'required|numeric|min:1',
            'tipe_kabel' => 'required|max:30',
            'serial_number' => 'required|unique:patchcords|max:30'
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $request['tanggal_masuk'] = Carbon::now();
            $patchcord = Patchcord::create($request->all());

            if ($patchcord) {
                return response()->json(['status' => 1, 'msg' => 'Berhasil menambahkan Patchcord '.$patchcord->jenis.'_'.$patchcord->konektor.'_'.$patchcord->jarak.'_'.$patchcord->tipe_kabel]);
            }
        }
    }

    public function showMasuk()
    {
        return view('list-patchcord-masuk');
    }

    public function showKeluar(Request $request)
    {
        return view('list-patchcord-keluar');
    }

    public function deletedPatchcord()
    {
        return view('patchcord-deleted-list');
    }

    public function deletedPatchcordKeluar()
    {
        return view('patchcord-keluar-deleted-list');
    }

    public function edit($id)
    {
        $patchcord = Patchcord::select(
            'jenis',
            'konektor',
            'jarak',
            'tipe_kabel',
            'serial_number',
            'tanggal_masuk',
            'bkeluar_id'
        )->findOrFail($id);
        return view('patchcord-edit', ['patchcord' => $patchcord]);
    }

    public function update(Request $request, $id)
    {
        // $patchcord = Patchcord::findOrFail($id);
        // $patchcord->update($request->all());

        // if ($patchcord) {
        //     Session::flash('status', 'success');
        //     Session::flash('message', 'edit patchcord success!');
        // }

        // if ($patchcord->bkeluar_id) {
        //     return redirect('logan/list-data/patchcord-keluar');
        // } else {
        //     return redirect('logan/list-data/patchcord-masuk');
        // }

        $validator = Validator::make($request->all(), [
            'jenis' => 'required|max:30',
            'konektor' => 'required|max:30',
            'jarak' => 'required|numeric|min:1',
            'tipe_kabel' => 'required|max:30',
            'serial_number' => 'required|unique:patchcords|max:30'
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            // $request['tanggal_masuk'] = Carbon::now();
            // $patchcord = Patchcord::create($request->all());
            $patchcord = Patchcord::findOrFail($id);
            $patchcord->update($request->all());

            if ($patchcord) {
                return response()->json(['status' => 1, 'msg' => 'Berhasil mengedit Patchcord '.$patchcord->jenis.'_'.$patchcord->konektor.'_'.$patchcord->jarak.'_'.$patchcord->tipe_kabel]);
            }
        }
    }

    public function delete($id)
    {
        $patchcord = Patchcord::findOrFail($id);

        $patchcord->delete();

        if ($patchcord) {
            Session::flash('status', 'success');
            Session::flash('message', 'hapus patchcord sukses!');
            return response()->json([
                'status'=>200,
                'message'=>'Berhasil menghapus Patchcord '.$patchcord->jenis.'_'.$patchcord->konektor.'_'.$patchcord->jarak.'_'.$patchcord->tipe_kabel
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Gagal menghapus. Barang tidak tersedia.'
            ]);
        }
    }

    public function permanentDelete($id)
    {
        $patchcord = Patchcord::withTrashed()->findOrFail($id);

        $patchcord->forceDelete();

        if ($patchcord) {
            Session::flash('status', 'success');
            Session::flash('message', 'hapus patchcord sukses!');
            return response()->json([
                'status'=>200,
                'message'=>'Berhasil menghapus permanen Patchcord '.$patchcord->jenis.'_'.$patchcord->konektor.'_'.$patchcord->jarak.'_'.$patchcord->tipe_kabel
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Gagal menghapus. Barang tidak tersedia.'
            ]);
        }
    }

    public function restore($id)
    {
        $patchcord = Patchcord::withTrashed()->findOrFail($id);

        $patchcord->restore();

        if ($patchcord) {
            Session::flash('status', 'success');
            Session::flash('message', 'hapus sfp sukses!');
            return response()->json([
                'status'=>200,
                'message'=>' Berhasil memulihkan Patchcord '.$patchcord->jenis.'_'.$patchcord->konektor.'_'.$patchcord->jarak.'_'.$patchcord->tipe_kabel
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Gagal memulihkan. Barang tidak tersedia.'
            ]);
        }
    }

    public function jsonPatchcordMasuk()
    {
        return DataTables::of(Patchcord::whereNull('bkeluar_id'))
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                return '<div class="d-flex flex-row gap-1"><a href="patchcord-edit/' . $row->id . '" id="edit-btn-'.$row->id.'" type="button" class="btn btn-primary shadow sharp"><i class="fa fa-pencil"></i></a> <button id="delete-btn-'.$row->id.'" type="button" value="' . $row->id . '" class="btn btn-danger shadow sharp delete-btn"><i class="fa fa-trash"></i></button></div>';
            })
            ->rawColumns(['Aksi'])
            ->make(true);
    }

    public function jsonPatchcordKeluar()
    {
        return DataTables::of(Patchcord::with('bkeluar')->whereNotNull('bkeluar_id')->select('patchcords.*'))
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                return '<div class="d-flex flex-row gap-1"><a href="patchcord-edit/' . $row->id . '" id="edit-btn-'.$row->id.'" type="button" class="btn btn-primary shadow sharp"><i class="fa fa-pencil"></i></a> <button id="delete-btn-'.$row->id.'" type="button" value="' . $row->id . '" class="btn btn-danger shadow sharp delete-btn"><i class="fa fa-trash"></i></button></div>';
            })
            ->addColumn('Penerima', function ($row) {
                // return $row->bkeluar->nama_penerima;
                return $row->bkeluar->instansi_penerima . '<br><b>' . $row->bkeluar->nama_penerima . '</b><br>' . $row->bkeluar->nik_penerima;
            })
            ->rawColumns(['Aksi', 'Penerima'])
            ->make(true);
    }

    public function jsonPatchcordMasukDeleted()
    {
        return DataTables::of(Patchcord::whereNull('bkeluar_id')->onlyTrashed())
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                return '<div class="d-flex flex-row gap-1"><button id="restore-btn-'.$row->id.'" type="button" value="' . $row->id . '" class="btn btn-success shadow sharp restore-btn"><i class="fa-solid fa-arrow-rotate-left"></i></button> <button id="delete-btn-'.$row->id.'" type="button" value="' . $row->id . '" class="btn btn-danger shadow sharp delete-btn"><i class="fa fa-trash"></i></button></div>';
                // return '<button id="restore-btn-'.$row->id.'" type="button" value="' . $row->id . '" class="btn btn-success shadow sharp restore-btn"><i class="fa-solid fa-arrow-rotate-left"></button>';
            })
            ->editColumn('deleted_at', function ($row){
                return Carbon::create($row->deleted_at);
            })
            ->rawColumns(['Aksi'])
            ->make(true);
    }

    public function jsonPatchcordKeluarDeleted()
    {
        return DataTables::of(Patchcord::with('bkeluar')->whereNotNull('bkeluar_id')->onlyTrashed()->select('patchcords.*'))
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                return '<div class="d-flex flex-row gap-1"><button id="restore-btn-'.$row->id.'" type="button" value="' . $row->id . '" class="btn btn-success shadow sharp restore-btn"><i class="fa-solid fa-arrow-rotate-left"></i></button> <button id="delete-btn-'.$row->id.'" type="button" value="' . $row->id . '" class="btn btn-danger shadow sharp delete-btn"><i class="fa fa-trash"></i></button></div>';
                // return '<button id="restore-btn-'.$row->id.'" type="button" value="' . $row->id . '" class="btn btn-success shadow sharp restore-btn"><i class="fa-solid fa-arrow-rotate-left"></button>';
            })
            ->addColumn('Penerima', function ($row) {
                // return $row->bkeluar->nama_penerima;
                return $row->bkeluar->instansi_penerima . '<br><b>' . $row->bkeluar->nama_penerima . '</b><br>' . $row->bkeluar->nik_penerima;
            })
            ->editColumn('deleted_at', function ($row){
                return Carbon::create($row->deleted_at);
            })
            ->rawColumns(['Aksi', 'Penerima'])
            ->make(true);
    }
}
