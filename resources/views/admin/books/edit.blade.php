@extends('layouts.admin')

@section('title', 'Edit Book')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">

        <h1 class="h3 mb-1">
            Edit Book
        </h1>

        <p class="text-muted mb-0">
            Update book information.
        </p>

    </div>

    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Please fix the following errors:</strong>

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
                  action="{{ route('admin.books.update', $book) }}"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row g-4">

                    <div class="col-lg-8">

                        <div class="mb-3">

                            <label for="title"
                                   class="form-label">
                                Book Title
                            </label>

                            <input type="text"
                                   id="title"
                                   name="title"
                                   value="{{ old('title', $book->title) }}"
                                   class="form-control @error('title') is-invalid @enderror"
                                   required>

                            @error('title')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                        <div class="mb-3">

                            <label for="isbn"
                                   class="form-label">
                                ISBN
                            </label>

                            <input type="text"
                                   id="isbn"
                                   name="isbn"
                                   value="{{ old('isbn', $book->isbn) }}"
                                   class="form-control @error('isbn') is-invalid @enderror"
                                   required>

                            @error('isbn')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label for="author_id"
                                       class="form-label">
                                    Author
                                </label>

                                <select id="author_id"
                                        name="author_id"
                                        class="form-select @error('author_id') is-invalid @enderror"
                                        required>

                                    @foreach($authors as $author)

                                        <option value="{{ $author->id }}"
                                            @selected(old('author_id', $book->author_id) == $author->id)>

                                            {{ $author->name }}

                                        </option>

                                    @endforeach

                                </select>

                                @error('author_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                            <div class="col-md-6 mb-3">

                                <label for="category_id"
                                       class="form-label">
                                    Category
                                </label>

                                <select id="category_id"
                                        name="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror"
                                        required>

                                    @foreach($categories as $category)

                                        <option value="{{ $category->id }}"
                                            @selected(old('category_id', $book->category_id) == $category->id)>

                                            {{ $category->name }}

                                        </option>

                                    @endforeach

                                </select>

                                @error('category_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="description"
                                   class="form-label">
                                Description
                            </label>

                            <textarea id="description"
                                      name="description"
                                      rows="7"
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $book->description) }}</textarea>

                            @error('description')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                    <div class="col-lg-4">

                        <div class="card bg-light border-0">

                            <div class="card-body">

                                <h5 class="mb-3">
                                    Inventory
                                </h5>

                                <div class="mb-3">

                                    <label for="quantity"
                                           class="form-label">
                                        Quantity
                                    </label>

                                    <input type="number"
                                           id="quantity"
                                           name="quantity"
                                           value="{{ old('quantity', $book->quantity) }}"
                                           min="0"
                                           class="form-control @error('quantity') is-invalid @enderror"
                                           required>

                                    @error('quantity')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                    @php
                                        $borrowedQuantity = max(
                                            0,
                                            $book->quantity - $book->available_quantity
                                        );
                                    @endphp

                                    <small class="text-muted">

                                        Currently borrowed:
                                        <strong>{{ $borrowedQuantity }}</strong>

                                    </small>

                                </div>

                                <hr>

                                <h5 class="mb-3">
                                    Book Cover
                                </h5>

                                @if($book->cover_image)

                                    <div class="mb-3">

                                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                                             alt="{{ $book->title }}"
                                             class="img-fluid rounded shadow-sm"
                                             style="max-height: 260px; width: 100%; object-fit: cover;">

                                    </div>

                                @endif

                                <div class="mb-3">

                                    <label for="cover_image"
                                           class="form-label">
                                        Replace Cover
                                    </label>

                                    <input type="file"
                                           id="cover_image"
                                           name="cover_image"
                                           class="form-control @error('cover_image') is-invalid @enderror"
                                           accept=".jpg,.jpeg,.png,.webp">

                                    <small class="text-muted">
                                        JPG, JPEG, PNG or WEBP. Maximum 2 MB.
                                    </small>

                                    @error('cover_image')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-save me-1"></i>
                        Update Book

                    </button>

                    <a href="{{ route('admin.books.index') }}"
                       class="btn btn-outline-secondary">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection