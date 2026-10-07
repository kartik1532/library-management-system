@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

{{-- =========================================================
     DASHBOARD HEADER
========================================================= --}}

<div class="dashboard-hero">

    <div>
        <div class="dashboard-eyebrow">
            <i class="bi bi-grid-1x2-fill"></i>
            ADMIN OVERVIEW
        </div>

        <h1 class="dashboard-heading">
            Welcome back, {{ auth()->user()->name }} 👋
        </h1>

        <p class="dashboard-description">
            Here's what's happening in your library today.
        </p>
    </div>

    <div class="dashboard-header-actions">

        <div class="dashboard-date">
            <i class="bi bi-calendar3"></i>
            <span>{{ now()->format('d M Y') }}</span>
        </div>

        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Add Book
        </a>

    </div>

</div>


{{-- =========================================================
     STATISTICS
========================================================= --}}

<div class="row g-4 mb-4">

    {{-- Total Books --}}
    <div class="col-sm-6 col-xl-4">

        <div class="stat-card">

            <div class="stat-card-top">

                <div class="stat-icon stat-icon-primary">
                    <i class="bi bi-book-fill"></i>
                </div>

                <span class="stat-trend">
                    <i class="bi bi-collection"></i>
                </span>

            </div>

            <div class="stat-label">
                Total Books
            </div>

            <div class="stat-value">
                {{ number_format($totalBooks) }}
            </div>

            <div class="stat-footer">
                <span>Books in library</span>
            </div>

        </div>

    </div>


    {{-- Available Copies --}}
    <div class="col-sm-6 col-xl-4">

        <div class="stat-card">

            <div class="stat-card-top">

                <div class="stat-icon stat-icon-success">
                    <i class="bi bi-bookmark-check-fill"></i>
                </div>

                <span class="stat-trend stat-trend-success">
                    <i class="bi bi-check-circle-fill"></i>
                </span>

            </div>

            <div class="stat-label">
                Available Copies
            </div>

            <div class="stat-value">
                {{ number_format($availableBooks) }}
            </div>

            <div class="stat-footer">
                <span>Ready to borrow</span>
            </div>

        </div>

    </div>


    {{-- Borrowed --}}
    <div class="col-sm-6 col-xl-4">

        <div class="stat-card">

            <div class="stat-card-top">

                <div class="stat-icon stat-icon-info">
                    <i class="bi bi-arrow-left-right"></i>
                </div>

                <span class="stat-trend">
                    <i class="bi bi-activity"></i>
                </span>

            </div>

            <div class="stat-label">
                Borrowed Books
            </div>

            <div class="stat-value">
                {{ number_format($borrowedBooks) }}
            </div>

            <div class="stat-footer">
                <span>Currently issued</span>
            </div>

        </div>

    </div>


    {{-- Members --}}
    <div class="col-sm-6 col-xl-4">

        <div class="stat-card">

            <div class="stat-card-top">

                <div class="stat-icon stat-icon-purple">
                    <i class="bi bi-people-fill"></i>
                </div>

                <span class="stat-trend">
                    <i class="bi bi-person-check-fill"></i>
                </span>

            </div>

            <div class="stat-label">
                Members
            </div>

            <div class="stat-value">
                {{ number_format($totalMembers) }}
            </div>

            <div class="stat-footer">
                <span>Registered members</span>
            </div>

        </div>

    </div>


    {{-- Overdue --}}
    <div class="col-sm-6 col-xl-4">

        <div class="stat-card stat-card-alert">

            <div class="stat-card-top">

                <div class="stat-icon stat-icon-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>

                <span class="stat-trend stat-trend-danger">
                    <i class="bi bi-clock-fill"></i>
                </span>

            </div>

            <div class="stat-label">
                Overdue Books
            </div>

            <div class="stat-value">
                {{ number_format($overdueBooks) }}
            </div>

            <div class="stat-footer">
                <span>Require attention</span>

                @if ($overdueBooks > 0)
                    <span class="text-danger fw-semibold">
                        Action needed
                    </span>
                @else
                    <span class="text-success fw-semibold">
                        All clear
                    </span>
                @endif

            </div>

        </div>

    </div>


    {{-- Fines --}}
    <div class="col-sm-6 col-xl-4">

        <div class="stat-card">

            <div class="stat-card-top">

                <div class="stat-icon stat-icon-warning">
                    <i class="bi bi-cash-coin"></i>
                </div>

                <span class="stat-trend">
                    <i class="bi bi-wallet2"></i>
                </span>

            </div>

            <div class="stat-label">
                Unpaid Fines
            </div>

            <div class="stat-value">
                ₹{{ number_format($unpaidFines, 2) }}
            </div>

            <div class="stat-footer">
                <span>Outstanding amount</span>
            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     QUICK ACTIONS
