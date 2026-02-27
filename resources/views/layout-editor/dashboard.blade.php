@extends('layouts.app')

@section('title', 'Layout Editor Dashboard')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes shimmer {
            0% {
                background-position: -100% 0;
            }
            100% {
                background-position: 100% 0;
            }
        }
        @keyframes blink {
            0%,
            100% {
                opacity: 1;
            }
            50% {
                opacity: 0.3;
            }
        }
        .fade-up {
            opacity: 0;
            animation: fadeUp 0.6s ease forwards;
        }
        .shimmer-bar {
            background: linear-gradient(
                90deg,
                transparent,
                #c9a84c,
                #f0d678,
                #c9a84c,
                transparent
            );
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
        }
        .card-hover {
            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(160, 120, 48, 0.15);
        }
    </style>
@endpush

@section('content')
    <div
        class="min-h-screen bg-gradient-to-br from-[#f5f0e8] via-[#ede5d5] to-[#e4daf0] font-['Source_Sans_3']"
    >
        {{-- Top shimmer line --}}
        <div class="h-[2px] w-full shimmer-bar"></div>

        {{-- Header --}}
        <div class="bg-[#2D8176] relative overflow-hidden">
            <div class="absolute inset-0 bg-black/10"></div>
            <div
                class="absolute inset-0 opacity-[0.05]"
                style="
                    background-image: radial-gradient(
                        circle,
                        #ffffff 1px,
                        transparent 1px
                    );
                    background-size: 28px 28px;
                "
            ></div>

            <div
                class="relative z-10 max-w-6xl mx-auto px-6 py-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4"
            >
                <div class="fade-up" style="animation-delay: 80ms">
                    <p
                        class="text-[10px] tracking-widest uppercase text-[#f0d678] font-semibold flex items-center gap-2 mb-1"
                    >
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-[#c9a84c] shadow-[0_0_8px_rgba(201,168,76,0.8)]"
                            style="animation: blink 2s ease-in-out infinite"
                        ></span>
                        Layout Editor Portal
                    </p>
                    <h1
                        class="font-['Libre_Baskerville'] text-3xl font-bold text-white leading-tight"
                    >
                        Welcome back,
                        <em
                            class="not-italic bg-gradient-to-r from-[#c9a84c] via-[#f0d678] to-[#c9a84c] bg-clip-text text-transparent"
                        >
                            {{ auth()->user()->name }}
                        </em>
                    </h1>
                    <p class="text-white/70 text-sm mt-1">
                        Manage layouts, format submissions, and prepare
                        publications.
                    </p>
                </div>

                <div
                    class="fade-up flex items-center gap-3"
                    style="animation-delay: 200ms"
                >
                    <div class="text-right hidden md:block">
                        <p
                            class="text-white/50 text-[11px] uppercase tracking-widest"
                        >
                            Today
                        </p>
                        <p class="text-white font-semibold text-sm">
                            {{ now()->format('F d, Y') }}
                        </p>
                    </div>

                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="max-w-6xl mx-auto px-6 py-10 space-y-8">
            {{-- Stats Row --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $stats = [
                        ['label' => 'For Layout', 'value' => $assignments->total(), 'icon' => '📐', 'delay' => '100ms'],
                        ['label' => 'In Progress', 'value' => $inProgressCount ?? 0, 'icon' => '✏️', 'delay' => '180ms'],
                        ['label' => 'For Review', 'value' => $pendingReviewCount ?? 0, 'icon' => '🔍', 'delay' => '260ms'],
                        ['label' => 'Published', 'value' => $completedCount ?? 0, 'icon' => '📄', 'delay' => '340ms'],
                    ];
                @endphp

                @foreach ($stats as $stat)
                    <div
                        class="fade-up card-hover bg-white/90 border border-[#c9a84c]/20 rounded-2xl p-5 backdrop-blur-sm"
                        style="animation-delay: {{ $stat['delay'] }}"
                    >
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-2xl">{{ $stat['icon'] }}</span>
                            <span
                                class="text-[10px] uppercase tracking-widest text-[#a07830] font-semibold"
                            >
                                {{ $stat['label'] }}
                            </span>
                        </div>
                        <p
                            class="font-['Libre_Baskerville'] text-3xl font-bold text-[#0d1628]"
                        >
                            {{ $stat['value'] }}
                        </p>
                    </div>
                @endforeach
            </div>

            {{-- Main Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Quick Actions --}}
                <div
                    class="fade-up md:col-span-1 bg-white/90 border border-[#c9a84c]/20 rounded-2xl p-6 backdrop-blur-sm"
                    style="animation-delay: 400ms"
                >
                    <h2
                        class="font-['Libre_Baskerville'] text-lg font-bold text-[#0d1628] mb-1"
                    >
                        Quick Actions
                    </h2>
                    <p class="text-[12px] text-[#8a96a8] mb-5">
                        Common layout editor tasks
                    </p>

                    <div class="space-y-3">
                        <a
                            href="{{ route('layout-editor.dashboard') }}"
                            class="flex items-center gap-3 p-3 rounded-xl bg-[#2D8176]/5 hover:bg-[#2D8176]/10 border border-[#2D8176]/10 transition-all group"
                        >
                            <span
                                class="w-8 h-8 rounded-lg bg-[#2D8176] flex items-center justify-center text-white text-sm"
                            >
                                📐
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-[#0d1628]">
                                    View Assigned Papers
                                </p>
                                <p class="text-[11px] text-[#8a96a8]">
                                    Papers pending layout
                                </p>
                            </div>
                        </a>
                        <a
                            href="#"
                            class="flex items-center gap-3 p-3 rounded-xl bg-[#c9a84c]/5 hover:bg-[#c9a84c]/10 border border-[#c9a84c]/10 transition-all group"
                        >
                            <span
                                class="w-8 h-8 rounded-lg bg-[#c9a84c] flex items-center justify-center text-white text-sm"
                            >
                                ✏️
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-[#0d1628]">
                                    Submit Layout
                                </p>
                                <p class="text-[11px] text-[#8a96a8]">
                                    Upload formatted file
                                </p>
                            </div>
                        </a>
                        <a
                            href="#"
                            class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-100 transition-all group"
                        >
                            <span
                                class="w-8 h-8 rounded-lg bg-slate-200 flex items-center justify-center text-slate-600 text-sm"
                            >
                                📋
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-[#0d1628]">
                                    Layout History
                                </p>
                                <p class="text-[11px] text-[#8a96a8]">
                                    Previously completed
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Assigned Papers Table --}}
                <div
                    class="fade-up md:col-span-2 bg-white/90 border border-[#c9a84c]/20 rounded-2xl p-6 backdrop-blur-sm"
                    style="animation-delay: 500ms"
                >
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h2
                                class="font-['Libre_Baskerville'] text-lg font-bold text-[#0d1628]"
                            >
                                Assigned Papers
                            </h2>
                            <p class="text-[12px] text-[#8a96a8]">
                                Papers requiring layout formatting
                            </p>
                        </div>
                        <span
                            class="px-3 py-1 bg-[#2D8176]/10 text-[#2D8176] text-[10px] font-black uppercase tracking-widest rounded-full"
                        >
                            Active
                        </span>
                    </div>

                    @if ($assignments->isEmpty())
                        {{-- Empty State --}}
                        <div
                            class="flex flex-col items-center justify-center py-12 text-center"
                        >
                            <div
                                class="w-14 h-14 rounded-2xl bg-[#f5f0e8] flex items-center justify-center text-2xl mb-3"
                            >
                                📄
                            </div>
                            <p class="font-semibold text-[#0d1628] text-sm">
                                No papers assigned yet
                            </p>
                            <p class="text-[12px] text-[#8a96a8] mt-1">
                                Papers assigned to you will appear here.
                            </p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-[#e8e0d0]">
                                        <th class="text-left text-[10px] uppercase tracking-widest text-[#a07830] pb-3 font-semibold">Title</th>
                                        <th class="text-left text-[10px] uppercase tracking-widest text-[#a07830] pb-3 font-semibold">Author</th>
                                        <th class="text-left text-[10px] uppercase tracking-widest text-[#a07830] pb-3 font-semibold">Status</th>
                                        <th class="pb-3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignments as $assignment)
                                        <tr class="border-b border-[#f5f0e8] hover:bg-[#fafaf8] transition-colors">
                                            <td class="py-3 font-medium text-[#0d1628]">{{ $assignment->submission->title }}</td>
                                            <td class="py-3 text-[#6a7890]">{{ $assignment->submission->author->name ?? 'Anonymous' }}</td>
                                            <td class="py-3">
                                                <span class="px-2 py-1 bg-[#c9a84c]/10 text-[#a07830] text-[10px] font-bold uppercase rounded-full">{{ ucfirst(str_replace('_', ' ', $assignment->status)) }}</span>
                                            </td>
                                            <td class="py-3">
                                                <a href="{{ route('layout-editor.show', $assignment->id) }}" class="text-[#2D8176] text-[11px] font-semibold hover:underline">Open →</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Footer note --}}
            <div
                class="fade-up text-center pb-4"
                style="animation-delay: 600ms"
            >
                <p class="text-[11px] text-[#b8aa90] uppercase tracking-widest">
                    BatStateU · BIRJISE Journal System · Layout Editor Portal
                </p>
            </div>
        </div>
    </div>
@endsection
