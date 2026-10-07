<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    /**
     * Display the member's borrowing history.
     */
    public function index(Request $request): View
    {
        $member = $request->user()->member;

        $status = $request->input('status');

        $borrowings = Borrowing::with([
            'book',
            'fine',
        ])
            ->where('member_id', $member->id)
            ->when($status, function ($query) use ($status) {
                if ($status === 'overdue') {
                    $query->whereNull('returned_at')
                        ->where('due_at', '<', now());
                } else {
                    $query->where('status', $status);
                }
            })
            ->latest('issued_at')
            ->paginate(10)
            ->withQueryString();

        return view('member.borrowings.index', compact(
            'borrowings',
            'status',
        ));
    }
}