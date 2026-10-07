@extends('layouts.admin')

@section('title', 'Books')

@section('content')

    <div class="container-fluid py-4">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2">
                        <i class="bi bi-book fs-5"></i>
                    </div>

                    <h1 class="h3 fw-bold mb-0">
                        Books
                    </h1>
                </div>

                <p class="text-muted mb-0 ms-5">
                    Manage the library collection.
                </p>
            </div>

            <a href="{{ route('admin.books.create') }}" class="btn btn-primary px-3">

                <i class="bi bi-plus-lg me-1"></i>
                Add Book

            </a>

        </div>


        {{-- Success Message --}}
        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">

                <div class="d-flex align-items-center">

                    <i class="bi bi-check-circle-fill me-2"></i>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- Error Message --}}
        @if(session('error'))

            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">

                <div class="d-flex align-items-center">

                    <i class="bi bi-exclamation-triangle-fill me-2"></i>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- Books Card --}}
        <div class="card border-0 shadow-sm">

            {{-- Search Area --}}
            <div class="card-body border-bottom">

                <form method="GET" action="{{ route('admin.books.index') }}" class="row g-2 mb-4">

                    <div class="col-md-9">

                        <div class="autocomplete-wrapper">

                            <input type="search" name="search" value="" class="form-control global-search-input"
                                placeholder="Search by title, ISBN, author or category..." autocomplete="off"
                                data-live-search data-autocomplete="books">

                        </div>

                    </div>

                    <div class="col-md-3 d-flex gap-2">

                        <button type="submit" class="btn btn-outline-primary">

                            <i class="bi bi-search me-1"></i>
                            Search

                        </button>

                    </div>

                </form>

            </div>


            {{-- Table --}}
            <div class="card-body p-0">

                @if($books->count())

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th class="ps-4 text-muted small fw-semibold" style="width: 55px;">
                                        #
                                    </th>

                                    <th class="text-muted small fw-semibold" style="width: 90px;">
                                        Cover
                                    </th>

                                    <th class="text-muted small fw-semibold">
                                        Book
                                    </th>

                                    <th class="text-muted small fw-semibold">
                                        ISBN
                                    </th>

                                    <th class="text-muted small fw-semibold">
                                        Author
                                    </th>

                                    <th class="text-muted small fw-semibold">
                                        Category
                                    </th>

                                    <th class="text-muted small fw-semibold text-center">
                                        Quantity
                                    </th>

                                    <th class="text-muted small fw-semibold text-center">
                                        Available
                                    </th>

                                    <th class="pe-4 text-end text-muted small fw-semibold">
                                        Actions
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($books as $book)

                                    <tr>

                                        {{-- Number --}}
                                        <td class="ps-4 text-muted">

                                            {{ $books->firstItem() + $loop->index }}

                                        </td>


                                        {{-- Cover --}}
                                        <td>
                                            @if ($book->cover_image)

                                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                                    class="w-100 h-100" style="object-fit: cover; display: block;" loading="lazy">

                                            @else

                                                <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center">

                                                    <i class="bi bi-book-half text-primary" style="font-size: 4rem;"></i>

                                                    <span class="text-muted small mt-2">
                                                        No Cover Available
                                                    </span>

                                                </div>

                                            @endif

                                        </td>


                                        {{-- Book --}}
                                        <td>

                                            <div class="fw-semibold text-dark">

                                                {{ $book->title }}

                                            </div>

                                        </td>


                                        {{-- ISBN --}}
                                        <td>

                                            <span class="text-muted small">

                                                {{ $book->isbn }}

                                            </span>

                                        </td>


                                        {{-- Author --}}
                                        <td>

                                            <span class="text-dark">

                                                {{ $book->author->name }}

                                            </span>

                                        </td>


                                        {{-- Category --}}
                                        <td>

                                            <span class="badge rounded-pill bg-light text-dark border px-2 py-1">

                                                <i class="bi bi-tag me-1 text-muted"></i>

                                                {{ $book->category->name }}

                                            </span>

                                        </td>


                                        {{-- Quantity --}}
                                        <td class="text-center">

                                            <span class="fw-semibold">

                                                {{ $book->quantity }}

                                            </span>

                                        </td>


                                        {{-- Available --}}
                                        <td class="text-center">

                                            @if($book->available_quantity > 0)

                                                <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">

                                                    <i class="bi bi-check-circle me-1"></i>

                                                    {{ $book->available_quantity }}

                                                </span>

                                            @else

                                                <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">

                                                    <i class="bi bi-x-circle me-1"></i>

                                                    Unavailable

                                                </span>

                                            @endif

                                        </td>


                                        {{-- Actions --}}
                                        <td class="pe-4 text-end">

                                            <div class="d-inline-flex gap-1">

                                                <a href="{{ route('admin.books.show', $book) }}" class="btn btn-sm btn-light border"
                                                    title="View Book">

                                                    <i class="bi bi-eye"></i>

                                                </a>

                                                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-light border"
                                                    title="Edit Book">

                                                    <i class="bi bi-pencil"></i>

                                                </a>

                                                <form method="POST" action="{{ route('admin.books.destroy', $book) }}"
                                                    class="d-inline delete-form">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-light border text-danger"
                                                        title="Delete Book">

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


                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">

                        <div class="text-muted small">

                            Showing
                            <strong>{{ $books->firstItem() }}</strong>
                            to
                            <strong>{{ $books->lastItem() }}</strong>
                            of
                            <strong>{{ $books->total() }}</strong>
                            books

                        </div>

                        <div>
                            {{ $books->links() }}
                        </div>

                    </div>

                @else

                    {{-- Empty State --}}
                    <div class="text-center py-5 px-4">

                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:72px;height:72px;">

                            <i class="bi bi-book text-muted fs-2"></i>

                        </div>

                        <h5 class="fw-semibold mb-2">
                            No books found
                        </h5>

                        <p class="text-muted mb-4">

                            @if($search)

                                No books matched your search.
                                Try a different search term.

                            @else

                                Your library does not contain any books yet.

                            @endif

                        </p>

                        @if($search)

                            <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary me-2">

                                <i class="bi bi-arrow-counterclockwise me-1"></i>
                                Clear Search

                            </a>

                        @endif

                        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">

                            <i class="bi bi-plus-lg me-1"></i>
                            Add Book

                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection