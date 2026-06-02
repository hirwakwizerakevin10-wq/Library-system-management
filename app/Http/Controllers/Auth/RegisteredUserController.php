<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

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
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['nullable', 'string', 'max:50'],
            'department' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => User::ROLE_CUSTOMER,
            'password' => Hash::make($request->password),
        ]);

        Student::create([
            'user_id' => $user->id,
            'full_name' => $user->name,
            'registration_number' => 'KH-'.now()->format('Y').'-'.str_pad((string) $user->id, 5, '0', STR_PAD_LEFT),
            'email' => $user->email,
            'phone' => $request->phone,
            'department' => $request->department,
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with('status', 'Registration complete. Please sign in with your new customer account.');
    }
}
