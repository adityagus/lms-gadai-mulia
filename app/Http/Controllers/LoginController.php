<?php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function aksiLogin(Request $request)
    {
        // Pastikan variabel di-assign sebelum digunakan
        $username = $request->input('user');
        $password = $request->input('pass');
        // Debugging line to check input
        // dd($username, $password);

        // Cek user login menggunakan model Login (db2)

        $users = Login::cekLogin($username);
        $user = null;
        if ($users && count($users) > 0) {
            $user = $users[0];
        }

        if ($user) {
            if (crypt($password, $user->password) == $user->password) {
                $nama = $user->nm_depan ?? ($user->nama ?? '');
                if (!empty($user->nm_belakang)) {
                    $nama .= ' ' . $user->nm_belakang;
                }

                $datasession = [
                    'nama' => $nama,
                    'user' => $user->username,
                    'idgrup' => $user->kd_jabatan ?? ($user->id_jabatan ?? null),
                    'status' => 'login'
                ];

                Session::put($datasession);

                // Kembalikan response JSON, frontend yang handle localStorage dan redirect
                $redirectUrl = ($datasession['idgrup'] === 'JBT-032') ? '/admin' : '/student';
                return response()->json([
                    'success' => true,
                    'user' => $datasession,
                    'redirect' => $redirectUrl
                ]);
            } else {
                return back()->with('sukses', "Oops... Username/Password Salah!!!Cek");
            }
        } else {
            return back()->with('sukses', "Oops... Username/Password Salah!!!");
        }
    }
}
