@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">

        <h1 class="h3 mb-1">
            Edit Category
        </h1>

        <p class="text-muted">
            Update category information.
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
                  action="{{ route('admin.categories.update', $category) }}">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label for="name"
                           class="form-label">
                        Category Name
                    </label>

                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $category->name) }}"
                           class="form-control @error('name') is-invalid @enderror"
                           required>

                    @error('name')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <div class="mb-4">

                    <label for="description"
                           class="form-label">
                        Description
                    </label>

                    <textarea id="description"
                              name="description"
                              rows="6"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>

                    @error('description')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-save me-1"></i>
                        Update Category

                    </button>

                    <a href="{{ route('admin.categories.index') }}"
                       class="btn btn-outline-secondary">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection