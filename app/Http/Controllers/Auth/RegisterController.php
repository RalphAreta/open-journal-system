<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'roles'    => ['required', 'array', 'min:1'],
            'roles.*'  => ['in:author,reviewer,editor'],  // only these 3 can self-register
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $roleIds = Role::whereIn('name', $validated['roles'])->pluck('id');
        $user->roles()->attach($roleIds);

        event(new Registered($user));
        Auth::login($user);

        // Redirect by priority
        return match(true) {
            in_array('editor',   $validated['roles']) => redirect()->route('dashboard.editor'),
            in_array('reviewer', $validated['roles']) => redirect()->route('dashboard.reviewer'),
            default                                   => redirect()->route('dashboard.author'),
        };
    }
}