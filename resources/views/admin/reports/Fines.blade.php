@extends('layouts.admin')

@section('title', 'Fine & Overdue Report')

@section('content')

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <div>
                <h2 class="fw-bold mb-1">

                    <i class="bi bi-cash-stack me-2"></i>

                    Fine & Overdue Report

                </h2>

                <p class="text-muted mb-0">

                    Monitor overdue books and fine payments.

                </p>
            </div>

            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">

                <i class="bi bi-arrow-left me-1"></i>

                Back to Reports

            </a>

        </div>


        {{-- Statistics --}}
        <div class="row g-4 mb-4">

            {{-- Overdue --}}
            <div class="col-md-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Overdue Books
                                </p>

                                <h3 class="fw-bold text-danger mb-0">
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


            {{-- Total Fine --}}
            <div class="col-md-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Total Fines
                                </p>

                                <h3 class="fw-bold mb-0">
                                    {{ number_format($totalFineAmount, 2) }}
                                </h3>

                            </div>

                            <div class="fs-2 text-primary">

                                <i class="bi bi-currency-exchange"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Paid --}}
            <div class="col-md-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Paid Fines
                                </p>

                                <h3 class="fw-bold text-success mb-0">
                                    {{ number_format($paidFineAmount, 2) }}
                                </h3>

                            </div>

                            <div class="fs-2 text-success">

                                <i class="bi bi-check-circle"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Unpaid --}}
            <div class="col-md-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Outstanding Fines
                                </p>

                                <h3 class="fw-bold text-danger mb-0">
                                    {{ number_format($unpaidFineAmount, 2) }}
                                </h3>

                            </div>

                            <div class="fs-2 text-danger">

                                <i class="bi bi-wallet2"></i>

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

                    Filter Fines

                </h5>

            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('admin.reports.fines') }}">

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
                            placeholder="Search book, ISBN, member or membership number..."
                            autocomplete="off"
                            data-live-search
                            data-autocomplete="fines">

                        </div>


                        {{-- Fine Status --}}
                        <div class="col-md-4 col-lg-3">

                            <label class="form-label fw-semibold">
                                Fine Status
                            </label>

                            <select name="fine_status" class="form-select">

                                <option value="">
                                    All
                                </option>

                                <option value="paid" @selected($fineStatus === 'paid')>
                                    Paid
                                </option>

                                <option value="unpaid" @selected($fineStatus === 'unpaid')>
                                    Unpaid
                                </option>

                            </select>

                        </div>


                        {{-- Overdue --}}
                        <div class="col-md-4 col-lg-2">

                            <label class="form-label fw-semibold">
                                Borrowing
                            </label>

                            <div class="form-check mt-2">

                                <input class="form-check-input" type="checkbox" name="overdue_only" value="1"
                                    id="overdueOnly" @checked($overdueOnly)>

                                <label class="form-check-label" for="overdueOnly">

                                    Overdue only

                                </label>

                            </div>

                        </div>


                        {{-- Buttons --}}
                        <div class="col-md-4 col-lg-2 d-flex align-items-end gap-2">

                            <button type="submit" class="btn btn-primary w-100">

                                <i class="bi bi-search me-1"></i>

                                Filter

                            </button>

                           

                        </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- Fine Table --}}
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <h5 class="mb-0 fw-bold">

                        <i class="bi bi-table me-2"></i>

                        Fine Records

                    </h5>

                    <span class="text-muted small">

                        {{ $fines->total() }} record(s)

                    </span>

                </div>

            </div>


            <div class="card-body p-0">

                @if($fines->count())

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
                                        Due Date
                                    </th>

                                    <th>
                                        Fine
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                    <th>
                                        Paid At
                                    </th>

                                    <th class="text-end px-3">
                                        Action
                                    </th>
                                </tr>

                            </thead>


                            <tbody>

                                @foreach($fines as $fine)

                                    @php
                                        $borrowing = $fine->borrowing;

                                        $overdueDays = 0;

                                        if (
                                            $borrowing?->due_at &&
                                            $borrowing->status === 'overdue'
                                        ) {
                                            $overdueDays = max(
                                                0,
                                                $borrowing->due_at->diffInDays(now())
                                            );
                                        }
                                    @endphp

                                    <tr>

                                        <td class="px-3">

                                            {{ $fines->firstItem() + $loop->index }}

                                        </td>


                                        {{-- Book --}}
                                        <td>

                                            <div class="fw-semibold">

                                                {{ $borrowing?->book?->title ?? 'N/A' }}

                                            </div>

                                            @if($borrowing?->book?->isbn)

                                                <small class="text-muted">

                                                    ISBN:
                                                    {{ $borrowing->book->isbn }}

                                                </small>

                                            @endif

                                        </td>


                                        {{-- Member --}}
                                        <td>

                                            <div class="fw-semibold">

                                                {{ $borrowing?->member?->user?->name ?? 'N/A' }}

                                            </div>

                                            @if($borrowing?->member?->membership_number)

                                                <small class="text-muted">

                                                    {{ $borrowing->member->membership_number }}

                                                </small>

                                            @endif

                                        </td>


                                        {{-- Due --}}
                                        <td>

                                            {{ $borrowing?->due_at?->format('d M Y') ?? '—' }}

                                            @if($overdueDays > 0)

                                                <br>

                                                <small class="text-danger">

                                                    {{ $overdueDays }}
                                                    day(s) overdue

                                                </small>

                                            @endif

                                        </td>


                                        {{-- Fine --}}
                                        <td>

                                            <span class="fw-bold">

                                                {{ number_format($fine->amount, 2) }}

                                            </span>

                                        </td>


                                        {{-- Status --}}
                                        <td>

                                            @if($fine->status === 'paid')

                                                <span class="badge bg-success">

                                                    Paid

                                                </span>

                                            @else

                                                <span class="badge bg-danger">

                                                    Unpaid

                                                </span>

                                            @endif

                                        </td>


                                        {{-- Paid At--}}
                                        <td>

                                            {{ $fine->paid_at?->format('d M Y') ?? '—' }}

                                        </td>

                                        <td class="text-end px-3">

                                            @if($fine->status === 'paid')

                                                <span class="text-success small fw-semibold">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Completed
                                                </span>

                                            @else

                                                <form action="{{ route('admin.borrowings.pay-fine', $borrowing) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('Mark this fine as paid?');">

                                                    @csrf

                                                    <button type="submit" class="btn btn-sm btn-success">

                                                        <i class="bi bi-check-circle me-1"></i>

                                                        Mark as Paid

                                                    </button>

                                                </form>

                                            @endif

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    @if($fines->hasPages())

                        <div class="p-3">

                            {{ $fines->links() }}

                        </div>

                    @endif

                @else

                    <div class="text-center py-5">

                        <div class="fs-1 text-muted mb-3">

                            <i class="bi bi-cash-stack"></i>

                        </div>

                        <h5 class="fw-bold">
                            No fine records found
                        </h5>

                        <p class="text-muted mb-0">

                            Try changing your filters.

                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection