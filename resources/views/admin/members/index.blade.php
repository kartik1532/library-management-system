@extends('layouts.admin')

@section('title', 'Members')

@section('content')

    <div class="container-fluid py-4">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <div class="d-flex align-items-center gap-2 mb-1">

                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2">
                        <i class="bi bi-people-fill fs-5"></i>
                    </div>

                    <h1 class="h3 fw-bold mb-0">
                        Members
                    </h1>

                </div>

                <p class="text-muted mb-0 ms-5">
                    Manage library members and their borrowing activity.
                </p>

            </div>

            <a href="{{ route('admin.members.create') }}" class="btn btn-primary px-3">

                <i class="bi bi-person-plus me-1"></i>
                Add Member

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


        {{-- Search Card --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body">
                <form method="GET" action="{{ route('admin.members.index') }}">

                    <div class="row g-2">

                        <div class="col-md-10">

                            <div class="autocomplete-wrapper">

                                <div class="input-group">

                                    <span class="input-group-text bg-white">
                                        <i class="bi bi-search"></i>
                                    </span>

                                    <input type="search" name="search" value="" class="form-control global-search-input"
                                        placeholder="Search name, email, membership number or phone..." autocomplete="off"
                                        data-live-search data-autocomplete="members">

                                </div>

                            </div>

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


        {{-- Members Table Card --}}
        <div class="card border-0 shadow-sm">

            {{-- Card Header --}}
            <div class="card-header bg-white border-0 px-4 py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="mb-1 fw-semibold">
                            Member List
                        </h5>

                        <small class="text-muted">
                            Manage registered library members.
                        </small>

                    </div>

                    <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">

                        <i class="bi bi-people me-1"></i>

                        {{ $members->total() }}
                        {{ $members->total() === 1 ? 'Member' : 'Members' }}

                    </span>

                </div>

            </div>


            {{-- Table --}}
            <div class="card-body p-0">

                @if($members->count())

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th class="ps-4 text-muted small fw-semibold" style="width: 60px;">
                                        #
                                    </th>

                                    <th class="text-muted small fw-semibold">
                                        Member
                                    </th>

                                    <th class="text-muted small fw-semibold">
                                        Membership No.
                                    </th>

                                    <th class="text-muted small fw-semibold">
                                        Phone
                                    </th>

                                    <th class="text-muted small fw-semibold">
                                        Join Date
                                    </th>

                                    <th class="text-muted small fw-semibold">
                                        Status
                                    </th>

                                    <th class="text-muted small fw-semibold text-center">
                                        Active Books
                                    </th>

                                    <th class="pe-4 text-end text-muted small fw-semibold">
                                        Actions
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($members as $member)

                                    <tr>

                                        {{-- Number --}}
                                        <td class="ps-4 text-muted">

                                            {{ $members->firstItem() + $loop->index }}

                                        </td>


                                        {{-- Member --}}
                                        <td>

                                            <div class="d-flex align-items-center">

                                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                                    style="width:42px;height:42px;">

                                                    <i class="bi bi-person"></i>

                                                </div>

                                                <div class="ms-3">

                                                    <div class="fw-semibold text-dark">

                                                        {{ $member->user->name }}

                                                    </div>

                                                    <div class="small text-muted">

                                                        {{ $member->user->email }}

                                                    </div>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- Membership Number --}}
                                        <td>

                                            <span class="badge rounded-pill bg-light text-dark border px-3 py-2">

                                                <i class="bi bi-person-vcard me-1 text-muted"></i>

                                                {{ $member->membership_number }}

                                            </span>

                                        </td>


                                        {{-- Phone --}}
                                        <td>

                                            @if($member->phone)

                                                <span class="text-dark">
                                                    {{ $member->phone }}
                                                </span>

                                            @else

                                                <span class="text-muted">
                                                    &mdash;
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Join Date --}}
                                        <td>

                                            @if($member->join_date)

                                                <span class="text-dark">

                                                    {{ $member->join_date->format('d M Y') }}

                                                </span>

                                            @else

                                                <span class="text-muted">
                                                    &mdash;
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Status --}}
                                        <td>

                                            @if($member->status === 'active')

                                                <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">

                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Active

                                                </span>

                                            @else

                                                <span class="badge rounded-pill bg-secondary-subtle text-secondary px-3 py-2">

                                                    <i class="bi bi-dash-circle me-1"></i>
                                                    Inactive

                                                </span>

                                            @endif

                                        </td>


                                        {{-- Active Books --}}
                                        <td class="text-center">

                                            @if($member->active_borrowings_count > 0)

                                                <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis px-3 py-2">

                                                    <i class="bi bi-book me-1"></i>

                                                    {{ $member->active_borrowings_count }}

                                                </span>

                                            @else

                                                <span class="text-muted">
                                                    0
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Actions --}}
                                        <td class="pe-4 text-end">

                                            <div class="d-inline-flex gap-1">

                                                <a href="{{ route('admin.members.show', $member) }}"
                                                    class="btn btn-sm btn-light border" title="View Member">

                                                    <i class="bi bi-eye"></i>

                                                </a>

                                                <a href="{{ route('admin.members.edit', $member) }}"
                                                    class="btn btn-sm btn-light border" title="Edit Member">

                                                    <i class="bi bi-pencil"></i>

                                                </a>


                                                @if($member->active_borrowings_count === 0 && $member->borrowings_count === 0)

                                                    <form action="{{ route('admin.members.destroy', $member) }}" method="POST"
                                                        class="d-inline" onsubmit="return confirm('Delete this member?');">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-sm btn-light border text-danger"
                                                            title="Delete Member">

                                                            <i class="bi bi-trash"></i>

                                                        </button>

                                                    </form>

                                                @endif

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    {{-- Pagination --}}
                    @if($members->hasPages())

                        <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">

                            <div class="text-muted small">

                                Showing
                                <strong>{{ $members->firstItem() }}</strong>
                                to
                                <strong>{{ $members->lastItem() }}</strong>
                                of
                                <strong>{{ $members->total() }}</strong>
                                members

                            </div>

                            <div>

                                {{ $members->withQueryString()->links() }}

                            </div>

                        </div>

                    @endif


                @else

                    {{-- Empty State --}}
                    <div class="text-center py-5 px-4">

                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:72px;height:72px;">

                            <i class="bi bi-people text-muted fs-2"></i>

                        </div>

                        <h5 class="fw-semibold mb-2">
                            No members found
                        </h5>

                        <p class="text-muted mb-4">

                            @if($search)

                                No members matched your search.
                                Try a different search term.

                            @else

                                No library members have been registered yet.

                            @endif

                        </p>

                        @if($search)

                            <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary me-2">

                                <i class="bi bi-arrow-counterclockwise me-1"></i>
                                Clear Search

                            </a>

                        @endif

                        <a href="{{ route('admin.members.create') }}" class="btn btn-primary">

                            <i class="bi bi-person-plus me-1"></i>
                            Add Member

                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection