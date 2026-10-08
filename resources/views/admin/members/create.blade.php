@extends('layouts.admin')

@section('title', 'Add Member')

@section('content')

<div class="container-fluid">

    <div class="d-flex align-items-center mb-4">

        <a href="{{ route('admin.members.index') }}"
           class="btn btn-outline-secondary me-3">

            <i class="bi bi-arrow-left"></i>

        </a>

        <div>
            <h2 class="fw-bold mb-1">Add Member</h2>

            <p class="text-muted mb-0">
                Create a new member account and library membership.
            </p>
        </div>

    </div>

    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Please correct the following:</strong>

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
                  action="{{ route('admin.members.store') }}">

                @csrf

                <div class="row g-4">

                    {{-- NAME --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Full Name <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="Enter member name"
                               required>

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- EMAIL --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Email <span class="text-danger">*</span>
                        </label>

                        <input type="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="member@example.com"
                               required>

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- PASSWORD --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Password <span class="text-danger">*</span>
                        </label>

                        <input type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Enter password"
                               required>

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- MEMBERSHIP NUMBER --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Membership Number
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="membership_number"
                               class="form-control @error('membership_number') is-invalid @enderror"
                               value="{{ old('membership_number') }}"
                               placeholder="Example: LIB-0001"
                               required>

                        @error('membership_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- PHONE --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Phone
                        </label>

                        <input type="text"
                               name="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone') }}"
                               placeholder="Phone number">

                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- JOIN DATE --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Join Date <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                               name="join_date"
                               class="form-control @error('join_date') is-invalid @enderror"
                               value="{{ old('join_date', now()->format('Y-m-d')) }}"
                               required>

                        @error('join_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- ADDRESS --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Address
                        </label>

                        <textarea name="address"
                                  rows="4"
                                  class="form-control @error('address') is-invalid @enderror"
                                  placeholder="Member address">{{ old('address') }}</textarea>

                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- STATUS --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select name="status"
                                class="form-select @error('status') is-invalid @enderror">

                            <option value="active"
                                @selected(old('status', 'active') === 'active')>
                                Active
                            </option>

                            <option value="inactive"
                                @selected(old('status') === 'inactive')>
                                Inactive
                            </option>

                        </select>

                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>


                <hr class="my-4">


                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('admin.members.index') }}"
                       class="btn btn-outline-secondary">

                        Cancel

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-person-plus me-1"></i>

                        Create Member

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection