@extends('layouts.admin')

@section('title', 'Add Book')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">

        <h1 class="h3 mb-1">
            Add Book
        </h1>

        <p class="text-muted mb-0">
            Add a new book to the library.
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
                  action="{{ route('admin.books.store') }}"
                  enctype="multipart/form-data">

                @csrf

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
                                   value="{{ old('title') }}"
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
                                   value="{{ old('isbn') }}"
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

                                    <option value="">
                                        Select Author
                                    </option>

                                    @foreach($authors as $author)

                                        <option value="{{ $author->id }}"
                                            @selected(old('author_id') == $author->id)>

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

                                    <option value="">
                                        Select Category
                                    </option>

                                    @foreach($categories as $category)

                                        <option value="{{ $category->id }}"
                                            @selected(old('category_id') == $category->id)>

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
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Enter book description...">{{ old('description') }}</textarea>

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
                                           value="{{ old('quantity', 0) }}"
                                           min="0"
                                           class="form-control @error('quantity') is-invalid @enderror"
                                           required>

                                    <small class="text-muted">
                                        Available quantity will automatically be set to this value.
                                    </small>

                                    @error('quantity')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                                <hr>

                                <h5 class="mb-3">
                                    Book Cover
                                </h5>

                                <div class="mb-3">

                                    <label for="cover_image"
                                           class="form-label">
                                        Cover Image
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

                        <i class="bi bi-check-lg me-1"></i>
                        Save Book

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