@extends('layouts.admin')

@section('title', 'Issue Book')

@section('content')

<div class="container-fluid">

    <div class="d-flex align-items-center mb-4">

        <a href="{{ route('admin.borrowings.index') }}"
           class="btn btn-outline-secondary me-3">

            <i class="bi bi-arrow-left"></i>

        </a>

        <div>

            <h2 class="fw-bold mb-1">
                Issue Book
            </h2>

            <p class="text-muted mb-0">
                Issue an available book to an active member.
            </p>

        </div>

    </div>

    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Unable to issue the book:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.borrowings.store') }}">

                @csrf

                <div class="row g-4">

                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Book <span class="text-danger">*</span>
                        </label>

                        <select name="book_id"
                                class="form-select @error('book_id') is-invalid @enderror"
                                required>

                            <option value="">
                                Select a book
                            </option>

                            @foreach($books as $book)

                                <option value="{{ $book->id }}"
                                    @selected(old('book_id') == $book->id)>

                                    {{ $book->title }}
                                    — {{ $book->isbn }}
                                    — Available: {{ $book->available_quantity }}

                                </option>

                            @endforeach

                        </select>

                        @error('book_id')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Member <span class="text-danger">*</span>
                        </label>

                        <select name="member_id"
                                class="form-select @error('member_id') is-invalid @enderror"
                                required>

                            <option value="">
                                Select a member
                            </option>

                            @foreach($members as $member)

                                <option value="{{ $member->id }}"
                                    @selected(old('member_id') == $member->id)>

                                    {{ $member->user->name }}
                                    — {{ $member->membership_number }}

                                </option>

                            @endforeach

                        </select>

                        @error('member_id')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Issue Date <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                               name="issued_at"
                               class="form-control @error('issued_at') is-invalid @enderror"
                               value="{{ old('issued_at', now()->format('Y-m-d')) }}"
                               required>

                        @error('issued_at')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Due Date <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                               name="due_at"
                               class="form-control @error('due_at') is-invalid @enderror"
                               value="{{ old('due_at', now()->addDays(14)->format('Y-m-d')) }}"
                               required>

                        @error('due_at')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>

                <div class="alert alert-info mt-4">

                    <i class="bi bi-info-circle me-2"></i>

                    When the book is issued,
                    <strong>available quantity will automatically decrease by 1</strong>.

                    When it is returned,
                    the quantity will automatically increase by 1.

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a href="{{ route('admin.borrowings.index') }}"
                       class="btn btn-outline-secondary">

                        Cancel

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-journal-arrow-up me-1"></i>
                        Issue Book

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection