<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Runner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
        $credentials = $request->only('email', 'password', 'role');
    
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'required|string',
        ]);
    
        $user = User::where('email', $credentials['email'])->first();
    
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Check if the user is blocked
            if ($user->blocked) {
                return back()->withErrors(['email' => 'Your account has been blocked.']);
            }
    
            session(['selected_role' => $credentials['role']]);
    
            if ($credentials['role'] === 'runner') {
                $runner = Runner::where('userid', $user->id)->first();
                if ($runner) {
                    if ($runner->approval == "1") {
                        // $runner->update(['status' => 'online']);
                        Auth::login($user);
                        return redirect()->route('runnerdashboard');
                    } else {
                        return back()->withErrors(['role' => 'Your runner account is not approved.']);
                    }
                } else {
                    return back()->withErrors(['role' => 'You are not registered as a runner.']);
                }
            } elseif ($credentials['role'] === 'customer') {
                if ($user->usertype == "customer") {
                    Auth::login($user);
                    return redirect()->route('dashboard');
                } else {
                    return back()->withErrors(['role' => 'You are not a customer.']);
                }
            } elseif($credentials['role'] === 'admin'){
                if ($user->usertype == "admin") {
                    Auth::login($user);
                    return redirect()->route('admindashboard');
                } else {
                    return back()->withErrors(['role' => 'You are not an admin.']);
                }
            } else {
                return back()->withErrors(['role' => 'Invalid role selected.']);
            }
        }
    
        return back()->withErrors(['email' => 'These credentials do not match our records.']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // // Get the logged-in user
        // $user = Auth::user();

        // // Check if the user is a runner
        // $runner = Runner::where('userid', $user->id)->first();

        // if ($runner) {
        //     // Update the runner's status to "offline"
        //     $runner->update(['status' => 'offline']);
        // }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $request->session()->forget('selected_role');

        return redirect('/');
    }
}
