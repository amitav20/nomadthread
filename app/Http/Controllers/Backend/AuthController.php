<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\DatabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        // Initialize DB/tables/seeds if needed
        DatabaseService::getConnection();

        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('backend.dashboard');
        }

        return view('backend.auth.login');
    }

    /**
     * Handle admin login submission.
     */
    public function login(Request $request)
    {
        DatabaseService::getConnection();

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $throttleKey = Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());

        // Limit to 5 attempts per minute
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Validate admin role
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                RateLimiter::hit($throttleKey, 60);

                return redirect()->route('backend.login')->with('error', 'Unauthorized access. Permitted for administrators only.');
            }

            // Authentication passed
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            return redirect()->intended(route('backend.dashboard'))->with('success', 'Welcome back, ' . Auth::user()->name);
        }

        // Authentication failed
        RateLimiter::hit($throttleKey, 60);

        throw ValidationException::withMessages([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    /**
     * Log the admin out.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('backend.login')->with('success', 'Logged out successfully.');
    }

    /**
     * Show the customer login form.
     */
    public function showCustomerLoginForm()
    {
        \App\Services\DatabaseService::getConnection();

        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('frontend.auth.login');
    }

    /**
     * Handle customer login submission.
     */
    public function customerLogin(Request $request)
    {
        \App\Services\DatabaseService::getConnection();

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Redirect admin to admin dashboard, regular user to home
            if (Auth::user()->role === 'admin') {
                return redirect()->route('backend.dashboard')->with('success', 'Logged in as Admin.');
            }
            
            return redirect()->route('home')->with('success', 'Logged in successfully.');
        }

        throw ValidationException::withMessages([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    /**
     * Show the customer registration form.
     */
    public function showCustomerRegisterForm()
    {
        \App\Services\DatabaseService::getConnection();

        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('frontend.auth.register');
    }

    /**
     * Handle customer registration submission.
     */
    public function customerRegister(Request $request)
    {
        \App\Services\DatabaseService::getConnection();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Account created successfully!');
    }

    /**
     * Log the customer out.
     */
    public function customerLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }
}
