@extends('layouts.member')

@section('title', 'My Fines')

@section('content')

    <div class="page-header">

        <div>
            <h1 class="page-title">
                My Fines
            </h1>

            <p class="text-muted mb-0">
                View your library fines and payment status.
            </p>
        </div>

    </div>

    {{-- Fine Summary --}}

    <div class="row g-4 mb-4">

        <div class="col-sm-6 col-xl-4">

            <div class="dashboard-card">

                <div class="dashboard-icon">
                    <i class="bi bi-cash-stack"></i>
                </div>

                <div>

                    <div class="dashboard-label">
                        Total Fines
                    </div>

                    <div class="dashboard-value">
                        {{ number_format($totalFines, 2) }}
                    </div>

                </div>

            </div>

        </div>

        <div class="col-sm-6 col-xl-4">

            <div class="dashboard-card">

                <div class="dashboard-icon">
                    <i class="bi bi-exclamation-circle"></i>
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

        <div class="col-sm-6 col-xl-4">

            <div class="dashboard-card">

                <div class="dashboard-icon">
                    <i class="bi bi-check-circle"></i>
                </div>

                <div>

                    <div class="dashboard-label">
                        Paid Fines
                    </div>

                    <div class="dashboard-value">
                        {{ number_format($paidFines, 2) }}
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Filter --}}

    <div class="content-card mb-4">

        <div class="card-header-modern">
            <div>
                <h5 class="mb-1">
                    <i class="bi bi-funnel me-2"></i>
                    Filter Fines
                </h5>

                <p class="text-muted small mb-0">
                    Filter your fine history by payment status.
                </p>
            </div>
        </div>

        <div class="p-3">

            <form action="{{ route('member.fines.index') }}" method="GET">

                <div class="row g-3 align-items-end">

                    <div class="col-md-5">

                        <label for="status" class="form-label fw-semibold">
                            Fine Status
                        </label>

                        <select name="status" id="status" class="form-select">

                            <option value="">
                                All Fines
                            </option>

                            <option value="unpaid" @selected($status === 'unpaid')>
                                Unpaid
                            </option>

                            <option value="paid" @selected($status === 'paid')>
                                Paid
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

                            <a href="{{ route('member.fines.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg me-1"></i>
                                Clear Filter
                            </a>

                        </div>

                    @endif

                </div>

            </form>

        </div>

    </div>

    <div class="content-card">

        <div class="card-header-modern">

            <div>

                <h5 class="mb-1">
                    <i class="bi bi-cash-stack me-2"></i>
                    Fine History
                </h5>

                <p class="text-muted small mb-0">
                    Your borrowing fines
                </p>

            </div>

            @if ($fines->total() > 0)

                <span class="badge bg-light text-dark border">
                    {{ $fines->total() }} Records
                </span>

            @endif

        </div>


        @if ($fines->isEmpty())

            <div class="empty-state py-5">

                <i class="bi bi-cash-stack"></i>

                <h5 class="mt-3">
                    No Fines Found
                </h5>

                <p class="text-muted mb-0">
                    You currently have no fines matching the selected filter.
                </p>

            </div>

        @else

            <div class="table-responsive">

                <table class="table modern-table align-middle mb-0">

                    <thead>

                        <tr>
                            <th class="text-start">
                                Book
                            </th>

                            <th>
                                Due Date
                            </th>

                            <th>
                                Returned
                            </th>

                            <th>
                                Amount
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Paid Date
                            </th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($fines as $fine)

                            <tr>

                                {{-- Book --}}
                                <td>

                                    <div class="fw-semibold">
                                        {{ $fine->borrowing->book->title }}
                                    </div>

                                    @if ($fine->borrowing->book->isbn)

                                        <small class="text-muted">
                                            ISBN: {{ $fine->borrowing->book->isbn }}
                                        </small>

                                    @endif

                                </td>


                                {{-- Due Date --}}
                                <td class="text-nowrap">

                                    <div class="fw-medium">
                                        {{ $fine->borrowing->due_at->format('d M Y') }}
                                    </div>

                                </td>


                                {{-- Returned --}}
                                <td class="text-nowrap">

                                    @if ($fine->borrowing->returned_at)

                                        <div class="fw-medium text-success">
                                            {{ $fine->borrowing->returned_at->format('d M Y') }}
                                        </div>

                                    @else

                                        <span class="text-muted">
                                            Not returned
                                        </span>

                                    @endif

                                </td>


                                {{-- Amount --}}
                                <td class="text-nowrap">

                                    <span class="fw-semibold">
                                        ₹{{ number_format($fine->amount, 2) }}
                                    </span>

                                </td>


                                {{-- Status --}}
                                <td>

                                    @if ($fine->status === 'paid')

                                        <span class="badge text-bg-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Paid
                                        </span>

                                    @else

                                        <span class="badge text-bg-danger">
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                            Unpaid
                                        </span>

                                    @endif

                                </td>


                                {{-- Paid Date --}}
                                <td class="text-nowrap">

                                    @if ($fine->paid_at)

                                        {{ $fine->paid_at->format('d M Y') }}

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

            @if ($fines->hasPages())

                <div class="d-flex justify-content-between align-items-center p-3 border-top">

                    <small class="text-muted">
                        Showing
                        {{ $fines->firstItem() }}
                        –
                        {{ $fines->lastItem() }}
                        of
                        {{ $fines->total() }}
                    </small>

                    <div>
                        {{ $fines->links() }}
                    </div>

                </div>

            @endif

        @endif

    </div>
@endsection