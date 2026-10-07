@extends('layouts.admin')

@section('title', 'Book Inventory Report')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                <i class="bi bi-box-seam me-2"></i>

                Book Inventory Report

            </h2>

            <p class="text-muted mb-0">

                View library books, copies, availability and inventory status.

            </p>

        </div>

        <div class="d-flex flex-wrap gap-2">

            <a
                href="{{ route('admin.reports.index') }}"
                class="btn btn-outline-secondary"
            >

                <i class="bi bi-arrow-left me-1"></i>

                Back to Reports

            </a>

            <a
                href="{{ route('admin.books.index') }}"
                class="btn btn-primary"
            >

                <i class="bi bi-book me-1"></i>

                Manage Books

            </a>

            <button
                type="button"
                class="btn btn-outline-secondary"
                onclick="window.print()"
            >

                <i class="bi bi-printer me-1"></i>

                Print

            </button>

        </div>

    </div>


    {{-- Inventory Statistics --}}
    <div class="row g-4 mb-4">

        {{-- Total Titles --}}
        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <p class="text-muted mb-1">
                                Total Titles
                            </p>

                            <h3 class="fw-bold mb-1">
                                {{ number_format($totalBooks) }}
                            </h3>

                            <small class="text-muted">
                                Books in catalog
                            </small>

                        </div>

                        <div class="fs-2 text-primary">

                            <i class="bi bi-book"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Total Copies --}}
        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <p class="text-muted mb-1">
                                Total Copies
                            </p>

                            <h3 class="fw-bold mb-1">
                                {{ number_format($totalCopies) }}
                            </h3>

                            <small class="text-muted">
                                Physical copies
                            </small>

                        </div>

                        <div class="fs-2 text-info">

                            <i class="bi bi-stack"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Available Copies --}}
        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <p class="text-muted mb-1">
                                Available Copies
                            </p>

                            <h3 class="fw-bold mb-1 text-success">
                                {{ number_format($availableCopies) }}
                            </h3>

                            <small class="text-success">
                                Ready to borrow
                            </small>

                        </div>

                        <div class="fs-2 text-success">

                            <i class="bi bi-check-circle"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Issued Copies --}}
        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <p class="text-muted mb-1">
                                Issued Copies
                            </p>

                            <h3 class="fw-bold mb-1 text-warning">
                                {{ number_format($issuedCopies) }}
                            </h3>

                            <small class="text-warning">
                                Currently borrowed
                            </small>

                        </div>

                        <div class="fs-2 text-warning">

                            <i class="bi bi-journal-arrow-up"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Title Availability Summary --}}
    <div class="row g-4 mb-4">

        <div class="col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small">
                                Titles with available copies
                            </div>

                            <div class="fs-4 fw-bold text-success">
                                {{ number_format($availableTitles) }}
                            </div>

                        </div>

                        <div class="fs-3 text-success">

                            <i class="bi bi-check-circle"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small">
                                Titles currently unavailable
                            </div>

                            <div class="fs-4 fw-bold text-danger">
                                {{ number_format($unavailableTitles) }}
                            </div>

                        </div>

                        <div class="fs-3 text-danger">

                            <i class="bi bi-exclamation-circle"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Filters --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white py-3">

            <h5 class="mb-0 fw-bold">

                <i class="bi bi-funnel me-2"></i>

                Filter Inventory

            </h5>

        </div>


        <div class="card-body">

            <form
                method="GET"
                action="{{ route('admin.reports.books') }}"
            >

                <div class="row g-3">

                    {{-- Search --}}
                    <div class="autocomplete-wrapper">

                        <label class="form-label fw-semibold">
                            Search
                        </label>

                        <input
                            type="search"
                            name="search"
                            value=""
                            class="form-control global-search-input"
                            placeholder="Book title, ISBN, author or category..."
                            autocomplete="off"
                            data-live-search
                            data-autocomplete="books"
                        >

                    </div>


                    {{-- Author --}}
                    <div class="col-md-6 col-lg-2">

                        <label class="form-label fw-semibold">
                            Author
                        </label>

                        <select
                            name="author_id"
                            class="form-select"
                        >

                            <option value="">
                                All Authors
                            </option>

                            @foreach($authors as $author)

                                <option
                                    value="{{ $author->id }}"
                                    @selected((string) $authorId === (string) $author->id)
                                >
                                    {{ $author->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Category --}}
                    <div class="col-md-6 col-lg-2">

                        <label class="form-label fw-semibold">
                            Category
                        </label>

                        <select
                            name="category_id"
                            class="form-select"
                        >

                            <option value="">
                                All Categories
                            </option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    @selected((string) $categoryId === (string) $category->id)
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Availability --}}
                    <div class="col-md-6 col-lg-2">

                        <label class="form-label fw-semibold">
                            Availability
                        </label>

                        <select
                            name="availability"
                            class="form-select"
                        >

                            <option value="">
                                All
                            </option>

                            <option
                                value="available"
                                @selected($availability === 'available')
                            >
                                Available
                            </option>

                            <option
                                value="unavailable"
                                @selected($availability === 'unavailable')
                            >
                                Unavailable
                            </option>

                        </select>

                    </div>


                    {{-- Buttons --}}
                    <div class="col-lg-2 d-flex align-items-end gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >

                            <i class="bi bi-search me-1"></i>

                            Filter

                        </button>

                       

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Inventory Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0 fw-bold">

                    <i class="bi bi-table me-2"></i>

                    Inventory Records

                </h5>

                <span class="text-muted small">

                    {{ $books->total() }} record(s)

                </span>

            </div>

        </div>


        <div class="card-body p-0">

            @if($books->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="px-3">
                                    #
                                </th>

                                <th>
                                    Book
                                </th>

                                <th>
                                    Author
                                </th>

                                <th>
                                    Category
                                </th>

                                <th>
                                    Total
                                </th>

                                <th>
                                    Available
                                </th>

                                <th>
                                    Issued
                                </th>

                                <th>
                                    Status
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($books as $book)

                                @php

                                    $issued = max(
                                        0,
                                        (int) $book->quantity -
                                        (int) $book->available_quantity
                                    );

                                @endphp

                                <tr>

                                    {{-- Number --}}
                                    <td class="px-3">

                                        {{ $books->firstItem() + $loop->index }}

                                    </td>


                                    {{-- Book --}}
                                    <td>

                                        <div class="d-flex align-items-center gap-3">

                                            @if($book->cover_image)

                                                <img
                                                    src="{{ asset('storage/' . $book->cover_image) }}"
                                                    alt="{{ $book->title }}"
                                                    class="book-cover-thumb"
                                                >

                                            @else

                                                <div
                                                    class="book-cover-thumb bg-light d-flex align-items-center justify-content-center"
                                                >

                                                    <i class="bi bi-book text-muted"></i>

                                                </div>

                                            @endif


                                            <div>

                                                <div class="fw-semibold">

                                                    {{ $book->title }}

                                                </div>

                                                @if($book->isbn)

                                                    <small class="text-muted">

                                                        ISBN:
                                                        {{ $book->isbn }}

                                                    </small>

                                                @endif

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Author --}}
                                    <td>

                                        {{ $book->author?->name ?? 'N/A' }}

                                    </td>


                                    {{-- Category --}}
                                    <td>

                                        {{ $book->category?->name ?? 'N/A' }}

                                    </td>


                                    {{-- Total --}}
                                    <td>

                                        <span class="fw-semibold">

                                            {{ number_format($book->quantity) }}

                                        </span>

                                    </td>


                                    {{-- Available --}}
                                    <td>

                                        <span class="fw-semibold text-success">

                                            {{ number_format($book->available_quantity) }}

                                        </span>

                                    </td>


                                    {{-- Issued --}}
                                    <td>

                                        <span class="fw-semibold text-warning">

                                            {{ number_format($issued) }}

                                        </span>

                                    </td>


                                    {{-- Status --}}
                                    <td>

                                        @if($book->available_quantity > 0)

                                            <span class="badge bg-success">

                                                <i class="bi bi-check-circle me-1"></i>

                                                Available

                                            </span>

                                        @else

                                            <span class="badge bg-danger">

                                                <i class="bi bi-x-circle me-1"></i>

                                                Unavailable

                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                @if($books->hasPages())

                    <div class="p-3">

                        {{ $books->links() }}

                    </div>

                @endif

            @else

                <div class="text-center py-5">

                    <div class="fs-1 text-muted mb-3">

                        <i class="bi bi-inbox"></i>

                    </div>

                    <h5 class="fw-bold">
                        No books found
                    </h5>

                    <p class="text-muted mb-0">

                        Try changing your search or filters.

                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection