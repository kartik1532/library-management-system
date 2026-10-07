@extends('layouts.admin')

@section('title', 'Borrowing Report')

@section('content')

    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-arrow-left-right me-2"></i>
                    Borrowing Report
                </h2>

                <p class="text-muted mb-0">
                    View and analyze library borrowing activity.
                </p>
            </div>

            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">

                <i class="bi bi-arrow-left me-1"></i>
                Back to Reports

            </a>

        </div>


        {{-- Statistics --}}
        <div class="row g-4 mb-4">

            {{-- Total --}}
            <div class="col-md-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Total Borrowings
                                </p>

                                <h3 class="fw-bold mb-0">
                                    {{ $totalBorrowings }}
                                </h3>

                            </div>

                            <div class="fs-2 text-primary">

                                <i class="bi bi-journal-text"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Borrowed --}}
            <div class="col-md-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Currently Borrowed
                                </p>

                                <h3 class="fw-bold mb-0 text-primary">
                                    {{ $borrowedCount }}
                                </h3>

                            </div>

                            <div class="fs-2 text-primary">

                                <i class="bi bi-book-half"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Returned --}}
            <div class="col-md-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Returned
                                </p>

                                <h3 class="fw-bold mb-0 text-success">
                                    {{ $returnedCount }}
                                </h3>

                            </div>

                            <div class="fs-2 text-success">

                                <i class="bi bi-check-circle"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Overdue --}}
            <div class="col-md-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Overdue
                                </p>

                                <h3 class="fw-bold mb-0 text-danger">
                                    {{ $overdueCount }}
                                </h3>

                            </div>

                            <div class="fs-2 text-danger">

                                <i class="bi bi-exclamation-triangle"></i>

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

                    Filter Borrowings

                </h5>

            </div>


            <div class="card-body">

                <form method="GET" action="{{ route('admin.reports.borrowings') }}">

                    <div class="row g-3">

                        {{-- Search --}}
                        <div class="autocomplete-wrapper">

                            <label class="form-label fw-semibold">
                                Search
                            </label>

                            <input 
                            type="search" 
                            name="search" value=""
                            class="form-control global-search-input"
                            placeholder="Search book, ISBN, member or membership number..." 
                            autocomplete="off"
                            data-live-search 
                            data-autocomplete="borrowings">

                        </div>


                        {{-- Status --}}
                        <div class="col-md-4 col-lg-2">

                            <label class="form-label fw-semibold">
                                Status
                            </label>

                            <select name="status" class="form-select">

                                <option value="">
                                    All Statuses
                                </option>

                                <option value="borrowed" @selected($status === 'borrowed')>
                                    Borrowed
                                </option>

                                <option value="returned" @selected($status === 'returned')>
                                    Returned
                                </option>

                                <option value="overdue" @selected($status === 'overdue')>
                                    Overdue
                                </option>

                            </select>

                        </div>


                        {{-- From --}}
                        <div class="col-md-4 col-lg-2">

                            <label class="form-label fw-semibold">
                                From
                            </label>

                            <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control">

                        </div>


                        {{-- To --}}
                        <div class="col-md-4 col-lg-2">

                            <label class="form-label fw-semibold">
                                To
                            </label>

                            <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control">

                        </div>


                        {{-- Buttons --}}
                        <div class="col-lg-2 d-flex align-items-end gap-2">

                            <button type="submit" class="btn btn-primary w-100">

                                <i class="bi bi-search me-1"></i>
                                Filter

                            </button>

                         </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- Borrowing Table --}}
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <h5 class="mb-0 fw-bold">

                        <i class="bi bi-table me-2"></i>

                        Borrowing Records

                    </h5>

                    <span class="text-muted small">

                        {{ $borrowings->total() }} record(s)

                    </span>

                </div>

            </div>


            <div class="card-body p-0">

                @if($borrowings->count())

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
                                        Member
                                    </th>

                                    <th>
                                        Issued
                                    </th>

                                    <th>
                                        Due
                                    </th>

                                    <th>
                                        Returned
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                    <th>
                                        Fine
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($borrowings as $borrowing)

                                    <tr>

                                        <td class="px-3">

                                            {{ $borrowings->firstItem() + $loop->index }}

                                        </td>


                                        {{-- Book --}}
                                        <td>

                                            <div class="fw-semibold">

                                                {{ $borrowing->book?->title ?? 'N/A' }}

                                            </div>

                                            @if($borrowing->book?->isbn)

                                                <small class="text-muted">

                                                    ISBN:
                                                    {{ $borrowing->book->isbn }}

                                                </small>

                                            @endif

                                        </td>


                                        {{-- Member --}}
                                        <td>

                                            <div class="fw-semibold">

                                                {{ $borrowing->member?->user?->name ?? 'N/A' }}

                                            </div>

                                            @if($borrowing->member?->membership_number)

                                                <small class="text-muted">

                                                    {{ $borrowing->member->membership_number }}

                                                </small>

                                            @endif

                                        </td>


                                        {{-- Issued --}}
                                        <td>

                                            {{ $borrowing->issued_at?->format('d M Y') ?? '—' }}

                                        </td>


                                        {{-- Due --}}
                                        <td>

                                            {{ $borrowing->due_at?->format('d M Y') ?? '—' }}

                                        </td>


                                        {{-- Returned --}}
                                        <td>

                                            {{ $borrowing->returned_at?->format('d M Y') ?? '—' }}

                                        </td>


                                        {{-- Status --}}
                                        <td>

                                            @if($borrowing->status === 'borrowed')

                                                <span class="badge bg-primary">
                                                    Borrowed
                                                </span>

                                            @elseif($borrowing->status === 'returned')

                                                <span class="badge bg-success">
                                                    Returned
                                                </span>

                                            @elseif($borrowing->status === 'overdue')

                                                <span class="badge bg-danger">
                                                    Overdue
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Fine --}}
                                        <td>

                                            @if($borrowing->fine)

                                                                <div class="fw-semibold">

                                                                    {{ number_format($borrowing->fine->amount, 2) }}

                                                                </div>

                                                                <small class="{{ $borrowing->fine->status === 'paid'
                                                ? 'text-success'
                                                : 'text-danger' }}">

                                                                    {{ ucfirst($borrowing->fine->status) }}

                                                                </small>

                                            @else

                                                <span class="text-muted">
                                                    —
                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    {{-- Pagination --}}
                    @if($borrowings->hasPages())

                        <div class="p-3">

                            {{ $borrowings->links() }}

                        </div>

                    @endif

                @else

                    {{-- Empty State --}}
                    <div class="text-center py-5">

                        <div class="fs-1 text-muted mb-3">

                            <i class="bi bi-inbox"></i>

                        </div>

                        <h5 class="fw-bold">
                            No borrowing records found
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