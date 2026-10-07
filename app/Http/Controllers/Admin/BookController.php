<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display books.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $books = Book::query()
            ->with([
                'author',
                'category',
            ])
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('title', 'like', '%' . $search . '%')
                        ->orWhere('isbn', 'like', '%' . $search . '%')
                        ->orWhereHas('author', function ($query) use ($search) {
                            $query->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );
                        })
                        ->orWhereHas('category', function ($query) use ($search) {
                            $query->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.books.index', compact(
            'books',
            'search'
        ));
    }

    /**
     * Show create book form.
     */
    public function create(): View
    {
        $authors = Author::query()
            ->orderBy('name')
            ->get();

        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return view('admin.books.create', compact(
            'authors',
            'categories'
        ));
    }

    /**
     * Store book.
     */
    public function store(StoreBookRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['available_quantity'] = $validated['quantity'];

        unset($validated['cover_image']);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request
                ->file('cover_image')
                ->store('books', 'public');
        }

        Book::create($validated);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Book added successfully.');
    }

    /**
     * Show book details.
     */
    public function show(Book $book): View
    {
        $book->load([
            'author',
            'category',
        ]);

        return view('admin.books.show', compact('book'));
    }

    /**
     * Show edit form.
     */
    public function edit(Book $book): View
    {
        $authors = Author::query()
            ->orderBy('name')
            ->get();

        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return view('admin.books.edit', compact(
            'book',
            'authors',
            'categories'
        ));
    }

    /**
     * Update book.
     */
    public function update(
        UpdateBookRequest $request,
        Book $book
    ): RedirectResponse {
        $validated = $request->validated();

        /*
         * Calculate how many copies are currently borrowed.
         */
        $borrowedQuantity = max(
            0,
            $book->quantity - $book->available_quantity
        );

        /*
         * A new quantity cannot be smaller than the number
         * of copies that are currently borrowed.
         */
        if ($validated['quantity'] < $borrowedQuantity) {
            return back()
                ->withInput()
                ->withErrors([
                    'quantity' => sprintf(
                        'Quantity cannot be less than %d because %d copy/copies are currently borrowed.',
                        $borrowedQuantity,
                        $borrowedQuantity
                    ),
                ]);
        }

        /*
         * Recalculate available quantity based on
         * the new total quantity.
         */
        $validated['available_quantity'] =
            $validated['quantity'] - $borrowedQuantity;

        /*
         * Remove uploaded file from validated data temporarily.
         */
        unset($validated['cover_image']);

        /*
         * Handle replacement cover.
         */
        if ($request->hasFile('cover_image')) {
            if (
                $book->cover_image &&
                Storage::disk('public')->exists($book->cover_image)
            ) {
                Storage::disk('public')->delete(
                    $book->cover_image
                );
            }

            $validated['cover_image'] = $request
                ->file('cover_image')
                ->store('books', 'public');
        }

        $book->update($validated);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Book updated successfully.');
    }

    /**
     * Delete book.
     */
    public function destroy(Book $book): RedirectResponse
    {
        /*
         * Do not allow deletion when borrowing records exist.
         *
         * Borrowing model will be used in Phase 3.
         */
        if ($book->borrowings()->exists()) {
            return redirect()
                ->route('admin.books.index')
                ->with(
                    'error',
                    'This book cannot be deleted because it has borrowing history.'
                );
        }

        if (
            $book->cover_image &&
            Storage::disk('public')->exists($book->cover_image)
        ) {
            Storage::disk('public')->delete(
                $book->cover_image
            );
        }

        $book->delete();

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Book deleted successfully.');
    }
}