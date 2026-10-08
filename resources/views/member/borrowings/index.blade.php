@extends('layouts.member')

@section('title', 'My Borrowings')

@section('content')

    <div class="page-header">

        <div>
            <h1 class="page-title">
                My Borrowings
            </h1>

            <p class="text-muted mb-0">
                View and track your current and previous borrowing records.
            </p>
        </div>

    </div>


    {{-- Filter --}}
    <div class="content-card mb-4">

        <div class="card-header-modern">

            <div>
                <h5 class="mb-1">
                    <i class="bi bi-funnel me-2"></i>
                    Filter Borrowings
                </h5>

                <p class="text-muted small mb-0">
                    Filter your borrowing history by status.
                </p>
            </div>

        </div>

        <div class="p-3">

            <form action="{{ route('member.borrowings.index') }}" method="GET">

                <div class="row g-3 align-items-end">

                    <div class="col-md-6 col-lg-4">

                        <label for="status" class="form-label fw-semibold">
                            Borrowing Status
                        </label>

                        <select name="status" id="status" class="form-select">

                            <option value="">
                                All Borrowings
                            </option>

                            <option value="borrowed" @selected($status === 'borrowed')>
                                Currently Borrowed
                            </option>

                            <option value="overdue" @selected($status === 'overdue')>
                                Overdue
                            </option>

                            <option value="returned" @selected($status === 'returned')>
                                Returned
                            </option>

                        </select>

                    </div>

                    <div class="col-md-auto">

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-funnel me-1"></i>
                            Apply Filter
                        </button>

                    </div>

                    @if ($status)

                        <div class="col-md-auto">

                            <a href="{{ route('member.borrowings.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg me-1"></i>
                                Clear Filter
                            </a>

                        </div>

                    @endif

                </div>

            </form>

        </div>

    </div>


    {{-- Borrowing History --}}
    <div class="content-card">

        <div class="card-header-modern">

            <div>

                <h5 class="mb-1">
                    <i class="bi bi-journal-bookmark me-2"></i>
                    Borrowing History
                </h5>

                <p class="text-muted small mb-0">
                    Your library borrowing records
                </p>

            </div>

            @if ($borrowings->total() > 0)

                <span class="badge bg-light text-dark border">
                    {{ $borrowings->total() }} Records
                </span>

            @endif

        </div>


        @if ($borrowings->isEmpty())

            <div class="empty-state py-5">

                <i class="bi bi-journal-x"></i>

                <h5 class="mt-3">
                    No Borrowings Found
                </h5>

                <p class="text-muted mb-0">
                    No borrowing records match the selected filter.
                </p>

                @if ($status)

                    <a href="{{ route('member.borrowings.index') }}" class="btn btn-outline-primary mt-3">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>
                        View All Borrowings
                    </a>

                @endif

            </div>

        @else

            <div class="table-responsive">

                <table class="table modern-table align-middle mb-0">

                    <thead>

                        <tr>

                            <th>
                                Book
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

                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($borrowings as $borrowing)

                            <tr>

                                {{-- Book --}}
                                <td>

                                    <div class="d-flex align-items-center gap-3">

                                        @if ($borrowing->book->cover_image)

                                            <img src="{{ asset('storage/' . $borrowing->book->cover_image) }}"
                                                alt="{{ $borrowing->book->title }}" class="rounded" style="
                                                                width: 45px;
                                                                height: 60px;
                                                                object-fit: cover;
                                                            ">

                                        @else

                                            <div class="d-flex align-items-center justify-content-center bg-light rounded" style="
                                                                width: 45px;
                                                                height: 60px;
                                                            ">
                                                <i class="bi bi-book text-muted fs-5"></i>
                                            </div>

                                        @endif

                                        <div>

                                            <div class="fw-semibold">
                                                {{ $borrowing->book->title }}
                                            </div>

                                            @if ($borrowing->book->isbn)

                                                <small class="text-muted">
                                                    ISBN: {{ $borrowing->book->isbn }}
                                                </small>

                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- Issued --}}
                                <td>

                                    <div class="fw-medium">
                                        {{ $borrowing->issued_at->format('d M Y') }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $borrowing->issued_at->format('h:i A') }}
                                    </small>

                                </td>


                                {{-- Due --}}
                                <td>

                                    <div class="fw-medium">
                                        {{ $borrowing->due_at->format('d M Y') }}
                                    </div>

                                    @if ($borrowing->isOverdue())

                                        <small class="text-danger fw-semibold">
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                            Overdue
                                        </small>

                                    @elseif (!$borrowing->returned_at)

                                        <small class="text-muted">
                                            {{ $borrowing->due_at->diffForHumans() }}
                                        </small>

                                    @endif

                                </td>


                                {{-- Returned --}}
                                <td>

                                    @if ($borrowing->returned_at)

                                        <div class="text-success fw-medium">
                                            {{ $borrowing->returned_at->format('d M Y') }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $borrowing->returned_at->format('h:i A') }}
                                        </small>

                                    @else

                                        <span class="text-muted">
                                            Not returned
                                        </span>

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td>

                                    @if ($borrowing->isOverdue())

                                        <span class="badge text-bg-danger">
                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                            Overdue
                                        </span>

                                    @elseif ($borrowing->status === 'returned')

                                        <span class="badge text-bg-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Returned
                                        </span>

                                    @else

                                        <span class="badge text-bg-primary">
                                            <i class="bi bi-bookmark me-1"></i>
                                            Borrowed
                                        </span>

                                    @endif

                                </td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if ($borrowings->hasPages())

                <div class="d-flex justify-content-between align-items-center p-3 border-top">

                    <small class="text-muted">

                        Showing
                        {{ $borrowings->firstItem() }}
                        –
                        {{ $borrowings->lastItem() }}
                        of
                        {{ $borrowings->total() }}

                    </small>

                    <div>
                        {{ $borrowings->links() }}
                    </div>

                </div>

            @endif

        @endif

    </div>

@endsection