<?php

namespace App\Http\Controllers\api;

use App\Models\Master;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MasterController extends Controller
{
    public function getAreas()
    {
        // Fetch all areas from the mst_area table
        $areas = \DB::table('mst_area')->get();

        // Return the areas as a JSON response
        return response()->json($areas);
    }

    
    public function getTypesByIdMenu($id_menu){
      $types = \DB::table('submenu_new')->where('id_menu', $id_menu)->get();
      return response()->json($types);
    }
    
    public function getJabatan(){
      
      $result = Master::getJabatan();

      return response()->json($result);
    }
    
    public function getWilayah(){
      $result = \DB::connection('db2')
      ->table('tblwilayah as w')
      ->select('w.kd_wilayah', 'w.nm_wilayah')
      ->orderBy('w.kd_wilayah', 'asc')
      ->get();
      return response()->json($result);
    }

    public function getCabang(){
      $result = Master::getCabang();
      return response()->json($result);
    }
    
    
  }
