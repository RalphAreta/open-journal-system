<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EditorExpertise;
use App\Models\ExpertiseCategory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class RegisterController extends Controller
{
    public function showRegistrationForm(): View
    {
        $categories = \App\Models\ExpertiseCategory::orderBy('is_custom')->orderBy('name')->pluck('name');
        return view('auth.register', compact('categories'));
    }

   public function register(Request $request): RedirectResponse
{
    $needsExpertise = collect($request->input('roles', []))
        ->intersect(['editor', 'reviewer'])
        ->isNotEmpty();

    $validated = $request->validate([
        'name'        => ['required', 'string', 'max:255'],
        'email'       => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password'    => ['required', 'confirmed', Password::defaults()],
        'roles'       => ['required', 'array', 'min:1'],
        'roles.*'     => ['in:author,reviewer,editor'],
        'expertise'   => [$needsExpertise ? 'required' : 'nullable', 'array'],
        'expertise.*' => ['string', 'max:100'],
    ]);

    $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

    $user = User::create([
        'name'             => $validated['name'],
        'email'            => $validated['email'],
        'password'         => Hash::make($validated['password']),
        'otp_code'         => $otp,
        'otp_expires_at'   => now()->addMinutes(10),
    ]);

    // Attach roles
    $roleIds = Role::whereIn('name', $validated['roles'])->pluck('id');
    $user->roles()->attach($roleIds);

    // Save expertise if editor or reviewer
    if ($needsExpertise && ! empty($validated['expertise'])) {
        foreach ($validated['expertise'] as $fieldName) {
            EditorExpertise::create([
                'user_id'    => $user->id,
                'field_name' => $fieldName,
            ]);
        }
    }

    Auth::login($user);

   \Mail::to($user->email)->send(new \App\Mail\OtpMail($otp));

   return redirect()->route('verification.notice') // ← same na, okay na
    ->with('message', 'Account created! Please check your email for the verification code.');
}
}