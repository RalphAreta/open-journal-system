<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'role'     => ['required', 'in:author,reviewer,editor,editor-in-chief,admin'],
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('email', 'role'))
                ->withErrors(['email' => 'These credentials do not match our records.']);
        }

        $user         = Auth::user();
        $selectedRole = $request->input('role');

        // Check if user actually has the selected role
        if (! $user->hasRole($selectedRole)) {
            Auth::logout();
            return back()
                ->withInput($request->only('email', 'role'))
                ->withErrors(['role' => 'Your account does not have the selected role.']);
        }

        $request->session()->regenerate();
        session(['active_role' => $selectedRole]);

        return match($selectedRole) {
            'admin'           => redirect()->route('dashboard.admin'),
            'editor-in-chief' => redirect()->route('chief-editor.dashboard'),
            'editor'          => redirect()->route('dashboard.editor'),
            'reviewer'        => redirect()->route('dashboard.reviewer'),
            default           => redirect()->route('dashboard.author'),
        };
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}