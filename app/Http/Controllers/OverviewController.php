<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Course;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class OverviewController extends Controller
{
    public function adminOverview()
    {
        // Dummy data, replace with actual queries if needed
        // Hitung total pengumuman dan formulir berdasarkan menu_id masing-masing
        $total_pengumuman = Announcement::with('menu')->whereHas('menu', function($q){
          $q->where('id_menu', 1);
        })->count();
        
        $total_formulir = Announcement::with('menu')->whereHas('menu', function($q){
          $q->where('id_menu', 2);
        })->count();

        $total_courses = Course::count();

        $stats = [
            'total_pengumuman' => $total_pengumuman,
            'total_courses' => $total_courses,
            'total_formulir' => $total_formulir,
            'active_in_last_7_days' => 12812,
        ];
        return response()->json([
            'success' => true,
            'stats' => $stats,
            'message' => 'Overview data loaded successfully.'
        ]);
    }

    public function userOverview()
    {
        $user = session('auth');
        $stats = [
            'courses_joined' => 3,
            'documents_accessed' => 12,
        ];
        $last_courses = Cache::get('last_previewed_course_' . session('auth.user')) ? [Cache::get('last_previewed_course_' . session('auth.user'))] : [];

        $last_documents = cache()->get('last_previewed_document_' . session('auth.user')) ? cache()->get('last_previewed_document_' . session('auth.user')) : [];
        return response()->json([
            'user' => $user,
            'stats' => $stats,
            'last_courses' => $last_courses,
            'last_documents' => $last_documents,
        ]);
    }
}
    