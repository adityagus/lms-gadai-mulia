<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Services\CourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CourseController extends Controller
{
    /**
     * @var CourseService
     */
    protected $courseService;

    /**
     * CourseController Constructor.
     *
     * @param CourseService $courseService
     */
    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * Display a listing of courses.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $courses = $this->courseService->getCoursesPaginated((int) $page);

        return CourseResource::collection($courses);
    }

    /**
     * Display the specified course with contents.
     *
     * @param Request $request
     * @param int|string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $page = $request->query('page', 1);
        $result = $this->courseService->getCourseWithContents((int) $id, (int) $page);

        return response()->json([
            'course' => new CourseResource($result['course']),
            'contents' => $result['contents']
        ]);
    }

    /**
     * Display the specified course contents for preview.
     *
     * @param int|string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function preview($id)
    {
        $result = $this->courseService->previewCourse((int) $id);

        return response()->json([
            'course' => new CourseResource($result['course']),
            'contents' => $result['contents']
        ]);
    }

    /**
     * Store a newly created course in storage.
     *
     * @param StoreCourseRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCourseRequest $request)
    {
        $course = $this->courseService->createCourse(
            $request->validated(),
            $request->file('thumbnail')
        );

        return response()->json([
            'status' => 201,
            'message' => 'Course created successfully',
            'data' => new CourseResource($course)
        ]);
    }

    /**
     * Update the specified course in storage.
     *
     * @param UpdateCourseRequest $request
     * @param int|string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCourseRequest $request, $id)
    {
        try {
            $course = $this->courseService->updateCourse(
                (int) $id,
                $request->validated(),
                $request->file('thumbnail')
            );

            return response()->json([
                'status' => 200,
                'message' => 'Course updated successfully',
                'data' => new CourseResource($course)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update course: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified course from storage.
     *
     * @param int|string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->courseService->deleteCourse((int) $id);

            return response()->json([
                'status' => 200,
                'message' => 'Course deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Course not found'
            ], 400);
        }
    }

    /**
     * Search courses and documents.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'Query parameter is required',
                'data' => []
            ]);
        }

        $jbt = Session::get('auth.idgrup');
        $cabang = Session::get('auth.cabang');

        $result = $this->courseService->search($query, $jbt, $cabang);

        $courseResults = $result['courses']->map(function ($course) {
            return [
                'id' => $course->id,
                'title' => $course->name,
                'tagline' => $course->tagline,
                'description' => $course->description,
                'category' => $course->category ? $course->category->name : null,
                'thumbnail_url' => config('services.mix.img_url') . $course->thumbnail,
                'type' => 'course',
            ];
        });

        $documentResults = $result['documents']->map(function ($doc) {
            return [
                'id' => $doc->id,
                'title' => $doc->title,
                'tagline' => $doc->no_surat ?? '',
                'description' => $doc->content ?? '',
                'submenu_id' => $doc->submenu_id,
                'tgl_berlaku' => $doc->tgl_berlaku,
                'url' => $doc->url,
                'no_surat' => $doc->no_surat,
                'content' => $doc->content,
                'menu' => $doc->menu ? $doc->menu->name : null,
                'category' => $doc->menu ? $doc->menu->name : null,
                'thumbnail_url' => $doc->menu ? $doc->menu->icon : null,
                'type' => $doc->type,
            ];
        });

        return response()->json([
            'success' => true,
            'courses' => $courseResults,
            'documents' => $documentResults,
            'total' => $courseResults->count() + $documentResults->count(),
        ]);
    }
}
