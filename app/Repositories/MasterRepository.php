<?php

namespace App\Repositories;

use App\Contracts\Repositories\MasterRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Client\ConnectionException;

class MasterRepository implements MasterRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAreas()
    {
        return DB::table('mst_area')->get();
    }

    /**
     * @inheritDoc
     */
    public function getTypesByIdMenu($id_menu)
    {
        return DB::table('submenu')->where('id_menu', $id_menu)->get();
    }

    /**
     * @inheritDoc
     */
    public function getJabatan()
    {
        return DB::connection('db2')
            ->table('tbljabatan as jb')
            ->select('jb.kd_jabatan', 'jb.nm_jabatan', 'jb.status_karyawan', 'jb.jabatan_active')
            ->where('jb.jabatan_active', 'true')
            ->where('jb.status_karyawan', '!=', 'Eksternal')
            ->orderBy('jb.nm_jabatan', 'asc')
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function getWilayah()
    {
        return DB::connection('db2')
            ->table('tblwilayah as w')
            ->select('w.kd_wilayah', 'w.nm_wilayah')
            ->where('w.wilayah_active', 'true')
            ->orderBy('w.kd_wilayah', 'asc')
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function getCabang()
    {
        try {
            $query = DB::connection('db2')
                ->table('tblcabang as cb')
                ->leftJoin('tblarea as area', 'cb.fk_area', '=', 'area.kd_area')
                ->select('area.*', 'cb.kd_cabang', 'cb.nm_cabang', 'cb.cabang_active', 'area.area_active')
                ->orderBy('area.kd_area', 'asc')
                ->orderBy('cb.kd_cabang', 'asc')
                ->where([
                    'cb.cabang_active' => 'true',
                    'area.area_active' => 'true'
                ])
                ->get();

            $grouped = $query->groupBy('kd_area');

            $result = [];
            foreach ($grouped as $kd_area => $items) {
                $areaName = $items[0]->nm_area;

                $children = [];
                foreach ($items as $item) {
                    $children[] = [
                        "id_area" => $item->kd_cabang,
                        "nm_area" => $item->nm_cabang,
                        "children" => []
                    ];
                }

                $result[] = [
                    "id_area" => $kd_area,
                    "nm_area" => $areaName,
                    "children" => $children
                ];
            }

            return $result;
        } catch (ConnectionException $error) {
            return ['error' => 'Internal Server Error'];
        }
    }
}
