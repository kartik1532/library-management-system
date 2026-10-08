@extends('layouts.member')

@section('title', 'Browse Books')

@section('content')

    <div class="page-header mb-4">

        <div>
            <div class="text-uppercase small fw-semibold text-primary mb-1">
                Library Catalog
            </div>

            <h1 class="page-title mb-1">
                Browse Books
            </h1>

            <p class="text-muted mb-0">
                Search and explore books available in the library.
            </p>
        </div>

        <div class="text-muted small">
            <i class="bi bi-collection me-1"></i>
            {{ $books->total() }} books
        </div>

    </div>


    {{-- =========================================================
    SEARCH & FILTER
    ========================================================= --}}

    <div class="content-card mb-4">

        <div class="p-4">

            <div class="d-flex align-items-center mb-3">

                <div class="d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded"
                    style="width: 40px; height: 40px;">
                    <i class="bi bi-funnel-fill"></i>
                </div>

                <div class="ms-3">

                    <h5 class="mb-0">
                        Find a Book
                    </h5>

                    <small class="text-muted">
                        Search by title, ISBN, author or category.
                    </small>

                </div>

            </div>


            <form action="{{ route('member.books.index') }}" method="GET">

                <div class="row g-3 align-items-end">

                    {{-- Search --}}

                    <div class="col-lg-6">

                        <label for="search" class="form-label fw-semibold">
                            Search
                        </label>

                        <div class="autocomplete-wrapper">

                            <div class="input-group">

                                <span class="input-group-text">

                                    <i class="bi bi-search"></i>

                                </span>

                                <input type="search" name="search" id="search" class="form-control global-search-input"
                                    value="" placeholder="Search by title, ISBN or author..." autocomplete="off"
                                    data-live-search data-autocomplete="books">

                            </div>

                        </div>




                        {{-- Category --}}

                        <div class="col-lg-4">

                            <label for="category_id" class="form-label fw-semibold">
                                Category
                            </label>

                            <select name="category_id" id="category_id" class="form-select">

                                <option value="">
                                    All Categories
                                </option>

                                @foreach ($categories as $category)

                                    <option value="{{ $category->id }}" @selected($categoryId == $category->id)>
                                        {{ $category->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- Search Button --}}
                        <div class="col-lg-2">

                            <button type="submit" class="btn btn-primary w-100">

                                <i class="bi bi-search me-1"></i>

                                Search

                            </button>

                        </div>



                    </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
    RESULTS HEADER
    ========================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>

            <h5 class="mb-1">
                Available Books
            </h5>

            <p class="text-muted small mb-0">

                Showing
                <strong>{{ $books->firstItem() ?? 0 }}</strong>
                –
                <strong>{{ $books->lastItem() ?? 0 }}</strong>

                of

                <strong>{{ $books->total() }}</strong>
                books

            </p>

        </div>

        @if ($search !== '' || $categoryId)

            <span class="badge bg-light text-dark border">

                <i class="bi bi-funnel me-1"></i>

                Filtered Results

            </span>

        @endif

    </div>


    {{-- =========================================================
    BOOK GRID
    ========================================================= --}}

    @if ($books->isEmpty())

        <div class="content-card">

            <div class="text-center py-5">

                <div class="d-flex align-items-center justify-content-center bg-light rounded-circle mx-auto mb-3"
                    style="width: 70px; height: 70px;">

                    <i class="bi bi-search text-muted" style="font-size: 1.7rem;"></i>

                </div>

                <h5 class="mb-2">
                    No Books Found
                </h5>

                <p class="text-muted mb-3">
                    No books match your current search or category filter.
                </p>

                <a href="{{ route('member.books.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>
                    Clear Filters
                </a>

            </div>

        </div>

    @else

        <div class="row g-4">

            @foreach ($books as $book)

                <div class="col-xl-3 col-lg-4">

                    <div class="card h-100 border-0 shadow-sm" style="
                                                            border-radius: 14px;
                                                            overflow: hidden;
                                                            transition: transform .2s ease, box-shadow .2s ease;
                                                        ">

                        {{-- =================================================
                        BOOK COVER
                        ================================================== --}}

                        <div class="position-relative bg-light" style="height: 240px;">

                            @if ($book->cover_image)

                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-100 h-100"
                                    style="
                                                                    object-fit: cover;
                                                                    display: block;
                                                                " loading="lazy">

                            @else

                                <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center">

                                    <i class="bi bi-book-half text-primary" style="font-size: 4rem;"></i>

                                    <span class="text-muted small mt-2">
                                        No Cover Available
                                    </span>

                                </div>

                            @endif


                            {{-- Availability Badge --}}

                            <div class="position-absolute" style="top: 12px; right: 12px;">

                                @if ($book->available_quantity > 0)

                                    <span class="badge bg-success shadow-sm">

                                        <i class="bi bi-check-circle me-1"></i>
                                        Available

                                    </span>

                                @else

                                    <span class="badge bg-danger shadow-sm">

                                        <i class="bi bi-x-circle me-1"></i>
                                        Unavailable

                                    </span>

                                @endif

                            </div>

                        </div>

                        {{-- =================================================
                        BOOK DETAILS
                        ================================================== --}}

                        <div class="card-body d-flex flex-column p-4">

                            <h5 class="fw-semibold mb-3" style="
                                                                    min-height: 48px;
                                                                    line-height: 1.4;
                                                                " title="{{ $book->title }}">
                                {{ $book->title }}
                            </h5>


                            {{-- Author --}}

                            <div class="d-flex align-items-center mb-2">

                                <i class="bi bi-person text-primary me-2"></i>

                                <span class="text-muted small text-truncate" title="{{ $book->author?->name }}">
                                    {{ $book->author?->name ?? 'Unknown Author' }}
                                </span>

                            </div>


                            {{-- Category --}}

                            <div class="d-flex align-items-center mb-2">

                                <i class="bi bi-tag text-primary me-2"></i>

                                <span class="text-muted small text-truncate" title="{{ $book->category?->name }}">
                                    {{ $book->category?->name ?? 'Uncategorized' }}
                                </span>

                            </div>


                            {{-- ISBN --}}

                            @if ($book->isbn)

                                <div class="d-flex align-items-center mb-3">

                                    <i class="bi bi-upc-scan text-primary me-2"></i>

                                    <span class="text-muted small text-truncate" title="{{ $book->isbn }}">
                                        {{ $book->isbn }}
                                    </span>

                                </div>

                            @else

                                <div class="mb-3"></div>

                            @endif


                            <div class="border-top pt-3 mt-auto">

                                <div class="d-flex justify-content-between align-items-center">

                                    <span class="text-muted small">
                                        Availability
                                    </span>

                                    <strong>

                                        {{ $book->available_quantity }}

                                        <span class="fw-normal text-muted small">
                                            /
                                            {{ $book->quantity }}
                                        </span>

                                    </strong>

                                </div>

                                <div class="text-muted small mt-1">

                                    {{ $book->available_quantity == 1 ? 'copy' : 'copies' }}
                                    currently available

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


        {{-- =========================================================
        PAGINATION
        ========================================================== --}}

        @if ($books->hasPages())

            <div class="d-flex justify-content-center mt-4">

                {{ $books->links() }}

            </div>

        @endif

    @endif

@endsection