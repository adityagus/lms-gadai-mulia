<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function cekLogin(string $username)
    {
        return DB::connection('db2')
            ->table('tbluser as a')
            ->select(
                'a.username',
                'a.password',
                'b.nm_depan',
                'b.nm_belakang',
                'c.kd_jabatan',
                'c.nm_jabatan',
                'a.fk_cabang_user'
            )
            ->join('tblkaryawan as b', 'a.fk_karyawan', '=', 'b.npk')
            ->join('tbljabatan as c', 'b.fk_jabatan', '=', 'c.kd_jabatan')
            ->where('a.active', 't')
            ->where('a.username', '=', $username)
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function getUserRole(string $username)
    {
        return DB::connection('db2')
            ->table('tbluser as a')
            ->select('c.kd_jabatan', 'c.nm_jabatan')
            ->join('tblkaryawan as b', 'a.fk_karyawan', '=', 'b.npk')
            ->join('tbljabatan as c', 'b.fk_jabatan', '=', 'c.kd_jabatan')
            ->where('a.username', '=', $username)
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function getUserProfile(string $username)
    {
        return DB::connection('db2')
            ->table('tbluser as a')
            ->select('a.username', 'b.nm_depan', 'b.nm_belakang', 'a.fk_cabang_user')
            ->join('tblkaryawan as b', 'a.fk_karyawan', '=', 'b.npk')
            ->where('a.username', '=', $username)
            ->get();
    }
}
