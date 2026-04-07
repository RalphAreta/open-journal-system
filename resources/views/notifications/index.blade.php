@extends('layouts.app')

@section('title', 'Notifications')

@push('styles')
    <style>
        /* ── MOBILE RESPONSIVE for Notifications ── */
        @media (max-width: 640px) {
            /* Header: stack title + unread badge vertically */
            .notif-header {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 10px;
            }

            /* Table header: hide "Time" column label on mobile */
            .notif-table-header {
                grid-template-columns: 16px 1fr !important;
            }
            .notif-table-header .notif-col-time {
                display: none;
            }

            /* Notification row: stack content + meta */
            .notif-row {
                grid-template-columns: 16px 1fr !important;
                padding: 12px 14px !important;
                gap: 10px !important;
            }

            /* Move time + mark-read below the message */
            .notif-right {
                grid-column: 2;
                flex-direction: row !important;
                align-items: center !important;
                justify-content: space-between !important;
                margin-top: 4px;
            }

            /* Allow message text to wrap instead of truncate on mobile */
            .notif-title {
                white-space: normal !important;
                overflow: visible !important;
                text-overflow: unset !important;
            }
            .notif-message {
                -webkit-line-clamp: 2 !important;
            }

            /* Pagination: tighten spacing */
            .notif-pagination {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 10px;
            }
        }

        @media (max-width: 400px) {
            .notif-row {
                padding: 10px 12px !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="mb-4 flex items-center justify-between notif-header">
            <div>
                <h1
                    class="font-['Libre_Baskerville'] text-2xl font-bold text-[#0d1628]"
                >
                    Notifications
                </h1>
                <p class="text-xs text-[#6a7890] mt-0.5">
                    Showing
                    <span class="font-semibold text-[#2D8176]">
                        {{ ucfirst(session('active_role', 'user')) }}
                    </span>
                    notifications &mdash; {{ $notifications->total() }} total
                </p>
            </div>
            @if ($notifications->where('read_at', null)->count() > 0)
                <div class="flex items-center gap-2">
                    <span
                        class="inline-flex items-center gap-1.5 bg-[#edf7f5] text-[#2D8176] text-xs font-semibold px-3 py-1.5 rounded-full border border-[#c5e8e3]"
                    >
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-[#2D8176] inline-block"
                        ></span>
                        {{ $notifications->where('read_at', null)->count() }}
                        unread
                    </span>
                </div>
            @endif
        </div>

        {{-- Notifications Card --}}
        <div
            class="bg-white border border-[#e8e2da] rounded-2xl overflow-hidden shadow-sm"
        >
            {{-- Table Header --}}
            <div
                class="px-4 py-2 bg-[#faf8f5] border-b border-[#ede8e0] grid grid-cols-[16px_1fr_auto] gap-3 items-center notif-table-header"
            >
                <div></div>
                <p
                    class="text-[10px] font-bold uppercase tracking-widest text-[#b0aaa0]"
                >
                    Message
                </p>
                <p
                    class="text-[10px] font-bold uppercase tracking-widest text-[#b0aaa0] notif-col-time"
                >
                    Time
                </p>
            </div>

            @forelse ($notifications as $notif)
                <div
                    class="px-4 py-2.5 border-b border-[#f3efe9] last:border-b-0 grid grid-cols-[16px_1fr_auto] gap-3 items-start {{ is_null($notif->read_at) ? 'bg-[#f0faf8]' : 'bg-white' }} hover:bg-[#faf8f5] transition-colors duration-150 notif-row"
                >
                    {{-- Dot --}}
                    <div class="pt-1.5 flex justify-center">
                        <div
                            class="w-1.5 h-1.5 rounded-full {{ is_null($notif->read_at) ? 'bg-[#2D8176]' : 'bg-[#ddd8d0]' }}"
                        ></div>
                    </div>

                    {{-- Content --}}
                    <div class="min-w-0">
                        <p
                            class="text-sm font-semibold text-[#0d1628] leading-snug truncate notif-title"
                        >
                            {{ $notif->title }}
                        </p>
                        <p
                            class="text-xs text-[#6a7890] leading-snug mt-0.5 line-clamp-1 notif-message"
                        >
                            {{ $notif->message }}
                        </p>

                        {{-- Time + action row (visible on mobile, inside content column) --}}
                        <div
                            class="flex items-center justify-between mt-1 notif-right"
                        >
                            <p
                                class="text-[10px] text-[#b0aaa0] whitespace-nowrap"
                            >
                                {{ $notif->created_at->diffForHumans() }}
                            </p>
                            @if (is_null($notif->read_at))
                                <form
                                    method="POST"
                                    action="{{ route('notifications.read', $notif) }}"
                                >
                                    @csrf
                                    <button
                                        type="submit"
                                        class="text-[10px] font-bold text-[#2D8176] hover:text-[#1f5d54] uppercase tracking-wider transition-colors"
                                    >
                                        Mark read
                                    </button>
                                </form>
                            @else
                                <span class="text-[10px] text-[#c8c2ba]">
                                    Read
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Right: time + action (desktop only) --}}
                    <div
                        class="flex flex-col items-end gap-1 shrink-0 hidden sm:flex"
                    >
                        <p class="text-[10px] text-[#b0aaa0] whitespace-nowrap">
                            {{ $notif->created_at->diffForHumans() }}
                        </p>
                        @if (is_null($notif->read_at))
                            <form
                                method="POST"
                                action="{{ route('notifications.read', $notif) }}"
                            >
                                @csrf
                                <button
                                    type="submit"
                                    class="text-[10px] font-bold text-[#2D8176] hover:text-[#1f5d54] uppercase tracking-wider transition-colors"
                                >
                                    Mark read
                                </button>
                            </form>
                        @else
                            <span class="text-[10px] text-[#c8c2ba]">Read</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="px-4 py-12 text-center">
                    <div
                        class="w-10 h-10 rounded-full bg-[#f3efe9] flex items-center justify-center mx-auto mb-3"
                    >
                        <svg
                            class="w-5 h-5 text-[#c8c2ba]"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                            />
                        </svg>
                    </div>
                    <p class="text-sm text-[#b0aaa0] font-medium">
                        No notifications yet
                    </p>
                    <p class="text-xs text-[#c8c2ba] mt-1">
                        for
                        <span class="font-semibold">
                            {{ session('active_role', 'your current role') }}
                        </span>
                    </p>
                    @if (auth()->user()->roles->count() > 1)
                        <p class="text-xs text-[#6a7890] mt-3">
                            Switch roles from the top navigation to see other
                            notifications.
                        </p>
                    @endif
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($notifications->hasPages())
            <div
                class="mt-4 flex items-center justify-between notif-pagination"
            >
                <p class="text-xs text-[#b0aaa0]">
                    Page {{ $notifications->currentPage() }} of
                    {{ $notifications->lastPage() }} &mdash;
                    {{ $notifications->total() }} total
                </p>
                <div class="flex items-center gap-1">
                    @if ($notifications->onFirstPage())
                        <span
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-sm text-[#ddd8d0] cursor-not-allowed border border-[#ede8e0] bg-white"
                        >
                            &lsaquo;
                        </span>
                    @else
                        <a
                            href="{{ $notifications->previousPageUrl() }}"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-sm text-[#6a7890] hover:bg-[#f3efe9] border border-[#ede8e0] bg-white transition-colors"
                        >
                            &lsaquo;
                        </a>
                    @endif

                    @foreach ($notifications->getUrlRange(1, $notifications->lastPage()) as $page => $url)
                        @if ($page == $notifications->currentPage())
                            <span
                                class="w-8 h-8 flex items-center justify-center rounded-lg text-sm font-bold bg-[#2D8176] text-white border border-[#2D8176]"
                            >
                                {{ $page }}
                            </span>
                        @elseif (abs($page - $notifications->currentPage()) <= 1 || $page == 1 || $page == $notifications->lastPage())
                            <a
                                href="{{ $url }}"
                                class="w-8 h-8 flex items-center justify-center rounded-lg text-sm text-[#6a7890] hover:bg-[#f3efe9] hover:text-[#0d1628] border border-[#ede8e0] bg-white transition-colors"
                            >
                                {{ $page }}
                            </a>
                        @elseif (abs($page - $notifications->currentPage()) == 2)
                            <span
                                class="w-8 h-8 flex items-center justify-center text-sm text-[#c8c2ba]"
                            >
                                &hellip;
                            </span>
                        @endif
                    @endforeach

                    @if ($notifications->hasMorePages())
                        <a
                            href="{{ $notifications->nextPageUrl() }}"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-sm text-[#6a7890] hover:bg-[#f3efe9] border border-[#ede8e0] bg-white transition-colors"
                        >
                            &rsaquo;
                        </a>
                    @else
                        <span
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-sm text-[#ddd8d0] cursor-not-allowed border border-[#ede8e0] bg-white"
                        >
                            &rsaquo;
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
