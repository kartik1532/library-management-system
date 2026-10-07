@extends('layouts.admin')

@section('title', 'Categories')

@section('content')

    <div class="container-fluid py-4">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

            <div>
                <h1 class="h3 mb-1">
                    Categories
                </h1>

                <p class="text-muted mb-0">
                    Organize books by category.
                </p>
            </div>

            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">

                <i class="bi bi-plus-lg me-1"></i>
                Add Category

            </a>

        </div>

        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show">

                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

            </div>

        @endif

        @if(session('error'))

            <div class="alert alert-danger alert-dismissible fade show">

                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('error') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

            </div>

        @endif

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-2 mb-4">

                    <div class="col-md-8">

                        <div class="autocomplete-wrapper">

                            <input type="search" name="search" value="" class="form-control global-search-input"
                                placeholder="Search categories..." autocomplete="off" data-live-search
                                data-autocomplete="categories">

                        </div>

                    </div>

                    <div class="col-md-4 d-flex gap-2">

                        <button type="submit" class="btn btn-outline-primary">

                            <i class="bi bi-search me-1"></i>
                            Search

                        </button>

                    </div>

                </form>
                @if($categories->count())

                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-light">

                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Books</th>
                                    <th>Created</th>
                                    <th class="text-end">Actions</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach($categories as $category)

                                    <tr>

                                        <td>
                                            {{ $categories->firstItem() + $loop->index }}
                                        </td>

                                        <td>
                                            <strong>
                                                {{ $category->name }}
                                            </strong>
                                        </td>

                                        <td>
                                            {{ \Illuminate\Support\Str::limit($category->description ?? 'No description', 60) }}
                                        </td>

                                        <td>

                                            <span class="badge text-bg-primary">
                                                {{ $category->books_count }}
                                            </span>

                                        </td>

                                        <td>
                                            {{ $category->created_at->format('d M Y') }}
                                        </td>

                                        <td class="text-end">

                                            <div class="btn-group">

                                                <a href="{{ route('admin.categories.show', $category) }}"
                                                    class="btn btn-sm btn-outline-info">

                                                    <i class="bi bi-eye"></i>

                                                </a>

                                                <a href="{{ route('admin.categories.edit', $category) }}"
                                                    class="btn btn-sm btn-outline-primary">

                                                    <i class="bi bi-pencil"></i>

                                                </a>

                                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                                    class="d-inline delete-form">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-outline-danger">

                                                        <i class="bi bi-trash"></i>

                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    <div class="mt-3">
                        {{ $categories->links() }}
                    </div>

                @else

                    <div class="text-center py-5">

                        <i class="bi bi-tags display-4 text-muted"></i>

                        <h5 class="mt-3">
                            No categories found
                        </h5>

                        <p class="text-muted">
                            Create your first category.
                        </p>

                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">

                            Add Category

                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection