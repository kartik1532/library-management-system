<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display the login form.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Authenticate the user.
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
        ]);

        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => 'The provided credentials are incorrect.',
                ]);
        }

        $request->session()->regenerate();

        $user = $request->user();

        /*
         * Prevent inactive members from logging in.
         */
        if ($user->role === 'member') {
            $member = $user->member;

            if (!$member || $member->status !== 'active') {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()
                    ->route('login')
                    ->withErrors([
                        'email' => 'Your member account is inactive. Please contact the administrator.',
                    ]);
            }
        }

        if ($user->isAdmin()) {
            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Welcome back, administrator.');
        }
        return redirect()
            ->intended(route('member.dashboard'))
            ->with('success', 'Welcome back.');
    }
    /**
     * Log the user out.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}