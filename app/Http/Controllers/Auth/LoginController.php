<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'in:author,reviewer,editor,editor-in-chief,layout-editor,admin,managing-editor'],
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

       if (! Auth::attempt($credentials, $remember)) {
    return back()
        ->withInput($request->only('email', 'role'))
        ->with('error', 'These credentials do not match our records.');
}

$user         = Auth::user();
$selectedRole = $request->input('role');

if (! $user || ! ($user instanceof User) || ! $user->hasRole($selectedRole)) {
    Auth::logout();
    return back()
        ->withInput($request->only('email', 'role'))
        ->with('error', 'Your account does not have the selected role.');
}

// ✅ DITO ILAGAY — pagkatapos ng role check, bago ang session regenerate
if ($user->status === 'pending') {
    Auth::logout();
    return back()
        ->withInput($request->only('email', 'role'))
        ->with('error', 'Your account is pending admin approval.');
}

if ($user->status === 'rejected') {
    Auth::logout();
    return back()
        ->withInput($request->only('email', 'role'))
        ->with('error', 'Your application was not approved. Contact the administrator.');
}

// ✅ Dito na nagsisimula ang dating code
$request->session()->regenerate();
session(['active_role' => $selectedRole]);

        // Increment per-user daily login counter (file-based) and store in session
        try {
            $day = date('Y-m-d');
            $dir = storage_path('app/visitors');
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $uid = $user->id ?? preg_replace('/[^a-z0-9_\-]/i', '_', ($user->email ?? 'guest'));
            $path = $dir . DIRECTORY_SEPARATOR . $day . '.user.' . $uid . '.count';

            if (! file_exists($path)) {
                file_put_contents($path, '1');
                $userCount = 1;
            } else {
                $fp = fopen($path, 'c+');
                if ($fp) {
                    if (flock($fp, LOCK_EX)) {
                        $contents = stream_get_contents($fp);
                        $current = (int) trim($contents);
                        if ($current < 0) $current = 0;
                        $current++;
                        ftruncate($fp, 0);
                        rewind($fp);
                        fwrite($fp, (string) $current);
                        fflush($fp);
                        flock($fp, LOCK_UN);
                        $userCount = $current;
                    } else {
                        $userCount = (int) file_get_contents($path);
                    }
                    fclose($fp);
                } else {
                    $userCount = (int) file_get_contents($path) + 1;
                    file_put_contents($path, (string) $userCount);
                }
            }
        } catch (\Throwable $e) {
            $userCount = null;
        }

        if (isset($userCount)) {
            session(['user_daily_logins' => $userCount]);
        }
        // Increment aggregate daily visitor counter (file-based)
        try {
            $day = date('Y-m-d');
            $dir = storage_path('app/visitors');
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $aggPath = $dir . DIRECTORY_SEPARATOR . $day . '.count';

            if (! file_exists($aggPath)) {
                file_put_contents($aggPath, '1');
            } else {
                $fp2 = fopen($aggPath, 'c+');
                if ($fp2) {
                    if (flock($fp2, LOCK_EX)) {
                        $contents2 = stream_get_contents($fp2);
                        $current2 = (int) trim($contents2);
                        if ($current2 < 0) $current2 = 0;
                        $current2++;
                        ftruncate($fp2, 0);
                        rewind($fp2);
                        fwrite($fp2, (string) $current2);
                        fflush($fp2);
                        flock($fp2, LOCK_UN);
                    }
                    fclose($fp2);
                }
            }
        } catch (\Throwable $_) {
            // ignore aggregate counter errors
        }
   return match($selectedRole) {
    'admin'           => redirect()->route('dashboard.admin'),
    'editor-in-chief' => redirect()->route('chief-editor.dashboard'),
    'managing-editor'  => redirect()->route('managing-editor.dashboard'), 
    'editor'          => redirect()->route('dashboard.editor'),
    'reviewer'        => redirect()->route('dashboard.reviewer'),
    'layout-editor'   => redirect()->route('layout-editor.dashboard'),
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
