<?php

namespace App\Http\Controllers\api;

use App\Models\DocumentPosition;
use App\Models\DocumentRegion;
use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Services\AlgoliaService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AnnouncementController extends Controller
{
  public function index(Request $request)
  {
    // fetch by parameter
    $category = $request->query('category');

    //fetch table submenu
    $announcements = Menu::where('id_menu', $category)->get();
    $jbt = Session::get('auth.idgrup');
    $cabang = Session::get('auth.cabang');

    if($cabang == null){
      $announcements = Menu::where('id_menu', $category)
      ->withCount([
        'announcements as count_tipe_announcement' => function ($q) use ($jbt) {
          // $q->whereHas('document_position', function ($q2) use ($jbt) {
          //   $q2->where('kd_jbt', $jbt);
          // });
        }
      ])
      ->get();
      return response()->json(['success' => true, 'data' => $announcements]);
    }else{
      $announcements = Menu::where('id_menu', $category)
        ->with(['announcements' => function ($q) use ($jbt, $cabang) {
          $q->whereHas('document_position', function ($q2) use ($jbt) {
            $q2->where('kd_jbt', $jbt);
          })
          ->whereHas('document_regional', function ($q3) use ($cabang) {
            $q3->where('regional_id', $cabang);
          });
        }])
        ->get();

      // Hitung count_tipe_announcement di PHP, lebih efisien untuk dataset kecil/menengah
      $announcements->map(function($menu) {
        $menu->count_tipe_announcement = $menu->announcements->count();
        unset($menu->announcements); // opsional, jika tidak ingin return array announcements
        return $menu;
      });
    }
    
    return response()->json(['success' => true, 'data' => $announcements]);
    
  }

  public function detail(Request $request, $menu_id)
  {
    // get query category
    $category = $request->query('category');
    $jbt = Session::get('auth.idgrup');
    $cabang = Session::get('auth.cabang');

    //fetch function model
    $announcementTitle = Menu::select('id', 'name', 'icon')->findOrFail($menu_id);

    // buat untuk tidak duplicate
    if($cabang == null){
      $announcements = Announcement::with('menu:id', 'document_regional')->where('submenu_id', $menu_id)
      // ->whereHas('document_position', function ($q) use ($jbt) {
      //   $q->where('kd_jbt', $jbt);
      // })
      ->orderBy('tgl_berlaku', 'desc')
      ->distinct()
      ->select('id', 'submenu_id', 'title', 'no_surat', 'url', 'tgl_berlaku', 'created_at','created_by', 'updated_at', 'updated_by', 'content', 'type')
      ->get();
    }else{
      $announcements = Announcement::with('menu:id', 'document_regional')->where('submenu_id', $menu_id)
      ->whereHas('document_position', function ($q) use ($jbt) {
        $q->where('kd_jbt', $jbt);
      })
      ->whereHas('document_regional', function ($q) use ($cabang) {
        $q->where('regional_id', $cabang);
      })
      ->orderBy('tgl_berlaku', 'desc')
      ->distinct()
      ->select('id', 'submenu_id', 'title', 'no_surat', 'url', 'tgl_berlaku', 'created_at', 'content', 'type')
      ->get();
      
      
    }
    // $announcements = Announcement::with('menu:id', 'document_regional')->where('submenu_id', $menu_id)
    //   // ->whereHas('document_position', function ($q) use ($jbt) {
    //   //   $q->where('kd_jbt', $jbt);
    //   // })
    //   ->distinct()
    //   ->select('id', 'submenu_id', 'title', 'no_surat', 'url', 'tgl_berlaku', 'created_at', )
    //   ->get();
    


    $announcements->transform(function ($announcement) {
      // timezone
      $announcement->dateLastUpdate = $announcement->updated_at
        ? Carbon::parse($announcement->updated_at)->format('d M Y H:i:s') . ' WIB'
        : ($announcement->created_at
          ? Carbon::parse($announcement->created_at)->format('d M Y H:i:s') . ' WIB'
          : null);

      $announcement->tgl_berlaku = $announcement->tgl_berlaku
        ? Carbon::parse($announcement->tgl_berlaku)->format('d-m-Y')
        : null;

      return $announcement;
    });

    $mainTitle = $announcementTitle->name ?? 'Pengumuman';
    $mainIcon = $announcementTitle->icon ?? 'https://unpkg.com/heroicons@2.0.13/24/solid/document.svg';
    return response()->json([
      'success' => true,
      'detail' => [
        'title' => $mainTitle,
        'icon' => $mainIcon
      ],
      'items' => $announcements
    ]);
  }

  // public function detailById($menu_id, $document_id)
  // {
  //   dd($menu_id, $document_id);
  //   $jbt = Session::get('auth.idgrup');

  //   $announcement = Announcement::where('submenu_id', $menu_id)
  //     ->where('id', $document_id)
  //     ->whereHas('document_position', function($q) use ($jbt) {
  //       $q->where('kd_jbt', $jbt);
  //     })
  //     ->first();

  //   if (!$announcement) {
  //     return response()->json(['success' => false, 'message' => 'Announcement not found'], 404);
  //   }

  //   return response()->json(['success' => true, 'data' => $announcement]);
  // }

  public function store(Request $request)
  {
    // debugging validate
    try {
      //code...
      $validated = $request->validate([
        'submenu_id' => 'required|integer',
        'title' => 'required|string|max:255',
        'no_surat' => 'nullable|string|max:255',
        'type' => 'string|max:100',
        'content' => 'nullable|string',
        'dokumen' => 'required|file|mimes:word,pdf,xlsx|max:20480', // max 20MB
        'tgl_berlaku' => 'nullable|date',
        'regionals_id' => 'required|array',
        // nama jabatan kalo array
        'kd_jabatan' => 'required|array',
        'created_at' => 'nullable|date',
        'updated_at' => 'nullable|date',
      ]);

      // dd($request->all());

      // Simpan file hanya sekali
      $mainPath = Menu::getNameById($request->get('submenu_id'));
      $mainPath = $mainPath ? $mainPath : '';
      $file = $request->file('dokumen');
      $fileName = time() . '_' . $file->getClientOriginalName();
      $filePath = $file->storeAs("public/aktif/{$mainPath}", $fileName);
      $publicPath = str_replace('public/aktif/', '', $filePath);

      // Simpan data ke table announcement (sekali saja)
      $data = $validated;
      $data['created_at'] = Carbon::now('Asia/Jakarta');
      $data['url'] = $publicPath;
      unset($data['file']);
      unset($data['regionals_id']);
      $announcement = Announcement::create($data);

      // Simpan ke table document_region untuk setiap region
      $regions = $validated['regionals_id'];
      $regionRows = [];
      foreach ($regions as $regionId) {
        $regionRows[] = [
          'document_id' => $announcement->id,
          'regional_id' => $regionId,
        ];
      }

      // simpan ke table akese_jabatan
      $jabatan = $validated['kd_jabatan'];
      foreach ($jabatan as $jbt) {
        $jabatanRows[] = [
          'document_id' => $announcement->id,
          'kd_jbt' => $jbt,
          'created_by' => 'Created by ' . session('auth.user')
        ];
      }
      if (!empty($jabatanRows)) {
        \DB::table('document_position')->insert($jabatanRows);
      }

      if (!empty($regionRows)) {
        \DB::table('document_region')->insert($regionRows);
      }

      $announcement->user = 'Created by ' . session('auth.user');
      return response()->json([
        'success' => true,
        'message' => 'Announcement created successfully',
        'data' => $announcement
      ], 201);
    } catch (ValidationException $th) {
      //throw $th;
      return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $th->errors()], 422);
    }
  } 

  public function documentById($document_id)
  {
    // debugging validate
    // 
    try {
      $announcement = Announcement::select('id', 'title', 'submenu_id', 'no_surat' ,'url', 'created_at', 'updated_at', 'tgl_berlaku', 'type', 'content')->with('document_position:document_id,kd_jbt', 'menu:id,id_menu', 'document_regional')->where('id', $document_id)->firstOrFail();

      $announcement->content_url = env('ENV_MIX_URL') . $announcement->url;
      return response()->json(['success' => true, 'data' => $announcement]);
    } catch (\Exception $e) {
      return response()->json(['success' => false, 'message' => 'Announcement not found: ' . $e->getMessage()], 404);
    }

  }

  public function update(Request $request, $document_id)
  {
    // add request document_id
    $request->merge(['document_id' => (int)$document_id]);
    // dd($request->all());
    // debugging validate
    try {
      //code...
      $validated = $request->validate([
        'submenu_id' => 'required|integer',
        'title' => 'required|string|max:255',
        'no_surat' => 'nullable|string|max:255',
        'dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:20480', // max 20MB
        'type' => 'string|max:100',
        'content' => 'nullable|string|max:10000',
        'tgl_berlaku' => 'nullable|date',
        'regionals_id' => 'required|array',
        'kd_jabatan' => 'required|array',
        'created_at' => 'nullable|date',
        'updated_at' => 'nullable|date',
        'document_id' => 'required|integer'
      ]);

      $announcement = Announcement::findOrFail($validated['document_id']);

      // Jika ada file baru, simpan file baru dan hapus file lama
      if ($request->hasFile('dokumen')) {
        // Hapus file lama jika ada
        if ($announcement->url && Storage::exists('public/aktif/' . $announcement->url)) {
          Storage::delete('public/aktif/' . $announcement->url);
        }

        $mainPath = Menu::getNameById($request->get('submenu_id'));
        $mainPath = $mainPath ? $mainPath : '';
        $file = $request->file('dokumen');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs("public/aktif/{$mainPath}", $fileName);
        $publicPath = str_replace('public/aktif/', '', $filePath);
        $validated['url'] = $publicPath;
      } else {
        unset($validated['dokumen']); // Jangan update kolom dokumen jika tidak ada file baru
      }

      // Update data announcement
      $data = $validated;
      unset($data['document_id']);
      unset($data['regionals_id']);
      $data['updated_at'] = Carbon::now('Asia/Jakarta');
      $announcement->update($data);

      // Update document_region
      // Hapus dulu yang lama
      DocumentRegion::where('document_id', $announcement->id)->delete();

      // Simpan yang baru
      $regions = $validated['regionals_id'];
      $regionRows = [];
      foreach ($regions as $regionId) {
        $regionRows[] = [
          'document_id' => $announcement->id,
          'regional_id' => $regionId,
        ];
      }
      if (!empty($regionRows)) {
        DocumentRegion::insert($regionRows);
      }
      
      // update ke table akese_jabatan
      DocumentPosition::where('document_id', $announcement->id)->delete();
      $jabatanRows = [];
      // Simpan yang baru
      $jabatan = $validated['kd_jabatan'];
      foreach ($jabatan as $jbt) {
        $jabatanRows[] = [
          'document_id' => $announcement->id,
          'kd_jbt' => $jbt,
        ];
      }
      if (!empty($jabatanRows)) {
        DocumentPosition::insert($jabatanRows);
      }

      return response()->json([
        'message' => 'Announcement updated successfully',
        'data' => $announcement
      ], 200);
    } catch (ValidationException $th) {
      return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $th->errors()], 422);
    } catch (\Exception $e) {
      return response()->json(['success' => false, 'message' => 'Error occurred: ' . $e->getMessage()], 500);
    }
  }
  public function destroy($document_id)
  {
    // debugging validate
    try {
      
      
      $announcement = Announcement::findOrFail($document_id);
      
      if ($announcement->url && Storage::exists('public/aktif/' . $announcement->url)) {
        $currentPath = 'public/aktif/' . $announcement->url;
        $newPath = 'public/tidakaktif/' . $announcement->url;
        Storage::move($currentPath, $newPath);
      }
      
      $announcement->delete();

      return response()->json(['success' => true, 'message' => 'Announcement deleted successfully'], 200);
    } catch (\Exception $e) {
      return response()->json(['success' => false, 'message' => 'Error occurred'], 500);
    }
  }

  public function trash(Request $request)
  {
    // get query category
    $category = $request->query('category');

    // Untuk sekarang, tampilkan semua yang di-softdelete
    // buatkan where dari relasi menu

    $trashedAnnouncements = Announcement::with('menu')->onlyTrashed()->whereHas('menu', function ($q) use ($category) {
      $q->where('id_menu', $category);
    })->get();
    // $trashedAnnouncements = Announcement::with('menu')->onlyTrashed()->where('menu.id', $category)->get();
    return response()->json([
      'success' => true,
      'data' => $trashedAnnouncements
    ], 200);
  }

  public function restore($document_id)
  {
    try {
      $announcement = Announcement::onlyTrashed()->where('id', $document_id)->firstOrFail();
      
      if ($announcement->url && Storage::exists('public/tidakaktif/' . $announcement->url)) {
        $currentPath = 'public/tidakaktif/' . $announcement->url;
        $newPath = 'public/aktif/' . $announcement->url;
        Storage::move($currentPath, $newPath);
      }
      
      
      $announcement->restore();
      return response()->json(['status' => 'success', 'message' => 'Announcement restored successfully'], 200);
    } catch (\Exception $e) {
      return response()->json(['status' => 'error', 'message' => 'Internal Server Error'], 500);
    }
  }
  
  public function lastDocumentPreview($document_id)
{
    try {
        $announcement = Announcement::select('id', 'title', 'submenu_id', 'no_surat' ,'url', 'created_at', 'updated_at', 'tgl_berlaku', 'type', 'content')
            ->with('document_position:document_id,kd_jbt', 'menu:id,id_menu', 'document_regional')
            ->where('id', $document_id)
            ->firstOrFail();

        $announcementArr = [
            'id' => $announcement->id,
            'title' => $announcement->title,
            'url' => env('ENV_MIX_URL') . $announcement->url,
            'no_surat' => $announcement->no_surat,
            'tgl_berlaku' => $announcement->tgl_berlaku,
            'type' => $announcement->type,
            'accessed_at' => now()->toDateString(),
        ];

        $userKey = 'last_previewed_document_' . session('auth.user');
        $lastDocuments = Cache::get($userKey, []);

        // Hapus dokumen yang sudah ada jika dibuka lagi, agar tidak double
        $lastDocuments = array_filter($lastDocuments, function($doc) use ($announcementArr) {
            return $doc['id'] !== $announcementArr['id'];
        });

        // Tambahkan dokumen baru di depan
        array_unshift($lastDocuments, $announcementArr);

        // Batasi hanya 2 dokumen terakhir
        $lastDocuments = array_slice($lastDocuments, 0, 2);

        // Simpan ke cache dengan masa berlaku 7 hari
        Cache::put($userKey, $lastDocuments, now()->addDays(7));

        // Debug: tampilkan dokumen terakhir di cache
        // dd(Cache::get($userKey));

        return response()->json(['success' => true, 'data' => $announcementArr]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Announcement not found: ' . $e->getMessage()], 404);
    }
}

  // public function deletePermanent($document_id)
  // {
  //   try {
  //     $announcement = Announcement::onlyTrashed()->where('id', $document_id)->firstOrFail();

  //     // Hapus file terkait jika ada
  //     if ($announcement->url && Storage::exists('public/' . $announcement->url)) {
  //       Storage::delete('public/' . $announcement->url);
  //     }

  //     $announcement->forceDelete();
  //     return response()->json(['status' => 'success', 'message' => 'Announcement permanently deleted'], 200);
  //   } catch (\Exception $e) {
  //     return response()->json(['status' => 'error', 'message' => 'Internal Server Error'], 500);
  //   }

  // }
  
  
  public function hardDelete($document_id)
  {
    try {
      $announcement = Announcement::onlyTrashed()->where('id', $document_id)->firstOrFail();

      // Hapus file terkait jika ada
      if ($announcement->url && Storage::exists('public/tidakaktif/' . $announcement->url)) {
        Storage::delete('public/tidakaktif/' . $announcement->url);
      }

      $announcement->forceDelete();
      return response()->json(['status' => 'success', 'message' => 'Announcement permanently deleted'], 200);
    } catch (\Exception $e) {
      return response()->json(['status' => 'error', 'message' => 'Internal Server Error'], 500);
    }

  }
  
}
