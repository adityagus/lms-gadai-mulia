<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_id' => 'required|integer|exists:courses,id',
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:text,video,pdf,quiz',
            'content' => 'nullable|string',
            'order' => 'required|integer|min:1', // Order required for create
            // 'created_by' => 'required|integer|exists:users,id',
            // 'updated_by' => 'nullable|integer|exists:users,id',
        ];
    }
    
    public function messages()
    {
        return [
            'course_id.required' => 'Course ID is required.',
            'course_id.integer' => 'Course ID must be a number.',
            'course_id.exists' => 'The selected course does not exist.',
            'title.required' => 'Title is required.',
            'type.required' => 'Content type is required.',
            'type.in' => 'Content type must be one of: text, video, pdf, quiz.',
            'order.required' => 'Order is required.',
            'order.integer' => 'Order must be a number.',
            'order.min' => 'Order must be at least 1.',
        ];
    }
}
