<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\Member;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the administrator dashboard.
     */
    public function index(): View
    {
        $totalBooks = Book::count();

        $availableBooks = Book::sum('available_quantity');

        $borrowedBooks = Borrowing::whereNull('returned_at')
            ->count();

        $totalMembers = Member::count();

        $overdueBooks = Borrowing::whereNull('returned_at')
            ->where('due_at', '<', now())
            ->count();

        $unpaidFines = Fine::where('status', 'unpaid')
            ->sum('amount');

        $recentBorrowings = Borrowing::with([
            'book',
            'member.user',
        ])
            ->latest('issued_at')
            ->limit(5)
            ->get();

        $recentBooks = Book::with([
            'author',
            'category',
        ])
            ->latest()
            ->limit(5)
            ->get();

        $overdueBorrowings = Borrowing::with([
            'book',
            'member.user',
        ])
            ->whereNull('returned_at')
            ->where('due_at', '<', now())
            ->orderBy('due_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(

            'totalBooks',
            'availableBooks',
            'borrowedBooks',
            'totalMembers',
            'overdueBooks',
            'unpaidFines',
            'recentBorrowings',
            'recentBooks',
            'overdueBorrowings',
        ));

    }
}