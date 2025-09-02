<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Master extends Model
{
  use HasFactory;

  public function getJabatan()
  {
    $query = \DB::connection('db2')
      ->table('tbljabatan as jb')
      ->select('jb.kd_jabatan', 'jb.nm_jabatan', 'jb.jabatan_active')
      ->where('jabatan_active', 'true')
      ->get();

    return $query;
  }


  public function getCabang()
  {
    try {
      $query = \DB::connection('db2')
        ->table('tblcabang as cb')
        ->leftJoin('tblarea as area', 'cb.fk_area', '=', 'area.kd_area')
        ->select('area.*', 'cb.kd_cabang', 'cb.nm_cabang', 'cb.cabang_active', 'area.area_active')
        ->orderBy('area.kd_area', 'asc')
        ->orderBy('cb.kd_cabang', 'asc')
        ->where([
          'cabang_active' => 'true',
          'area_active' => 'true'
        ])
        ->get();


      // Group berdasarkan area
      $grouped = $query->groupBy('kd_area');

      $result = [];
      foreach ($grouped as $kd_area => $items) {
        $areaName = $items[0]->nm_area; // ambil nama area sekali saja

        $children = [];
        foreach ($items as $item) {
          $children[] = [
            "id_area" => (int) $item->kd_cabang,
            "nm_area" => $item->nm_cabang,
            "children" => []
          ];
        }

        $result[] = [
          "id_area" => (int) $kd_area,
          "nm_area" => $areaName,
          "children" => $children
        ];
      }

      return $result;
    } catch (ConnectionException $error) {
      // throw new Exception('Internal Server Error');
      return json_encode(['error' => 'Internal Server Error']);
    }

  }
}
  