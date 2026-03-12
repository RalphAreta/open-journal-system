@extends('layouts.app')

@section('title', 'Layout Editor Dashboard')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <style>
        :root {
            --teal: #2d8176;
            --teal-dk: #1a4d46;
            --teal-lt: #e8f4f2;
            --gold: #c9a84c;
            --gold-lt: #e8d49a;
            --gold-dk: #8a6e28;
            --ink: #1a1209;
            --ink-mid: #3d2f1a;
            --ink-soft: #6b5740;
            --cream: #faf6ef;
            --parchment: #f3ece0;
            --border: #e8dfd0;
            --border-dk: #c9b99a;
        }
        * {
            box-sizing: border-box;
        }
        .aw {
            font-family: 'Source Sans 3', sans-serif;
            color: var(--ink);
            font-size: 16px;
        }
        .serif {
            font-family: 'Libre Baskerville', serif;
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
        .hero-header {
            position: relative;
            padding: 44px 0 32px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 36px;
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
            font-weight: 400;
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

        .fu {
            animation: fadeUp 0.45s ease both;
        }
        .fu1 {
            animation: fadeUp 0.45s 0.08s ease both;
        }
        .fu2 {
            animation: fadeUp 0.45s 0.16s ease both;
        }
        .fu3 {
            animation: fadeUp 0.45s 0.24s ease both;
        }
        .fu4 {
            animation: fadeUp 0.45s 0.32s ease both;
        }
    </style>
@endpush

@section('content')
    {{-- Top shimmer line --}}
    <div class="h-0.5 w-full shimmer-bar"></div>

    <div class="aw aw-bg max-w-7xl mx-auto px-4">
        {{-- Hero Header (matches Author Dashboard style) --}}
        <div class="hero-header fu">
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div>
                    <p class="hero-eyebrow">Layout Editor Portal</p>
                    <h1 class="hero-title">
                        Your
                        <em>Layout</em>
                        Workspace
                    </h1>
                    <p class="hero-sub">
                        Manage layouts, format submissions, and prepare
                        publications
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

        {{-- Main Content --}}
        <div class="space-y-8 pb-10">
            {{-- Stats Row --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 fu1">
        @php
    $stats = [
        ['label' => 'For Layout',  'value' => $pendingReviewCount,   'icon' => '📐', 'delay' => '100ms'],
        ['label' => 'In Progress', 'value' => $inProgressCount,      'icon' => '✏️', 'delay' => '180ms'],
        ['label' => 'Completed',   'value' => $completedCount,       'icon' => '🔍', 'delay' => '260ms'],
        ['label' => 'Total',       'value' => $assignments->total(), 'icon' => '📄', 'delay' => '340ms'],
    ];
@endphp

                @foreach ($stats as $stat)
                    <div
                        class="card-hover bg-white/90 border border-[#c9a84c]/20 rounded-2xl p-5 backdrop-blur-sm"
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
                    class="fu2 md:col-span-1 bg-white/90 border border-[#c9a84c]/20 rounded-2xl p-6 backdrop-blur-sm"
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
                            href="#"
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
    class="fu3 md:col-span-2 bg-white/90 border border-[#c9a84c]/20 rounded-2xl p-6 backdrop-blur-sm"
    style="animation-delay: 500ms"
>
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="font-['Libre_Baskerville'] text-lg font-bold text-[#0d1628]">
                Assigned Papers
            </h2>
            <p class="text-[12px] text-[#8a96a8]">
                Papers requiring layout formatting
            </p>
        </div>
        <span class="px-3 py-1 bg-[#2D8176]/10 text-[#2D8176] text-[10px] font-black uppercase tracking-widest rounded-full">
            Active
        </span>
    </div>

    @if ($assignments->isEmpty())
        <div class="flex flex-col items-center justify-center py-12 text-center">
            <div class="w-14 h-14 rounded-2xl bg-[#f5f0e8] flex items-center justify-center text-2xl mb-3">
                📄
            </div>
            <p class="font-semibold text-[#0d1628] text-sm">No papers assigned yet</p>
            <p class="text-[12px] text-[#8a96a8] mt-1">Papers assigned to you will appear here.</p>
        </div>
    @else
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
                @foreach ($assignments as $assignment)
                    <tr class="border-b border-[#f5f0e8] hover:bg-[#fafaf8] transition-colors">
                        <td class="py-3 font-medium text-[#0d1628]">
                            {{ $assignment->submission->title }}
                        </td>
                        <td class="py-3 text-[#6a7890]">
                            {{ $assignment->submission->author->name ?? 'Unknown' }}
                        </td>
                        <td class="py-3">
                            <span class="px-2 py-1 bg-[#c9a84c]/10 text-[#a07830] text-[10px] font-bold uppercase rounded-full">
                                {{ $assignment->status }}
                            </span>
                        </td>
                       <td class="py-3">
    <a href="{{ route('layout-editor.show', $assignment->id) }}" class="text-[#2D8176] text-[11px] font-semibold hover:underline">Open →</a>
</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $assignments->links() }}
        </div>
    @endif
</div>

{{-- Author Revision Notes --}}
@php
    $revisionAssignments = $assignments->filter(fn($a) => 
        $a->status === 'pending' && str_starts_with($a->notes ?? '', 'Author revision request:')
    );
@endphp

@if ($revisionAssignments->count())
<div class="fu3 md:col-span-3 bg-white/90 border border-[#c9a84c]/30 rounded-2xl p-6 backdrop-blur-sm">
    <div class="flex items-center gap-3 mb-4">
        <span class="text-xl">⚠️</span>
        <div>
            <h2 class="font-['Libre_Baskerville'] text-lg font-bold text-[#0d1628]">
                Revision Requests from Author
            </h2>
            <p class="text-[12px] text-[#8a96a8]">
                These papers need layout revision based on author feedback
            </p>
        </div>
    </div>

    <div class="space-y-3">
        @foreach ($revisionAssignments as $ra)
        <div class="p-4 rounded-xl border border-[#c9a84c]/40 bg-[#fffdf9]">
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div class="flex-1">
                    <p class="font-['Libre_Baskerville'] text-[.95rem] font-bold text-[#1a1209] italic">
                        {{ $ra->submission->title }}
                    </p>
                    <p class="text-[.75rem] text-[#6b5740] mt-0.5">
                        by {{ $ra->submission->author->name ?? 'Unknown' }}
                    </p>

                    {{-- Author's reason --}}
                    @if ($ra->notes)
                    <div class="mt-3 p-3 bg-white border-l-4 border-[#c9a84c] rounded-lg">
                        <p class="text-[.65rem] font-extrabold tracking-widest uppercase text-[#8a6e28] mb-1">
                            Author's Revision Note
                        </p>
                        <p class="text-[.85rem] italic text-[#3d2f1a] leading-relaxed">
                            {{ str_replace('Author revision request: ', '', $ra->notes) }}
                        </p>
                    </div>
                    @endif
                </div>
                <a href="{{ route('layout-editor.show', $ra->id) }}"
                    class="shrink-0 px-4 py-2 bg-[#c9a84c] hover:bg-[#a07830] text-white text-[.7rem] font-bold uppercase tracking-wider rounded-lg transition-all">
                    Open & Revise →
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

            {{-- Footer note --}}
            <div class="fu4 text-center pb-4" style="animation-delay: 600ms">
                <p class="text-[11px] text-[#b8aa90] uppercase tracking-widest">
                  
                </p>
            </div>
        </div>
    </div>
@endsection
