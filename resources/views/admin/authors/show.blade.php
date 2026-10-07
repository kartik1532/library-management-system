@extends('layouts.admin')

@section('title', $author->name)

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                {{ $author->name }}
            </h1>

            <p class="text-muted mb-0">
                Author details and associated books.
            </p>
        </div>

        <a href="{{ route('admin.authors.index') }}"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left me-1"></i>
            Back

        </a>

    </div>

    <div class="row g-4">

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5 class="card-title">
                        Author Information
                    </h5>

                    <hr>

                    <p>
                        <strong>Name:</strong><br>
                        {{ $author->name }}
                    </p>

                    <p>
                        <strong>Total Books:</strong><br>

                        <span class="badge text-bg-primary">
                            {{ $author->books->count() }}
                        </span>
                    </p>

                    <p class="mb-0">
                        <strong>Created:</strong><br>
                        {{ $author->created_at->format('d M Y') }}
                    </p>

                </div>

            </div>

        </div>

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5 class="card-title">
                        Biography
                    </h5>

                    <hr>

                    @if($author->biography)

                        <p class="text-muted">
                            {{ $author->biography }}
                        </p>

                    @else

                        <p class="text-muted">
                            No biography has been added.
                        </p>

                    @endif

                </div>

            </div>

            <div class="card border-0 shadow-sm mt-4">

                <div class="card-body">

                    <h5 class="card-title mb-3">
                        Books by {{ $author->name }}
                    </h5>

                    @if($author->books->count())

                        <div class="table-responsive">

                            <table class="table table-hover align-middle">

                                <thead class="table-light">

                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Available</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($author->books as $book)

                                        <tr>

                                            <td>
                                                {{ $book->title }}
                                            </td>

                                            <td>
                                                {{ $book->category->name }}
                                            </td>

                                            <td>

                                                @if($book->available_quantity > 0)

                                                    <span class="badge text-bg-success">
                                                        {{ $book->available_quantity }}
                                                    </span>

                                                @else

                                                    <span class="badge text-bg-danger">
                                                        Unavailable
                                                    </span>

                                                @endif

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <p class="text-muted mb-0">
                            No books are associated with this author.
                        </p>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection