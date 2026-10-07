@extends('layouts.admin')

@section('title', 'Reports')

@section('content')

<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-xl-row justify-content-between align-items-xl-center gap-3 mb-4">

        <div>

            <div class="d-flex align-items-center gap-2 mb-1">

                <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2">
                    <i class="bi bi-bar-chart-line-fill fs-5"></i>
                </div>

                <h1 class="h3 fw-bold mb-0">
                    Reports
                </h1>

            </div>

            <p class="text-muted mb-0 ms-5">
                Library statistics, inventory and borrowing insights.
            </p>

        </div>


        <div class="d-flex flex-wrap gap-2">

            <a href="{{ route('admin.reports.books') }}"
               class="btn btn-outline-success">

                <i class="bi bi-box-seam me-1"></i>
                Book Inventory

            </a>

            <a href="{{ route('admin.reports.borrowings') }}"
               class="btn btn-outline-primary">

                <i class="bi bi-arrow-left-right me-1"></i>
                Borrowing Report

            </a>

            <a href="{{ route('admin.reports.fines') }}"
               class="btn btn-outline-danger">

                <i class="bi bi-cash-stack me-1"></i>
                Fine Report

            </a>

            <button type="button"
                    class="btn btn-light border"
                    onclick="window.print()">

                <i class="bi bi-printer me-1"></i>
                Print

            </button>

        </div>

    </div>


    {{-- Main Statistics --}}
    <div class="row g-4 mb-4">


        {{-- Total Books --}}
        <div class="col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <p class="text-muted small fw-semibold mb-2">
                                Total Books
                            </p>

                            <h3 class="fw-bold mb-1">
                                {{ $totalBooks }}
                            </h3>

                            <small class="text-muted">
                                {{ $totalCopies }} total copies
                            </small>

                        </div>

                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">

                            <i class="bi bi-book fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Available Copies --}}
        <div class="col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <p class="text-muted small fw-semibold mb-2">
                                Available Copies
                            </p>

                            <h3 class="fw-bold mb-1">
                                {{ $availableCopies }}
                            </h3>

                            <small class="text-success">
                                Currently available
                            </small>

                        </div>

                        <div class="bg-success bg-opacity-10 text-success rounded-3 p-3">

                            <i class="bi bi-check-circle fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Issued Copies --}}
        <div class="col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <p class="text-muted small fw-semibold mb-2">
                                Issued Copies
                            </p>

                            <h3 class="fw-bold mb-1">
                                {{ $issuedCopies }}
                            </h3>

                            <small class="text-info">
                                Currently issued
                            </small>

                        </div>

                        <div class="bg-info bg-opacity-10 text-info rounded-3 p-3">

                            <i class="bi bi-journal-arrow-up fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Overdue --}}
        <div class="col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <p class="text-muted small fw-semibold mb-2">
                                Overdue
                            </p>

                            <h3 class="fw-bold mb-1">
                                {{ $overdueBooks }}
                            </h3>

                            <small class="text-danger">
                                Requires attention
                            </small>

                        </div>

                        <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3">

                            <i class="bi bi-exclamation-triangle fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Member & Borrowing Statistics --}}
    <div class="row g-4 mb-4">


        {{-- Member Statistics --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0 px-4 py-3">

                    <h5 class="mb-0 fw-semibold">

                        <i class="bi bi-people me-2 text-primary"></i>
                        Member Statistics

                    </h5>

                </div>

                <div class="card-body px-4">

                    <div class="row g-3">

                        <div class="col-4 text-center">

                            <div class="fs-3 fw-bold">
                                {{ $totalMembers }}
                            </div>

                            <small class="text-muted">
                                Total
                            </small>

                        </div>

                        <div class="col-4 text-center">

                            <div class="fs-3 fw-bold text-success">
                                {{ $activeMembers }}
                            </div>

                            <small class="text-muted">
                                Active
                            </small>

                        </div>

                        <div class="col-4 text-center">

                            <div class="fs-3 fw-bold text-secondary">
                                {{ $inactiveMembers }}
                            </div>

                            <small class="text-muted">
                                Inactive
                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Borrowing Statistics --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0 px-4 py-3">

                    <h5 class="mb-0 fw-semibold">

                        <i class="bi bi-arrow-left-right me-2 text-primary"></i>
                        Borrowing Statistics

                    </h5>

                </div>

                <div class="card-body px-4">

                    <div class="row g-3">

                        <div class="col-4 text-center">

                            <div class="fs-3 fw-bold text-primary">
                                {{ $borrowedBooks }}
                            </div>

                            <small class="text-muted">
                                Borrowed
                            </small>

                        </div>

                        <div class="col-4 text-center">

                            <div class="fs-3 fw-bold text-success">
                                {{ $returnedBooks }}
                            </div>

                            <small class="text-muted">
                                Returned
                            </small>

                        </div>

                        <div class="col-4 text-center">

                            <div class="fs-3 fw-bold text-danger">
                                {{ $overdueBooks }}
                            </div>

                            <small class="text-muted">
                                Overdue
                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Fine Statistics --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white border-0 px-4 py-3">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">

                <div>

                    <h5 class="mb-1 fw-semibold">

                        <i class="bi bi-cash-stack me-2 text-danger"></i>
                        Fine Statistics

                    </h5>

                    <small class="text-muted">
                        Overview of collected and outstanding fines.
                    </small>

                </div>

                <a href="{{ route('admin.reports.fines') }}"
                   class="btn btn-sm btn-outline-danger">

                    View Fine Report
                    <i class="bi bi-arrow-right ms-1"></i>

                </a>

            </div>

        </div>

        <div class="card-body px-4">

            <div class="row g-4">

                <div class="col-md-4 text-center">

                    <div class="fs-3 fw-bold">
                        {{ number_format($totalFines, 2) }}
                    </div>

                    <small class="text-muted">
                        Total Fines
                    </small>

                </div>

                <div class="col-md-4 text-center">

                    <div class="fs-3 fw-bold text-success">
                        {{ number_format($paidFines, 2) }}
                    </div>

                    <small class="text-muted">
                        Paid
                    </small>

                </div>

                <div class="col-md-4 text-center">

                    <div class="fs-3 fw-bold text-danger">
                        {{ number_format($unpaidFines, 2) }}
                    </div>

                    <small class="text-muted">
                        Unpaid
                    </small>

                </div>

            </div>

        </div>

    </div>


    {{-- Overdue Borrowings --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 px-4 py-3">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">

                <div>

                    <h5 class="mb-1 fw-semibold text-danger">

                        <i class="bi bi-exclamation-triangle me-1"></i>
                        Overdue Borrowings

                    </h5>

                    <small class="text-muted">
                        Books that require attention from the library staff.
                    </small>

                </div>

                <a href="{{ route('admin.reports.fines') }}"
                   class="btn btn-sm btn-outline-danger">

                    View Full Report
                    <i class="bi bi-arrow-right ms-1"></i>

                </a>

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="ps-4 text-muted small fw-semibold">
                                Book
                            </th>

                            <th class="text-muted small fw-semibold">
                                Member
                            </th>

                            <th class="text-muted small fw-semibold">
                                Due Date
                            </th>

                            <th class="text-muted small fw-semibold">
                                Overdue
                            </th>

                            <th class="text-muted small fw-semibold">
                                Fine
                            </th>

                            <th class="pe-4 text-muted small fw-semibold">
                                Fine Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($overdueBorrowings as $borrowing)

                            <tr>

                                {{-- Book --}}
                                <td class="ps-4">

                                    <div class="fw-semibold text-dark">

                                        {{ $borrowing->book->title ?? 'N/A' }}

                                    </div>

                                    @if($borrowing->book?->isbn)

                                        <div class="small text-muted">

                                            ISBN:
                                            {{ $borrowing->book->isbn }}

                                        </div>

                                    @endif

                                </td>


                                {{-- Member --}}
                                <td>

                                    <div class="fw-semibold text-dark">

                                        {{ $borrowing->member->user->name ?? 'N/A' }}

                                    </div>

                                    @if($borrowing->member?->membership_number)

                                        <div class="small text-muted">

                                            {{ $borrowing->member->membership_number }}

                                        </div>

                                    @endif

                                </td>


                                {{-- Due Date --}}
                                <td>

                                    {{ $borrowing->due_at?->format('d M Y') ?? '—' }}

                                </td>


                                {{-- Overdue Days --}}
                                <td>

                                    @php

                                        $overdueDays = $borrowing->due_at

                                            ? max(
                                                1,
                                                (int) ceil(
                                                    $borrowing->due_at->diffInSeconds(now()) / 86400
                                                )
                                            )

                                            : 0;

                                    @endphp

                                    <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">

                                        {{ $overdueDays }}
                                        {{ $overdueDays === 1 ? 'day' : 'days' }}

                                    </span>

                                </td>


                                {{-- Fine --}}
                                <td>

                                    @if($borrowing->fine)

                                        <span class="fw-semibold">

                                            {{ number_format((float) $borrowing->fine->amount, 2) }}

                                        </span>

                                    @else

                                        <span class="text-muted">
                                            &mdash;
                                        </span>

                                    @endif

                                </td>


                                {{-- Fine Status --}}
                                <td class="pe-4">

                                    @if($borrowing->fine)

                                        @if($borrowing->fine->status === 'paid')

                                            <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">

                                                <i class="bi bi-check-circle me-1"></i>
                                                Paid

                                            </span>

                                        @else

                                            <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">

                                                <i class="bi bi-exclamation-circle me-1"></i>
                                                Unpaid

                                            </span>

                                        @endif

                                    @else

                                        <span class="badge rounded-pill bg-secondary-subtle text-secondary px-3 py-2">

                                            No Fine

                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center py-5">

                                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                         style="width:64px;height:64px;">

                                        <i class="bi bi-check-circle fs-3"></i>

                                    </div>

                                    <h6 class="fw-semibold mb-1">
                                        No overdue borrowings
                                    </h6>

                                    <p class="text-muted mb-0">
                                        All books are currently within their due dates.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection