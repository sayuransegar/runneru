<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Runner;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'studid' => ['required', 'string', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'studid.unique' => 'The student ID has already been taken.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phonenum' => $request->phonenum,
            'studid' => $request->studid,
            'usertype' => $request->usertype,
            'blocked' => false,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        Session::flash('success', 'You have successfully register.');
        return redirect(route('dashboard', absolute: false));
    }

    public function listcustomer(Request $request)
    {
        $search = $request->input('search');
    
        $query = User::where('usertype', 'customer');
    
        if ($search) {
            $query->where('studid', 'like', '%' . $search . '%');
        }
    
        $customers = $query->get();
    
        return view('auth.listcustomer', compact('customers', 'search'));
    }

    public function blockCustomer($id)
    {
        $user = User::findOrFail($id);
    
        // Update the 'blocked' status on the User model
        $user->update(['blocked' => true]);
    
        // Find the related runner and update the status to offline
        $runner = Runner::where('userid', $id)->first();
        if ($runner) {
            $runner->update(['status' => 'offline']);
        }
        
        Session::flash('success', 'Customer blocked and set to offline successfully');
        return redirect()->back();
    }

    public function unblockCustomer($id)
    {
        $user = User::findOrFail($id);
    
        // Update the 'blocked' status on the User model
        $user->update(['blocked' => false]);
    
        // Find the related runner and update the status to online
        $runner = Runner::where('userid', $id)->first();
        if ($runner) {
            $runner->update(['status' => 'online']);
        }
    
        Session::flash('success', 'Customer unblocked and set to online successfully');
        return redirect()->back();
    }
    
    public function showAdminDashboard()
    {
        $user = Auth::user();

        if ($user->usertype !== 'admin') {
            return redirect()->route('home')->with('error', 'You are not authorized to access the admin dashboard.');
        }

        $totalUsers = User::where('usertype', 'customer')->count();
        $activeUsers = User::where('blocked', false)->where('usertype', 'customer')->count();
        $blockedUsers = User::where('blocked', true)->where('usertype', 'customer')->count();
        $users = User::where('usertype', 'customer')->get();

        return view('admindashboard', compact('user', 'totalUsers', 'activeUsers', 'blockedUsers', 'users'));
    }

}
