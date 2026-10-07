<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use App\Models\Borrowing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function suggestions(Request $request): JsonResponse
    {
        $query = trim((string) $request->input('q', ''));
        $type = (string) $request->input('type', 'books');

        if (mb_strlen($query) < 1) {
            return response()->json([]);
        }

        /*
         * Members are only allowed to search books.
         * Admins can search all supported record types.
         */
        if (!auth()->user()->isAdmin() && $type !== 'books') {
            abort(403);
        }

        $limit = 8;
        $like = '%' . $query . '%';

        return match ($type) {

            /*
             * BOOK SEARCH
             *
             * Searches:
             * - Book title
             * - ISBN
             * - Author name
             * - Category name
             */
            'books' => response()->json(
                Book::query()
                    ->with(['author', 'category'])
                    ->where(function ($builder) use ($like) {

                        $builder
                            ->where('title', 'like', $like)
                            ->orWhere('isbn', 'like', $like)

                            ->orWhereHas(
                                'author',
                                fn ($q) =>
                                    $q->where('name', 'like', $like)
                            )

                            ->orWhereHas(
                                'category',
                                fn ($q) =>
                                    $q->where('name', 'like', $like)
                            );
                    })
                    ->orderBy('title')
                    ->limit($limit)
                    ->get()
                    ->map(fn (Book $book) => [

                        'value' => $book->title,

                        'label' => $book->title,

                        'meta' => trim(
                            implode(
                                ' • ',
                                array_filter([
                                    $book->isbn
                                        ? 'ISBN ' . $book->isbn
                                        : null,

                                    $book->author?->name,

                                    $book->category?->name,
                                ])
                            )
                        ),
                    ])
                    ->values()
            ),

            /*
             * AUTHOR SEARCH
             */
            'authors' => response()->json(
                Author::query()
                    ->where('name', 'like', $like)
                    ->orderBy('name')
                    ->limit($limit)
                    ->get(['name'])
                    ->map(fn (Author $author) => [

                        'value' => $author->name,

                        'label' => $author->name,

                        'meta' => 'Author',
                    ])
                    ->values()
            ),

            /*
             * CATEGORY SEARCH
             */
            'categories' => response()->json(
                Category::query()
                    ->where('name', 'like', $like)
                    ->orderBy('name')
                    ->limit($limit)
                    ->get(['name'])
                    ->map(fn (Category $category) => [

                        'value' => $category->name,

                        'label' => $category->name,

                        'meta' => 'Category',
                    ])
                    ->values()
            ),

            /*
             * MEMBER SEARCH
             *
             * Searches:
             * - Membership number
             * - Phone
             * - Member name
             * - Email
             */
            'members' => response()->json(
                Member::query()
                    ->with('user')
                    ->where(function ($builder) use ($like) {

                        $builder
                            ->where(
                                'membership_number',
                                'like',
                                $like
                            )

                            ->orWhere(
                                'phone',
                                'like',
                                $like
                            )

                            ->orWhereHas(
                                'user',
                                function ($q) use ($like) {

                                    $q->where(
                                        'name',
                                        'like',
                                        $like
                                    )

                                    ->orWhere(
                                        'email',
                                        'like',
                                        $like
                                    );
                                }
                            );
                    })
                    ->latest()
                    ->limit($limit)
                    ->get()
                    ->map(fn (Member $member) => [

                        'value' =>
                            $member->user?->name
                            ?: $member->membership_number,

                        'label' =>
                            $member->user?->name
                            ?: 'Member',

                        'meta' => implode(
                            ' • ',
                            array_filter([
                                $member->membership_number,
                                $member->user?->email,
                                $member->phone,
                            ])
                        ),
                    ])
                    ->values()
            ),

            /*
             * BORROWING / FINE SEARCH
             */
            'borrowings',
            'fines' => $this->borrowingSuggestions(
                $like,
                $limit
            ),

            /*
             * Unknown search type
             */
            default => response()->json([]),
        };
    }


    /**
     * Generate suggestions for borrowings and fines.
     */
    private function borrowingSuggestions(
        string $like,
        int $limit
    ): JsonResponse {

        $results = Borrowing::query()
            ->with([
                'book',
                'member.user'
            ])

            ->where(function ($builder) use ($like) {

                $builder

                    ->whereHas(
                        'book',
                        function ($q) use ($like) {

                            $q->where(
                                'title',
                                'like',
                                $like
                            )

                            ->orWhere(
                                'isbn',
                                'like',
                                $like
                            );
                        }
                    )

                    ->orWhereHas(
                        'member',
                        function ($q) use ($like) {

                            $q->where(
                                'membership_number',
                                'like',
                                $like
                            );
                        }
                    )

                    ->orWhereHas(
                        'member.user',
                        function ($q) use ($like) {

                            $q->where(
                                'name',
                                'like',
                                $like
                            )

                            ->orWhere(
                                'email',
                                'like',
                                $like
                            );
                        }
                    );
            })

            ->latest('issued_at')

            ->limit($limit)

            ->get()

            ->map(fn (Borrowing $borrowing) => [

                'value' =>
                    $borrowing->book?->title
                    ?: $borrowing->member?->user?->name
                    ?: '',

                'label' =>
                    $borrowing->book?->title
                    ?: 'Borrowing',

                'meta' => implode(
                    ' • ',
                    array_filter([
                        $borrowing->member?->user?->name,

                        $borrowing->member?->membership_number,

                        ucfirst($borrowing->status),
                    ])
                ),
            ])

            ->filter(
                fn (array $item) =>
                    $item['value'] !== ''
            )

            ->values();

        return response()->json($results);
    }
}