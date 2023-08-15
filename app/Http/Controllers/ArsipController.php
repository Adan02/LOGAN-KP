<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Arsip;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArsipController extends Controller
{
    public function index()
    {
        return view('input-arsip');
    }

    public function store(Request $request)
    {
        // $newName = '';

        // if ($request->file('file')) {
        //     $extension = $request->file('file')->getClientOriginalExtension();
        //     $newName = 'file-' . $request->nomor_arsip . '.' . $extension;
        //     $request->file('file')->storeAs('file', $newName);
        // }

        // $request['file_arsip'] = $newName;
        // $request['tanggal_masuk'] = Carbon::now();
        // $arsip = Arsip::create($request->all());

        // if ($arsip) {
        //     Session::flash('status', 'success');
        //     Session::flash('message', 'Sukses menambahkan Arsip!');
        // }

        // return redirect('logan/input-data/arsip');

        $validator = Validator::make($request->all(), [
            'jenis' => 'required',
            'judul' => 'required',
            'vendor' => 'required',
            'nomor_arsip' => 'required|unique:arsips',
            // 'file_arsip' => 'required|max:255',
            'tanggal_arsip' => 'required'
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $newName = '';

            if ($request->file('file')) {
                // $extension = $request->file('file')->getClientOriginalExtension();
                // $newName = 'file-' . $request->nomor_arsip . '.' . $extension;
                // $request->file('file')->storeAs('file', $newName);
                $request->file('file')->storeAs('files', $request->file('file')->getClientOriginalName());
            }

            $request['file_arsip'] = $request->file('file')->getClientOriginalName();
            $request['tanggal_masuk'] = Carbon::now();
            $arsip = Arsip::create($request->all());

            if ($arsip) {
                return response()->json(['status' => 1, 'msg' => 'Berhasil menambahkan Arsip ' . $arsip->jenis . '_' . $arsip->judul . '_' . $arsip->vendor . '_' . $arsip->nomor_arsip . '_' . $arsip->file_arsip . '_' . $arsip->tanggal_arsip]);
            }
        }
    }

    public function show()
    {
        return view('list-arsip');
    }

    public function deletedArsip()
    {
        return view('arsip-deleted-list');
    }

    public function edit($id)
    {
        $arsip = Arsip::select(
            'jenis',
            'judul',
            'vendor',
            'nomor_arsip',
            'file_arsip',
            'tanggal_arsip'
        )->findOrFail($id);
        return view('arsip-edit', ['arsip' => $arsip]);
    }

    public function update(Request $request, $id)
    {
        // $arsip = Arsip::findOrFail($id);

        // if (Storage::exists('file/' . $arsip->file_arsip)) {
        //     Storage::delete('file/' . $arsip->file_arsip);
        // }

        // $newName = '';

        // if ($request->file('file')) {
        //     $extension = $request->file('file')->getClientOriginalExtension();
        //     $newName = 'file-' . $request->nomor_arsip . '.' . $extension;
        //     $request->file('file')->storeAs('file', $newName);
        // }

        // $request['file_arsip'] = $newName;
        // $arsip->update($request->all());

        // if ($arsip) {
        //     Session::flash('status', 'success');
        //     Session::flash('message', 'edit arsip success!');
        // }

        // return redirect('logan/list-data/arsip');

        $validator = Validator::make($request->all(), [
            'jenis' => 'required',
            'judul' => 'required',
            'vendor' => 'required',
            'nomor_arsip' => 'required|unique:arsips,nomor_arsip,'.$id,
            // 'file_arsip' => 'required|max:255',
            'tanggal_arsip' => 'required'
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $arsip = Arsip::findOrFail($id);

            if (Storage::exists('files/' . $arsip->file_arsip)) {
                Storage::delete('files/' . $arsip->file_arsip);
            }

            $newName = '';

            if ($request->file('file')) {
                // $extension = $request->file('file')->getClientOriginalExtension();
                // $newName = 'file-' . $request->nomor_arsip . '.' . $extension;
                // $request->file('file')->storeAs('file', $newName);
                $request->file('file')->storeAs('files', $request->file('file')->getClientOriginalName());
            }

            $request['file_arsip'] = $request->file('file')->getClientOriginalName();
            $arsip->update($request->all());

            if ($arsip) {
                return response()->json(['status' => 1, 'msg' => 'Berhasil mengedit Arsip ' . $arsip->jenis . '_' . $arsip->judul . '_' . $arsip->vendor . '_' . $arsip->nomor_arsip . '_' . $arsip->file_arsip . '_' . $arsip->tanggal_arsip]);
            }
        }
    }

    public function delete($id)
    {
        // $deleteArsip = DB::table('arsips')->where('id', $id)->delete();

        // dd($id);
        $arsip = Arsip::findOrFail($id);
        $arsip->delete();

        if ($arsip) {
            Session::flash('status', 'success');
            Session::flash('message', 'hapus arsip sukses!');
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil menghapus Arsip ' . $arsip->jenis . '_' . $arsip->judul . '_' . $arsip->vendor . '_' . $arsip->nomor_arsip . '_' . $arsip->file_arsip . '_' . $arsip->tanggal_arsip
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Gagal menghapus. Arsip tidak tersedia.'
            ]);
        }
    }

    public function permanentDelete($id)
    {
        $arsip = Arsip::withTrashed()->findOrFail($id);

        if (Storage::exists('file/' . $arsip->file_arsip)) {
            Storage::delete('file/' . $arsip->file_arsip);
        }

        $arsip->forceDelete();

        if ($arsip) {
            Session::flash('status', 'success');
            Session::flash('message', 'hapus arsip sukses!');
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil menghapus permanen Arsip ' . $arsip->jenis . '_' . $arsip->judul . '_' . $arsip->vendor . '_' . $arsip->nomor_arsip . '_' . $arsip->file_arsip . '_' . $arsip->tanggal_arsip
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Gagal menghapus. Arsip tidak tersedia.'
            ]);
        }
    }

    public function restore($id)
    {
        $arsip = Arsip::withTrashed()->findOrFail($id);
        $arsip->restore();

        if ($arsip) {
            Session::flash('status', 'success');
            Session::flash('message', 'restore arsip sukses!');
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil memulihkan Arsip ' . $arsip->jenis . '_' . $arsip->judul . '_' . $arsip->vendor . '_' . $arsip->nomor_arsip . '_' . $arsip->file_arsip . '_' . $arsip->tanggal_arsip
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Gagal memulihkan. Arsip tidak tersedia.'
            ]);
        }
    }

    public function jsonArsip()
    {
        return DataTables::of(Arsip::all())
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                return '<div class="d-flex flex-row gap-1"><a href="arsip-edit/' . $row->id . '" id="edit-btn-' . $row->id . '" type="button" class="btn btn-primary shadow sharp"><i class="fa fa-pencil"></i></a> <button id="delete-btn-' . $row->id . '" type="button" value="' . $row->id . '" class="btn btn-danger shadow sharp delete-btn"><i class="fa fa-trash"></i></button></div>';
            })
            ->editColumn('file_arsip', function ($row) {
                return '<a href="/storage/files/' . $row->file_arsip . '" target="_blank">' . $row->file_arsip . '</a>';
            })
            ->rawColumns(['Aksi', 'file_arsip'])
            ->make(true);
    }

    public function jsonArsipDeleted()
    {
        return DataTables::of(Arsip::onlyTrashed()->get())
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                return '<div class="d-flex flex-row gap-1"><button id="restore-btn-' . $row->id . '" type="button" value="' . $row->id . '" class="btn btn-success shadow sharp restore-btn"><i class="fa-solid fa-arrow-rotate-left"></i></button> <button id="delete-btn-' . $row->id . '" type="button" value="' . $row->id . '" class="btn btn-danger shadow sharp delete-btn"><i class="fa fa-trash"></i></button></div>';
            })
            ->editColumn('deleted_at', function ($row) {
                return Carbon::create($row->deleted_at);
            })
            ->editColumn('file_arsip', function ($row) {
                return '<a href="/storage/files/' . $row->file_arsip . '" target="_blank">' . $row->file_arsip . '</a>';
            })
            ->rawColumns(['Aksi', 'file_arsip'])
            ->make(true);
    }
}
