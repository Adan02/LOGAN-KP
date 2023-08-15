<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sfp;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SfpController extends Controller
{
    public function index()
    {
        return view('input-sfp-masuk');
    }

    public function store(Request $request)
    {
        // $request['tanggal_masuk'] = Carbon::now();
        // $sfp = Sfp::create($request->all());

        // return response()->json([
        //     'message'=>'Berhasil menambahkan Sfp '.$sfp->jenis.'_'.$sfp->vendor.'_'.$sfp->bandwidth.'_'.$sfp->jarak.'_'.$sfp->serial_number
        // ]);

        $validator = Validator::make($request->all(), [
            'jenis' => 'required|max:30',
            'vendor' => 'required|max:30',
            'bandwidth' => 'required|numeric|min:1',
            'lambda' => 'required|numeric|min:1',
            'jarak' => 'required|numeric|min:1',
            'serial_number' => 'required|max:30|unique:sfps'
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $request['tanggal_masuk'] = Carbon::now();
            $sfp = Sfp::create($request->all());

            if ($sfp) {
                return response()->json(['status' => 1, 'msg' => 'Berhasil menambahkan Sfp ' . $sfp->jenis . '_' . $sfp->vendor . '_' . $sfp->bandwidth . '_' . $sfp->jarak . '_' . $sfp->serial_number]);
            }
        }
    }

    public function showMasuk()
    {
        return view('list-sfp-masuk');
    }

    public function showKeluar(Request $request)
    {
        return view('list-sfp-keluar');
    }

    public function deletedSfp()
    {
        return view('sfp-deleted-list');
    }

    public function deletedSfpKeluar()
    {
        return view('sfp-keluar-deleted-list');
    }

    public function edit($id)
    {
        $sfp = Sfp::select(
            'jenis',
            'vendor',
            'bandwidth',
            'lambda',
            'jarak',
            'serial_number',
            'tanggal_masuk',
            'bkeluar_id'
        )->findOrFail($id);
        return view('sfp-edit', ['sfp' => $sfp]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jenis' => 'required|max:30',
            'vendor' => 'required|max:30',
            'bandwidth' => 'required|numeric|min:1',
            'lambda' => 'required|numeric|min:1',
            'jarak' => 'required|numeric|min:1',
            'serial_number' => 'required|max:30|unique:sfps,serial_number,'.$id,
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $sfp = Sfp::findOrFail($id);
            $sfp->update($request->all());

            if ($sfp) {
                return response()->json(['status' => 1, 'msg' => 'Berhasil mengedit Sfp ' . $sfp->jenis . '_' . $sfp->vendor . '_' . $sfp->bandwidth . '_' . $sfp->jarak . '_' . $sfp->serial_number]);
            }
        }
    }

    public function delete($id)
    {
        $sfp = Sfp::findOrFail($id);

        $sfp->delete();

        if ($sfp) {
            Session::flash('status', 'success');
            Session::flash('message', 'hapus sfp sukses!');
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil menghapus Sfp ' . $sfp->jenis . '_' . $sfp->vendor . '_' . $sfp->bandwidth . '_' . $sfp->jarak . '_' . $sfp->serial_number
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Gagal menghapus. Barang tidak tersedia.'
            ]);
        }
    }

    public function permanentDelete($id)
    {
        $sfp = Sfp::withTrashed()->findOrFail($id);

        // dd($sfp);
        $sfp->forceDelete();

        if ($sfp) {
            Session::flash('status', 'success');
            Session::flash('message', 'hapus sfp sukses!');
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil menghapus permanen Sfp ' . $sfp->jenis . '_' . $sfp->vendor . '_' . $sfp->bandwidth . '_' . $sfp->jarak . '_' . $sfp->serial_number
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Gagal menghapus. Barang tidak tersedia.'
            ]);
        }
    }

    public function restore($id)
    {
        $sfp = Sfp::withTrashed()->findOrFail($id);

        $sfp->restore();

        if ($sfp) {
            Session::flash('status', 'success');
            Session::flash('message', 'restore sfp sukses!');
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil memulihkan Sfp ' . $sfp->jenis . '_' . $sfp->vendor . '_' . $sfp->bandwidth . '_' . $sfp->jarak . '_' . $sfp->serial_number . ' berhasil'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Gagal memulihkan. Barang tidak tersedia.'
            ]);
        }
    }

    public function jsonSfpMasuk()
    {
        return DataTables::of(Sfp::whereNull('bkeluar_id'))
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                return '<div class="d-flex flex-row gap-1"><a href="sfp-edit/' . $row->id . '" id="edit-btn-' . $row->id . '" type="button" class="btn btn-primary shadow sharp"><i class="fa fa-pencil"></i></a> <button id="delete-btn-' . $row->id . '" type="button" value="' . $row->id . '" class="btn btn-danger shadow sharp delete-btn"><i class="fa fa-trash"></i></button></div>';
            })
            ->rawColumns(['Aksi'])
            ->make(true);
    }

    public function jsonSfpKeluar()
    {
        return DataTables::of(Sfp::with('bkeluar')->whereNotNull('bkeluar_id')->select('sfps.*'))
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                return '<div class="d-flex flex-row gap-1"><a href="sfp-edit/' . $row->id . '" id="edit-btn-' . $row->id . '" type="button" class="btn btn-primary shadow sharp"><i class="fa fa-pencil"></i></a> <button id="delete-btn-' . $row->id . '" type="button" value="' . $row->id . '" class="btn btn-danger shadow sharp delete-btn"><i class="fa fa-trash"></i></button></div>';
            })
            ->addColumn('Penerima', function ($row) {
                // return $row->bkeluar->nama_penerima;
                return $row->bkeluar->instansi_penerima . '<br><b>' . $row->bkeluar->nama_penerima . '</b><br>' . $row->bkeluar->nik_penerima;
            })
            ->rawColumns(['Aksi', 'Penerima'])
            ->make(true);
    }

    public function jsonSfpMasukDeleted()
    {
        return DataTables::of(Sfp::whereNull('bkeluar_id')->onlyTrashed())
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                return '<div class="d-flex flex-row gap-1"><button id="restore-btn-' . $row->id . '" type="button" value="' . $row->id . '" class="btn btn-success shadow sharp restore-btn"><i class="fa-solid fa-arrow-rotate-left"></i></button> <button id="delete-btn-' . $row->id . '" type="button" value="' . $row->id . '" class="btn btn-danger shadow sharp delete-btn"><i class="fa fa-trash"></i></button></div>';
            })
            ->editColumn('deleted_at', function ($row) {
                return Carbon::create($row->deleted_at);
            })
            ->rawColumns(['Aksi'])
            ->make(true);
    }

    public function jsonSfpKeluarDeleted()
    {
        return DataTables::of(Sfp::with('bkeluar')->whereNotNull('bkeluar_id')->onlyTrashed()->select('sfps.*'))
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                return '<div class="d-flex flex-row gap-1"><button id="restore-btn-' . $row->id . '" type="button" value="' . $row->id . '" class="btn btn-success shadow sharp restore-btn"><i class="fa-solid fa-arrow-rotate-left"></i></button> <button id="delete-btn-' . $row->id . '" type="button" value="' . $row->id . '" class="btn btn-danger shadow sharp delete-btn"><i class="fa fa-trash"></i></button></div>';
                // return '<button id="restore-btn-'.$row->id.'" type="button" value="' . $row->id . '" class="btn btn-success shadow sharp restore-btn"><i class="fa-solid fa-arrow-rotate-left"></button>';
            })
            ->addColumn('Penerima', function ($row) {
                // return $row->bkeluar->nama_penerima;
                return $row->bkeluar->instansi_penerima . '<br><b>' . $row->bkeluar->nama_penerima . '</b><br>' . $row->bkeluar->nik_penerima;
            })
            ->editColumn('deleted_at', function ($row) {
                return Carbon::create($row->deleted_at);
            })
            ->rawColumns(['Aksi', 'Penerima'])
            ->make(true);
    }
}
