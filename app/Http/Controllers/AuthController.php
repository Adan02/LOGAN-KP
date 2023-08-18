<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        Session::put('previous_url', url()->previous());
        return view('login');
    }

    public function authenticating(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        $credential = $validator->valid();
        unset($credential['_token']);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            if (Auth::attempt($credential)) {
                $request->session()->regenerate();
                return response()->json(['status' => 1, 'msg' => 'Berhasil Login']);
            } else {
                $err = [
                    "username" => [
                        0 => "username dan/atau password salah"
                    ],
                    "password" => [
                        0 => "username dan/atau password salah"
                    ]
                ];
                return response()->json(['status' => 0, 'error' => $err]);
            }
        }

        Session::flash('status', 'failed');
        Session::flash('message', 'login gagal');

        return redirect('logan/login');
    }

    public function manajemenAkun()
    {
        $akun = User::with('role')->get();
        return view('manajemen-akun', compact('akun'));
    }

    public function buatAkun(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30',
            'username' => 'required|max:30|unique:users',
            'password' => 'required',
            'role_id' => 'required|numeric',
        ], [
            'role_id.required' => 'role tidak boleh kosong',
            'role_id.numeric' => 'role tidak valid',
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $request['password'] = Hash::make($request->password);
            $akun = User::create($request->all());

            if ($akun) {
                return response()->json(['status' => 1, 'msg' => 'Berhasil menambahkan Akun ' . $akun->username]);
            }
        }
    }

    public function deleteAkun($id)
    {
        $akun = User::findOrFail($id);

        $akun->delete();

        if ($akun) {
            if (auth()->user()->username == $akun->username) {
                return response()->json([
                    'status' => 201,
                    'message' => 'Berhasil menghapus akun saat ini'
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil menghapus akun ' . $akun->username
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Gagal menghapus. Akun tidak tersedia.'
            ]);
        }
    }

    public function updateAkun(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'username' => 'required|max:255|unique:users,username,' . $request->akun_id,
                'role_id' => 'required|numeric',
                'admin_password' => ['required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        return $fail(__('password akun ' . auth()->user()->name . ' salah'));
                    }
                }],
            ],
            [
                'role_id.required' => 'role tidak boleh kosong',
                'role_id.numeric' => 'role tidak valid',
                'admin_password.required' => 'password tidak boleh kosong'
            ]
        );

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $akun = User::findOrFail($request->akun_id);
            $akun->update([
                'name' => $request->name,
                'username' => $request->username,
                'role_id' => $request->role_id,
            ]);

            if ($akun) {
                return response()->json(['status' => 1, 'msg' => 'Berhasil mengupdate Akun ' . $akun->username]);
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('logan/login');
    }

    public function jsonAkun()
    {
        return DataTables::of(User::with('role')->get())
            ->addIndexColumn()
            ->addColumn('Aksi', function ($row) {
                return '<div class="d-flex flex-row gap-1"><button id="edit-btn-' . $row->id . '" type="button" class="btn btn-primary shadow sharp edit-btn"><i class="fa fa-pencil"></i></button> <button id="delete-btn-' . $row->id . '" type="button" value="' . $row->id . '" class="btn btn-danger shadow sharp delete-btn"><i class="fa fa-trash"></i></button></div>';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::create($row->created_at);
            })
            ->rawColumns(['Aksi'])
            ->make(true);
    }
}
