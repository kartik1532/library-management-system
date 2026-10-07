<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Author;
use App\Models\Category;

class ReportController extends Controller
{
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Book Statistics
        |--------------------------------------------------------------------------
        */

        $totalBooks = Book::count();

        $totalCopies = Book::sum('quantity');

        $availableCopies = Book::sum('available_quantity');

        $issuedCopies = max(
            0,
            $totalCopies - $availableCopies
        );


        /*
        |--------------------------------------------------------------------------
        | Member Statistics
        |--------------------------------------------------------------------------
        */

        $totalMembers = Member::count();

        $activeMembers = Member::where('status', 'active')
            ->count();

        $inactiveMembers = Member::where('status', 'inactive')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Borrowing Statistics
        |--------------------------------------------------------------------------
        */

        $totalBorrowings = Borrowing::count();

        $borrowedBooks = Borrowing::where('status', 'borrowed')
            ->count();

        $returnedBooks = Borrowing::where('status', 'returned')
            ->count();

        $overdueBooks = Borrowing::where('status', 'overdue')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Fine Statistics
        |--------------------------------------------------------------------------
        */

        $totalFines = Fine::sum('amount');

        $paidFines = Fine::where('status', 'paid')
            ->sum('amount');

        $unpaidFines = Fine::where('status', 'unpaid')
            ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | Recent Borrowings
        |--------------------------------------------------------------------------
        */

        $recentBorrowings = Borrowing::with([
            'book',
            'member.user',
            'fine',
        ])
            ->latest('issued_at')
            ->limit(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Overdue Borrowings
        |--------------------------------------------------------------------------
        */

        $overdueBorrowings = Borrowing::with([
            'book',
            'member.user',
            'fine',
        ])
            ->where('status', 'overdue')
            ->orderBy('due_at')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Return Reports View
        |--------------------------------------------------------------------------
        */

        return view('admin.reports.index', compact(
            'totalBooks',
            'totalCopies',
            'availableCopies',
            'issuedCopies',

            'totalMembers',
            'activeMembers',
            'inactiveMembers',

            'totalBorrowings',
            'borrowedBooks',
            'returnedBooks',
            'overdueBooks',

            'totalFines',
            'paidFines',
            'unpaidFines',

            'recentBorrowings',
            'overdueBorrowings',
        ));
    }

    public function borrowings(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        $status = (string) $request->input('status', '');

        $dateFrom = (string) $request->input('date_from', '');

        $dateTo = (string) $request->input('date_to', '');

        $borrowings = Borrowing::query()
            ->with([
                'book',
                'member.user',
                'fine',
            ])

            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            ->when($search !== '', function ($query) use ($search) {

                $query->where(function ($query) use ($search) {

                    $query->whereHas('book', function ($bookQuery) use ($search) {

                        $bookQuery
                            ->where('title', 'like', "%{$search}%")
                            ->orWhere('isbn', 'like', "%{$search}%");

                    })

                        ->orWhereHas('member', function ($memberQuery) use ($search) {

                            $memberQuery->where(
                                'membership_number',
                                'like',
                                "%{$search}%"
                            );

                        })

                        ->orWhereHas('member.user', function ($userQuery) use ($search) {

                            $userQuery
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");

                        });

                });

            })

            /*
            |--------------------------------------------------------------------------
            | Status Filter
            |--------------------------------------------------------------------------
            */

            ->when(
                in_array($status, ['borrowed', 'returned', 'overdue'], true),
                function ($query) use ($status) {

                    $query->where('status', $status);

                }
            )

            ->when($dateFrom !== '', function ($query) use ($dateFrom) {

                $query->whereDate('issued_at', '>=', $dateFrom);

            })

            ->when($dateTo !== '', function ($query) use ($dateTo) {

                $query->whereDate('issued_at', '<=', $dateTo);

            })
            ->latest('issued_at')

            ->paginate(15)

            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Report Statistics
        |--------------------------------------------------------------------------
        */

        $totalBorrowings = Borrowing::count();

        $borrowedCount = Borrowing::where('status', 'borrowed')
            ->count();

        $returnedCount = Borrowing::where('status', 'returned')
            ->count();

        $overdueCount = Borrowing::where('status', 'overdue')
            ->count();


        return view('admin.reports.borrowings', compact(
            'borrowings',
            'search',
            'status',
            'dateFrom',
            'dateTo',
            'totalBorrowings',
            'borrowedCount',
            'returnedCount',
            'overdueCount',
        ));
    }


