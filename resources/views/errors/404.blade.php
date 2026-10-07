@extends('layouts.app')

@section('title', 'Page Not Found')

@section('body')

<div class="min-vh-100 d-flex align-items-center justify-content-center p-4">

    <div class="text-center">

        <div class="display-1 fw-bold text-primary">
            404
        </div>

        <h1 class="h3 mb-3">
            Page Not Found
        </h1>

        <p class="text-muted mb-4">
            The page you requested could not be found.
        </p>

        <a
            href="{{ route('home') }}"
            class="btn btn-primary"
        >
            Return Home
        </a>

    </div>

</div>

@endsection