@extends('layouts.app')

@section('title', 'Access Denied')

@section('body')

<div class="min-vh-100 d-flex align-items-center justify-content-center p-4">

    <div class="text-center">

        <div class="display-1 fw-bold text-danger">
            403
        </div>

        <h1 class="h3 mb-3">
            Access Denied
        </h1>

        <p class="text-muted mb-4">
            You do not have permission to access this page.
        </p>

        @auth

            @if (auth()->user()->isAdmin())

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="btn btn-primary"
                >
                    Go to Dashboard
                </a>

            @else

                <a
                    href="{{ route('member.dashboard') }}"
                    class="btn btn-primary"
                >
                    Go to Dashboard
                </a>

            @endif

        @else

            <a
                href="{{ route('login') }}"
                class="btn btn-primary"
            >
                Go to Login
            </a>

        @endauth

    </div>

</div>

@endsection