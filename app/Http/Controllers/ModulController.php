<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Modul;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ModulController extends Controller
{
    public function index()
    {
        return view('input-modul-masuk');
    }

    public function store(Request $request)
    {
        // $request['tanggal_masuk'] = Carbon::now();
        // $modul = Modul::create($request->all());

        // return response()->json([
        //     'message'=>'Berhasil menambahkan Modul '.$modul->vendor.'_'.$modul->tipe_board.'_'.$modul->serial_number
        // ]);

        // return redirect('logan/input-data/modul-masuk');
        $validator = Validator::make($request->all(), [
            'vendor' => 'required|max:30',
            'tipe_board' => 'required|max:30',
            'serial_number' => 'required|unique:moduls|max:30'
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $request['tanggal_masuk'] = Carbon::now();
            $modul = Modul::create($request->all());

            if ($modul) {
                return response()->json(['status' => 1, 'msg' => 'Berhasil menambahkan Modul '.$modul->vendor.'_'.$modul->tipe_board.'_'.$modul->serial_number]);
            }
        }
    }

    public function showMasuk()
    {
        return view('list-modul-masuk');
    }

    public function showKeluar(Request $request)
    {
        return view('list-modul-keluar');
    }

    public function deletedmodul()
    {
        return view('modul-deleted-list');
    }

    public function deletedModulKeluar()
    {
        return view('modul-keluar-deleted-list');
    }

    public function edit($id)
    {
        $modul = Modul::select(
            'vendor',
            'tipe_board',
            'serial_number',
            'tanggal_masuk',
            'bkeluar_id'
        )->findOrFail($id);
        return view('modul-edit', ['modul' => $modul]);
    }

    public function update(Request $request, $id)
    {
        // $modul = Modul::findOrFail($id);
        // $modul->update($request->all());

        // if ($modul) {
        //     Session::flash('status', 'success');
        //     Session::flash('message', 'edit modul success!');
        // }

        // if ($modul->bkeluar_id) {
        //     return redirect('logan/list-data/modul-keluar');
        // } else {
        //     return redirect('logan/list-data/modul-masuk');
        // }

        $validator = Validator::make($request->all(), [
            'vendor' => 'required|max:30',
            'tipe_board' => 'required|max:30',
            'serial_number' => 'required|max:30|unique:moduls,serial_number,'.$id,
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $modul = Modul::findOrFail($id);
            $modul->update($request->all());

            if ($modul) {
                return response()->json(['status' => 1, 'msg' => 'Berhasil mengedit Modul '.$modul->vendor.'_'.$modul->tipe_board.'_'.$modul->serial_number]);
            }
        }
    }

    public function delete($id)
    {
        $modul = Modul::findOrFail($id);
        $modul->delete();

        if ($modul) {
            Session::flash('status', 'success');
            Session::flash('message', 'ambil modul sukses!');
            return response()->json([
                'status'=>200,
                'message'=>'Berhasil menghapus Modul '.$modul->vendor.'_'.$modul->tipe_board.'_'.$modul->serial_number
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
        $modul = Modul::withTrashed()->findOrFail($id);
        $modul->forceDelete();

        if ($modul) {
            Session::flash('status', 'success');
            Session::flash('message', 'ambil modul sukses!');
            return response()->json([
                'status'=>200,
                'message'=>'Berhasil menghapus permanen Modul '.$modul->vendor.'_'.$modul->tipe_board.'_'.$modul->serial_number
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
        $modul = Modul::withTrashed()->findOrFail($id);

        $modul->restore();

        if ($modul) {
            Session::flash('status', 'success');
            Session::flash('message', 'ambil modul sukses!');
            return response()->json([
                'status'=>200,
                'message'=>'Berhasil memulihkan Modul '.$modul->vendor.'_'.$modul->tipe_board.'_'.$modul->serial_number
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Gagal memulihkan. Barang tidak tersedia.'
            ]);
        }
    }

    public function jsonModulMasuk()
    {
        return DataTables::of(Modul::whereNull('bkeluar_id'))
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                return '<div class="d-flex flex-row gap-1"><a href="modul-edit/' . $row->id . '" id="edit-btn-'.$row->id.'" type="button" class="btn btn-primary shadow sharp"><i class="fa fa-pencil"></i></a> <button id="delete-btn-'.$row->id.'" type="button" value="' . $row->id . '" class="btn btn-danger shadow sharp delete-btn"><i class="fa fa-trash"></i></button></div>';
            })
            ->rawColumns(['Aksi'])
            ->make(true);
    }

    public function jsonModulKeluar()
    {
        return DataTables::of(Modul::with('bkeluar')->whereNotNull('bkeluar_id')->select('moduls.*'))
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                return '<div class="d-flex flex-row gap-1"><a href="modul-edit/' . $row->id . '" id="edit-btn-'.$row->id.'" type="button" class="btn btn-primary shadow sharp"><i class="fa fa-pencil"></i></a> <button id="delete-btn-'.$row->id.'" type="button" value="' . $row->id . '" class="btn btn-danger shadow sharp delete-btn"><i class="fa fa-trash"></i></button></div>';
            })
            ->addColumn('Penerima', function ($row) {
                // return $row->bkeluar->nama_penerima;
                return $row->bkeluar->instansi_penerima . '<br><b>' . $row->bkeluar->nama_penerima . '</b><br>' . $row->bkeluar->nik_penerima;
            })
            ->rawColumns(['Aksi', 'Penerima'])
            ->make(true);
    }

    public function jsonModulMasukDeleted()
    {
        return DataTables::of(Modul::whereNull('bkeluar_id')->onlyTrashed())
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                return '<div class="d-flex flex-row gap-1"><button id="restore-btn-'.$row->id.'" type="button" value="' . $row->id . '" class="btn btn-success shadow sharp restore-btn"><i class="fa-solid fa-arrow-rotate-left"></i></button> <button id="delete-btn-'.$row->id.'" type="button" value="' . $row->id . '" class="btn btn-danger shadow sharp delete-btn"><i class="fa fa-trash"></i></button></div>';
            })
            ->editColumn('deleted_at', function ($row){
                return Carbon::create($row->deleted_at);
            })
            ->rawColumns(['Aksi'])
            ->make(true);
    }

    public function jsonModulKeluarDeleted()
    {
        return DataTables::of(Modul::with('bkeluar')->whereNotNull('bkeluar_id')->onlyTrashed()->select('moduls.*'))
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                return '<div class="d-flex flex-row gap-1"><button id="restore-btn-'.$row->id.'" type="button" value="' . $row->id . '" class="btn btn-success shadow sharp restore-btn"><i class="fa-solid fa-arrow-rotate-left"></i></button> <button id="delete-btn-'.$row->id.'" type="button" value="' . $row->id . '" class="btn btn-danger shadow sharp delete-btn"><i class="fa fa-trash"></i></button></div>';
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
