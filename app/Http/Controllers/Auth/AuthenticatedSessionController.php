<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        
        // Check if there was an intended room booking
        if ($roomId = session('intended_room_booking')) {
            session()->forget('intended_room_booking');
            return redirect()->route('rooms.book', $roomId);
        }
        
        // Role-based redirection
        return redirect()->intended($this->getRedirectUrl($user));
    }

    /**
     * Get the redirect URL based on user role.
     */
    private function getRedirectUrl($user): string
    {
        switch ($user->role) {
            case 'admin':
                return '/admin/dashboard';
            case 'receptionist':
                return '/receptionist/dashboard';
            case 'customer':
            default:
                return '/dashboard';
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}