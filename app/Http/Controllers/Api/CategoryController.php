<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    /**
     * Display a paginated list of categories.
     */
    public function index(): AnonymousResourceCollection
    {
        $categories = Category::query()
            ->latest()
            ->paginate(10);

        return CategoryResource::collection($categories);
    }

    /**
     * Display a single category.
     */
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }
}