========================================================= --}}

<div class="content-card quick-actions-card mb-4">

    <div class="quick-actions-header">

        <div>

            <div class="section-eyebrow">
                QUICK ACTIONS
            </div>

            <h5 class="mb-1">
                Manage your library
            </h5>

            <p class="text-muted small mb-0">
                Frequently used administrative actions.
            </p>

        </div>

    </div>


    <div class="quick-actions-grid">

        <a href="{{ route('admin.books.create') }}" class="quick-action">

            <div class="quick-action-icon quick-action-primary">
                <i class="bi bi-plus-lg"></i>
            </div>

            <div>
                <strong>Add Book</strong>
                <span>Create a new book record</span>
            </div>

            <i class="bi bi-arrow-right quick-action-arrow"></i>

        </a>


        <a href="{{ route('admin.members.create') }}" class="quick-action">

            <div class="quick-action-icon quick-action-purple">
                <i class="bi bi-person-plus-fill"></i>
            </div>

            <div>
                <strong>Add Member</strong>
                <span>Register a library member</span>
            </div>

            <i class="bi bi-arrow-right quick-action-arrow"></i>

        </a>


        <a href="{{ route('admin.borrowings.create') }}" class="quick-action">

            <div class="quick-action-icon quick-action-success">
                <i class="bi bi-arrow-left-right"></i>
            </div>

            <div>
                <strong>Issue Book</strong>
                <span>Create a borrowing record</span>
            </div>

            <i class="bi bi-arrow-right quick-action-arrow"></i>

        </a>


        <a href="{{ route('admin.reports.index') }}" class="quick-action">

            <div class="quick-action-icon quick-action-warning">
                <i class="bi bi-bar-chart-fill"></i>
            </div>

            <div>
                <strong>View Reports</strong>
                <span>Analyze library activity</span>
            </div>

            <i class="bi bi-arrow-right quick-action-arrow"></i>

        </a>

    </div>

</div>


{{-- =========================================================
     RECENT BORROWINGS + RECENT BOOKS
========================================================= --}}

<div class="row g-4 mb-4">

    {{-- Recent Borrowings --}}
    <div class="col-xl-8">

        <div class="content-card h-100">

            <div class="card-header-modern">

                <div>

                    <div class="section-eyebrow">
                        LIBRARY ACTIVITY
                    </div>

                    <h5 class="mb-1">
                        Recent Borrowings
                    </h5>

                    <p class="text-muted small mb-0">
                        Latest borrowing activity
                    </p>

                </div>

                <a
                    href="{{ route('admin.borrowings.index') }}"
                    class="btn btn-sm btn-light border"
                >
                    View all
                    <i class="bi bi-arrow-right ms-1"></i>
                </a>

            </div>


            @if ($recentBorrowings->isEmpty())

                <div class="empty-state">

                    <div class="empty-state-icon">
                        <i class="bi bi-journal-x"></i>
                    </div>

                    <h6>
                        No borrowing activity
                    </h6>

                    <p class="text-muted mb-0">
                        Borrowing records will appear here.
                    </p>

                </div>

            @else

                <div class="table-responsive">

                    <table class="table modern-table align-middle mb-0">

                        <thead>
                            <tr>
                                <th>Book</th>
                                <th>Member</th>
                                <th>Issued</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                        @foreach ($recentBorrowings as $borrowing)

                            <tr>

                                <td>

                                    <div class="dashboard-book-cell">

                                        <div class="dashboard-book-icon">
                                            <i class="bi bi-book"></i>
                                        </div>

                                        <div class="min-width-0">

                                            <div
                                                class="fw-semibold text-truncate"
                                                title="{{ $borrowing->book->title }}"
                                            >
                                                {{ $borrowing->book->title }}
                                            </div>

                                            @if ($borrowing->book->isbn)

                                                <small class="text-muted">
                                                    {{ $borrowing->book->isbn }}
                                                </small>

                                            @endif

                                        </div>

                                    </div>

                                </td>


                                <td>

                                    <div class="member-cell">

                                        <div class="avatar avatar-sm">
                                            {{ strtoupper(substr($borrowing->member->user->name, 0, 1)) }}
                                        </div>

                                        <span class="fw-medium">
                                            {{ $borrowing->member->user->name }}
                                        </span>

                                    </div>

                                </td>


                                <td>

                                    <div class="fw-medium">
                                        {{ $borrowing->issued_at->format('d M Y') }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $borrowing->issued_at->format('h:i A') }}
                                    </small>

                                </td>


                                <td>

                                    @if ($borrowing->status === 'returned')

                                        <span class="status-badge status-success">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Returned
                                        </span>

                                    @elseif ($borrowing->isOverdue())

                                        <span class="status-badge status-danger">
                                            <i class="bi bi-exclamation-circle-fill"></i>
                                            Overdue
                                        </span>

                                    @else

                                        <span class="status-badge status-primary">
                                            <i class="bi bi-bookmark-fill"></i>
                                            Borrowed
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </div>

    </div>


    {{-- Recently Added Books --}}
    <div class="col-xl-4">

        <div class="content-card h-100">

            <div class="card-header-modern">

                <div>

                    <div class="section-eyebrow">
                        CATALOG
                    </div>

                    <h5 class="mb-1">
                        Recently Added
                    </h5>

                    <p class="text-muted small mb-0">
                        Latest books
                    </p>

                </div>

                <a
                    href="{{ route('admin.books.index') }}"
                    class="icon-btn"
                    title="View books"
                >
                    <i class="bi bi-arrow-up-right"></i>
                </a>

            </div>


            @if ($recentBooks->isEmpty())

                <div class="empty-state">

                    <div class="empty-state-icon">
                        <i class="bi bi-book"></i>
                    </div>

                    <p class="mb-0">
                        No books have been added yet.
                    </p>

                </div>

            @else

                <div class="recent-books-list">

                    @foreach ($recentBooks as $book)

                        <div class="book-list-item">

                            <div class="book-list-icon">
                                <i class="bi bi-book-fill"></i>
                            </div>

                            <div class="flex-grow-1 min-width-0">

                                <div
                                    class="fw-semibold text-truncate"
                                    title="{{ $book->title }}"
                                >
                                    {{ $book->title }}
                                </div>

                                <small class="text-muted text-truncate d-block">
                                    {{ $book->author->name ?? 'Unknown Author' }}
                                </small>

                            </div>

                            <div class="book-availability">

                                <strong>
                                    {{ $book->available_quantity }}
                                </strong>

                                <small>
                                    available
                                </small>

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        </div>

    </div>

