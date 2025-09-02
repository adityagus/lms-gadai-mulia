<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\AlgoliaController;
use App\Models\Course;
use App\Models\Category;
use App\Services\AlgoliaService;
use Illuminate\Support\Str;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Algolia\AlgoliaSearch\SearchClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request as FacadesRequest;
class CourseController extends Controller
{
  public function index(Request $request)
  {
    $page = $request->query('page', 1); // Get the page number from the query string, default to 1 if not provided
    $cacheKey = 'courses.page.' . $page;

    $courses = Cache::remember($cacheKey, now()->addDay(), function () {
      return Course::with('category:id,name')->paginate(5);
    });

    // Loop through the courses and append the thumbnail URL
    collect($courses->items())->transform(function ($course) {
      // Generate the full URL for the thumbnail (assuming the thumbnail is stored in public disk)
      $baseUrl = config('app.img_url', asset('storage/'));
      $course->thumbnail_url = $baseUrl . '/' . ltrim($course->thumbnail, '/');

      //  Storage::url($course->thumbnail); // Adjust if storage path differs
      return $course;
    });

    $courses->appends(['thumbnail_url' => $page]); // Append the page number to the pagination links

    return response()->json($courses);
  }

  public function show(Request $request, $id)
  {
    $page = $request->query('page', 1); // Get the page number from the query string, default to 1 if not provided


    $course = Course::with('category:id,name')->find($id);
    if (!$course) {
      return response()->json(['message' => 'Course not Found'], 400);
    }
    $contents = $course->contents()->orderBy('order', 'asc')->paginate(5, ['*'], 'page', $page); // 5 konten per halaman
    $courseArr = $course->toArray();
    $courseArr['thumbnail_url'] = asset('storage/' . $course->thumbnail);
    return response()->json([
      'course' => $courseArr,
      'contents' => $contents
    ]);

  }

  public function preview($id)
  {
    $course = Course::with('category:id,name')->find($id);
    if (!$course) {
      return response()->json(['message' => 'Course not Found'], 400);
    }
    $contents = $course->contents()->orderBy('order')->get();
    $courseArr = $course->toArray();
    $courseArr['thumbnail_url'] = asset('storage/' . $course->thumbnail);
    return response()->json([
      'course' => $courseArr,
      'contents' => $contents
    ]);

  }

