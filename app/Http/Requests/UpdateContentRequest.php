<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContentRequest extends FormRequest
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
            'course_id' => 'sometimes|integer|exists:courses,id', // sometimes = optional but validated if present
            'title' => 'sometimes|string|max:255',
            'type' => 'sometimes|string|in:text,video,pdf,quiz',
            'content' => 'nullable|string',
            'order' => 'sometimes|integer|min:1',
            // 'created_by' => 'sometimes|integer|exists:users,id',
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
            'order.integer' => 'Order must be a number.',
            'order.min' => 'Order must be at least 1.',
        ];
    }
}
