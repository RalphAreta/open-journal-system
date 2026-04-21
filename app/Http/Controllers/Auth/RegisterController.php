<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerificationOtp;
use App\Models\EditorExpertise;
use App\Models\PendingRegistration;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    // ── Show registration form ──────────────────────────────────────
    public function showRegistrationForm()
    {
        $categories = \App\Models\ExpertiseCategory::orderBy('name')->pluck('name');
        return view('auth.register', compact('categories'));
    }

    // ── Step 1: Validate → save pending → send OTP ─────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'roles'    => ['required', 'array', 'min:1'],
            'roles.*'  => ['in:author,reviewer,editor'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $token = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Encrypt the full payload so raw data isn't sitting in the DB
        $payload = Crypt::encryptString(json_encode([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'roles'     => $request->roles,
            'expertise' => $request->input('expertise', []),
        ]));

        PendingRegistration::updateOrCreate(
            ['email' => $request->email],
            [
                'token'      => Hash::make($token),
                'payload'    => $payload,
                'attempts'   => 0,
                'expires_at' => Carbon::now()->addMinutes(10),
            ]
        );

        Mail::to($request->email)->send(new EmailVerificationOtp($token));

        session(['pending_email' => $request->email]);

        return redirect()->route('verify.email.show');
    }

    // ── Step 2: Show OTP page ───────────────────────────────────────
    public function showVerify()
    {
        if (! session('pending_email')) {
            return redirect()->route('register');
        }
        return view('auth.verify-email');
    }

    // ── Step 3: Verify OTP → create real user ──────────────────────
    public function verify(Request $request)
    {
        $request->validate(['token' => ['required', 'digits:6']]);

        $email   = session('pending_email');
        $pending = PendingRegistration::where('email', $email)->first();

        // Expired or not found
        if (! $pending || Carbon::now()->isAfter($pending->expires_at)) {
            $pending?->delete();
            session()->forget('pending_email');
            return redirect()->route('register')
                ->withErrors(['token' => 'Your code has expired. Please register again.']);
        }

        // Too many attempts
        if ($pending->attempts >= 3) {
            $pending->delete();
            session()->forget('pending_email');
            return redirect()->route('register')
                ->withErrors(['token' => 'Too many failed attempts. Please register again.']);
        }

        // Wrong code
        if (! Hash::check($request->token, $pending->token)) {
            $pending->increment('attempts');
            $remaining = 3 - $pending->fresh()->attempts;
            return back()->withErrors([
                'token' => "Invalid code. {$remaining} attempt(s) remaining."
            ]);
        }

        // ✅ OTP valid — decrypt payload and create user
        $data = json_decode(Crypt::decryptString($pending->payload), true);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'], // already hashed
        ]);

        // Assign roles
        $roleModels = Role::whereIn('name', $data['roles'])->get();
        $user->roles()->sync($roleModels->pluck('id'));

        // Assign expertise (for reviewer/editor)
        $needsExpertise = array_intersect($data['roles'], ['reviewer', 'editor']);
        if (! empty($needsExpertise) && ! empty($data['expertise'])) {
            foreach ($data['expertise'] as $field) {
                EditorExpertise::create([
                    'user_id'         => $user->id,
                    'expertise_field' => $field,
                ]);
            }
        }

        // Mark email as verified since they proved ownership via OTP
       // Mark email as verified since they proved ownership via OTP
$user->forceFill(['email_verified_at' => now()])->save();

$pending->delete();
session()->forget('pending_email');

return redirect()->route('login')
    ->with('success', 'Your account has been verified! You can now log in.');
    }

    // ── Step 4: Resend OTP ──────────────────────────────────────────
    public function resend()
    {
        $email   = session('pending_email');
        $pending = $email ? PendingRegistration::where('email', $email)->first() : null;

        if (! $email || ! $pending) {
            return redirect()->route('register');
        }

        $token = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $pending->update([
            'token'      => Hash::make($token),
            'attempts'   => 0,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        Mail::to($email)->send(new EmailVerificationOtp($token));

        return back()->with('resent', true);
    }
}