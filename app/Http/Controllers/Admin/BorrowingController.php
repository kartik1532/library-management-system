<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBorrowingRequest;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use App\Services\FineService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BorrowingController extends Controller
{
  /**
 * Display borrowing records.
 */
public function index(
    Request $request,
    FineService $fineService
): View {
    $search = trim($request->input('search', ''));
    $status = $request->input('status', '');

    /*
     * Find borrowed records that have passed their
     * due date and mark them as overdue.
     */
    $overdueBorrowings = Borrowing::query()
        ->where('status', 'borrowed')
        ->whereNotNull('due_at')
        ->where('due_at', '<', now())
        ->get();

    foreach ($overdueBorrowings as $borrowing) {
        $borrowing->update([
            'status' => 'overdue',
        ]);

        /*
         * Create or update the fine for this
         * overdue borrowing.
         */
        $fineService->createOrUpdateFine($borrowing);
    }

    /*
     * Also update existing overdue borrowings.
     *
     * This is useful because an unpaid fine may increase
     * as more days pass.
     */
    $existingOverdueBorrowings = Borrowing::query()
        ->where('status', 'overdue')
        ->whereNotNull('due_at')
        ->get();

    foreach ($existingOverdueBorrowings as $borrowing) {
        $fineService->createOrUpdateFine($borrowing);
    }

    $borrowings = Borrowing::query()
        ->with([
            'book',
            'member.user',
            'fine',
        ])
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
        ->when(
            in_array($status, ['borrowed', 'returned', 'overdue'], true),
            function ($query) use ($status) {
                $query->where('status', $status);
            }
        )
        ->latest('issued_at')
        ->paginate(10)
        ->withQueryString();

    return view('admin.borrowings.index', compact(
        'borrowings',
        'search',
        'status'
    ));
}

    /**
     * Show issue-book form.
     */
    public function create(): View
    {
        $books = Book::query()
            ->with(['author', 'category'])
            ->where('available_quantity', '>', 0)
            ->orderBy('title')
            ->get();

        $members = Member::query()
            ->with('user')
            ->where('status', 'active')
            ->orderBy('membership_number')
            ->get();

        return view('admin.borrowings.create', compact(
            'books',
            'members'
        ));
    }

    /**
     * Issue a book.
     */
    public function store(StoreBorrowingRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {

            /*
             * Lock the selected book row so two administrators
             * cannot issue the last available copy simultaneously.
             */
            $book = Book::query()
                ->lockForUpdate()
                ->findOrFail($validated['book_id']);

            if ($book->available_quantity <= 0) {
                abort(
                    422,
                    'This book is currently unavailable.'
                );
            }

            $member = Member::query()
                ->lockForUpdate()
                ->findOrFail($validated['member_id']);

            if ($member->status !== 'active') {
                abort(
                    422,
                    'This member is inactive and cannot borrow books.'
                );
            }

            /*
             * Prevent the same member from having
             * multiple active records for the same book.
             */
            $alreadyBorrowed = Borrowing::query()
                ->where('member_id', $member->id)
                ->where('book_id', $book->id)
                ->whereIn('status', ['borrowed', 'overdue'])
                ->exists();

            if ($alreadyBorrowed) {
                abort(
                    422,
                    'This member already has this book.'
                );
            }

            Borrowing::create([
                'book_id' => $book->id,
                'member_id' => $member->id,
                'issued_at' => $validated['issued_at'],
                'due_at' => $validated['due_at'],
                'status' => 'borrowed',
            ]);

            $book->decrement('available_quantity');
        });

        return redirect()
            ->route('admin.borrowings.index')
            ->with('success', 'Book issued successfully.');
    }

    /**
     * Display one borrowing record.
     */
    public function show(Borrowing $borrowing): View
    {
        $borrowing->load([
            'book.author',
            'book.category',
            'member.user',
            'fine',
        ]);

        return view('admin.borrowings.show', compact('borrowing'));
    }

    /**
     * Edit borrowing dates/status.
     */
    public function edit(Borrowing $borrowing): View
    {
        $borrowing->load([
            'book',
            'member.user',
        ]);

        return view('admin.borrowings.edit', compact('borrowing'));
    }

    /**
     * Update borrowing information.
     */
    public function update(
        Request $request,
        Borrowing $borrowing
    ): RedirectResponse {

        if ($borrowing->status === 'returned') {
            return back()->with(
                'error',
                'A returned borrowing record cannot be edited.'
            );
        }

        $validated = $request->validate([
            'issued_at' => [
                'required',
                'date',
            ],

            'due_at' => [
                'required',
                'date',
                'after:issued_at',
            ],
        ]);

        $borrowing->update($validated);

        /*
         * Refresh overdue status after changing the due date.
         */
        if (
            $borrowing->due_at
            && now()->greaterThan($borrowing->due_at)
        ) {
            $borrowing->update([
                'status' => 'overdue',
            ]);
        } else {
            $borrowing->update([
                'status' => 'borrowed',
            ]);
        }

        return redirect()
            ->route('admin.borrowings.index')
            ->with('success', 'Borrowing updated successfully.');
    }

    /**
     * Return a borrowed book.
     */
    public function returnBook(
        Borrowing $borrowing
    ): RedirectResponse {

        DB::transaction(function () use ($borrowing) {

            $borrowing = Borrowing::query()
                ->lockForUpdate()
                ->with('book')
                ->findOrFail($borrowing->id);

            if ($borrowing->status === 'returned') {
                abort(
                    422,
                    'This book has already been returned.'
                );
            }

            $book = Book::query()
                ->lockForUpdate()
                ->findOrFail($borrowing->book_id);

            $borrowing->update([
                'returned_at' => now(),
                'status' => 'returned',
            ]);

            /*
             * Never allow available quantity to exceed
             * the total quantity.
             */
            $book->update([
                'available_quantity' => min(
                    $book->available_quantity + 1,
                    $book->quantity
                ),
            ]);
        });

        return redirect()
            ->route('admin.borrowings.index')
            ->with('success', 'Book returned successfully.');
    }

    /**
 * Mark the fine for a borrowing as paid.
 */
public function markFineAsPaid(
    Borrowing $borrowing
): RedirectResponse {

    $fine = $borrowing->fine;

    if (!$fine) {
        return back()->with(
            'error',
            'No fine exists for this borrowing.'
        );
    }

    if ($fine->status === 'paid') {
        return back()->with(
            'error',
            'This fine has already been paid.'
        );
    }

    $fine->update([
        'status' => 'paid',
        'paid_at' => now(),
    ]);

    return redirect()
        ->route('admin.borrowings.index')
        ->with(
            'success',
            'Fine marked as paid successfully.'
        );
}


    /**
     * Delete a borrowing record.
     */
    public function destroy(Borrowing $borrowing): RedirectResponse
    {
        /*
         * Do not delete active borrowing records because
         * deleting them would make inventory inconsistent.
         */
        if (in_array(
            $borrowing->status,
            ['borrowed', 'overdue'],
            true
        )) {
            return back()->with(
                'error',
                'Active borrowing records cannot be deleted. Return the book first.'
            );
        }

        $borrowing->delete();

        return redirect()
            ->route('admin.borrowings.index')
            ->with('success', 'Borrowing record deleted successfully.');
    }
}
