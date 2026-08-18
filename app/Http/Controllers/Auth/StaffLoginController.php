<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
class StaffLoginController extends Controller
{
    public function index()
    {
        $staff = User::where('role', 'staff')->orderBy('name')->get();
        return view('auth.staff-login', compact('staff'));
    }
    public function showPin(User $user)
    {
        if ($user->role !== 'staff') {
            abort(404);
        }
        return view('auth.staff-pin', compact('user'));
    }
    public function attempt(Request $request, User $user)
    {
        if ($user->role !== 'staff') {
            abort(404);
        }
        $validated = $request->validate([
            'pin' => 'required|digits:6',
        ]);
        $key = 'staff-pin-attempt:' . $user->id;
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withInput()->withErrors(['pin' => "Too many attempts. Try again in {$seconds} seconds."]);
        }
        if (! $user->verifyPin($validated['pin'])) {
            RateLimiter::hit($key, 60);
            return back()->withInput()->withErrors(['pin' => 'Incorrect PIN.']);
        }
        RateLimiter::clear($key);
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended(route('sales.index'));
    }
}