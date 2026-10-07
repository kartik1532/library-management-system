<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBorrowingRequest extends FormRequest
{
    /**
     * Only authenticated administrators can create borrowings.
     */
    public function authorize(): bool
    {
        return auth()->check()
            && auth()->user()->role === 'admin';
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [
            'book_id' => [
                'required',
                'integer',
                'exists:books,id',
            ],

            'member_id' => [
                'required',
                'integer',
                'exists:members,id',
            ],

            'issued_at' => [
                'required',
                'date',
            ],

            'due_at' => [
                'required',
                'date',
                'after:issued_at',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'book_id.required' => 'Please select a book.',
            'book_id.exists' => 'The selected book does not exist.',

            'member_id.required' => 'Please select a member.',
            'member_id.exists' => 'The selected member does not exist.',

            'issued_at.required' => 'Please select the issue date.',
            'issued_at.date' => 'The issue date must be valid.',

            'due_at.required' => 'Please select a due date.',
            'due_at.date' => 'The due date must be valid.',
            'due_at.after' => 'The due date must be after the issue date.',
        ];
    }
}
