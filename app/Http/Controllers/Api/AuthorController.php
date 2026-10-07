<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorController extends Controller
{
    /**
     * Display a paginated list of authors.
     */
    public function index(): AnonymousResourceCollection
    {
        $authors = Author::query()
            ->latest()
            ->paginate(10);

        return AuthorResource::collection($authors);
    }

    /**
     * Display a single author.
     */
    public function show(Author $author): AuthorResource
    {
        return new AuthorResource($author);
    }
}