    public function fines(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        $fineStatus = (string) $request->input('fine_status', '');

        $overdueOnly = $request->boolean('overdue_only');


        /*
        |--------------------------------------------------------------------------
        | Fine / Overdue Records
        |--------------------------------------------------------------------------
        */

        $fines = Fine::query()
            ->with([
                'borrowing.book',
                'borrowing.member.user',
            ])

            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            ->when($search !== '', function ($query) use ($search) {

                $query->whereHas('borrowing', function ($borrowingQuery) use ($search) {

                    $borrowingQuery->whereHas('book', function ($bookQuery) use ($search) {

                        $bookQuery
                            ->where('title', 'like', "%{$search}%")
                            ->orWhere('isbn', 'like', "%{$search}%");

                    })
                        ->orWhereHas('member.user', function ($userQuery) use ($search) {

                            $userQuery
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");

                        })
                        ->orWhereHas('member', function ($memberQuery) use ($search) {

                            $memberQuery->where(
                                'membership_number',
                                'like',
                                "%{$search}%"
                            );

                        });

                });

            })

            /*
            |--------------------------------------------------------------------------
            | Fine Status
            |--------------------------------------------------------------------------
            */

            ->when(
                in_array($fineStatus, ['paid', 'unpaid'], true),
                function ($query) use ($fineStatus) {

                    $query->where('status', $fineStatus);

                }
            )

            /*
            |--------------------------------------------------------------------------
            | Overdue Only
            |--------------------------------------------------------------------------
            */

            ->when($overdueOnly, function ($query) {

                $query->whereHas('borrowing', function ($borrowingQuery) {

                    $borrowingQuery->where('status', 'overdue');

                });

            })

            ->latest('created_at')

            ->paginate(15)

            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Summary Statistics
        |--------------------------------------------------------------------------
        */
        $totalFineAmount = Fine::sum('amount');

        $paidFineAmount = Fine::where('status', 'paid')
            ->sum('amount');

        $unpaidFineAmount = Fine::where('status', 'unpaid')
            ->sum('amount');

        $totalFineRecords = Fine::count();

        $overdueCount = Borrowing::where('status', 'overdue')
            ->count();


        return view('admin.reports.fines', compact(
            'fines',
            'search',
            'fineStatus',
            'overdueOnly',
            'totalFineAmount',
            'paidFineAmount',
            'unpaidFineAmount',
            'totalFineRecords',
            'overdueCount',
        ));
    }

    public function books(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        $authorId = $request->input('author_id');

        $categoryId = $request->input('category_id');

        $availability = (string) $request->input('availability', '');

        /*
        |--------------------------------------------------------------------------
        | Book Inventory Query
        |--------------------------------------------------------------------------
        */

        $books = Book::query()
            ->with([
                'author',
                'category',
            ])

            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            ->when($search !== '', function ($query) use ($search) {

                $query->where(function ($query) use ($search) {

                    $query
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%");

                });

            })

            /*
            |--------------------------------------------------------------------------
            | Author Filter
            |--------------------------------------------------------------------------
            */

            ->when($authorId, function ($query) use ($authorId) {

                $query->where('author_id', $authorId);

            })

            /*
            |--------------------------------------------------------------------------
            | Category Filter
            |--------------------------------------------------------------------------
            */

            ->when($categoryId, function ($query) use ($categoryId) {

                $query->where('category_id', $categoryId);

            })

            /*
            |--------------------------------------------------------------------------
            | Availability Filter
            |--------------------------------------------------------------------------
            */

            ->when(
                in_array($availability, ['available', 'unavailable'], true),
                function ($query) use ($availability) {

                    if ($availability === 'available') {

                        $query->where('available_quantity', '>', 0);

                    } else {

                        $query->where('available_quantity', '<=', 0);

                    }

                }
            )

            ->latest()
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Inventory Statistics
        |--------------------------------------------------------------------------
        */

        $totalBooks = Book::count();

        $totalCopies = Book::sum('quantity');

        $availableCopies = Book::sum('available_quantity');

        $issuedCopies = max(
            0,
            $totalCopies - $availableCopies
        );

        $availableTitles = Book::where(
            'available_quantity',
            '>',
            0
        )->count();

        $unavailableTitles = Book::where(
            'available_quantity',
            '<=',
            0
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Filter Dropdown Data
        |--------------------------------------------------------------------------
        */

        $authors = Author::orderBy('name')
            ->get();

        $categories = Category::orderBy('name')
            ->get();


        return view('admin.reports.books', compact(
            'books',
            'search',
            'authorId',
            'categoryId',
            'availability',

            'totalBooks',
            'totalCopies',
            'availableCopies',
            'issuedCopies',
            'availableTitles',
            'unavailableTitles',

            'authors',
            'categories',
        ));
    }
}