</div>


{{-- =========================================================
     OVERDUE BORROWINGS
========================================================= --}}

<div class="content-card overdue-card">

    <div class="card-header-modern">

        <div>

            <div class="section-eyebrow text-danger">
                ATTENTION REQUIRED
            </div>

            <h5 class="mb-1">
                Overdue Borrowings
            </h5>

            <p class="text-muted small mb-0">
                Books that have passed their due date
            </p>

        </div>

        @if ($overdueBooks > 0)

            <span class="status-badge status-danger">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ number_format($overdueBooks) }} overdue
            </span>

        @else

            <span class="status-badge status-success">
                <i class="bi bi-check-circle-fill"></i>
                All clear
            </span>

        @endif

    </div>


    @if ($overdueBorrowings->isEmpty())

        <div class="empty-state">

            <div class="empty-state-icon empty-success">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <h6>
                Everything looks good
            </h6>

            <p class="text-muted mb-0">
                There are currently no overdue books.
            </p>

        </div>

    @else

        <div class="table-responsive">

            <table class="table modern-table align-middle mb-0">

                <thead>

                    <tr>
                        <th>Member</th>
                        <th>Book</th>
                        <th>Issued</th>
                        <th>Due Date</th>
                        <th>Overdue</th>
                    </tr>

                </thead>

                <tbody>

                @foreach ($overdueBorrowings as $borrowing)

                    @php
                        $overdueDays = max(
                            1,
                            (int) ceil(
                                $borrowing->due_at->diffInSeconds(now()) / 86400
                            )
                        );
                    @endphp

                    <tr>

                        <td>

                            <div class="member-cell">

                                <div class="avatar avatar-sm avatar-danger">
                                    {{ strtoupper(substr($borrowing->member->user->name, 0, 1)) }}
                                </div>

                                <div>

                                    <div class="fw-semibold">
                                        {{ $borrowing->member->user->name }}
                                    </div>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="fw-semibold">
                                {{ $borrowing->book->title }}
                            </div>

                            @if ($borrowing->book->isbn)

                                <small class="text-muted">
                                    ISBN: {{ $borrowing->book->isbn }}
                                </small>

                            @endif

                        </td>


                        <td>
                            {{ $borrowing->issued_at->format('d M Y') }}
                        </td>


                        <td>

                            <span class="fw-semibold text-danger">
                                {{ $borrowing->due_at->format('d M Y') }}
                            </span>

                        </td>


                        <td>

                            <span class="status-badge status-danger">
                                <i class="bi bi-clock-fill"></i>

                                {{ $overdueDays }}

                                {{ $overdueDays === 1 ? 'day' : 'days' }}

                            </span>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    @endif

</div>

@endsection