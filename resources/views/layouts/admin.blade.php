@extends('layouts.app')

@section('title', $title ?? 'Admin Dashboard')

@section('body')

    <div class="admin-wrapper">

        {{-- Sidebar Overlay --}}
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        {{-- =====================================================
        SIDEBAR
        ====================================================== --}}
        <aside class="admin-sidebar" id="adminSidebar">

            {{-- Brand --}}
            <div class="sidebar-brand">

                <a href="{{ route('admin.dashboard') }}" class="brand-link">

                    <div class="brand-icon">
                        <i class="bi bi-book-half"></i>
                    </div>

                    <div class="brand-text">
                        <div class="brand-title">
                            Library
                        </div>

                        <div class="brand-subtitle">
                            Management System
                        </div>
                    </div>

                </a>

                {{-- Desktop collapse button --}}
                <button type="button" class="sidebar-collapse-btn" id="sidebarCollapse" title="Collapse sidebar">
                    <i class="bi bi-chevron-left"></i>
                </button>

            </div>


            {{-- User Card --}}
            <div class="sidebar-user-card">

                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="sidebar-user-details">

                    <div class="sidebar-user-name">
                        {{ auth()->user()->name }}
                    </div>

                    <div class="sidebar-user-role">
                        <span class="online-dot"></span>
                        Administrator
                    </div>

                </div>

                <i class="bi bi-three-dots-vertical sidebar-user-menu"></i>

            </div>


            {{-- Navigation --}}
            <nav class="sidebar-nav">

                {{-- Main --}}
                <div class="sidebar-section-title">
                    MAIN
                </div>

                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="sidebar-icon">
                        <i class="bi bi-grid-1x2-fill"></i>
                    </span>

                    <span class="sidebar-link-text">
                        Dashboard
                    </span>
                </a>


                {{-- =================================================
                LIBRARY DROPDOWN
                ================================================== --}}
                @php
                    $libraryOpen =
                        request()->routeIs('admin.books.*') ||
                        request()->routeIs('admin.authors.*') ||
                        request()->routeIs('admin.categories.*');
                @endphp

                <div class="sidebar-dropdown {{ $libraryOpen ? 'open' : '' }}">

                    <button type="button" class="sidebar-dropdown-toggle {{ $libraryOpen ? 'active' : '' }}"
                        data-dropdown="libraryDropdown">

                        <span class="sidebar-icon">
                            <i class="bi bi-book-fill"></i>
                        </span>

                        <span class="sidebar-link-text">
                            Library
                        </span>

                        <i class="bi bi-chevron-down dropdown-arrow"></i>

                    </button>


                    <div class="sidebar-dropdown-menu" id="libraryDropdown">

                        <a href="{{ route('admin.books.index') }}"
                            class="sidebar-sublink {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                            <span class="sub-dot"></span>
                            Books
                        </a>

                        <a href="{{ route('admin.authors.index') }}"
                            class="sidebar-sublink {{ request()->routeIs('admin.authors.*') ? 'active' : '' }}">
                            <span class="sub-dot"></span>
                            Authors
                        </a>

                        <a href="{{ route('admin.categories.index') }}"
                            class="sidebar-sublink {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <span class="sub-dot"></span>
                            Categories
                        </a>

                    </div>

                </div>


                {{-- Members --}}
                <a href="{{ route('admin.members.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.members.*') ? 'active' : '' }}">

                    <span class="sidebar-icon">
                        <i class="bi bi-people-fill"></i>
                    </span>

                    <span class="sidebar-link-text">
                        Members
                    </span>

                </a>

                {{-- =================================================
                CIRCULATION DROPDOWN
                ================================================== --}}
                @php
                    $circulationOpen =
                        request()->routeIs('admin.borrowings.*') ||
                        request()->routeIs('admin.reports.fines');
                @endphp

                <div class="sidebar-dropdown {{ $circulationOpen ? 'open' : '' }}">

                    <button type="button" class="sidebar-dropdown-toggle {{ $circulationOpen ? 'active' : '' }}"
                        data-dropdown="circulationDropdown">

                        <span class="sidebar-icon">
                            <i class="bi bi-arrow-left-right"></i>
                        </span>

                        <span class="sidebar-link-text">
                           Borrowings and Fines
                        </span>

                        <i class="bi bi-chevron-down dropdown-arrow"></i>

                    </button>


                    <div class="sidebar-dropdown-menu" id="circulationDropdown">

                        <a href="{{ route('admin.borrowings.index') }}"
                            class="sidebar-sublink {{ request()->routeIs('admin.borrowings.*') ? 'active' : '' }}">
                            <span class="sub-dot"></span>
                            Borrowings
                        </a>

                        <a href="{{ route('admin.reports.fines') }}"
                            class="sidebar-sublink {{ request()->routeIs('admin.reports.fines') ? 'active' : '' }}">
                            <span class="sub-dot"></span>
                            Fines
                        </a>

                    </div>

                </div>

                {{-- =================================================
                REPORTS DROPDOWN
                ================================================== --}}
                @php
                    $reportsOpen =
                        request()->routeIs('admin.reports.index') ||
                        request()->routeIs('admin.reports.books') ||
                        request()->routeIs('admin.reports.borrowings');
                @endphp

                <div class="sidebar-dropdown {{ $reportsOpen ? 'open' : '' }}">

                    <button type="button" class="sidebar-dropdown-toggle {{ $reportsOpen ? 'active' : '' }}"
                        data-dropdown="reportsDropdown">

                        <span class="sidebar-icon">
                            <i class="bi bi-bar-chart-fill"></i>
                        </span>

                        <span class="sidebar-link-text">
                            Reports
                        </span>

                        <i class="bi bi-chevron-down dropdown-arrow"></i>

                    </button>


                    <div class="sidebar-dropdown-menu" id="reportsDropdown">

                        <a href="{{ route('admin.reports.index') }}"
                            class="sidebar-sublink {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}">
                            <span class="sub-dot"></span>
                            Overview
                        </a>

                        <a href="{{ route('admin.reports.books') }}"
                            class="sidebar-sublink {{ request()->routeIs('admin.reports.books') ? 'active' : '' }}">
                            <span class="sub-dot"></span>
                            Book Inventory
                        </a>

                        <a href="{{ route('admin.reports.borrowings') }}"
                            class="sidebar-sublink {{ request()->routeIs('admin.reports.borrowings') ? 'active' : '' }}">
                            <span class="sub-dot"></span>
                            Borrowing Report
                        </a>

                    </div>

                </div>


                <div class="sidebar-divider"></div>


                {{-- Profile --}}
                <a href="{{ route('admin.profile.edit') }}"
                    class="sidebar-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">

                    <span class="sidebar-icon">
                        <i class="bi bi-person-circle"></i>
                    </span>

                    <span class="sidebar-link-text">
                        Profile
                    </span>

                </a>

            </nav>


            {{-- Sidebar Bottom --}}
            <div class="sidebar-bottom">

                <form action="{{ route('logout') }}" method="POST">

                    @csrf

                    <button type="submit" class="sidebar-link sidebar-logout">

                        <span class="sidebar-icon">
                            <i class="bi bi-box-arrow-right"></i>
                        </span>

                        <span class="sidebar-link-text">
                            Logout
                        </span>

                    </button>

                </form>

            </div>

        </aside>


        {{-- =====================================================
        MAIN AREA
        ====================================================== --}}
        <div class="admin-main">


            {{-- Top Header --}}
            <header class="admin-topbar">

                <div class="topbar-left">

                    {{-- Mobile menu --}}
                    <button type="button" class="mobile-menu-button" id="sidebarToggle" aria-label="Open navigation">
                        <i class="bi bi-list"></i>
                    </button>

                    <div class="topbar-page-info">

                        <div class="topbar-title">
                            Library Management System
                        </div>

                        <div class="topbar-subtitle">
                            Administration Panel
                        </div>

                    </div>

                </div>


                <div class="topbar-right">

                    {{-- Notifications --}}
                    <button type="button" class="topbar-icon-btn" title="Notifications">
                        <i class="bi bi-bell"></i>

                        <span class="notification-dot"></span>
                    </button>


                    {{-- Divider --}}
                    <div class="topbar-divider"></div>


                    {{-- User --}}
                    <a href="{{ route('admin.profile.edit') }}" class="topbar-user">

                        <div class="topbar-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                        <div class="topbar-user-info">

                            <div class="topbar-user-name">
                                {{ auth()->user()->name }}
                            </div>

                            <div class="topbar-user-role">
                                Administrator
                            </div>

                        </div>

                        <i class="bi bi-chevron-down topbar-user-arrow"></i>

                    </a>

                </div>

            </header>


            {{-- Page Content --}}
            <main class="page-content">

                <x-alert />

                @yield('content')

            </main>


            {{-- Footer --}}
            <footer class="app-footer">

                <span>
                    &copy; {{ date('Y') }} Library Management System
                </span>

                <span class="footer-separator">
                    •
                </span>

                <span>
                    Admin Panel
                </span>

            </footer>

        </div>

    </div>

@endsection