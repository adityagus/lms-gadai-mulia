<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\UserRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * LoginController Constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle user login.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function aksiLogin(Request $request)
    {
        $username = $request->input('user');
        $password = $request->input('pass');

        $users = $this->userRepository->cekLogin($username);
        // dd($users);
        $usersArray = $users->toArray();
        $user = null;
        if ($users && count($users) > 0) {
            $user = $usersArray[0];
        }
        // dd($user);
        // dd($user);
        if ($user) {
            if (Hash::check($password, $user->password_hash)) {

                $nama = $user->full_name ?? '';

                $datasession = [
                    'nama' => Str::title($nama),
                    'user' => $user->username,
                    'cabang' => $user->branch_code ?? null,
                    'jabatan' => $user->position_name ?? null,
                    'idgrup' => $user->position_code ?? null,
                    'npk' => $user->npk ?? null,
                    'status' => 'login'
                ];

                session()->put('auth', $datasession);
                // dd(Session::all());

                $redirectUrl = '/lms';
                return response()->json([
                    'success' => true,
                    'user' => $datasession,
                    'redirect' => $redirectUrl
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Oops... Username/Password Salah!!!Cek"
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => "Oops... Username/Password Salah!!!"
            ]);
        }
    }
    
    /**
     * Handle user logout.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Session::flush();
        return Redirect::to('/sign-in');
    }
}
