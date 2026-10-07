<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FineController extends Controller
{
    /**
     * Display the member's fines.
     */
    public function index(Request $request): View
    {
        $member = $request->user()->member;

        $status = $request->input('status');

        /*
        |--------------------------------------------------------------------------
        | Fine History
        |--------------------------------------------------------------------------
        */

        $fines = Fine::with([
            'borrowing.book',
        ])
            ->whereHas('borrowing', function ($query) use ($member) {
                $query->where('member_id', $member->id);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Total Fines
        |--------------------------------------------------------------------------
        */

        $totalFines = Fine::whereHas('borrowing', function ($query) use ($member) {
            $query->where('member_id', $member->id);
        })
            ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | Unpaid Fines
        |--------------------------------------------------------------------------
        */

        $unpaidFines = Fine::whereHas('borrowing', function ($query) use ($member) {
            $query->where('member_id', $member->id);
        })
            ->where('status', 'unpaid')
            ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | Paid Fines
        |--------------------------------------------------------------------------
        */
        $totalFines = Fine::whereHas('borrowing', function ($query) use ($member) {
            $query->where('member_id', $member->id);
        })
            ->sum('amount');

        $unpaidFines = Fine::whereHas('borrowing', function ($query) use ($member) {
            $query->where('member_id', $member->id);
        })
            ->where('status', 'unpaid')
            ->sum('amount');

        $paidFines = Fine::whereHas('borrowing', function ($query) use ($member) {
            $query->where('member_id', $member->id);
        })
            ->where('status', 'paid')
            ->sum('amount');

        return view('member.fines.index', compact(
            'fines',
            'status',
            'totalFines',
            'unpaidFines',
            'paidFines',
        ));
    }
}
