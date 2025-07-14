<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class CourseController extends Controller
{
    public function index(Request $request){
      $page = $request->query('page', 1);
      
      $courses = Course::paginate(5);
      
      return response()->json($courses);
    }
    
    public function show($id){
      $course = Course::find($id);
      
      if(!$course){
        return response()->json(['message' => 'Course not Found'], 400);
      }
      
      return response()->json($course);
    }

    public function store(Request $request)
    {
      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:courses',  // Ensure the slug is unique
        'thumbnail' => 'required|string|max:255',
        'about' => 'required|string|max:500',
        'category_id' => 'required|integer',  // This ensures 1 or 0 is provided
        'is_popular' => 'required|boolean',  // This ensures 1 or 0 is provided
      ]);
    // }
    // public function store(Request $request)
    // {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'tagline'     => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'thumbnail'   => 'required|image|max:2048', // ≤2 MB
        ]);

        // simpan file
        $data['thumbnail'] = $request->file('thumbnail')
                                     ->store('courses', 'public');

        $course = Course::create($data);

        return response()->json($course, 201);
    


      $course = Course::create($validated);
      return response()->json([
        "status" => 201,
        "data" => $course
      ]);
      
    }
    
    public function update(Request $request, $id){
      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'thumbnail' => 'required|string|max:255',
        'about' => 'required|string|max:500',
        'category_id' => 'required|integer',
        'is_popular' => 'required|boolean',  // This ensures 1 or 0 is provided
      ]);
      
      $content = Course::findOrFail($id);
      // var_dump($content);die;
      
      if(!$content){
        return response()->json(['message' => "Course not found"], 400);
      }
      
      
      $content->update($validated);
      return response()->json($content, 200);
    }
    
    public function destroy($id){
      $course = Course::find($id);
      
      if(!$course){
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
    
    
}
