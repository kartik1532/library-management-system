@extends('layouts.admin')

@section('title', 'Edit Member')

@section('content')

<div class="container-fluid">

    <div class="d-flex align-items-center mb-4">

        <a href="{{ route('admin.members.index') }}"
           class="btn btn-outline-secondary me-3">

            <i class="bi bi-arrow-left"></i>

        </a>

        <div>
            <h2 class="fw-bold mb-1">
                Edit Member
            </h2>

            <p class="text-muted mb-0">
                Update member information.
            </p>
        </div>

    </div>

    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.members.update', $member) }}">

                @csrf
                @method('PUT')

                <div class="row g-4">

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Member
                        </label>

                        <input type="text"
                               class="form-control"
                               value="{{ $member->user->name }} — {{ $member->user->email }}"
                               disabled>

                        <div class="form-text">
                            The linked user account cannot be changed here.
                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Membership Number
                        </label>

                        <input type="text"
                               name="membership_number"
                               class="form-control"
                               value="{{ old('membership_number', $member->membership_number) }}"
                               required>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Phone
                        </label>

                        <input type="text"
                               name="phone"
                               class="form-control"
                               value="{{ old('phone', $member->phone) }}">

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Join Date
                        </label>

                        <input type="date"
                               name="join_date"
                               class="form-control"
                               value="{{ old('join_date', $member->join_date?->format('Y-m-d')) }}"
                               required>

                    </div>

                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Address
                        </label>

                        <textarea name="address"
                                  rows="4"
                                  class="form-control">{{ old('address', $member->address) }}</textarea>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="active"
                                @selected(old('status', $member->status) === 'active')>
                                Active
                            </option>

                            <option value="inactive"
                                @selected(old('status', $member->status) === 'inactive')>
                                Inactive
                            </option>

                        </select>

                        @error('status')

                            <div class="text-danger small mt-1">
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

                        <i class="bi bi-save me-1"></i>
                        Update Member

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection