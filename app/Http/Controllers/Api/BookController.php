<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    /**
     * Display a paginated list of books.
     */
    public function index(): AnonymousResourceCollection
    {
        $books = Book::query()
            ->with(['author', 'category'])
            ->latest()
            ->paginate(10);

        return BookResource::collection($books);
    }

    /**
     * Display a single book.
     */
    public function show(Book $book): BookResource
    {
        $book->load(['author', 'category']);

        return new BookResource($book);
    }

    /**
     * Store a new book.
     */
    public function store(Request $request): BookResource
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'isbn' => [
                'required',
                'string',
                'max:255',
                'unique:books,isbn',
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
            'available_quantity' => [
                'required',
                'integer',
                'min:0',
                'lte:quantity',
            ],
            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request
                ->file('cover_image')
                ->store('books', 'public');
        }

        $book = Book::create($validated);

        $book->load(['author', 'category']);

        return new BookResource($book);
    }

    /**
     * Update an existing book.
     */
    public function update(Request $request, Book $book): BookResource
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'isbn' => [
                'required',
                'string',
                'max:255',
                Rule::unique('books', 'isbn')->ignore($book->id),
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
            'available_quantity' => [
                'required',
                'integer',
                'min:0',
                'lte:quantity',
            ],
            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $validated['cover_image'] = $request
                ->file('cover_image')
                ->store('books', 'public');
        }

        $book->update($validated);

        $book->load(['author', 'category']);

        return new BookResource($book);
    }

    /**
     * Delete a book.
     */
    public function destroy(Book $book): JsonResponse
    {
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully.',
        ]);
    }
}