<?php
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Member\ProfileController;
use App\Http\Controllers\Member\FineController as MemberFineController;
use App\Http\Controllers\Member\BorrowingController as MemberBorrowingController;
use App\Http\Controllers\Member\BookController as MemberBookController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\BorrowingController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [
        LoginController::class,
        'create',
    ])->name('login');

    Route::post('/login', [
        LoginController::class,
        'store',
    ])->name('login.store');
});

Route::post('/logout', [
    LoginController::class,
    'destroy',
])->middleware('auth')->name('logout');

Route::get('/search/suggestions', [
    SearchController::class,
    'suggestions',
])
    ->middleware('auth')
    ->name('search.suggestions');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [
            AdminDashboardController::class,
            'index',
        ])->name('dashboard');

        // Authors
        Route::resource('authors', AuthorController::class);

        // Categories
        Route::resource('categories', CategoryController::class);

        // Books
        Route::resource('books', BookController::class);

        // Members
        Route::resource('members', MemberController::class);


        // Borrowings
        Route::resource('borrowings', BorrowingController::class);

        // Return Book
        Route::post(
            'borrowings/{borrowing}/return',
            [BorrowingController::class, 'returnBook']
        )->name('borrowings.return');

        // Mark Fine as Paid
        Route::post(
            'borrowings/{borrowing}/pay-fine',
            [BorrowingController::class, 'markFineAsPaid']
        )->name('borrowings.pay-fine');


        // Reports
        Route::get(
            '/reports',
            [ReportController::class, 'index']
        )->name('reports.index');

        Route::get(
            '/reports/borrowings',
            [ReportController::class, 'borrowings']
        )->name('reports.borrowings');

        Route::get(
            '/reports/fines',
            [ReportController::class, 'fines']
        )->name('reports.fines');


        // Admin Profile
        Route::get('/profile', [
            AdminProfileController::class,
            'edit',
        ])->name('profile.edit');

        Route::put('/profile', [
            AdminProfileController::class,
            'update',
        ])->name('profile.update');

        Route::put('/profile/password', [
            AdminProfileController::class,
            'updatePassword',
        ])->name('profile.password');

        Route::get('/reports/books', [ReportController::class, 'books'])
            ->name('reports.books');

            
    });

/*
|--------------------------------------------------------------------------
| Member Routes
|--------------------------------------------------------------------------
*/

Route::prefix('member')
    ->name('member.')
    ->middleware(['auth', 'member'])
    ->group(function () {

        Route::get('/dashboard', [
            MemberDashboardController::class,
            'index',
        ])->name('dashboard');

        Route::get('/books', [
            MemberBookController::class,
            'index',
        ])->name('books.index');

        Route::get('/borrowings', [
            MemberBorrowingController::class,
            'index',
        ])->name('borrowings.index');

        Route::get('/fines', [
            MemberFineController::class,
            'index',
        ])->name('fines.index');

        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
            ->name('profile.password');

        Route::get('/notifications', function () {
            return view('member.notifications.index', [
                'notifications' => auth()->user()
                    ->notifications()
                    ->latest()
                    ->paginate(10),
            ]);
        })->name('notifications.index');

        Route::post('/notifications/{notification}/read', function (\Illuminate\Notifications\DatabaseNotification $notification) {
            if ($notification->notifiable_id !== auth()->id()) {
                abort(403);
            }

            $notification->markAsRead();

            return back();
        })->name('notifications.read');

        Route::post('/notifications/read-all', function () {
            auth()->user()
                ->unreadNotifications
                ->markAsRead();

            return back();
        })->name('notifications.read-all');


    });
    