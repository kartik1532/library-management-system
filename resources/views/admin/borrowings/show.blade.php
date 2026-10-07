@extends('layouts.admin')

@section('title', 'Borrowing Details')

@section('content')

<div class="container-fluid">

    <div class="d-flex align-items-center mb-4">

        <a href="{{ route('admin.borrowings.index') }}"
           class="btn btn-outline-secondary me-3">

            <i class="bi bi-arrow-left"></i>

        </a>

        <div>

            <h2 class="fw-bold mb-1">
                Borrowing Details
            </h2>

            <p class="text-muted mb-0">
                View complete issue and return information.
            </p>

        </div>

    </div>

    <div class="row g-4">

        <div class="col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0">
                        <i class="bi bi-book me-2"></i>
                        Book
                    </h5>

                </div>

                <div class="card-body">

                    <h4 class="fw-bold">
                        {{ $borrowing->book->title }}
                    </h4>

                    <p class="text-muted">
                        ISBN: {{ $borrowing->book->isbn }}
                    </p>

                    <p>
                        <strong>Author:</strong>
                        {{ $borrowing->book->author->name }}
                    </p>

                    <p>
                        <strong>Category:</strong>
                        {{ $borrowing->book->category->name }}
                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0">
                        <i class="bi bi-person me-2"></i>
                        Member
                    </h5>

                </div>

                <div class="card-body">

                    <h4 class="fw-bold">
                        {{ $borrowing->member->user->name }}
                    </h4>

                    <p class="text-muted">
                        {{ $borrowing->member->user->email }}
                    </p>

                    <p>
                        <strong>Membership:</strong>
                        {{ $borrowing->member->membership_number }}
                    </p>

                    <p>
                        <strong>Phone:</strong>
                        {{ $borrowing->member->phone ?: '—' }}
                    </p>

                </div>

            </div>

        </div>

        <div class="col-12">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0">
                        <i class="bi bi-calendar-event me-2"></i>
                        Borrowing Information
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-3">

                            <small class="text-muted d-block">
                                Issued
                            </small>

                            <strong>
                                {{ $borrowing->issued_at?->format('d M Y') }}
                            </strong>

                        </div>

                        <div class="col-md-3">

                            <small class="text-muted d-block">
                                Due
                            </small>

                            <strong>
                                {{ $borrowing->due_at?->format('d M Y') }}
                            </strong>

                        </div>

                        <div class="col-md-3">

                            <small class="text-muted d-block">
                                Returned
                            </small>

                            <strong>
                                {{ $borrowing->returned_at?->format('d M Y H:i') ?? 'Not returned' }}
                            </strong>

                        </div>

                        <div class="col-md-3">

                            <small class="text-muted d-block">
                                Status
                            </small>

                            @if($borrowing->status === 'borrowed')

                                <span class="badge bg-primary">
                                    Borrowed
                                </span>

                            @elseif($borrowing->status === 'overdue')

                                <span class="badge bg-danger">
                                    Overdue
                                </span>

                            @else

                                <span class="badge bg-success">
                                    Returned
                                </span>

                            @endif

                        </div>

                    </div>

                    @if(in_array($borrowing->status, ['borrowed', 'overdue'], true))

                        <hr>

                        <form method="POST"
                              action="{{ route('admin.borrowings.return', $borrowing) }}"
                              onsubmit="return confirm('Confirm book return?');">

                            @csrf

                            <button type="submit"
                                    class="btn btn-success">

                                <i class="bi bi-arrow-return-left me-1"></i>
                                Mark as Returned

                            </button>

                        </form>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection