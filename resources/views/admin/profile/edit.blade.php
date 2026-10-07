@extends('layouts.admin')

@section('title', 'Admin Profile')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="mb-4">

        <h2 class="fw-bold mb-1">
            <i class="bi bi-person-circle me-2"></i>
            Admin Profile
        </h2>

        <p class="text-muted mb-0">
            Manage your account information and password.
        </p>

    </div>


    <div class="row g-4">

        {{-- Profile Information --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-person me-2"></i>
                        Profile Information
                    </h5>

                </div>

                <div class="card-body">

                    <div class="text-center mb-4">

                        <div
                            class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
                            style="width: 90px; height: 90px; font-size: 2rem;"
                        >
                            <i class="bi bi-person"></i>
                        </div>

                        <h5 class="fw-bold mt-3 mb-1">
                            {{ $user->name }}
                        </h5>

                        <span class="badge bg-primary">
                            Administrator
                        </span>

                    </div>


                    <form
                        action="{{ route('admin.profile.update') }}"
                        method="POST"
                    >

                        @csrf
                        @method('PUT')


                        {{-- Name --}}
                        <div class="mb-3">

                            <label for="name" class="form-label fw-semibold">
                                Name
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                required
                            >

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Email --}}
                        <div class="mb-3">

                            <label for="email" class="form-label fw-semibold">
                                Email
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                class="form-control @error('email') is-invalid @enderror"
                                required
                            >

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="bi bi-check-lg me-1"></i>
                            Update Profile
                        </button>

                    </form>

                </div>

            </div>

        </div>


        {{-- Change Password --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-shield-lock me-2"></i>
                        Change Password
                    </h5>

                </div>

                <div class="card-body">

                    <form
                        action="{{ route('admin.profile.password') }}"
                        method="POST"
                    >

                        @csrf
                        @method('PUT')


                        {{-- Current Password --}}
                        <div class="mb-3">

                            <label
                                for="current_password"
                                class="form-label fw-semibold"
                            >
                                Current Password
                            </label>

                            <input
                                type="password"
                                id="current_password"
                                name="current_password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                required
                            >

                            @error('current_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- New Password --}}
                        <div class="mb-3">

                            <label
                                for="password"
                                class="form-label fw-semibold"
                            >
                                New Password
                            </label>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required
                            >

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Confirm Password --}}
                        <div class="mb-4">

                            <label
                                for="password_confirmation"
                                class="form-label fw-semibold"
                            >
                                Confirm New Password
                            </label>

                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control"
                                required
                            >

                        </div>


                        <button
                            type="submit"
                            class="btn btn-dark"
                        >
                            <i class="bi bi-key me-1"></i>
                            Change Password
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection