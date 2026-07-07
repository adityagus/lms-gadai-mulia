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
        // ->select('a.username', 'a.password', 'b.nm_depan', 'b.nm_belakang', 'c.kd_jabatan', 'nm_jabatan', 'a.fk_cabang_user')

        
        
        return DB::connection('db2')
            ->table('auth.users as a')
            ->select('a.username', 'a.password_hash', 'a.full_name', 'c.position_code', 'c.position_name', 'b.branch_id', DB::raw('RIGHT(d.branch_code, 3) as branch_code'))
            ->join('master.employee as b', 'a.employee_id', '=', 'b.employee_id')
            ->join('master.position as c', 'b.position_id', '=', 'c.position_id')
            ->leftJoin('master.branch as d', 'b.branch_id', '=', 'd.branch_id')
            ->where('a.is_active', 'true')
            ->where('a.username', '=', $username)
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function getUserRole(string $username)
    {
        return DB::connection('db2')
            ->table('auth.users as a')
            ->select('c.position_code as kd_jabatan', 'c.position_name as nm_jabatan')
            ->join('master.employee as b', 'a.employee_id', '=', 'b.employee_id')
            ->join('master.position as c', 'b.position_id', '=', 'c.position_id')
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

