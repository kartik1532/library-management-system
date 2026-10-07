<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AuthorController extends Controller
{
    /**
     * Display all authors.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $authors = Author::query()
            ->withCount('books')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.authors.index', compact('authors', 'search'));
    }

    /**
     * Show create author form.
     */
    public function create(): View
    {
        return view('admin.authors.create');
    }

    /**
     * Store a new author.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:authors,name',
            ],

            'biography' => [
                'nullable',
                'string',
            ],
        ]);

        Author::create($validated);

        return redirect()
            ->route('admin.authors.index')
            ->with('success', 'Author added successfully.');
    }

    /**
     * Display one author.
     */
    public function show(Author $author): View
    {
        $author->load([
            'books.category',
        ]);

        return view('admin.authors.show', compact('author'));
    }

    /**
     * Show edit form.
     */
    public function edit(Author $author): View
    {
        return view('admin.authors.edit', compact('author'));
    }

    /**
     * Update author.
     */
    public function update(Request $request, Author $author): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('authors', 'name')->ignore($author->id),
            ],

            'biography' => [
                'nullable',
                'string',
            ],
        ]);

        $author->update($validated);

        return redirect()
            ->route('admin.authors.index')
            ->with('success', 'Author updated successfully.');
    }

    /**
     * Delete author.
     */
    public function destroy(Author $author): RedirectResponse
    {
        if ($author->books()->exists()) {
            return redirect()
                ->route('admin.authors.index')
                ->with('error', 'This author cannot be deleted because books are associated with this author.');
        }

        $author->delete();

        return redirect()
            ->route('admin.authors.index')
            ->with('success', 'Author deleted successfully.');
    }
}