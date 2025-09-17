<?php

namespace App\Http\Controllers\api;

use App\Models\Master;
use App\Models\Category;
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
      $types = \DB::table('submenu')->where('id_menu', $id_menu)->get();
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
      ->where('w.wilayah_active', 'true')
      ->get();
      return response()->json($result);
    }

    public function getCabang(){
      $result = Master::getCabang();
      return response()->json($result);
    }

    public function getCategories()
    {
      $categories = Category::select('id', 'name', 'description')->get();

    if ($categories->isEmpty()) {
      return response()->json(['message' => 'No categories found'], 404);
    }

    return response()->json($categories, 200);
  }
  
  public function addCategory(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'required|string|max:500',
    ]);

    $category = Category::create($request->validated());

    return response()->json([
      'message' => 'Category created successfully',
      'category' => $category
    ], 201);
  }
  
  public function updateCategory(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'required|string|max:500',
    ]);

    $category = Category::find($id);
    if (!$category) {
      return response()->json(['message' => 'Category not found'], 404);
    }

    $category->update($request->validated());

    return response()->json([
      'message' => 'Category updated successfully',
      'category' => $category
    ], 200);
  }
    
    
    
}
