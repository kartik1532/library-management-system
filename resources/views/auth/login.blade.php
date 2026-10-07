@extends('layouts.app')

@section('title', 'Login')

@section('body')

<div class="login-page">

    <div class="login-card">

        <div class="text-center mb-4">

            <div class="login-icon">
                <i class="bi bi-book-half"></i>
            </div>

            <h1 class="h3 fw-bold mt-3">
                Library Management System
            </h1>

            <p class="text-muted mb-0">
                Sign in to continue
            </p>

        </div>

        <x-alert />

        <form
            action="{{ route('login.store') }}"
            method="POST"
        >
            @csrf

            <div class="mb-3">

                <label
                    for="email"
                    class="form-label fw-semibold"
                >
                    Email Address
                </label>

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Enter your email"
                        required
                        autofocus
                    >

                </div>

                @error('email')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="mb-3">

                <label
                    for="password"
                    class="form-label fw-semibold"
                >
                    Password
                </label>

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Enter your password"
                        required
                    >

                </div>

                @error('password')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div class="form-check">

                    <input
                        type="checkbox"
                        class="form-check-input"
                        id="remember"
                        name="remember"
                        value="1"
                        {{ old('remember') ? 'checked' : '' }}
                    >

                    <label
                        class="form-check-label"
                        for="remember"
                    >
                        Remember me
                    </label>

                </div>

            </div>

            <button
                type="submit"
                class="btn btn-primary w-100 py-2"
            >
                <i class="bi bi-box-arrow-in-right me-2"></i>
                Login
            </button>

        </form>

    </div>

</div>

@endsection