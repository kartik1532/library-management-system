@extends('layouts.app')

@section('title', $title ?? 'Member Dashboard')

@section('body')

    <div class="admin-wrapper">

        <aside class="admin-sidebar" id="memberSidebar">

            <div class="sidebar-brand">

                <div class="brand-icon">
                    <i class="bi bi-book-half"></i>
                </div>

                <div>
                    <div class="brand-title">
                        Library
                    </div>

                    <small>
                        Member Portal
                    </small>
                </div>

            </div>

            <nav class="sidebar-nav">

                <a href="{{ route('member.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('member.books.index') }}"
                    class="sidebar-link {{ request()->routeIs('member.books.*') ? 'active' : '' }}">
                    <i class="bi bi-search"></i>
                    <span>Browse Books</span>
                </a>

                <a href="{{ route('member.borrowings.index') }}"
                    class="sidebar-link {{ request()->routeIs('member.borrowings.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-bookmark"></i>
                    <span>My Borrowings</span>
                </a>

                <a href="{{ route('member.fines.index') }}"
                    class="sidebar-link {{ request()->routeIs('member.fines.*') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i>
                    <span>My Fines</span>
                </a>

                <a href="{{ route('member.notifications.index') }}"
                    class="sidebar-link {{ request()->routeIs('member.notifications.*') ? 'active' : '' }}">
                    <i class="bi bi-bell"></i>
                    <span>Notifications</span>

                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="badge bg-danger ms-auto">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>

                <div class="sidebar-divider"></div>

                <a href="{{ route('member.profile.edit') }}"
                    class="sidebar-link {{ request()->routeIs('member.profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>

            </nav>

            <div class="sidebar-bottom">

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="sidebar-link sidebar-logout">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>

            </div>

        </aside>

        <div class="admin-main">

            <header class="mobile-header">

                <button type="button" class="btn btn-outline-secondary" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>

                <span class="fw-semibold">
                    Member Portal
                </span>

            </header>

            <main class="page-content">

                <x-alert />

                @yield('content')

            </main>

            <footer class="app-footer">
                <div>
                    &copy; {{ date('Y') }} Library Management System
                </div>
            </footer>

        </div>

    </div>

@endsection