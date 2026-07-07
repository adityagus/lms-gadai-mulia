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
        $user = session('auth');
        $jbt = $user['idgrup'] ?? null;
        $cabang = $user['cabang'] ?? null;

        // Hitung total pengumuman dan formulir berdasarkan menu_id masing-masing
        $total_pengumuman = Announcement::with('menu')
            ->forUser($jbt, $cabang)
            ->whereHas('menu', function($q){
                $q->where('id_menu', 1);
            })->count();
        
        $total_formulir = Announcement::with('menu')
            ->forUser($jbt, $cabang)
            ->whereHas('menu', function($q){
                $q->where('id_menu', 2);
            })->count();

        $total_courses = Course::count();

        $latest_documents = Announcement::with('menu')
            ->forUser($jbt, $cabang)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $usernames = $latest_documents->pluck('created_by')->filter()->unique()->toArray();

        $uploaderNames = [];
        if (!empty($usernames)) {
            $uploaderNames = DB::connection('db2')
                ->table('auth.users')
                ->whereIn('username', $usernames)
                ->pluck('full_name', 'username')
                ->toArray();
        }

        $latest_docs_data = $latest_documents->map(function($doc) use ($uploaderNames) {
            return [
                'id' => $doc->id,
                'title' => $doc->title,
                'submenu_id' => $doc->submenu_id,
                'url' => $doc->url,
                'tgl_berlaku' => $doc->tgl_berlaku,
                'content' => $doc->content,
                'type' => $doc->type,
                'no_surat' => $doc->no_surat,
                'created_at' => $doc->created_at ? $doc->created_at->toISOString() : null,
                'uploader_name' => $uploaderNames[$doc->created_by] ?? $doc->created_by ?? 'System',
                'menu' => $doc->menu ? [
                    'id' => $doc->menu->id,
                    'name' => $doc->menu->name,
                ] : null,
            ];
        });

        $stats = [
            'total_pengumuman' => $total_pengumuman,
            'total_courses' => $total_courses,
            'total_formulir' => $total_formulir,
            'active_in_last_7_days' => 12812,
        ];
        return response()->json([
            'success' => true,
            'stats' => $stats,
            'latest_documents' => $latest_docs_data,
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
    