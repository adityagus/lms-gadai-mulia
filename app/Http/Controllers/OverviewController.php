<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OverviewController extends Controller
{
    public function index()
    {
        // Dummy data, replace with actual queries if needed
        $stats = [
            'active_users' => 189498,
            'total_courses' => 7221,
            'video_content' => 893891,
            'text_content' => 12812,
            'completed_percent' => 75,
            'not_completed_percent' => 25,
        ];
        return response()->json([
            'success' => true,
            'stats' => $stats,
            'message' => 'Overview data loaded successfully.'
        ]);
    }

    public function userOverview()
    {
        $user = [
            'id' => 1,
            'name' => 'User',
        ];
        $stats = [
            'courses_joined' => 3,
            'documents_accessed' => 12,
        ];
        $last_courses = session()->get('last_previewed_course_' . session('auth.user'));
        $last_documents = [
            [
                'id' => 1,
                'title' => 'Panduan SOP',
                'accessed_at' => '2025-09-10',
            ],
            [
                'id' => 2,
                'title' => 'Formulir Pengajuan',
                'accessed_at' => '2025-09-08',
            ],
        ];
        return response()->json([
            'user' => $user,
            'stats' => $stats,
            'last_courses' => $last_courses,
            'last_documents' => $last_documents,
        ]);
    }
}
    