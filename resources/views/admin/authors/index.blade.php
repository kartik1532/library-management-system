@extends('layouts.admin')

@section('title', 'Authors')

@section('content')

    <div class="container-fluid py-4">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

            <div>
                <h1 class="h3 mb-1">Authors</h1>
                <p class="text-muted mb-0">
                    Manage all book authors.
                </p>
            </div>

            <a href="{{ route('admin.authors.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                Add Author
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

                <form method="GET" action="{{ route('admin.authors.index') }}" class="row g-2 mb-4">

                    <div class="col-md-8">

                        <div class="autocomplete-wrapper">

                            <input type="search" name="search" value="" class="form-control global-search-input"
                                placeholder="Search authors..." autocomplete="off" data-live-search
                                data-autocomplete="authors">

                        </div>

                    </div>

                    <div class="col-md-4 d-flex gap-2">

                        <button type="submit" class="btn btn-outline-primary">

                            <i class="bi bi-search me-1"></i>
                            Search

                        </button>

                    </div>

                </form>
                @if($authors->count())

                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-light">

                                <tr>
                                    <th>#</th>
                                    <th>Author</th>
                                    <th>Books</th>
                                    <th>Created</th>
                                    <th class="text-end">Actions</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach($authors as $author)

                                    <tr>

                                        <td>
                                            {{ $authors->firstItem() + $loop->index }}
                                        </td>

                                        <td>
                                            <div class="fw-semibold">
                                                {{ $author->name }}
                                            </div>

                                            @if($author->biography)
                                                <small class="text-muted">
                                                    {{ \Illuminate\Support\Str::limit($author->biography, 70) }}
                                                </small>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="badge text-bg-primary">
                                                {{ $author->books_count }}
                                            </span>
                                        </td>

                                        <td>
                                            {{ $author->created_at->format('d M Y') }}
                                        </td>

                                        <td class="text-end">

                                            <div class="btn-group">

                                                <a href="{{ route('admin.authors.show', $author) }}"
                                                    class="btn btn-sm btn-outline-info" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.authors.edit', $author) }}"
                                                    class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <form method="POST" action="{{ route('admin.authors.destroy', $author) }}"
                                                    class="d-inline delete-form">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
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
                        {{ $authors->links() }}
                    </div>

                @else

                    <div class="text-center py-5">

                        <i class="bi bi-person-lines-fill display-4 text-muted"></i>

                        <h5 class="mt-3">
                            No authors found
                        </h5>

                        <p class="text-muted">
                            Add your first author to get started.
                        </p>

                        <a href="{{ route('admin.authors.create') }}" class="btn btn-primary">
                            Add Author
                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection