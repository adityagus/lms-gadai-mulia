<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        // $request->validate([
        //     'file' => 'required|file|max:10240', // max 10MB
        // ]);
        $request->validate([
            'thumbnail' => 'required|file|mimes:jpeg,png,jpg,gif,pdf,docx|max:2048',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'tagline' => 'nullable|string|max:255',
            'categoryId' => 'required|integer',
            'description' => 'nullable|string|max:500',
        ]);


        $path = $request->file('file')->store('uploads/courses', 'public');

        return response()->json([
            'message' => 'File uploaded successfully',
            'path' => $path,
        ]);
    }
}
