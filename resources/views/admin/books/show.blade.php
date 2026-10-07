@extends('layouts.admin')

@section('title', $book->title)

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>

            <h1 class="h3 mb-1">
                {{ $book->title }}
            </h1>

            <p class="text-muted mb-0">
                Book details.
            </p>

        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('admin.books.edit', $book) }}"
               class="btn btn-primary">

                <i class="bi bi-pencil me-1"></i>
                Edit

            </a>

            <a href="{{ route('admin.books.index') }}"
               class="btn btn-outline-secondary">

                <i class="bi bi-arrow-left me-1"></i>
                Back

            </a>

        </div>

    </div>

    <div class="row g-4">

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center">

                    @if($book->cover_image)

                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                             alt="{{ $book->title }}"
                             class="img-fluid rounded shadow-sm"
                             style="max-height: 420px; width: 100%; object-fit: cover;">

                    @else

                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                             style="height: 350px;">

                            <i class="bi bi-book display-1 text-muted"></i>

                        </div>

                    @endif

                    <h4 class="mt-4 mb-1">
                        {{ $book->title }}
                    </h4>

                    <p class="text-muted mb-0">
                        {{ $book->author->name }}
                    </p>

                </div>

            </div>

        </div>

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5 class="mb-4">
                        Book Information
                    </h5>

                    <div class="row g-4">

                        <div class="col-md-6">

                            <small class="text-muted">
                                ISBN
                            </small>

                            <div class="fw-semibold">
                                {{ $book->isbn }}
                            </div>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted">
                                Author
                            </small>

                            <div class="fw-semibold">
                                {{ $book->author->name }}
                            </div>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted">
                                Category
                            </small>

                            <div>

                                <span class="badge text-bg-primary">
                                    {{ $book->category->name }}
                                </span>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted">
                                Total Quantity
                            </small>

                            <div class="fw-semibold">
                                {{ $book->quantity }}
                            </div>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted">
                                Available
                            </small>

                            <div>

                                @if($book->available_quantity > 0)

                                    <span class="badge text-bg-success">
                                        {{ $book->available_quantity }} Available
                                    </span>

                                @else

                                    <span class="badge text-bg-danger">
                                        Not Available
                                    </span>

                                @endif

                            </div>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted">
                                Added
                            </small>

                            <div class="fw-semibold">
                                {{ $book->created_at->format('d M Y') }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card border-0 shadow-sm mt-4">

                <div class="card-body">

                    <h5>
                        Description
                    </h5>

                    <hr>

                    @if($book->description)

                        <p class="text-muted">
                            {{ $book->description }}
                        </p>

                    @else

                        <p class="text-muted mb-0">
                            No description has been added.
                        </p>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection