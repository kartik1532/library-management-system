@extends('layouts.admin')

@section('title', $category->name)

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="h3 mb-1">
                {{ $category->name }}
            </h1>

            <p class="text-muted mb-0">
                Category details and books.
            </p>

        </div>

        <a href="{{ route('admin.categories.index') }}"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left me-1"></i>
            Back

        </a>

    </div>

    <div class="row g-4">

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5>
                        Category Information
                    </h5>

                    <hr>

                    <p>
                        <strong>Name:</strong><br>
                        {{ $category->name }}
                    </p>

                    <p>
                        <strong>Total Books:</strong><br>

                        <span class="badge text-bg-primary">
                            {{ $category->books->count() }}
                        </span>

                    </p>

                    <p class="mb-0">

                        <strong>Created:</strong><br>

                        {{ $category->created_at->format('d M Y') }}

                    </p>

                </div>

            </div>

        </div>

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5>
                        Description
                    </h5>

                    <hr>

                    @if($category->description)

                        <p class="text-muted">
                            {{ $category->description }}
                        </p>

                    @else

                        <p class="text-muted">
                            No description available.
                        </p>

                    @endif

                </div>

            </div>

            <div class="card border-0 shadow-sm mt-4">

                <div class="card-body">

                    <h5 class="mb-3">
                        Books in {{ $category->name }}
                    </h5>

                    @if($category->books->count())

                        <div class="table-responsive">

                            <table class="table table-hover">

                                <thead class="table-light">

                                    <tr>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>ISBN</th>
                                        <th>Available</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($category->books as $book)

                                        <tr>

                                            <td>
                                                {{ $book->title }}
                                            </td>

                                            <td>
                                                {{ $book->author->name }}
                                            </td>

                                            <td>
                                                {{ $book->isbn }}
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
                            No books are currently assigned to this category.
                        </p>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection