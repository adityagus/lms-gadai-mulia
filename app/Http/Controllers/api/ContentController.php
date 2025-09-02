<?php

namespace App\Http\Controllers\api;

use App\Models\Course;
use App\Models\Content;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContentRequest;
use App\Http\Requests\UpdateContentRequest;

class ContentController extends Controller
{
    public function index(Request $request, $courseId)
    {
        // Fetch contents related to the course
        $contents = Content::where('course_id', $courseId)->get();

        $contents->transform(function ($content) {
            $content->user_name = $content->user ? $content->user->name : 'Unknown';
            return $content;
        });

        return response()->json($contents);
    }
    
    public function getContentByCourseId($courseId)
    {
        $content = Content::where('course_id', $courseId)->get();

        return response()->json($content);
    }
    
    public function show($id)
    {
        $content = Content::find($id);
        if (!$content) {
            return response()->json(['message' => 'Content not Found'], 404);
        }
        
        $content->user_name = $content->user ? $content->user->name : 'Unknown';
        
        return response()->json($content);
    }

    
    public function store(StoreContentRequest $request){
      $validated = $request->validated();
      
      // Jika type == 'pdf' dan ada file, upload file dan simpan path-nya
      if ($request->get('type') === 'pdf' && $request->hasFile('content')) {
          $contentPath = Content::uploadContent($request->file('content'));
          $validated['content'] = $contentPath;
      }else if($request->get('type') === 'text' && $request->hasFile('lampiran')){
        $lampiranPath = Content::uploadLampiran($request->file('lampiran'));
        $validated['lampiran'] = $lampiranPath;
      }else{
        $validated['content'] = $request->get('content', null); 
      }

      $contents = Content::create($validated);

      return response()->json([
        'message' => 'Content created successfully',
        'data' => $contents,
        'status' => 201
      ]);
    }
    
    public function update(UpdateContentRequest $request, $id)
    {
        // Debug: Log received data
        // \Log::info('Update Content Request:', $request->all());
        // \Log::info('Update Content ID:', $id);
        
        $content = Content::find($id);
        if (!$content) {
            return response()->json(['message' => 'Content not Found'], 404);
        }

        $validated = $request->validated();

        // Jika type == 'pdf' dan ada file, upload file dan simpan path-nya
        if ($request->get('type') === 'pdf' && $request->hasFile('content')) {
            $contentPath = Content::uploadContent($request->file('content'));
            $validated['content'] = $contentPath;
        } else {
            $validated['content'] = $request->get('content', null); // Jika bukan pdf, ambil string content
        }

        $content->update($validated);

        return response()->json([
            'message' => 'Content updated successfully',
            'data' => $content
        ]);
    }
    
    public function destroy($id)
    {
        $content = Content::find($id);
        if (!$content) {
            return response()->json(['message' => 'Content not Found'], 404);
        }
        
        $content->delete();
        
        return response()->json([
            'message' => 'Content deleted successfully'
        ]);
    }
    
    
}