  public function store(Request $request)
  {

    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'tagline' => 'required|string',
      'description' => 'required|string|max:500',
      'category_id' => 'required|integer',
      'is_popular' => 'required|boolean',
      'students' => 'nullable|json',
      'details' => 'nullable|json',
    ]);

    // Membuat slug secara otomatis
    $slug = Str::slug($validated['name']);

    // Jika slug sudah ada di database, tambahkan angka untuk membuatnya unik
    $originalSlug = $slug;
    $count = 1;
    while (Course::where('slug', $slug)->exists()) {
      $slug = $originalSlug . '-' . $count;
      $count++;
    }

    // Menggunakan metode upload dari model Course untuk menyimpan file
    $thumbnailPath = Course::uploadThumbnail($request->file('thumbnail'));

    // Simpan data kursus ke dalam database
    $course = new Course();
    $course->name = $validated['name'];
    $course->slug = $slug;
    $course->students = 'null'; // Menyimpan data siswa jika ada
    $course->details = 'null'; // Menyimpan data siswa jika ada
    $course->tagline = $validated['tagline'];  // Menyimpan path file thumbnail
    $course->thumbnail = $thumbnailPath;  // Menyimpan path file thumbnail
    $course->description = $validated['description'];
    $course->category_id = $validated['category_id'];
    $course->is_popular = 0;
    $course->save();

    // Update Algolia index setelah create
    $algoliaController = new AlgoliaService();
    $algoliaController->updateCourse($course);

    return response()->json([
      "status" => 201,
      "message" => "Course created successfully",
      "data" => $course
    ]);
  }

  public function categories()
  {
    $categories = Category::select('id', 'name')->get();

    if ($categories->isEmpty()) {
      return response()->json(['message' => 'No categories found'], 404);
    }

    return response()->json($categories, 200);
  }

  public function update(Request $request, $id)
  {
    try {
      // Validasi data yang diterima dari request
      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'tagline' => 'required|string',
        'description' => 'required|string|max:500',
        'category_id' => 'required|integer',
        'is_popular' => 'required|boolean',
        'students' => 'nullable|string',
        'details' => 'nullable|string',
      ]);
      // Mencari kursus berdasarkan ID
      $course = Course::findOrFail($id);

      // Jika nama kursus diubah, buat slug baru
      if ($validated['name'] != $course->name) {
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;
        // Exclude current course dari pengecekan slug
        while (Course::where('slug', $slug)->where('id', '!=', $id)->exists()) {
          $slug = $originalSlug . '-' . $count;
          $count++;
        }
        $course->slug = $slug;
      }

      // Jika thumbnail di-upload, simpan file baru dan hapus file lama (jika ada)
      if ($request->hasFile('thumbnail')) {
        $thumbnailPath = Course::uploadThumbnail($request->file('thumbnail'));

        // Hapus thumbnail lama jika ada
        if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
          Storage::disk('public')->delete($course->thumbnail);
        }

        $course->thumbnail = $thumbnailPath;
      }

      // Mengupdate data kursus
      $course->name = $validated['name'];
      $course->tagline = $validated['tagline'];
      $course->description = $validated['description'];
      $course->category_id = $validated['category_id'];
      $course->is_popular = $validated['is_popular'];

      // Update students dan details jika ada
      if (isset($validated['students'])) {
        $course->students = $validated['students'];
      }
      if (isset($validated['details'])) {
        $course->details = $validated['details'];
      }

      $course->save();

      // Update Algolia index setelah update
      $algoliaController = new AlgoliaService();
      $algoliaController->updateCourse($course);

      // Return course dengan thumbnail URL
      $courseData = $course->toArray();
      $courseData['thumbnail_url'] = asset('storage/' . $course->thumbnail);

      return response()->json([
        "status" => 200,
        "message" => "Course updated successfully",
        "data" => $courseData
      ]);

    } catch (\Exception $e) {
      Log::error('Update course error:', ['message' => $e->getMessage()]);

      return response()->json([
        "status" => 500,
        "message" => "Failed to update course: " . $e->getMessage()
      ], 500);
    }
  }


  public function destroy($id)
  {
    $course = Course::find($id);

    if (!$course) {
      return response()->json([
        'status' => 400,
        'message' => 'Course not found'
      ], 400);
    }
    $courses = Course::paginate(5);
    $course->delete();

    // Hapus dari Algolia index setelah delete
    $algoliaController = new AlgoliaService();
    $algoliaController->deleteFromAlgolia('course', $id);

    return response()->json([
      'status' => 200,
      'message' => 'Course deleted successfully'
    ]);
  }


  public function search(Request $request)
  {
    $query = $request->get('q', '');

    if (empty($query)) {
      return response()->json([
        'success' => false,
        'message' => 'Query parameter is required',
        'data' => []
      ]);
    }

    // Search courses
    $courses = Course::with('category:id,name')
      ->where('name', 'LIKE', "%{$query}%")
      ->orWhere('tagline', 'LIKE', "%{$query}%")
      ->orWhere('description', 'LIKE', "%{$query}%")
      ->orWhereHas('category', function ($q) use ($query) {
        $q->where('name', 'LIKE', "%{$query}%");
      })
      ->limit(10)
      ->get();

    // Search documents (announcements)
    $documents = Announcement::with('menu') ->where(function($q) use ($query) {
        $q->where('title', 'LIKE', "%{$query}%")
          ->orWhere('no_surat', 'LIKE', "%{$query}%");
          // ->orWhere('menu.name', 'LIKE', "%{$query}%");
      })
      ->limit(10)
      ->get();

    // Transform data untuk response
    $courseResults = $courses->map(function ($course) {
      return [
        'id' => $course->id,
        'title' => $course->name,
        'tagline' => $course->tagline,
        'description' => $course->description,
        'category' => $course->category ? $course->category->name : null,
        'thumbnail_url' => env('MIX_IMG_URL') . $course->thumbnail,
        'type' => 'course',
      ];
    });

    $documentResults = $documents->map(function ($doc) {
      return [
        'id' => $doc->id,
        'title' => $doc->title,
        'tagline' => $doc->no_surat ?? '',
        'description' => $doc->content ?? '',
        'category' => 'Document',
        'thumbnail_url' => "https://unpkg.com/heroicons@2.0.13/24/solid/document.svg",
        'type' => 'document',
      ];
    });

    return response()->json([
      'success' => true,
      'courses' => $courseResults,
      'documents' => $documentResults,
      'total' => $courseResults->count() + $documentResults->count(),
    ]);
  }

  private function updateAlgoliaIndex($course)
  {
    try {
      // Load relasi category jika belum di-load
      $course->load('category');

      $client = SearchClient::create('V18ENC6M06', 'c2ca39153191af8d720b24257772d170');
      $index = $client->initIndex('course_gadai_mulia');

      $algoliaData = [
        'objectID' => $course->id,
        'title' => $course->name,
        'tagline' => $course->tagline,
        'description' => $course->description,
        'category' => $course->category ? $course->category->name : null,
        'thumbnail_url' => env('MIX_IMG_URL') . $course->thumbnail,
      ];

      $index->saveObject($algoliaData);

      Log::info('Algolia index updated for course: ' . $course->id);
    } catch (\Exception $e) {
      Log::error('Failed to update Algolia index: ' . $e->getMessage());
    }
  }

  /**
   * Hapus course dari Algolia index
   */
  private function deleteFromAlgoliaIndex($courseId)
  {
    try {
      $client = SearchClient::create('V18ENC6M06', 'c2ca39153191af8d720b24257772d170');
      $index = $client->initIndex('course_gadai_mulia');

      $index->deleteObject($courseId);

      Log::info('Course deleted from Algolia index: ' . $courseId);
    } catch (\Exception $e) {
      Log::error('Failed to delete from Algolia index: ' . $e->getMessage());
    }
  }

}
