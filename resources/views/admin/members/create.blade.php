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
                Create a library membership for an existing member account.
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

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Member Account <span class="text-danger">*</span>
                        </label>

                        <select name="user_id"
                                class="form-select @error('user_id') is-invalid @enderror"
                                required>

                            <option value="">
                                Select member account
                            </option>

                            @foreach($users as $user)

                                <option value="{{ $user->id }}"
                                    @selected(old('user_id') == $user->id)>

                                    {{ $user->name }}
                                    — {{ $user->email }}

                                </option>

                            @endforeach

                        </select>

                        @error('user_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Membership Number <span class="text-danger">*</span>
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

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Phone
                        </label>

                        <input type="text"
                               name="phone"
                               class="form-control"
                               value="{{ old('phone') }}"
                               placeholder="Phone number">

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Join Date <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                               name="join_date"
                               class="form-control"
                               value="{{ old('join_date', now()->format('Y-m-d')) }}"
                               required>

                    </div>

                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Address
                        </label>

                        <textarea name="address"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Member address">{{ old('address') }}</textarea>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="active"
                                @selected(old('status', 'active') === 'active')>
                                Active
                            </option>

                            <option value="inactive"
                                @selected(old('status') === 'inactive')>
                                Inactive
                            </option>

                        </select>

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

                        <i class="bi bi-check-lg me-1"></i>
                        Create Member

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection