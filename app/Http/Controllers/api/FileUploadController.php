<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // max 10MB
        ]);

        $path = $request->file('file')->store('uploads/courses', 'public');

        return response()->json([
            'message' => 'File uploaded successfully',
            'path' => $path,
        ]);
    }
}
