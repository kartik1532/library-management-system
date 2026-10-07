@extends('layouts.admin')

@section('title', 'Borrowings')

@section('content')

    <div class="container-fluid py-4">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <div class="d-flex align-items-center gap-2 mb-1">

                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2">
                        <i class="bi bi-journal-bookmark-fill fs-5"></i>
                    </div>

                    <h1 class="h3 fw-bold mb-0">
                        Borrowings
                    </h1>

                </div>

                <p class="text-muted mb-0 ms-5">
                    Manage issued and returned books.
                </p>

            </div>

            <a href="{{ route('admin.borrowings.create') }}" class="btn btn-primary px-3">

                <i class="bi bi-plus-lg me-1"></i>
                Issue Book

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


        {{-- Filters --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body">

                <form method="GET" action="{{ route('admin.borrowings.index') }}">

                    <div class="row g-2">

                        <div class="col-md-7">

                            <div class="autocomplete-wrapper">

                                <input type="search" name="search" value="" class="form-control global-search-input"
                                    placeholder="Search book, ISBN, member or membership number..." autocomplete="off"
                                    data-live-search data-autocomplete="borrowings">

                            </div>

                        </div>

                        <div class="col-md-3">

                            <select name="status" class="form-select">

                                <option value="">
                                    All Statuses
                                </option>

                                <option value="borrowed" @selected($status === 'borrowed')>
                                    Borrowed
                                </option>

                                <option value="overdue" @selected($status === 'overdue')>
                                    Overdue
                                </option>

                                <option value="returned" @selected($status === 'returned')>
                                    Returned
                                </option>

                            </select>

                        </div>

                        <div class="col-md-2">

                            <button type="submit" class="btn btn-primary w-100">

                                <i class="bi bi-search me-1"></i>
                                Search

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- Borrowings Table --}}
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white border-0 px-4 py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="mb-1 fw-semibold">
                            Borrowing Records
                        </h5>

                        <small class="text-muted">
                            Track issued, overdue and returned books.
                        </small>

                    </div>

                    <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">

                        <i class="bi bi-journal-bookmark me-1"></i>

                        {{ $borrowings->total() }}
                        {{ $borrowings->total() === 1 ? 'Record' : 'Records' }}

                    </span>

                </div>

            </div>


            <div class="card-body p-0">

                @if($borrowings->count())

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th class="ps-4 text-muted small fw-semibold" style="width: 60px;">
                                        #
                                    </th>

                                    <th class="text-muted small fw-semibold">
                                        Book
                                    </th>

                                    <th class="text-muted small fw-semibold">
                                        Member
                                    </th>

                                    <th class="text-muted small fw-semibold">
                                        Issued Date
                                    </th>

                                    <th class="text-muted small fw-semibold">
                                        Due Date
                                    </th>

                                    <th class="text-muted small fw-semibold">
                                        Returned Date
                                    </th>

                                    <th class="text-muted small fw-semibold">
                                        Status
                                    </th>

                                    <th class="pe-4 text-end text-muted small fw-semibold">
                                        Actions
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($borrowings as $borrowing)

                                    <tr>

                                        {{-- Number --}}
                                        <td class="ps-4 text-muted">

                                            {{ $borrowings->firstItem() + $loop->index }}

                                        </td>


                                        {{-- Book --}}
                                        <td>

                                            <div class="fw-semibold text-dark">

                                                {{ $borrowing->book->title }}

                                            </div>

                                            <div class="small text-muted">

                                                ISBN:
                                                {{ $borrowing->book->isbn }}

                                            </div>

                                        </td>


                                        {{-- Member --}}
                                        <td>

                                            <div class="fw-semibold text-dark">

                                                {{ $borrowing->member->user->name }}

                                            </div>

                                            <div class="small text-muted">

                                                {{ $borrowing->member->membership_number }}

                                            </div>

                                        </td>


                                        {{-- Issued --}}
                                        <td>

                                            @if($borrowing->issued_at)

                                                <span class="text-dark">

                                                    {{ $borrowing->issued_at->format('d M Y') }}

                                                </span>

                                            @else

                                                <span class="text-muted">
                                                    &mdash;
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Due --}}
                                        <td>

                                            @if($borrowing->due_at)

                                                <span
                                                    class="{{ $borrowing->status === 'overdue' ? 'text-danger fw-semibold' : 'text-dark' }}">

                                                    {{ $borrowing->due_at->format('d M Y') }}

                                                </span>

                                            @else

                                                <span class="text-muted">
                                                    &mdash;
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Returned --}}
                                        <td>

                                            @if($borrowing->returned_at)

                                                <span class="text-dark">

                                                    {{ $borrowing->returned_at->format('d M Y') }}

                                                </span>

                                            @else

                                                <span class="text-muted">
                                                    &mdash;
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Status --}}
                                        <td>

                                            @if($borrowing->status === 'borrowed')

                                                <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">

                                                    <i class="bi bi-book me-1"></i>
                                                    Borrowed

                                                </span>

                                            @elseif($borrowing->status === 'overdue')

                                                <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">

                                                    <i class="bi bi-exclamation-circle me-1"></i>
                                                    Overdue

                                                </span>

                                            @else

                                                <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">

                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Returned

                                                </span>

                                            @endif

                                        </td>


                                        {{-- Actions --}}
                                        <td class="pe-4 text-end">

                                            <div class="d-inline-flex gap-1">

                                                <a href="{{ route('admin.borrowings.show', $borrowing) }}"
                                                    class="btn btn-sm btn-light border" title="View Borrowing">

                                                    <i class="bi bi-eye"></i>

                                                </a>


                                                @if(in_array($borrowing->status, ['borrowed', 'overdue'], true))

                                                    {{-- Return Book --}}
                                                    <form method="POST" action="{{ route('admin.borrowings.return', $borrowing) }}"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to mark this book as returned?');">

                                                        @csrf

                                                        <button type="submit" class="btn btn-sm btn-light border text-success"
                                                            title="Return Book">

                                                            <i class="bi bi-arrow-return-left"></i>

                                                        </button>

                                                    </form>


                                                    {{-- Pay Fine --}}
                                                    @if($borrowing->fine && $borrowing->fine->status === 'unpaid')

                                                        <form method="POST" action="{{ route('admin.borrowings.pay-fine', $borrowing) }}"
                                                            class="d-inline"
                                                            onsubmit="return confirm('Are you sure you want to mark this fine as paid?');">

                                                            @csrf

                                                            <button type="submit" class="btn btn-sm btn-light border text-warning"
                                                                title="Pay Fine">

                                                                <i class="bi bi-cash-coin"></i>

                                                            </button>

                                                        </form>

                                                    @endif


                                                    {{-- Edit --}}
                                                    <a href="{{ route('admin.borrowings.edit', $borrowing) }}"
                                                        class="btn btn-sm btn-light border" title="Edit Borrowing">

                                                        <i class="bi bi-pencil"></i>

                                                    </a>

                                                @endif

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    {{-- Pagination --}}
                    @if($borrowings->hasPages())

                        <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">

                            <div class="text-muted small">

                                Showing
                                <strong>{{ $borrowings->firstItem() }}</strong>
                                to
                                <strong>{{ $borrowings->lastItem() }}</strong>
                                of
                                <strong>{{ $borrowings->total() }}</strong>
                                records

                            </div>

                            <div>

                                {{ $borrowings->withQueryString()->links() }}

                            </div>

                        </div>

                    @endif


                @else

                    {{-- Empty State --}}
                    <div class="text-center py-5 px-4">

                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:72px;height:72px;">

                            <i class="bi bi-journal-x text-muted fs-2"></i>

                        </div>

                        <h5 class="fw-semibold mb-2">
                            No borrowing records found
                        </h5>

                        <p class="text-muted mb-4">

                            @if($search || $status)

                                No borrowing records matched your current filters.

                            @else

                                No books have been issued yet.

                            @endif

                        </p>

                        @if($search || $status)

                            <a href="{{ route('admin.borrowings.index') }}" class="btn btn-outline-secondary me-2">

                                <i class="bi bi-arrow-counterclockwise me-1"></i>
                                Clear Filters

                            </a>

                        @endif

                        <a href="{{ route('admin.borrowings.create') }}" class="btn btn-primary">

                            <i class="bi bi-plus-lg me-1"></i>
                            Issue Book

                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection