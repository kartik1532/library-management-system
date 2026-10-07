@extends('layouts.admin')

@section('title', 'Edit Borrowing')

@section('content')

<div class="container-fluid">

    <div class="d-flex align-items-center mb-4">

        <a href="{{ route('admin.borrowings.index') }}"
           class="btn btn-outline-secondary me-3">

            <i class="bi bi-arrow-left"></i>

        </a>

        <div>

            <h2 class="fw-bold mb-1">
                Edit Borrowing
            </h2>

            <p class="text-muted mb-0">
                Update issue and due dates.
            </p>

        </div>

    </div>

    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="alert alert-light border">

                <strong>Book:</strong>
                {{ $borrowing->book->title }}

                <br>

                <strong>Member:</strong>
                {{ $borrowing->member->user->name }}

            </div>

            <form method="POST"
                  action="{{ route('admin.borrowings.update', $borrowing) }}">

                @csrf
                @method('PUT')

                <div class="row g-4">

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Issue Date
                        </label>

                        <input type="date"
                               name="issued_at"
                               class="form-control"
                               value="{{ old('issued_at', $borrowing->issued_at?->format('Y-m-d')) }}"
                               required>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Due Date
                        </label>

                        <input type="date"
                               name="due_at"
                               class="form-control"
                               value="{{ old('due_at', $borrowing->due_at?->format('Y-m-d')) }}"
                               required>

                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a href="{{ route('admin.borrowings.index') }}"
                       class="btn btn-outline-secondary">

                        Cancel

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-save me-1"></i>
                        Update Borrowing

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection