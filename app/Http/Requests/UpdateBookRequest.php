<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine whether the user is authorized
     * to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        $bookId = $this->route('book')?->id;

        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'isbn' => [
                'required',
                'string',
                'max:50',
                Rule::unique('books', 'isbn')->ignore($bookId),
            ],

            'author_id' => [
                'required',
                'integer',
                'exists:authors,id',
            ],

            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Please enter the book title.',

            'isbn.required' => 'Please enter the ISBN.',

            'isbn.unique' => 'This ISBN already exists.',

            'author_id.required' => 'Please select an author.',

            'author_id.exists' => 'The selected author does not exist.',

            'category_id.required' => 'Please select a category.',

            'category_id.exists' => 'The selected category does not exist.',

            'quantity.required' => 'Please enter the book quantity.',

            'quantity.min' => 'Quantity cannot be negative.',

            'cover_image.image' => 'The cover must be a valid image.',

            'cover_image.mimes' => 'Cover image must be JPG, JPEG, PNG, or WEBP.',

            'cover_image.max' => 'Cover image cannot exceed 2 MB.',
        ];
    }
}