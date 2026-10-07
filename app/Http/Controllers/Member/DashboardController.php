<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the member dashboard.
     */
    public function index(Request $request): View
    {
        $member = $request->user()->member;

        $currentBorrowings = Borrowing::where(
            'member_id',
            $member->id
        )
            ->whereNull('returned_at')
            ->count();

        $overdueBooks = Borrowing::where(
            'member_id',
            $member->id
        )
            ->whereNull('returned_at')
            ->where('due_at', '<', now())
            ->count();

        $totalBorrowings = Borrowing::where(
            'member_id',
            $member->id
        )->count();

        $unpaidFines = Fine::whereHas('borrowing', function ($query) use ($member) {
            $query->where('member_id', $member->id);
        })
            ->where('status', 'unpaid')
            ->sum('amount');

        $recentBorrowings = Borrowing::with('book')
            ->where('member_id', $member->id)
            ->latest('issued_at')
            ->limit(5)
            ->get();

        /*
         * Notification information
         */
        $unreadNotifications = $request->user()
            ->unreadNotifications()
            ->latest()
            ->limit(5)
            ->get();

        $unreadNotificationCount = $request->user()
            ->unreadNotifications()
            ->count();

        return view('member.dashboard', compact(
            'currentBorrowings',
            'overdueBooks',
            'totalBorrowings',
            'unpaidFines',
            'recentBorrowings',
            'unreadNotifications',
            'unreadNotificationCount',
        ));
    }
}