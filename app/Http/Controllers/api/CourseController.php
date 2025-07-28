<?php

namespace App\Http\Controllers\api;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Algolia\AlgoliaSearch\SearchClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request as FacadesRequest;

class CourseController extends Controller
{
  public function index(Request $request)
  {
    $page = $request->query('page', 1); // Get the page number from the query string, default to 1 if not provided

    $courses = Course::with('category:id,name')->paginate(5);
    
        // Loop through the courses and append the thumbnail URL
    $courses->getCollection()->transform(function ($course) {
        // Generate the full URL for the thumbnail (assuming the thumbnail is stored in public disk)
        $course->thumbnail_url = env('MIX_IMG_URL') . $course->thumbnail; // Use env variable for base URL
        //  Storage::url($course->thumbnail); // Adjust if storage path differs
        return $course;
    });
    
    $courses->appends(['thumbnail_url' => $page]); // Append the page number to the pagination links
    
    return response()->json($courses);
  }
  
  public function search(Request $request)
  {
$courses = Course::with('category:id,name')->get(); // Ambil data sebagai collection

    // Transform data agar sesuai dengan Algolia
    $algoliaCourses = $courses->map(function ($course) {
      return [
        'objectID' => $course->id,
        'title' => $course->name,
        'tagline' => $course->tagline,
        'description' => $course->description,
        'category' => $course->category ? $course->category->name : null,
        'thumbnail_url' => env('MIX_IMG_URL') . $course->thumbnail,
      ];
    })->toArray();

    // Push ke Algolia
    $client = SearchClient::create('V18ENC6M06', 'c2ca39153191af8d720b24257772d170'); // Gunakan Admin API Key
    $index = $client->initIndex('course_gadai_mulia');
    $index->saveObjects($algoliaCourses);

    return response()->json([
      'success' => true,
      'uploaded' => count($algoliaCourses)
    ]);
    
    // $courses = Course::with('category:id,name')->get();
    // $courses->getCollection()->transform(function ($course) {
    //     $course->thumbnail_url = env('MIX_IMG_URL') . $course->thumbnail; // Use env variable for base URL
    //     return $course;
    // });
    // return response()->json($courses);
  }

  public function show(Request $request, $id)
  {
    $page = $request->query('page', 1); // Get the page number from the query string, default to 1 if not provided
    

    $course = Course::with('category:id,name')->find($id);
    if (!$course) {
      return response()->json(['message' => 'Course not Found'], 400);
    }
    $contents = $course->contents()->orderBy('order')->paginate(5, ['*'], 'page', $page); // 5 konten per halaman
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
      'category_id' => 'required|integer',  // This ensures 1 or 0 is provided
      'is_popular' => 'required|boolean',  // This ensures 1 or 0 is provided
      'students' => 'nullable|json', // Assuming students is a JSON field
      'details' => 'nullable|json', // Assuming details is a JSON field
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

    return response()->json([
      "status" => 201,
      "message" => "Course created successfully",
      "data" => $course
    ]);
  }

  public function update(Request $request, $id)
{
  
    // Validasi data yang diterima dari request
    // Log the incoming request data to see the contents
    // Log::debug('Incoming request:', $request->all());
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'tagline' => 'required|string',
      'description' => 'required|string|max:500',
      'category_id' => 'required|integer',  // This ensures 1 or 0 is provided
      'is_popular' => 'required|boolean',  // This ensures 1 or 0 is provided
      'students' => 'nullable|json', // Assuming students is a JSON field
      'details' => 'nullable|json', // Assuming details is a JSON field
    ]);
    // Mencari kursus berdasarkan ID
    $course = Course::findOrFail($id);

    // Jika nama kursus diubah, buat slug baru
    if ($validated['name'] != $course->name) {
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;
        while (Course::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        $course->slug = $slug;  // Update slug
    }

    // Jika thumbnail di-upload, simpan file baru dan hapus file lama (jika ada)
    if ($request->hasFile('thumbnail')) {
        $thumbnailPath = Course::uploadThumbnail($request->file('thumbnail'));
        // Hapus thumbnail lama jika ada
        if ($course->thumbnail && file_exists(public_path($course->thumbnail))) {
            unlink(public_path($course->thumbnail));  // Menghapus file thumbnail lama
        }
        $course->thumbnail = $thumbnailPath;  // Update thumbnail
    }

    // Mengupdate data kursus
    $course->name = $validated['name'];
    $course->tagline = $validated['tagline'];
    $course->description = $validated['description'];
    $course->category_id = $validated['category_id'];
    $course->is_popular = $validated['is_popular'];
    $course->students = $validated['students'] ?? $course->students;  // Jika 'students' tidak diubah, biarkan yang lama
    $course->save();

    return response()->json([
        "status" => 200,
        "message" => "Course updated successfully",
        "data" => $course
    ]);
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


    return response()->json([
      'status' => 200,
      'message' => 'Course deleted successfully'
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
  
}
