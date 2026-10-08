@extends('layouts.member')

@section('title', 'Notifications')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">
                Notifications
            </h2>

            <p class="text-muted mb-0">
                Stay updated about your library activity.
            </p>
        </div>

        @if(auth()->user()->unreadNotifications->count() > 0)
            <form
                action="{{ route('member.notifications.read-all') }}"
                method="POST"
            >
                @csrf

                <button
                    type="submit"
                    class="btn btn-outline-primary"
                >
                    <i class="bi bi-check2-all me-1"></i>
                    Mark all as read
                </button>
            </form>
        @endif

    </div>

    @forelse($notifications as $notification)

        <div class="card mb-3
            {{ is_null($notification->read_at) ? 'border-primary' : '' }}"
        >

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start">

                    <div class="d-flex gap-3">

                        <div class="fs-3 text-primary">
                            <i class="bi bi-bell"></i>
                        </div>

                        <div>

                            <h5 class="mb-1">
                                Due Date Reminder
                            </h5>

                            <p class="mb-2">
                                {{ $notification->data['message'] ?? 'You have a new library notification.' }}
                            </p>

                            @if(isset($notification->data['due_at']))
                                <small class="text-muted">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    Due:
                                    {{ \Carbon\Carbon::parse($notification->data['due_at'])->format('d M Y, h:i A') }}
                                </small>
                            @endif

                            <div class="mt-1">
                                <small class="text-muted">
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>

                        </div>

                    </div>

                    @if(is_null($notification->read_at))

                        <form
                            action="{{ route('member.notifications.read', $notification->id) }}"
                            method="POST"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="btn btn-sm btn-outline-primary"
                            >
                                Mark as read
                            </button>
                        </form>

                    @else

                        <span class="badge bg-secondary">
                            Read
                        </span>

                    @endif

                </div>

            </div>

        </div>

    @empty

        <div class="card">

            <div class="card-body text-center py-5">

                <i class="bi bi-bell-slash fs-1 text-muted"></i>

                <h5 class="mt-3">
                    No notifications
                </h5>

                <p class="text-muted mb-0">
                    You don't have any notifications yet.
                </p>

            </div>

        </div>

    @endforelse

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>

</div>

@endsection