<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\str;
use Illuminate\View\View;

class MemberController extends Controller
{
    /**
     * Display all members.
     */
    public function index(Request $request): View
    {
        $search = trim($request->input('search', ''));

        $members = Member::query()
            ->with('user')
            ->withCount([
                'borrowings',
                'borrowings as active_borrowings_count' => function ($query) {
                    $query->whereIn('status', ['borrowed', 'overdue']);
                },
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('membership_number', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.members.index', compact(
            'members',
            'search'
        ));
    }

    /**
     * Show member creation form.
     */
    public function create(): View
    {
        $users = User::query()
            ->where('role', 'member')
            ->whereDoesntHave('member')
            ->orderBy('name')
            ->get();

        return view('admin.members.create', compact('users'));
    }

    /**
     * Store a new member.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'membership_number' => [
                'required',
                'string',
                'max:100',
                'unique:members,membership_number',
            ],

            'join_date' => [
                'required',
                'date',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);

        $user = User::findOrFail($validated['user_id']);

        if ($user->role !== 'member') {
            return back()
                ->withInput()
                ->withErrors([
                    'user_id' => 'Only users with the member role can be assigned to a member record.',
                ]);
        }

        if ($user->member()->exists()) {
            return back()
                ->withInput()
                ->withErrors([
                    'user_id' => 'This user already has a member profile.',
                ]);
        }

        Member::create($validated);

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Member created successfully.');
    }

    /**
     * Display a member.
     */
    public function show(Member $member): View
    {
        $member->load([
            'user',
            'borrowings.book',
        ]);

        $member->loadCount([
            'borrowings',
            'borrowings as active_borrowings_count' => function ($query) {
                $query->whereIn('status', ['borrowed', 'overdue']);
            },
        ]);

        return view('admin.members.show', compact('member'));
    }

    /**
     * Show member edit form.
     */
    public function edit(Member $member): View
    {
        $member->load('user');

        return view('admin.members.edit', compact('member'));
    }

    /**
     * Update member.
     */
    public function update(Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate([
            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'membership_number' => [
                'required',
                'string',
                'max:100',
                'unique:members,membership_number,' . $member->id,
            ],

            'join_date' => [
                'required',
                'date',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);

        /*
         * Do not deactivate a member who currently
         * has borrowed books.
         */
        if (
            $validated['status'] === 'inactive'
            && $member->hasActiveBorrowings()
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'status' => 'This member cannot be made inactive because they still have borrowed books.',
                ]);                                                                     
        }

        $member->update($validated);

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Member updated successfully.');
    }

    /**
     * Delete a member.
     */
    public function destroy(Member $member): RedirectResponse
    {
        if ($member->hasActiveBorrowings()) {
            return back()->with(
                'error',
                'This member cannot be deleted because they still have borrowed books.'
            );
        }

        if ($member->borrowings()->exists()) {
            return back()->with(
                'error',
                'This member cannot be deleted because borrowing records are associated with this member.'
            );
        }

        $member->delete();

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Member deleted successfully.');
    }
}
