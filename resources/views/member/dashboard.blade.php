@extends('layouts.member')

@section('title', 'Member Dashboard')

@section('content')

    <div class="page-header">

        <div>
            <h1 class="page-title">
                My Dashboard
            </h1>

            <p class="text-muted mb-0">
                Welcome, {{ auth()->user()->name }}.
            </p>
        </div>

    </div>

    <div class="row g-4 mb-4">

        <div class="col-sm-6 col-xl-3">

            <div class="dashboard-card">

                <div class="dashboard-icon">
                    <i class="bi bi-journal-bookmark"></i>
                </div>

                <div>
                    <div class="dashboard-label">
                        Currently Borrowed
                    </div>

                    <div class="dashboard-value">
                        {{ $currentBorrowings }}
                    </div>
                </div>

            </div>

        </div>

        <div class="col-sm-6 col-xl-3">

            <div class="dashboard-card">

                <div class="dashboard-icon">
                    <i class="bi bi-exclamation-circle"></i>
                </div>

                <div>
                    <div class="dashboard-label">
                        Overdue Books
                    </div>

                    <div class="dashboard-value">
                        {{ $overdueBooks }}
                    </div>
                </div>

            </div>

        </div>

        <div class="col-sm-6 col-xl-3">

            <div class="dashboard-card">

                <div class="dashboard-icon">
                    <i class="bi bi-clock-history"></i>
                </div>

                <div>
                    <div class="dashboard-label">
                        Total Borrowings
                    </div>

                    <div class="dashboard-value">
                        {{ $totalBorrowings }}
                    </div>
                </div>

            </div>

        </div>

        <div class="col-sm-6 col-xl-3">

            <div class="dashboard-card">

                <div class="dashboard-icon">
                    <i class="bi bi-cash-coin"></i>
                </div>

                <div>
                    <div class="dashboard-label">
                        Unpaid Fines
                    </div>

                    <div class="dashboard-value">
                        {{ number_format($unpaidFines, 2) }}
                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="content-card mb-4">

        {{-- Quick Actions --}}

        <div class="content-card mb-4">

            <div class="card-header-modern">

                <div>

                    <h5 class="mb-1">
                        Quick Actions
                    </h5>

                    <p class="text-muted small mb-0">
                        Quickly access your library services
                    </p>

                </div>

            </div>


            <div class="row g-3">

                {{-- Browse Books --}}
                <div class="col-md-6 col-xl-3">

                    <a href="{{ route('member.books.index') }}" class="text-decoration-none">

                        <div class="quick-action-card">

                            <div class="quick-action-icon">
                                <i class="bi bi-book"></i>
                            </div>

                            <div>

                                <div class="fw-semibold text-dark">
                                    Browse Books
                                </div>

                                <small class="text-muted">
                                    Find available books
                                </small>

                            </div>

                        </div>

                    </a>

                </div>


                {{-- My Borrowings --}}
                <div class="col-md-6 col-xl-3">

                    <a href="{{ route('member.borrowings.index') }}" class="text-decoration-none">

                        <div class="quick-action-card">

                            <div class="quick-action-icon">
                                <i class="bi bi-journal-bookmark"></i>
                            </div>

                            <div>

                                <div class="fw-semibold text-dark">
                                    My Borrowings
                                </div>

                                <small class="text-muted">
                                    View your borrowing history
                                </small>

                            </div>

                        </div>

                    </a>

                </div>


                {{-- My Fines --}}
                <div class="col-md-6 col-xl-3">

                    <a href="{{ route('member.fines.index') }}" class="text-decoration-none">

                        <div class="quick-action-card">

                            <div class="quick-action-icon">
                                <i class="bi bi-cash-coin"></i>
                            </div>

                            <div>

                                <div class="fw-semibold text-dark">
                                    My Fines
                                </div>

                                <small class="text-muted">
                                    Check your fines
                                </small>

                            </div>

                        </div>

                    </a>

                </div>


                {{-- My Profile --}}
                <div class="col-md-6 col-xl-3">

                    <a href="{{ route('member.profile.edit') }}" class="text-decoration-none">

                        <div class="quick-action-card">

                            <div class="quick-action-icon">
                                <i class="bi bi-person-circle"></i>
                            </div>

                            <div>

                                <div class="fw-semibold text-dark">
                                    My Profile
                                </div>

                                <small class="text-muted">
                                    Manage your profile
                                </small>

                            </div>

                        </div>

                    </a>

                </div>

            </div>

        </div>
        <div class="card-header-modern">

            <div>
                <h5 class="mb-1">
                    Recent Borrowing History
                </h5>

                <p class="text-muted small mb-0">
                    Your latest library activity
                </p>
            </div>

        </div>

        @if ($recentBorrowings->isEmpty())

            <div class="empty-state">

                <i class="bi bi-journal-x"></i>

                <p>
                    You have no borrowing history yet.
                </p>

            </div>

        @else

            <div class="table-responsive">

                <table class="table modern-table align-middle mb-0">

                    <thead>

                        <tr>
                            <th>Book</th>
                            <th>Issued</th>
                            <th>Due</th>
                            <th>Returned</th>
                            <th>Status</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($recentBorrowings as $borrowing)

                            <tr>

                                <td class="fw-semibold">
                                    {{ $borrowing->book->title }}
                                </td>

                                <td>
                                    {{ $borrowing->issued_at->format('d M Y') }}
                                </td>

                                <td>
                                    {{ $borrowing->due_at->format('d M Y') }}
                                </td>

                                <td>

                                    @if ($borrowing->returned_at)

                                        {{ $borrowing->returned_at->format('d M Y') }}

                                    @else

                                        <span class="text-muted">
                                            Not returned
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @if ($borrowing->isOverdue())

                                        <span class="badge text-bg-danger">
                                            Overdue
                                        </span>

                                    @elseif ($borrowing->status === 'returned')

                                        <span class="badge text-bg-success">
                                            Returned
                                        </span>

                                    @else

                                        <span class="badge text-bg-primary">
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

    {{-- Notifications --}}

    <div class="content-card">

        <div class="card-header-modern">

            <div>
                <h5 class="mb-1">
                    Notifications
                </h5>

                <p class="text-muted small mb-0">
                    Your latest unread notifications
                </p>
            </div>

            <div class="d-flex align-items-center gap-2">

                @if ($unreadNotificationCount > 0)

                    <span class="badge bg-danger">
                        {{ $unreadNotificationCount }} unread
                    </span>

                @endif

                <a href="{{ route('member.notifications.index') }}" class="btn btn-sm btn-outline-primary">
                    View All
                </a>

            </div>

        </div>

        @if ($unreadNotifications->isEmpty())

            <div class="empty-state">

                <i class="bi bi-bell-slash"></i>

                <p>
                    You have no unread notifications.
                </p>

            </div>

        @else

            <div class="list-group list-group-flush">

                @foreach ($unreadNotifications as $notification)

                    <div class="list-group-item px-0 py-3">

                        <div class="d-flex justify-content-between align-items-start gap-3">

                            <div class="d-flex gap-3">

                                <div class="dashboard-icon flex-shrink-0">
                                    <i class="bi bi-bell"></i>
                                </div>

                                <div>

                                    <div class="fw-semibold">
                                        {{ $notification->data['message'] ?? 'New notification' }}
                                    </div>

                                    @if (!empty($notification->data['due_at']))

                                        <div class="text-muted small mt-1">

                                            Due:
                                            {{ \Carbon\Carbon::parse($notification->data['due_at'])->format('d M Y, h:i A') }}

                                        </div>

                                    @endif

                                    <div class="text-muted small mt-1">

                                        {{ $notification->created_at->diffForHumans() }}

                                    </div>

                                </div>

                            </div>

                            <form action="{{ route('member.notifications.read', $notification->id) }}" method="POST">
                                @csrf

                                <button type="submit" class="btn btn-sm btn-outline-secondary" title="Mark as read">
                                    <i class="bi bi-check2"></i>
                                </button>

                            </form>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

@endsection