@extends('layouts.admin')

@section('title', 'Add Author')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">

        <h1 class="h3 mb-1">
            Add Author
        </h1>

        <p class="text-muted mb-0">
            Create a new book author.
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
                  action="{{ route('admin.authors.store') }}">

                @csrf

                <div class="mb-3">

                    <label for="name"
                           class="form-label">
                        Author Name
                    </label>

                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           required>

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="mb-4">

                    <label for="biography"
                           class="form-label">
                        Biography
                    </label>

                    <textarea id="biography"
                              name="biography"
                              rows="6"
                              class="form-control @error('biography') is-invalid @enderror"
                              placeholder="Enter author biography...">{{ old('biography') }}</textarea>

                    @error('biography')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-check-lg me-1"></i>
                        Save Author

                    </button>

                    <a href="{{ route('admin.authors.index') }}"
                       class="btn btn-outline-secondary">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection