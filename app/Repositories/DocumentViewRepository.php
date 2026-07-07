<?php

namespace App\Repositories;

use App\Contracts\Repositories\DocumentViewRepositoryInterface;
use App\Models\DocumentView;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DocumentViewRepository implements DocumentViewRepositoryInterface
{
    /**
     * @var DocumentView
     */
    protected $model;

    /**
     * DocumentViewRepository Constructor.
     *
     * @param DocumentView $model
     */
    public function __construct(DocumentView $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function recordView(string $username, int $documentId): void
    {
        $now = now();
        
        // Menggunakan SQL raw untuk efisiensi Upsert MySQL tanpa memicu SELECT query tambahan
        DB::statement("
            INSERT INTO document_views (username, document_id, first_viewed_at, last_viewed_at, view_count, created_at, updated_at)
            VALUES (?, ?, ?, ?, 1, ?, ?)
            ON DUPLICATE KEY UPDATE 
                last_viewed_at = VALUES(last_viewed_at),
                view_count = view_count + 1,
                updated_at = VALUES(updated_at)
        ", [$username, $documentId, $now, $now, $now, $now]);
    }

    /**
     * @inheritDoc
     */
    public function hasViewed(string $username, int $documentId): bool
    {
        return $this->model->where('username', $username)
            ->where('document_id', $documentId)
            ->exists();
    }

    /**
     * @inheritDoc
     */
    public function getUsersWhoHaveNotViewed(int $documentId): Collection
    {
        // 1. Ambil semua user aktif dari database eksternal (db2)
        $allUsers = DB::connection('db2')
            ->table('auth.users as a')
            ->select('a.username', 'a.full_name')
            ->join('master.employee as b', 'a.employee_id', '=', 'b.employee_id')
            ->where('a.is_active', '=', 'true') // DB pgsql boolean value check
            ->get();

        // 2. Ambil username yang sudah melihat dokumen Y
        $viewedUsernames = $this->model->where('document_id', $documentId)
            ->pluck('username')
            ->toArray();

        // 3. Filter user yang BELUM melihat dokumen Y
        return $allUsers->reject(function ($user) use ($viewedUsernames) {
            return in_array($user->username, $viewedUsernames);
        })->values();
    }

    /**
     * @inheritDoc
     */
    public function getUsersWhoHaveViewed(int $documentId): Collection
    {
        // 1. Ambil data viewed records untuk document_id ini
        $views = $this->model->where('document_id', $documentId)->get();
        if ($views->isEmpty()) {
            return collect();
        }

        $usernames = $views->pluck('username')->toArray();

        // 2. Ambil user profile dari db2 -> auth.users
        $users = DB::connection('db2')
            ->table('auth.users as a')
            ->select('a.username', 'a.full_name')
            ->join('master.employee as b', 'a.employee_id', '=', 'b.employee_id')
            ->whereIn('a.username', $usernames)
            ->get();

        // 3. Gabungkan info tracking view (first_viewed_at, last_viewed_at, view_count)
        $viewsByUsername = $views->keyBy('username');

        return $users->map(function ($user) use ($viewsByUsername) {
            $viewInfo = $viewsByUsername->get($user->username);
            if ($viewInfo) {
                $user->first_viewed_at = $viewInfo->first_viewed_at ? $viewInfo->first_viewed_at->toDateTimeString() : null;
                $user->last_viewed_at = $viewInfo->last_viewed_at ? $viewInfo->last_viewed_at->toDateTimeString() : null;
                $user->view_count = $viewInfo->view_count;
            }
            return $user;
        });
    }

    /**
     * @inheritDoc
     */
    public function getDocumentViewStats(): Collection
    {
        // Menghitung statistik keterbacaan per dokumen
        return DB::table('documents as d')
            ->leftJoin('document_views as dv', 'd.id', '=', 'dv.document_id')
            ->select(
                'd.id as document_id',
                'd.title as document_title',
                'd.no_surat as document_no_surat',
                DB::raw('COUNT(dv.username) as total_users_read'),
                DB::raw('IFNULL(SUM(dv.view_count), 0) as total_clicks')
            )
            ->whereNull('d.deleted_at')
            ->groupBy('d.id', 'd.title', 'd.no_surat')
            ->get();
    }
}
