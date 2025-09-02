<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Announcement;
use Algolia\AlgoliaSearch\SearchClient;
use Illuminate\Support\Facades\Log;

class AlgoliaService
{
    /**
     * Refresh Algolia index for both courses and documents (announcements)
     */
    public function refresh(Request $request)
    {
        $client = SearchClient::create('V18ENC6M06', 'c2ca39153191af8d720b24257772d170');
        $index = $client->initIndex('course_gadai_mulia');

        // Courses
        $courses = Course::with('category:id,name')->get();
        $algoliaCourses = $courses->map(function ($course) {
            return [
                'objectID' => 'course_' . $course->id,
                'id' => $course->id,
                'type' => 'course',
                'title' => $course->name,
                'tagline' => $course->tagline,
                'description' => $course->description,
                'category' => $course->category ? $course->category->name : null,
                'thumbnail_url' => env('MIX_IMG_URL') . $course->thumbnail,
            ];
        })->toArray();

        // Documents (Announcements)
        $documents = Announcement::all();
        $algoliaDocuments = $documents->map(function ($doc) {
            return [
                'objectID' => 'document_' . $doc->id,
                'id' => $doc->id,
                'type' => 'document',
                'title' => $doc->title,
                'tagline' => $doc->no_surat ?? '',
                'description' => $doc->content ?? '',
                'category' => 'Document',
                'thumbnail_url' => env('MIX_IMG_URL') . ($doc->url ?? ''),
            ];
        })->toArray();

        // Merge and push to Algolia
        $allObjects = array_merge($algoliaCourses, $algoliaDocuments);
        $index->clearObjects();
        $index->saveObjects($allObjects);

        return response()->json([
            'success' => true,
            'courses_uploaded' => count($algoliaCourses),
            'documents_uploaded' => count($algoliaDocuments),
            'total_uploaded' => count($allObjects),
            'message' => 'Algolia index refreshed with latest courses and documents.'
        ]);
    }

    /**
     * Update or add a single course to Algolia
     */
    public function updateCourse($course)
    {
        try {
            $course->load('category');
            $client = SearchClient::create('V18ENC6M06', 'c2ca39153191af8d720b24257772d170');
            $index = $client->initIndex('course_gadai_mulia');
            $algoliaData = [
                'objectID' => 'course_' . $course->id,
                'id' => $course->id,
                'type' => 'course',
                'title' => $course->name,
                'tagline' => $course->tagline,
                'description' => $course->description,
                'category' => $course->category ? $course->category->name : null,
                'thumbnail_url' => env('MIX_IMG_URL') . $course->thumbnail,
            ];
            $index->saveObject($algoliaData);
            Log::info('Algolia index updated for course: ' . $course->id);
        } catch (\Exception $e) {
            Log::error('Failed to update Algolia index for course: ' . $e->getMessage());
        }
    }

    /**
     * Update or add a single document (announcement) to Algolia
     */
    public function updateDocument($document)
    {
        try {
            $client = SearchClient::create('V18ENC6M06', 'c2ca39153191af8d720b24257772d170');
            $index = $client->initIndex('course_gadai_mulia');
            $algoliaData = [
                'objectID' => 'document_' . $document->id,
                'id' => $document->id,
                'type' => 'document',
                'title' => $document->title,
                'tagline' => $document->no_surat ?? '',
                'description' => $document->content ?? '',
                'category' => 'Document',
                'thumbnail_url' => env('MIX_IMG_URL') . ($document->url ?? ''),
            ];
            $index->saveObject($algoliaData);
            Log::info('Algolia index updated for document: ' . $document->id);
        } catch (\Exception $e) {
            Log::error('Failed to update Algolia index for document: ' . $e->getMessage());
        }
    }

    /**
     * Delete a course or document from Algolia by type and id
     */
    public function deleteFromAlgolia($type, $id)
    {
        try {
            $client = SearchClient::create('V18ENC6M06', 'c2ca39153191af8d720b24257772d170');
            $index = $client->initIndex('course_gadai_mulia');
            $objectID = $type . '_' . $id;
            $index->deleteObject($objectID);
            Log::info('Deleted from Algolia: ' . $objectID);
        } catch (\Exception $e) {
            Log::error('Failed to delete from Algolia: ' . $e->getMessage());
        }
    }
}
