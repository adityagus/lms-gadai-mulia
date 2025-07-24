<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function aksiLogin(Request $request)
    {
        // dd($request->all()); // Debugging: tampilkan semua input yang diterima
        $user = $request->input('user');
        $pass = $request->input('pass');

        // Cek ke database utama
        $cek = DB::table('users')
            ->where('username', $user)
            ->where('password', $pass)
            ->count();
        $u = DB::table('users')
            ->where('username', $user)
            ->where('password', $pass)
            ->first();

        // Cek ke database kedua (sam_pos_view)
        $cek2 = DB::connection('sam_pos_view')->table('users')
            ->where('username', $user)
            ->where('password', $pass)
            ->count();
        $u2 = DB::connection('sam_pos_view')->table('users')
            ->where('username', $user)
            ->where('password', $pass)
            ->first();

        // Pilih hasil dari database kedua jika ada, jika tidak pakai utama
        $finalCek = $cek2 > 0 ? $cek2 : $cek;
        $finalU = $u2 ?: $u;

        // Debug
        // dd($finalU);

        if ($finalCek > 0 && $finalU) {
            $datasession = [
                'username' => $user,
                'nama' => $finalU->nama ?? '',
                'id_area' => $finalU->id_area ?? null,
                'id_cbg' => $finalU->id_cabang ?? null,
                'id_jbt' => $finalU->id_jabatan ?? null,
                'status' => 'login',
            ];
            Session::put($datasession);
            return Redirect::to('home');
        } else {
            Session::flash('sukses', 'Oops... Username/password salah');
            return Redirect::to('login');
        }
    }
}
