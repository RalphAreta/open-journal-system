@extends('layouts.app')

@section('title', 'Edit User')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <style>
        :root {
            --teal: #2d8176;
            --teal-dark: #1a4d46;
            --teal-light: #e8f4f2;
            --ink: #1a1209;
            --ink-soft: #6b5740;
            --cream: #faf6ef;
            --parchment: #f3ece0;
            --border: #e8dfd0;
            --border-dk: #c9b99a;
            --muted: #64748b;
            --white: #ffffff;
            --red: #dc2626;
        }

        * {
            box-sizing: border-box;
        }

        .aw {
            font-family: 'Source Sans 3', sans-serif;
            color: var(--ink);
        }
        .aw-bg {
            background-color: var(--cream);
            background-image:
                radial-gradient(
                    ellipse 80% 50% at 50% -10%,
                    rgba(45, 129, 118, 0.08) 0%,
                    transparent 70%
                ),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Crect width='4' height='4' fill='%23faf6ef'/%3E%3Ccircle cx='1' cy='1' r='.4' fill='%23e8dfd0' opacity='.5'/%3E%3C/svg%3E");
        }

        /* ── Hero Header ── */
        .hero-header {
            position: relative;
            padding: 44px 0 32px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 32px;
        }
        .hero-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--teal), transparent);
        }
        .hero-eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--teal);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .hero-eyebrow::before {
            content: '';
            width: 24px;
            height: 1px;
            background: var(--teal);
        }
        .hero-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.01em;
            line-height: 1.15;
        }
        .hero-title em {
            font-style: italic;
            color: var(--teal);
        }
        .hero-sub {
            font-size: 0.98rem;
            color: var(--ink-soft);
            margin-top: 8px;
        }
        .date-pill {
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--ink-soft);
            background: var(--parchment);
            border: 1px solid var(--border);
            padding: 6px 16px;
            border-radius: 20px;
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #c9b99a;
            text-decoration: none;
            margin-bottom: 16px;
            transition: color 0.15s;
        }
        .back-link:hover {
            color: var(--teal);
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fu {
            animation: fadeUp 0.4s ease both;
        }
        .fu1 {
            animation: fadeUp 0.4s 0.07s ease both;
        }

        /* ── Card ── */
        .card {
            background: var(--white);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            padding: 32px;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.06);
        }

        /* ── Section label ── */
        .section-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Field ── */
        .field-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-soft);
            display: block;
            margin-bottom: 6px;
        }
        .field-input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--border);
            border-radius: 9px;
            background: var(--parchment);
            font-family: 'Source Sans 3', sans-serif;
            font-size: 13px;
            color: var(--ink);
            outline: none;
            transition:
                border-color 0.15s,
                box-shadow 0.15s;
        }
        .field-input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(45, 129, 118, 0.12);
            background: var(--white);
        }
        .field-input.error {
            border-color: var(--red);
        }
        .field-input::placeholder {
            color: #b5a595;
        }

        /* ── Password wrap ── */
        .pw-wrap {
            position: relative;
        }
        .pw-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #c9b99a;
            transition: color 0.14s;
            padding: 2px;
        }
        .pw-toggle:hover {
            color: var(--teal);
        }

        /* ── Role checkbox cards ── */
        .role-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }
        @media (min-width: 640px) {
            .role-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .role-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            background: var(--parchment);
            border: 1.5px solid var(--border);
            border-radius: 9px;
            cursor: pointer;
            transition:
                border-color 0.15s,
                background 0.15s;
        }
        .role-card:hover {
            border-color: var(--teal);
            background: var(--teal-light);
        }
        .role-card input[type='checkbox'] {
            accent-color: var(--teal);
            width: 15px;
            height: 15px;
            flex-shrink: 0;
            cursor: pointer;
        }
        .role-card:has(input:checked) {
            border-color: var(--teal);
            background: var(--teal-light);
        }
        .role-name {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--ink-soft);
        }
        .role-card:has(input:checked) .role-name {
            color: var(--teal-dark);
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 11px 26px;
            border: none;
            border-radius: 10px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            cursor: pointer;
            text-decoration: none;
            transition:
                transform 0.14s,
                box-shadow 0.14s,
                filter 0.14s;
        }
        .btn:hover {
            transform: translateY(-1px);
            filter: brightness(1.05);
        }
        .btn-teal {
            background: var(--teal);
            color: #fff;
            box-shadow: 0 2px 10px rgba(45, 129, 118, 0.25);
        }
        .btn-ghost {
            background: var(--parchment);
            color: var(--muted);
            border: 1.5px solid var(--border);
        }
        .btn-ghost:hover {
            color: var(--ink);
            border-color: var(--teal);
            background: var(--white);
            filter: none;
            transform: none;
        }

        /* ── Divider ── */
        .divider {
            height: 1px;
            background: var(--border);
            margin: 28px 0;
        }

        /* ── Error message ── */
        .field-error {
            font-size: 11px;
            color: var(--red);
            margin-top: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="aw aw-bg max-w-7xl mx-auto px-6 pb-16">
        {{-- ── Hero Header ── --}}
        <div class="hero-header fu">
            <a href="{{ route('admin.users.index') }}" class="back-link">
                <svg
                    width="12"
                    height="12"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.5"
                >
                    <path d="M19 12H5M12 5l-7 7 7 7" />
                </svg>
                Back to Directory
            </a>
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div>
                    <p class="hero-eyebrow">Administration</p>
                    <h1 class="hero-title">
                        Edit
                        <em>User</em>
                    </h1>
                    <p class="hero-sub">
                        {{ $user->name }} &nbsp;·&nbsp; {{ $user->email }}
                    </p>
                </div>
                <div
                    class="flex items-center gap-3 self-start md:self-auto shrink-0"
                >
                    <span class="date-pill hidden sm:inline-block">
                        {{ now()->format('D, M j Y') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ── Form Card ── --}}
        <div class="card fu1">
            <form
                method="POST"
                action="{{ route('admin.users.update', $user) }}"
                style="display: flex; flex-direction: column; gap: 0"
            >
                @csrf
                @method('PUT')

                {{-- Identity --}}
                <div class="section-label">Identity</div>
                <div
                    style="
                        display: grid;
                        grid-template-columns: 1fr 1fr;
                        gap: 16px;
                        margin-bottom: 28px;
                    "
                >
                    <div>
                        <label for="name" class="field-label">
                            Full Name
                            <span style="color: var(--red)">*</span>
                        </label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                            class="field-input @error('name') error @enderror"
                            placeholder="Full name"
                        />
                        @error('name')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="field-label">
                            Email Address
                            <span style="color: var(--red)">*</span>
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            class="field-input @error('email') error @enderror"
                            placeholder="email@example.com"
                        />
                        @error('email')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="divider"></div>

                {{-- Security --}}
                <div class="section-label">Security</div>
                <div
                    style="
                        display: grid;
                        grid-template-columns: 1fr 1fr;
                        gap: 16px;
                        margin-bottom: 28px;
                    "
                >
                    <div>
                        <label for="password" class="field-label">
                            New Password
                        </label>
                        <div class="pw-wrap">
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="field-input @error('password') error @enderror"
                                placeholder="Leave blank to keep current"
                            />
                            <button
                                type="button"
                                class="pw-toggle"
                                onclick="togglePassword('password')"
                            >
                                <svg
                                    id="eye-icon-password"
                                    width="16"
                                    height="16"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                    />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="field-label">
                            Confirm New Password
                        </label>
                        <div class="pw-wrap">
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                class="field-input"
                                placeholder="Repeat new password"
                            />
                            <button
                                type="button"
                                class="pw-toggle"
                                onclick="
                                    togglePassword('password_confirmation')
                                "
                            >
                                <svg
                                    id="eye-icon-password_confirmation"
                                    width="16"
                                    height="16"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                {{-- Roles --}}
                <div class="section-label">System Roles</div>
                <div class="role-grid" style="margin-bottom: 28px">
                    @foreach ($roles as $role)
                        <label class="role-card">
                            <input
                                type="checkbox"
                                name="roles[]"
                                value="{{ $role->id }}"
                                {{ in_array($role->id, old('roles',$user->roles()->pluck('roles.id')->toArray(),),) ? 'checked' : '' }}
                            />
                            <span class="role-name">
                                {{ $role->display_name }}
                            </span>
                        </label>
                    @endforeach
                </div>

                <div class="divider"></div>

                {{-- Actions --}}
                <div
                    style="
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        padding-top: 4px;
                    "
                >
                    <button type="submit" class="btn btn-teal">
                        <svg
                            width="13"
                            height="13"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                        >
                            <path d="M5 13l4 4L19 7" />
                        </svg>
                        Update Account
                    </button>
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="btn btn-ghost"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = document.getElementById('eye-icon-' + id);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />`;
            } else {
                input.type = 'password';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>
@endpush
