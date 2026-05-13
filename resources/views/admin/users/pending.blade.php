@extends('layouts.app')
@section('title', 'Pending Registrations | Admin')

@section('content')
    <div class="aw aw-bg max-w-5xl mx-auto px-4 py-8">
        <div class="hero-header fu">
            <p class="hero-eyebrow">Admin · Users</p>
            <h1 class="hero-title">
                Pending
                <em>Registrations</em>
            </h1>
            <p class="hero-sub">
                Review CV and approve or reject reviewer / editor applicants.
            </p>
        </div>

        @if (session('success'))
            <div
                class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg"
            >
                {{ session('success') }}
            </div>
        @endif

        @if ($pending->isEmpty())
            <div
                class="feature-card feature-card-dashed text-center py-10 text-[#a0aab8]"
            >
                <svg
                    class="mx-auto mb-3 opacity-40"
                    width="40"
                    height="40"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.4"
                    viewBox="0 0 24 24"
                >
                    <path d="M9 11l3 3L22 4" />
                    <path
                        d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"
                    />
                </svg>
                No pending applications.
            </div>
        @else
            <div class="flex flex-col gap-3">
                @foreach ($pending as $user)
                    <div
                        class="feature-card flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                    >
                        {{-- Info --}}
                        <div class="flex items-start gap-4 min-w-0">
                            <div
                                class="feature-icon shrink-0"
                                style="background: var(--teal-lt)"
                            >
                                <svg
                                    width="18"
                                    height="18"
                                    fill="none"
                                    stroke="var(--teal)"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"
                                    />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="feature-title">{{ $user->name }}</p>
                                <p class="feature-desc">{{ $user->email }}</p>
                                <div class="flex flex-wrap gap-1.5 mt-1.5">
                                    @foreach ($user->roles as $role)
                                        <span
                                            class="action-badge"
                                            style="text-transform: capitalize"
                                        >
                                            {{ $role->name }}
                                        </span>
                                    @endforeach

                                    <span class="action-badge">
                                        Registered
                                        {{ $user->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-2 shrink-0 flex-wrap">
                            @if ($user->cv_path)
                                <a
                                    href="{{ route('admin.users.cv', $user) }}"
                                    target="_blank"
                                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg border border-[#c9a84c]/40 bg-[#fdfcf8] text-[#a07830] text-[.76rem] font-bold tracking-wide uppercase hover:bg-[#c9a84c]/10 transition-colors"
                                >
                                    <svg
                                        width="13"
                                        height="13"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"
                                        />
                                        <polyline points="14 2 14 8 20 8" />
                                    </svg>
                                    View CV
                                </a>
                            @endif

                            <form
                                method="POST"
                                action="{{ route('admin.users.approve', $user) }}"
                            >
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-[var(--teal)] text-white text-[.76rem] font-bold tracking-wide uppercase hover:bg-[var(--teal-dk)] transition-colors shadow-sm"
                                >
                                    <svg
                                        width="13"
                                        height="13"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                        viewBox="0 0 24 24"
                                    >
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                    Approve
                                </button>
                            </form>

                            <form
                                method="POST"
                                action="{{ route('admin.users.reject', $user) }}"
                            >
                                @csrf
                                <button
                                    type="submit"
                                    onclick="
                                        return confirm(
                                            'Reject {{ $user->name }}?',
                                        );
                                    "
                                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-[#c0392b] text-white text-[.76rem] font-bold tracking-wide uppercase hover:bg-[#a93226] transition-colors shadow-sm"
                                >
                                    <svg
                                        width="13"
                                        height="13"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                        viewBox="0 0 24 24"
                                    >
                                        <line x1="18" y1="6" x2="6" y2="18" />
                                        <line x1="6" y1="6" x2="18" y2="18" />
                                    </svg>
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
