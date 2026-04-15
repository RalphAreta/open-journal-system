@extends('layouts.app')

@section('title', 'Managing Editor Dashboard')

@push('styles')
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
        @media (max-width: 640px) {
            .hero-header {
                padding: 28px 0 22px;
                margin-bottom: 24px;
            }
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
        @media (max-width: 640px) {
            .hero-title {
                font-size: 2rem;
            }
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
        @media (max-width: 640px) {
            .hero-sub {
                font-size: 0.88rem;
            }
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

        /* Stat Grid */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            background: var(--parchment);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.07);
        }
        @media (max-width: 700px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        .stat-cell {
            padding: 24px 22px 18px;
            border-right: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            position: relative;
            transition: background 0.18s;
            cursor: default;
        }
        @media (max-width: 640px) {
            .stat-cell {
                padding: 18px 16px 14px;
            }
        }
        .stat-cell:hover {
            background: #fff;
        }
        .stat-cell:nth-child(4n) {
            border-right: none;
        }
        .stat-cell:nth-last-child(-n + 4) {
            border-bottom: none;
        }
        @media (max-width: 700px) {
            .stat-cell:nth-child(4n) {
                border-right: 1px solid var(--border);
            }
            .stat-cell:nth-last-child(-n + 4) {
                border-bottom: 1px solid var(--border);
            }
            .stat-cell:nth-child(2n) {
                border-right: none;
            }
            .stat-cell:nth-child(n + 3) {
                border-bottom: none;
            }
            .stat-cell:nth-child(-n + 2) {
                border-bottom: 1px solid var(--border);
            }
        }
        .stat-lbl {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 10px;
        }
        .stat-val {
            font-family: 'Libre Baskerville', serif;
            font-size: 2.6rem;
            font-weight: 700;
            line-height: 1;
        }
        @media (max-width: 640px) {
            .stat-val {
                font-size: 2rem;
            }
        }
        .stat-cell .accent-line {
            position: absolute;
            bottom: 0;
            left: 22px;
            height: 2px;
            width: 0;
            border-radius: 2px;
            transition: width 0.3s ease;
        }
        .stat-cell:hover .accent-line {
            width: 36px;
        }
        .sv-teal {
            color: var(--teal);
        }
        .sv-gold {
            color: var(--gold-dk);
        }
        .sv-emerald {
            color: var(--teal-dk);
        }
        .sv-amber {
            color: #a07830;
        }
        .al-teal {
            background: var(--teal);
        }
        .al-gold {
            background: var(--gold);
        }
        .al-emerald {
            background: var(--teal-dk);
        }
        .al-amber {
            background: #a07830;
        }

        /* Search */
        .search-wrap {
            position: relative;
        }
        .search-wrap svg {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--ink-soft);
            pointer-events: none;
            width: 18px;
            height: 18px;
        }
        .search-inp {
            width: 100%;
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 13px 18px 13px 48px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.95rem;
            color: var(--ink);
            outline: none;
            transition:
                border-color 0.15s,
                box-shadow 0.15s;
            box-shadow: 0 1px 4px rgba(26, 18, 9, 0.05);
        }
        .search-inp:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(45, 129, 118, 0.12);
        }
        .search-inp::placeholder {
            color: #b5a595;
        }

        /* Table wrapper */
        .ms-table-wrap {
            background: #fff;
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(26, 18, 9, 0.07);
        }
        .ms-table-head {
            padding: 16px 28px 14px;
            background: var(--parchment);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        @media (max-width: 640px) {
            .ms-table-head {
                padding: 14px 16px 12px;
            }
        }
        .ms-table-head-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--ink);
        }
        .ms-table-head-count {
            font-size: 0.76rem;
            font-weight: 600;
            color: var(--ink-soft);
            background: var(--cream);
            border: 1px solid var(--border);
            padding: 4px 12px;
            border-radius: 20px;
        }

        /* Desktop table */
        table.mst {
            width: 100%;
            border-collapse: collapse;
        }
        table.mst thead tr {
            background: var(--parchment);
            border-bottom: 1.5px solid var(--border-dk);
        }
        table.mst th {
            padding: 12px 24px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            text-align: left;
        }
        table.mst th:last-child {
            text-align: right;
        }
        table.mst td {
            padding: 18px 24px;
            font-size: 0.92rem;
            border-bottom: 1px solid #f5f0e8;
            vertical-align: top;
        }
        table.mst tbody tr:last-child td {
            border-bottom: none;
        }
        table.mst tbody tr {
            transition: background 0.1s;
        }
        table.mst tbody tr:hover td {
            background: var(--teal-lt);
        }
        table.mst tbody tr:hover .ms-row-title {
            color: var(--teal);
        }

        /* Hide less-important columns on tablet */
        @media (max-width: 900px) {
            .col-updated {
                display: none;
            }
            table.mst th,
            table.mst td {
                padding: 14px 16px;
            }
        }
        /* On narrow mobile: hide the table, show cards */
        .ms-table-desktop {
            display: block;
        }
        .ms-card-list {
            display: none;
            padding: 8px;
        }
        @media (max-width: 600px) {
            .ms-table-desktop {
                display: none;
            }
            .ms-card-list {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }
        }

        /* Mobile cards */
        .ms-card {
            background: var(--parchment);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 14px 16px;
        }
        .ms-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 6px;
        }
        .ms-card-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
        }

        .ms-ref {
            font-size: 0.76rem;
            font-weight: 700;
            color: var(--teal);
            letter-spacing: 0.06em;
            background: rgba(45, 129, 118, 0.07);
            border: 1px solid rgba(45, 129, 118, 0.22);
            padding: 3px 10px;
            border-radius: 4px;
            display: inline-block;
        }
        .ms-row-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.05rem;
            font-weight: 400;
            font-style: italic;
            color: var(--ink);
            line-height: 1.4;
            margin-top: 5px;
            transition: color 0.12s;
        }
        .ms-author {
            font-size: 0.8rem;
            color: var(--ink-soft);
            margin-top: 3px;
        }

        /* Badges */
        .sbadge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            border: 1px solid;
            white-space: nowrap;
        }
        .sbadge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .sbadge.pending-me {
            background: #fdf8ec;
            border-color: rgba(201, 168, 76, 0.4);
            color: var(--gold-dk);
        }
        .sbadge.pending-me .dot {
            background: var(--gold);
        }
        .sbadge.ctf-sent {
            background: var(--teal-lt);
            border-color: rgba(45, 129, 118, 0.35);
            color: var(--teal-dk);
        }
        .sbadge.ctf-sent .dot {
            background: var(--teal);
        }
        .sbadge.forwarded {
            background: #f0fdf4;
            border-color: #86efac;
            color: var(--teal-dk);
        }
        .sbadge.forwarded .dot {
            background: var(--teal-dk);
        }
        .sbadge.published {
            background: #f0fdf4;
            border-color: #22c55e;
            color: #16a34a;
        }
        .sbadge.published .dot {
            background: #22c55e;
        }
        .sbadge.archived {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #475569;
        }
        .sbadge.archived .dot {
            background: #64748b;
        }

        /* Action buttons */
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 7px 14px;
            border-radius: 6px;
            text-decoration: none;
            border: 1.5px solid;
            transition: all 0.15s;
            white-space: nowrap;
            cursor: pointer;
            background: none;
            font-family: 'Source Sans 3', sans-serif;
        }
        .btn-action.teal {
            color: var(--teal);
            border-color: rgba(45, 129, 118, 0.35);
        }
        .btn-action.teal:hover {
            background: var(--teal);
            color: #fff;
            box-shadow: 0 4px 12px rgba(45, 129, 118, 0.25);
        }
        .btn-action.gold {
            color: var(--gold-dk);
            border-color: rgba(201, 168, 76, 0.4);
        }
        .btn-action.gold:hover {
            background: var(--gold);
            color: #fff;
            box-shadow: 0 4px 12px rgba(201, 168, 76, 0.25);
        }

        /* Alert */
        .alert-strip {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid;
            display: flex;
            align-items: stretch;
        }
        .alert-strip-accent {
            width: 5px;
            flex-shrink: 0;
        }
        .alert-strip-body {
            flex: 1;
            padding: 16px 20px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        @media (max-width: 540px) {
            .alert-strip-body {
                padding: 12px 14px;
            }
        }
        .alert-tag {
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .alert-desc {
            font-size: 0.9rem;
            font-weight: 400;
        }
        .ms-date {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--ink-soft);
            letter-spacing: 0.04em;
            white-space: nowrap;
        }

        /* Empty state */
        .empty-state {
            padding: 80px 24px;
            text-align: center;
        }
        .empty-state-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--parchment);
            border: 1.5px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }
        .empty-state-label {
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #c9b99a;
        }

        /* Modal base */
        .modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(26, 18, 9, 0.45);
            backdrop-filter: blur(3px);
            z-index: 9998;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .modal-backdrop.open {
            display: flex;
        }
        .modal-box {
            background: #fff;
            border: 1px solid var(--border-dk);
            border-radius: 18px;
            box-shadow: 0 24px 60px rgba(26, 18, 9, 0.22);
            width: 100%;
            max-width: 480px;
            margin: 0;
            overflow: hidden;
            animation: modalIn 0.25s ease both;
            max-height: 90vh;
            overflow-y: auto;
        }
        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.97);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        .modal-head {
            background: var(--parchment);
            border-bottom: 1px solid var(--border);
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        @media (max-width: 480px) {
            .modal-head {
                padding: 16px 18px;
            }
        }
        .modal-head-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--ink);
        }
        @media (max-width: 480px) {
            .modal-head-title {
                font-size: 1rem;
            }
        }
        .modal-close {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ink-soft);
            transition: all 0.15s;
            flex-shrink: 0;
        }
        .modal-close:hover {
            background: var(--cream);
            color: var(--ink);
        }
        .modal-body {
            padding: 24px;
        }
        @media (max-width: 480px) {
            .modal-body {
                padding: 16px 18px;
            }
        }
        .modal-manuscript-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 0.95rem;
            font-style: italic;
            color: var(--ink-mid);
            background: var(--cream);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        .modal-label {
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 8px;
            display: block;
        }
        .modal-select {
            width: 100%;
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 12px 16px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.92rem;
            color: var(--ink);
            outline: none;
            transition:
                border-color 0.15s,
                box-shadow 0.15s;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%236b5740' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 40px;
        }
        .modal-select:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(45, 129, 118, 0.12);
        }
        .modal-footer {
            padding: 16px 24px 20px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            border-top: 1px solid var(--border);
            flex-wrap: wrap;
        }
        @media (max-width: 480px) {
            .modal-footer {
                padding: 14px 18px 16px;
                flex-direction: column-reverse;
            }
            .modal-footer button {
                width: 100%;
                justify-content: center;
            }
        }
        .btn-modal-cancel {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 10px 20px;
            border-radius: 8px;
            border: 1.5px solid var(--border-dk);
            background: #fff;
            color: var(--ink-soft);
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-modal-cancel:hover {
            background: var(--parchment);
        }
        .btn-modal-submit {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 10px 24px;
            border-radius: 8px;
            border: none;
            background: var(--teal);
            color: #fff;
            cursor: pointer;
            transition: all 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-modal-submit:hover {
            background: var(--teal-dk);
            box-shadow: 0 4px 14px rgba(45, 129, 118, 0.3);
        }
        .btn-modal-submit.gold-btn {
            background: var(--gold);
        }
        .btn-modal-submit.gold-btn:hover {
            background: var(--gold-dk);
            box-shadow: 0 4px 14px rgba(201, 168, 76, 0.3);
        }

        /* Upload zone */
        .upload-zone {
            border: 2px dashed var(--border-dk);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition:
                border-color 0.15s,
                background 0.15s;
            background: var(--cream);
            position: relative;
        }
        .upload-zone:hover,
        .upload-zone.dragover {
            border-color: var(--gold);
            background: #fffdf5;
        }
        .upload-zone input[type='file'] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }
        .upload-zone-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: #fdf8ec;
            border: 1px solid rgba(201, 168, 76, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            color: var(--gold-dk);
        }
        .upload-zone-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--ink-mid);
        }
        .upload-zone-sub {
            font-size: 0.73rem;
            color: var(--ink-soft);
            margin-top: 3px;
        }
        .upload-selected {
            display: none;
            margin-top: 10px;
            background: #fff;
            border: 1px solid rgba(201, 168, 76, 0.3);
            border-radius: 8px;
            padding: 8px 12px;
        }
        .upload-selected.show {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .upload-selected-name {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--ink);
            flex: 1;
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .upload-selected-size {
            font-size: 0.72rem;
            color: var(--ink-soft);
            flex-shrink: 0;
        }

        /* Animations */
        .fu {
            animation: fu 0.45s ease both;
        }
        .fu1 {
            animation: fu 0.45s 0.08s ease both;
        }
        .fu2 {
            animation: fu 0.45s 0.16s ease both;
        }
        .fu3 {
            animation: fu 0.45s 0.24s ease both;
        }
        .fu4 {
            animation: fu 0.45s 0.32s ease both;
        }
        @keyframes fu {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    <div class="aw aw-bg max-w-7xl mx-auto px-4 sm:px-6">
        {{-- Hero Header --}}
        <div class="hero-header fu">
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div>
                    <p class="hero-eyebrow">Managing Editor Dashboard</p>
                    <h1 class="hero-title">
                        Manuscript
                        <em>Processing</em>
                    </h1>
                    <p class="hero-sub">
                        Manage accepted manuscripts, upload copyright transfer
                        forms, and forward to layout
                    </p>
                </div>
                <span class="date-pill hidden sm:inline-block">
                    {{ now()->format('D, M j Y') }}
                </span>
            </div>
        </div>

        {{-- ── CTF Template Management ── --}}
        @php
            $ctfTemplate = \App\Models\CtfTemplate::latest()->first();
        @endphp

        <div class="fu1 mb-8">
            <div
                style="
                    background: #fff;
                    border: 1px solid var(--border-dk);
                    border-radius: 14px;
                    overflow: hidden;
                    box-shadow: 0 2px 12px rgba(26, 18, 9, 0.07);
                "
            >
                <div
                    style="
                        padding: 16px 24px 14px;
                        background: var(--parchment);
                        border-bottom: 1px solid var(--border);
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        flex-wrap: wrap;
                        gap: 10px;
                    "
                >
                    <div>
                        <p
                            style="
                                font-size: 10px;
                                font-weight: 700;
                                letter-spacing: 0.18em;
                                text-transform: uppercase;
                                color: var(--teal);
                                margin-bottom: 3px;
                            "
                        >
                            System-wide
                        </p>
                        <p
                            style="
                                font-family: 'Libre Baskerville', serif;
                                font-size: 1.05rem;
                                font-weight: 700;
                                color: var(--ink);
                            "
                        >
                            Copyright Transfer Form Template
                        </p>
                    </div>
                    @if ($ctfTemplate)
                        <span
                            style="display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:20px;font-size:.7rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;border:1px solid;
                    {{
                        $ctfTemplate->is_released
                            ? 'background:#f0fdf4;border-color:#86efac;color:var(--teal-dk)'
                            : 'background:#fef2f2;border-color:#fecaca;color:#991b1b'
                    }}"
                        >
                            <span
                                style="
                                    width: 6px;
                                    height: 6px;
                                    border-radius: 50%;
                                    background: {{ $ctfTemplate->is_released ? 'var(--teal)' : '#c0392b' }};
                                    flex-shrink: 0;
                                "
                            ></span>
                            {{ $ctfTemplate->is_released ? 'Released to Authors' : 'Not Released' }}
                        </span>
                    @endif
                </div>

                <div
                    style="
                        padding: 20px 24px;
                        display: flex;
                        align-items: center;
                        gap: 16px;
                        flex-wrap: wrap;
                    "
                >
                    @if ($ctfTemplate)
                        {{-- Current template info --}}
                        <div
                            style="
                                flex: 1;
                                min-width: 200px;
                                display: flex;
                                align-items: center;
                                gap: 12px;
                            "
                        >
                            <div
                                style="
                                    width: 40px;
                                    height: 40px;
                                    border-radius: 8px;
                                    background: var(--teal-lt);
                                    color: var(--teal);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                "
                            >
                                <svg
                                    width="18"
                                    height="18"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p
                                    style="
                                        font-size: 0.85rem;
                                        font-weight: 600;
                                        color: var(--ink);
                                    "
                                >
                                    {{ $ctfTemplate->file_name }}
                                </p>
                                <p
                                    style="
                                        font-size: 0.72rem;
                                        color: var(--ink-soft);
                                        margin-top: 2px;
                                    "
                                >
                                    Uploaded
                                    {{ $ctfTemplate->created_at->format('d M Y') }}
                                    @if ($ctfTemplate->is_released && $ctfTemplate->released_at)
                                        · Released
                                        {{ $ctfTemplate->released_at->format('d M Y') }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        {{-- Release button — one-way only, hidden once released --}}
                        @if (! $ctfTemplate->is_released)
                            <form
                                method="POST"
                                action="{{ route('managing-editor.ctf-template.toggle-release') }}"
                            >
                                @csrf
                                <button
                                    type="submit"
                                    class="btn-action gold"
                                    onclick="
                                        return confirm(
                                            'Release CTF template to all authors with ctf_sent status?',
                                        );
                                    "
                                >
                                    <svg
                                        width="12"
                                        height="12"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                    Release to Authors
                                </button>
                            </form>
                        @endif
                    @else
                        <p
                            style="
                                font-size: 0.88rem;
                                color: var(--ink-soft);
                                flex: 1;
                            "
                        >
                            No CTF template uploaded yet. Upload one below.
                        </p>
                    @endif

                    {{-- Upload / Replace button --}}
                    <button
                        type="button"
                        class="btn-action gold"
                        onclick="
                            document
                                .getElementById('ctfTemplateModal')
                                .classList.add('open')
                        "
                    >
                        <svg
                            width="12"
                            height="12"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                            />
                        </svg>
                        {{ $ctfTemplate ? 'Replace Template' : 'Upload Template' }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="stat-grid fu1 mb-10">
            @foreach ([
                    ['Awaiting CTF', $stats['pending'], 'sv-gold', 'al-gold'],
                    ['CTF Uploaded', $stats['ctf_sent'], 'sv-teal', 'al-teal'],
                    ['Sent to Layout', $stats['forwarded'], 'sv-emerald', 'al-emerald'],
                    ['Total Handled', $stats['total'], 'sv-amber', 'al-amber']
                ]
                as [$lbl, $val, $vc, $ac])
                <div class="stat-cell">
                    <p class="stat-lbl">{{ $lbl }}</p>
                    <p class="stat-val {{ $vc }}">
                        {{ sprintf('%02d', $val) }}
                    </p>
                    <div class="accent-line {{ $ac }}"></div>
                </div>
            @endforeach
        </div>

        {{-- Alert --}}
        @if ($stats['pending'] > 0)
            <div class="fu2 mb-4">
                <div
                    class="alert-strip"
                    style="
                        border-color: rgba(201, 168, 76, 0.4);
                        background: #fffdf9;
                    "
                >
                    <div
                        class="alert-strip-accent"
                        style="background: var(--gold)"
                    ></div>
                    <div class="alert-strip-body">
                        <div class="flex items-center gap-3">
                            <div
                                style="
                                    width: 38px;
                                    height: 38px;
                                    border-radius: 8px;
                                    background: #fdf8ec;
                                    color: var(--gold-dk);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                "
                            >
                                <svg
                                    class="w-5 h-5"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p
                                    class="alert-tag"
                                    style="color: var(--gold-dk)"
                                >
                                    Action Required
                                </p>
                                <p
                                    class="alert-desc"
                                    style="color: var(--ink-mid)"
                                >
                                    {{ $stats['pending'] }}
                                    manuscript{{ $stats['pending'] > 1 ? 's are' : ' is' }}
                                    awaiting copyright transfer form upload
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Author Feedback Section --}}
        @php
            $authorFeedbacks = \App\Models\LayoutEditorAssignment::with('submission')
                ->whereNotNull('author_status')
                ->whereIn('author_status', ['confirmed', 'revision_requested'])
                ->whereHas('submission', function ($query) {
                    $query
                        ->where('managing_editor_id', auth()->id())
                        ->where('status', '!=', \App\Models\Submission::STATUS_PUBLISHED);
                })
                ->latest('author_feedback_at')
                ->get();
        @endphp

        @if ($authorFeedbacks->count())
            <div class="mb-6">
                <h2
                    class="text-[.7rem] font-bold tracking-widest uppercase text-[#2d8176] mb-3"
                >
                    Author Responses
                </h2>
                @foreach ($authorFeedbacks as $fb)
                    <div
                        class="p-4 rounded-lg border mb-3 {{ $fb->author_status === 'revision_requested' ? 'border-[#c9a84c] bg-[#fdf8ee]' : 'border-[rgba(45,129,118,.3)] bg-[#e8f4f2]' }}"
                    >
                        <p class="text-[.75rem] font-bold text-[#1a4d46]">
                            {{ $fb->submission->title }}
                        </p>
                        <p class="text-[.7rem] mt-1">
                            @if ($fb->author_status === 'confirmed')
                                <span class="text-[#2d8176] font-semibold">
                                    ✓ Author confirmed layout.
                                </span>
                                <form
                                    method="POST"
                                    action="{{ route('managing-editor.publish', $fb->submission) }}"
                                    class="mt-2"
                                >
                                    @csrf
                                    <button
                                        class="px-4 py-2 bg-[#2d8176] text-white text-[.7rem] font-bold rounded-lg hover:bg-[#1a4d46] uppercase tracking-wider"
                                    >
                                        Publish Now
                                    </button>
                                </form>
                            @else
                                <span class="text-[#c9a84c] font-semibold">
                                    ⚠ Revision Requested:
                                </span>
                                <span class="text-[#444] block mt-1">
                                    {{ $fb->author_feedback }}
                                </span>
                                <button
                                    type="button"
                                    class="px-4 py-2 bg-[#c9a84c] text-white text-[.7rem] font-bold rounded-lg hover:bg-[#a8873a] uppercase tracking-wider mt-2"
                                    onclick="
                                        openReassignModal(
                                            {{ $fb->submission->id }},
                                            '{{ addslashes($fb->submission->title) }}',
                                            {{ $fb->id }},
                                            '{{ addslashes($fb->author_feedback) }}',
                                        )
                                    "
                                >
                                    Forward to Layout Editor
                                </button>
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Search --}}
        <div class="fu2 mb-6">
            <div class="search-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                        stroke-width="2.5"
                    />
                </svg>
                <input
                    type="text"
                    id="dashboardSearch"
                    class="search-inp"
                    placeholder="Filter by title, reference number, or status…"
                    onkeyup="filterTable()"
                />
            </div>
        </div>

        {{-- Table --}}
        <div class="ms-table-wrap fu3">
            <div class="ms-table-head">
                <span class="ms-table-head-title">Current Assignment</span>
                <span class="ms-table-head-count">
                    {{ $submissions->count() }}
                    record{{ $submissions->count() !== 1 ? 's' : '' }}
                </span>
            </div>
            <div class="overflow-x-auto">
                {{-- Desktop table --}}
                <div class="ms-table-desktop">
                    <table class="mst" id="submissionsTable">
                        <thead>
                            <tr>
                                <th style="width: 110px">Ref No.</th>
                                <th>Manuscript Title &amp; Author</th>
                                <th style="width: 170px">Status</th>
                                <th style="width: 240px">Actions</th>
                                <th
                                    class="col-updated"
                                    style="width: 120px; text-align: right"
                                >
                                    Updated
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($submissions as $s)
                                @php
                                    $meStatus = $s->managing_editor_status ?? 'pending';
                                    [$cls, $label] = match ($meStatus) {
                                        'ctf_sent' => ['ctf-sent', 'Awaiting Signed CTF'],
                                        'ctf_returned' => ['forwarded', 'Signed CTF Received'],
                                        'forwarded' => ['forwarded', 'Sent to Layout'],
                                        'published' => ['published', 'Published'],
                                        'archived' => ['archived', 'Archived'],
                                        default => ['pending-me', 'Awaiting CTF'],
                                    };
                                @endphp

                                <tr class="submission-row">
                                    <td>
                                        <span class="ms-ref">
                                            #{{ str_pad($s->id, 5, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td>
                                        <p class="ms-row-title title-cell">
                                            {{ $s->title }}
                                        </p>
                                        <p class="ms-author">
                                            by
                                            {{ $s->author->name ?? 'Unknown Author' }}
                                        </p>
                                    </td>
                                    <td>
                                        <span
                                            class="sbadge {{ $cls }} status-cell"
                                        >
                                            <span class="dot"></span>
                                            {{ $label }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex flex-col gap-2">
                                            <a
                                                href="{{ route('managing-editor.submission.show', $s) }}"
                                                class="btn-action teal"
                                            >
                                                <svg
                                                    width="12"
                                                    height="12"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"
                                                    />
                                                    <circle
                                                        cx="12"
                                                        cy="12"
                                                        r="3"
                                                    />
                                                </svg>
                                                View Manuscript Details
                                            </a>
                                            @if ($meStatus === 'pending')
                                                <button
                                                    type="button"
                                                    class="btn-action gold"
                                                    onclick="
                                                        openCtfModal(
                                                            {{ $s->id }},
                                                            '{{ addslashes($s->title) }}',
                                                        )
                                                    "
                                                >
                                                    <svg
                                                        width="12"
                                                        height="12"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                                                        />
                                                    </svg>
                                                    Upload CTF
                                                </button>
                                            @endif

                                            @if ($meStatus === 'ctf_returned')
                                                <a
                                                    href="{{ route('managing-editor.download-signed-ctf', $s) }}"
                                                    class="btn-action teal"
                                                >
                                                    <svg
                                                        width="12"
                                                        height="12"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                                        />
                                                    </svg>
                                                    Download Signed CTF
                                                </a>
                                                <button
                                                    type="button"
                                                    class="btn-action gold"
                                                    onclick="
                                                        openLayoutModal(
                                                            {{ $s->id }},
                                                            '{{ addslashes($s->title) }}',
                                                        )
                                                    "
                                                >
                                                    <svg
                                                        width="12"
                                                        height="12"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M13 5l7 7-7 7M5 5l7 7-7 7"
                                                        />
                                                    </svg>
                                                    Send to Layout
                                                </button>
                                            @endif

                                            @if ($meStatus === 'forwarded')
                                                <span
                                                    style="
                                                        font-size: 0.72rem;
                                                        font-weight: 700;
                                                        color: var(--teal-dk);
                                                        letter-spacing: 0.04em;
                                                    "
                                                >
                                                    ✓ Forwarded
                                                </span>
                                            @endif

                                            @if ($meStatus === 'published' && $s->status === \App\Models\Submission::STATUS_PUBLISHED)
                                                <form
                                                    method="POST"
                                                    action="{{ route('managing-editor.archive', $s) }}"
                                                >
                                                    @csrf
                                                    <button
                                                        type="submit"
                                                        class="btn-action gold"
                                                    >
                                                        <svg
                                                            width="12"
                                                            height="12"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="2"
                                                            viewBox="0 0 24 24"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M20 7l-8 4-8-4m16 0l-8-4-8 4m16 0v10l-8 4m-8-14v10l8 4"
                                                            />
                                                        </svg>
                                                        Archive Paper
                                                    </button>
                                                </form>
                                            @endif

                                            @if ($meStatus === 'archived' && $s->status === \App\Models\Submission::STATUS_ARCHIVED)
                                                <form
                                                    method="POST"
                                                    action="{{ route('managing-editor.unarchive', $s) }}"
                                                >
                                                    @csrf
                                                    <button
                                                        type="submit"
                                                        class="btn-action teal"
                                                    >
                                                        <svg
                                                            width="12"
                                                            height="12"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="2"
                                                            viewBox="0 0 24 24"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M4 17l6-6-6-6m8 12h8"
                                                            />
                                                        </svg>
                                                        Unarchive Paper
                                                    </button>
                                                </form>
                                            @endif

                                            @if ($s->status === \App\Models\Submission::STATUS_LAYOUT_REVIEW)
                                                <a
                                                    href="{{ route('managing-editor.layout.show', $s) }}"
                                                    class="btn-action teal"
                                                >
                                                    <svg
                                                        width="12"
                                                        height="12"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        viewBox="0 0 24 24"
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
                                                    Review Layout
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td
                                        class="col-updated"
                                        style="text-align: right"
                                    >
                                        <span class="ms-date">
                                            {{ $s->updated_at->format('d M Y') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">
                                                <svg
                                                    class="w-8 h-8"
                                                    fill="none"
                                                    stroke="#c9b99a"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                    />
                                                </svg>
                                            </div>
                                            <p class="empty-state-label">
                                                No manuscripts assigned yet
                                            </p>
                                            <p
                                                style="
                                                    font-size: 0.88rem;
                                                    color: #b5a595;
                                                    margin-top: 6px;
                                                "
                                            >
                                                Manuscripts accepted by editors
                                                will appear here
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile card list --}}
                <div class="ms-card-list">
                    @forelse ($submissions as $s)
                        @php
                            $meStatus = $s->managing_editor_status ?? 'pending';
                            [$cls, $label] = match ($meStatus) {
                                'ctf_sent' => ['ctf-sent', 'Awaiting Signed CTF'],
                                'ctf_returned' => ['forwarded', 'Signed CTF Received'],
                                'forwarded' => ['forwarded', 'Sent to Layout'],
                                'published' => ['published', 'Published'],
                                'archived' => ['archived', 'Archived'],
                                default => ['pending-me', 'Awaiting CTF'],
                            };
                        @endphp

                        <div class="ms-card submission-row">
                            <div class="ms-card-top">
                                <span class="ms-ref">
                                    #{{ str_pad($s->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                                <span class="sbadge {{ $cls }} status-cell">
                                    <span class="dot"></span>
                                    {{ $label }}
                                </span>
                            </div>
                            <p class="ms-row-title title-cell">
                                {{ $s->title }}
                            </p>
                            <p class="ms-author">
                                by {{ $s->author->name ?? 'Unknown Author' }}
                            </p>
                            <div class="ms-card-actions">
                                <a
                                    href="{{ route('managing-editor.submission.show', $s) }}"
                                    class="btn-action teal"
                                >
                                    <svg
                                        width="12"
                                        height="12"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"
                                        />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    View
                                </a>
                                @if ($meStatus === 'pending')
                                    <button
                                        type="button"
                                        class="btn-action gold"
                                        onclick="
                                            openCtfModal(
                                                {{ $s->id }},
                                                '{{ addslashes($s->title) }}',
                                            )
                                        "
                                    >
                                        <svg
                                            width="12"
                                            height="12"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                                            />
                                        </svg>
                                        Upload CTF
                                    </button>
                                @endif

                                @if ($meStatus === 'ctf_returned')
                                    <a
                                        href="{{ route('managing-editor.download-signed-ctf', $s) }}"
                                        class="btn-action teal"
                                    >
                                        <svg
                                            width="12"
                                            height="12"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                            />
                                        </svg>
                                        Download Signed CTF
                                    </a>
                                    <button
                                        type="button"
                                        class="btn-action gold"
                                        onclick="
                                            openLayoutModal(
                                                {{ $s->id }},
                                                '{{ addslashes($s->title) }}',
                                            )
                                        "
                                    >
                                        <svg
                                            width="12"
                                            height="12"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M13 5l7 7-7 7M5 5l7 7-7 7"
                                            />
                                        </svg>
                                        Send to Layout
                                    </button>
                                @endif

                                @if ($meStatus === 'forwarded')
                                    <span
                                        style="
                                            font-size: 0.72rem;
                                            font-weight: 700;
                                            color: var(--teal-dk);
                                            letter-spacing: 0.04em;
                                        "
                                    >
                                        ✓ Forwarded
                                    </span>
                                @endif

                                @if ($meStatus === 'published' && $s->status === \App\Models\Submission::STATUS_PUBLISHED)
                                    <form
                                        method="POST"
                                        action="{{ route('managing-editor.archive', $s) }}"
                                    >
                                        @csrf
                                        <button type="submit" class="btn-action gold">
                                            <svg
                                                width="12"
                                                height="12"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M20 7l-8 4-8-4m16 0l-8-4-8 4m16 0v10l-8 4m-8-14v10l8 4"
                                                />
                                            </svg>
                                            Archive
                                        </button>
                                    </form>
                                @endif

                                @if ($meStatus === 'archived' && $s->status === \App\Models\Submission::STATUS_ARCHIVED)
                                    <form
                                        method="POST"
                                        action="{{ route('managing-editor.unarchive', $s) }}"
                                    >
                                        @csrf
                                        <button type="submit" class="btn-action teal">
                                            <svg
                                                width="12"
                                                height="12"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M4 17l6-6-6-6m8 12h8"
                                                />
                                            </svg>
                                            Unarchive
                                        </button>
                                    </form>
                                @endif

                                @if ($s->status === \App\Models\Submission::STATUS_LAYOUT_REVIEW)
                                    <a
                                        href="{{ route('managing-editor.layout.show', $s) }}"
                                        class="btn-action teal"
                                    >
                                        <svg
                                            width="12"
                                            height="12"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            viewBox="0 0 24 24"
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
                                        Review Layout
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <svg
                                    class="w-8 h-8"
                                    fill="none"
                                    stroke="#c9b99a"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                    />
                                </svg>
                            </div>
                            <p class="empty-state-label">
                                No manuscripts assigned yet
                            </p>
                            <p
                                style="
                                    font-size: 0.88rem;
                                    color: #b5a595;
                                    margin-top: 6px;
                                "
                            >
                                Manuscripts accepted by editors will appear here
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        @if (method_exists($submissions, 'hasPages') && $submissions->hasPages())
            <div class="fu4 mt-5">{{ $submissions->links() }}</div>
        @endif
    </div>

    {{-- CTF Confirm Modal --}}
    <div
        class="modal-backdrop"
        id="ctfModal"
        onclick="closeOnBackdrop(event, 'ctfModal')"
    >
        <div class="modal-box">
            <div class="modal-head">
                <span class="modal-head-title">
                    Send Copyright Transfer Form
                </span>
                <button class="modal-close" onclick="closeCtfModal()">
                    <svg
                        width="14"
                        height="14"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
            <form method="POST" id="ctfModalForm" action="">
                @csrf
                <div class="modal-body">
                    <p class="modal-manuscript-title" id="ctfManuscriptTitle">
                        —
                    </p>

                    @php
                        $ctfTpl = \App\Models\CtfTemplate::latest()->first();
                    @endphp

                    @if ($ctfTpl)
                        <div
                            style="
                                display: flex;
                                align-items: center;
                                gap: 12px;
                                background: var(--teal-lt);
                                border: 1px solid rgba(45, 129, 118, 0.25);
                                border-radius: 8px;
                                padding: 12px 14px;
                                margin-bottom: 16px;
                            "
                        >
                            <div
                                style="
                                    width: 36px;
                                    height: 36px;
                                    border-radius: 7px;
                                    background: #fff;
                                    color: var(--teal);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                "
                            >
                                <svg
                                    width="17"
                                    height="17"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p
                                    style="
                                        font-size: 0.72rem;
                                        font-weight: 700;
                                        letter-spacing: 0.07em;
                                        text-transform: uppercase;
                                        color: var(--teal-dk);
                                        margin-bottom: 2px;
                                    "
                                >
                                    Global CTF Template
                                </p>
                                <p
                                    style="
                                        font-size: 0.85rem;
                                        font-weight: 600;
                                        color: var(--ink);
                                    "
                                >
                                    {{ $ctfTpl->file_name }}
                                </p>
                                <p
                                    style="
                                        font-size: 0.72rem;
                                        color: var(--ink-soft);
                                        margin-top: 1px;
                                    "
                                >
                                    {{ $ctfTpl->is_released ? '✓ Currently released to authors' : '⚠ Not yet released — author will be notified once you release it' }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div
                            style="
                                background: #fef2f2;
                                border: 1px solid #fecaca;
                                border-radius: 8px;
                                padding: 12px 14px;
                                margin-bottom: 16px;
                                font-size: 0.84rem;
                                color: #991b1b;
                            "
                        >
                            ⚠ No global CTF template uploaded yet. Please upload
                            one first from the CTF Template section above.
                        </div>
                    @endif

                    <p
                        style="
                            font-size: 0.84rem;
                            color: var(--ink-soft);
                            line-height: 1.65;
                        "
                    >
                        This will mark the manuscript as
                        <strong style="color: var(--ink)">
                            Awaiting Signed CTF
                        </strong>
                        .
                        @if ($ctfTpl?->is_released)
                            The author will be notified immediately and can download the CTF template from their dashboard.
                        @else
                                The author will be notified once you release the
                                CTF template from the section above.
                        @endif
                    </p>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn-modal-cancel"
                        onclick="closeCtfModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="btn-modal-submit gold-btn"
                        {{ ! $ctfTpl ? 'disabled style=opacity:.5;cursor:not-allowed' : '' }}
                    >
                        <svg
                            width="14"
                            height="14"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                        Confirm &amp; Notify Author
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Assign Layout Editor Modal --}}
    <div
        class="modal-backdrop"
        id="layoutModal"
        onclick="closeOnBackdrop(event, 'layoutModal')"
    >
        <div class="modal-box">
            <div class="modal-head">
                <span class="modal-head-title">Assign Layout Editor</span>
                <button class="modal-close" onclick="closeLayoutModal()">
                    <svg
                        width="14"
                        height="14"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
            <form method="POST" id="layoutModalForm" action="">
                @csrf
                <div class="modal-body">
                    <p class="modal-manuscript-title" id="modalManuscriptTitle">
                        —
                    </p>
                    <label class="modal-label" for="layout_editor_id">
                        Select Layout Editor
                    </label>
                    <select
                        name="layout_editor_id"
                        id="layout_editor_id"
                        class="modal-select"
                        required
                    >
                        <option value="">— Choose a Layout Editor —</option>
                        @foreach ($layoutEditors as $le)
                            <option value="{{ $le->id }}">
                                {{ $le->name }} — {{ $le->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('layout_editor_id')
                        <p
                            style="
                                font-size: 0.78rem;
                                color: #dc2626;
                                margin-top: 6px;
                            "
                        >
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn-modal-cancel"
                        onclick="closeLayoutModal()"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="btn-modal-submit">
                        <svg
                            width="14"
                            height="14"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13 5l7 7-7 7M5 5l7 7-7 7"
                            />
                        </svg>
                        Forward to Layout
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Reassign Layout Modal --}}
    <div
        class="modal-backdrop"
        id="reassignModal"
        onclick="closeOnBackdrop(event, 'reassignModal')"
    >
        <div class="modal-box">
            <div class="modal-head">
                <span class="modal-head-title">
                    Forward Revision to Layout Editor
                </span>
                <button class="modal-close" onclick="closeReassignModal()">
                    <svg
                        width="14"
                        height="14"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
            <form method="POST" id="reassignModalForm" action="">
                @csrf
                <input
                    type="hidden"
                    name="assignment_id"
                    id="reassignAssignmentId"
                />
                <div class="modal-body">
                    <p
                        class="modal-manuscript-title"
                        id="reassignManuscriptTitle"
                    >
                        —
                    </p>
                    <div
                        class="mb-4 p-3 rounded-lg border border-[rgba(201,168,76,.4)] bg-[#fffdf9]"
                    >
                        <p class="modal-label" style="color: var(--gold-dk)">
                            ⚠ Author's Revision Note
                        </p>
                        <p
                            class="text-[.85rem] text-(--ink-mid) italic leading-relaxed"
                            id="reassignAuthorFeedback"
                        >
                            —
                        </p>
                    </div>
                    <label class="modal-label" for="reassign_layout_editor_id">
                        Select Layout Editor
                    </label>
                    <select
                        name="layout_editor_id"
                        id="reassign_layout_editor_id"
                        class="modal-select"
                        required
                    >
                        <option value="">— Choose a Layout Editor —</option>
                        @foreach ($layoutEditors as $le)
                            <option value="{{ $le->id }}">
                                {{ $le->name }} — {{ $le->email }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn-modal-cancel"
                        onclick="closeReassignModal()"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="btn-modal-submit gold-btn">
                        <svg
                            width="14"
                            height="14"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13 5l7 7-7 7M5 5l7 7-7 7"
                            />
                        </svg>
                        Forward with Author Note
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- CTF Template Upload Modal --}}
    <div
        class="modal-backdrop"
        id="ctfTemplateModal"
        onclick="if (event.target === this) this.classList.remove('open');"
    >
        <div class="modal-box">
            <div class="modal-head">
                <span class="modal-head-title">Upload CTF Template</span>
                <button
                    class="modal-close"
                    onclick="
                        document
                            .getElementById('ctfTemplateModal')
                            .classList.remove('open')
                    "
                >
                    <svg
                        width="14"
                        height="14"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
            <form
                method="POST"
                action="{{ route('managing-editor.ctf-template.upload') }}"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="modal-body">
                    <p
                        style="
                            font-size: 0.84rem;
                            color: var(--ink-soft);
                            margin-bottom: 16px;
                            line-height: 1.6;
                        "
                    >
                        This template will be used system-wide. Uploading a new
                        file will
                        <strong style="color: var(--ink)">
                            replace the existing one.
                        </strong>
                    </p>
                    <label class="modal-label">CTF Template File</label>
                    <div class="upload-zone">
                        <input
                            type="file"
                            name="ctf_template_file"
                            accept=".pdf,.doc,.docx"
                            required
                            onchange="onTemplateFileSelected(this)"
                        />
                        <div class="upload-zone-icon">
                            <svg
                                width="20"
                                height="20"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                                />
                            </svg>
                        </div>
                        <p class="upload-zone-label">Click or drag file here</p>
                        <p class="upload-zone-sub">
                            PDF, DOC, DOCX · Max 10 MB
                        </p>
                    </div>
                    <div class="upload-selected" id="templateFileSelected">
                        <svg
                            width="16"
                            height="16"
                            fill="none"
                            stroke="var(--gold-dk)"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            style="flex-shrink: 0"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            />
                        </svg>
                        <span
                            class="upload-selected-name"
                            id="templateFileName"
                        >
                            —
                        </span>
                        <span
                            class="upload-selected-size"
                            id="templateFileSize"
                        >
                            —
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn-modal-cancel"
                        onclick="
                            document
                                .getElementById('ctfTemplateModal')
                                .classList.remove('open')
                        "
                    >
                        Cancel
                    </button>
                    <button type="submit" class="btn-modal-submit gold-btn">
                        <svg
                            width="14"
                            height="14"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                            />
                        </svg>
                        Upload Template
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function filterTable() {
                            const f = document.getElementById('dashboardSearch').value.toUpperCase();
                            document.querySelectorAll('.submission-row').forEach(row => {
                                const title  = row.querySelector('.title-cell')?.innerText.toUpperCase() ?? '';
                                const ref    = row.cells?.[0]?.innerText.toUpperCase() ?? row.querySelector('.ms-ref')?.innerText.toUpperCase() ?? '';
                                const status = row.querySelector('.status-cell')?.innerText.toUpperCase() ?? '';
                                row.style.display = (title.includes(f) || ref.includes(f) || status.includes(f)) ? '' : 'none';
                            });
                        }

                  const ctfRoutes = @json(
            $submissions->filter(fn($s) => is_null($s->managing_editor_status) || $s->managing_editor_status === 'pending')
                ->mapWithKeys(fn($s) => [$s->id => route('managing-editor.ctf.generate', $s)])
        );

        function openCtfModal(id, title) {
            document.getElementById('ctfManuscriptTitle').textContent = title;
            document.getElementById('ctfModalForm').action = ctfRoutes[id] ?? '#';
            document.getElementById('ctfModal').classList.add('open');
        }
        function closeCtfModal() {
            document.getElementById('ctfModal').classList.remove('open');
        }



                        const layoutRoutes = @json(
                            $submissions->filter(fn($s) => $s->managing_editor_status === 'ctf_returned')
                                ->mapWithKeys(fn($s) => [$s->id => route('managing-editor.forward', $s)])
                        );

                        function openLayoutModal(id, title) {
                            const route = layoutRoutes[id];
                            if (!route) { alert('Route not found for id: ' + id); return; }
                            document.getElementById('modalManuscriptTitle').textContent = title;
                            document.getElementById('layoutModalForm').action = route;
                            document.getElementById('layout_editor_id').value = '';
                            document.getElementById('layoutModal').classList.add('open');
                        }
                        function closeLayoutModal() { document.getElementById('layoutModal').classList.remove('open'); }

                        function closeOnBackdrop(e, id) {
                            if (e.target === document.getElementById(id)) {
                                if (id === 'ctfModal') closeCtfModal();
                                else if (id === 'reassignModal') closeReassignModal();
                                else closeLayoutModal();
                            }
                        }

                        document.addEventListener('keydown', e => {
                            if (e.key === 'Escape') { closeCtfModal(); closeLayoutModal(); closeReassignModal(); }
                        });

                        function openReassignModal(submissionId, title, assignmentId, authorFeedback) {
                            document.getElementById('reassignManuscriptTitle').textContent = title;
                            document.getElementById('reassignAssignmentId').value = assignmentId;
                            document.getElementById('reassignAuthorFeedback').textContent = authorFeedback || '—';
                            document.getElementById('reassignModalForm').action = `/managing-editor/submissions/${submissionId}/reassign-layout`;
                            document.getElementById('reassign_layout_editor_id').value = '';
                            document.getElementById('reassignModal').classList.add('open');
                        }
                        function closeReassignModal() { document.getElementById('reassignModal').classList.remove('open'); }

                        @if(session('success'))
                        Swal.fire({
                            icon:'success',
                            title:'<span style="font-family:\'Libre Baskerville\',serif;font-size:1.3rem;font-weight:700;">Done</span>',
                            html:'<p style="font-size:.9rem;color:#6b5740;">{{ session('success') }}</p>',
                            confirmButtonText:'Close', confirmButtonColor:'#2d8176',
                            customClass:{popup:'rounded-2xl',confirmButton:'rounded-lg px-8 py-2.5 text-xs font-bold uppercase tracking-widest'},
                            buttonsStyling:false,
                        });
                        @endif
                        @if(session('error'))
                        Swal.fire({
                            icon:'error',
                            title:'<span style="font-family:\'Libre Baskerville\',serif;font-size:1.3rem;font-weight:700;">Oops!</span>',
                            html:'<p style="font-size:.9rem;color:#6b5740;">{{ session('error') }}</p>',
                            confirmButtonText:'Close', confirmButtonColor:'#c9a84c',
                            customClass:{popup:'rounded-2xl',confirmButton:'rounded-lg px-8 py-2.5 text-xs font-bold uppercase tracking-widest'},
                            buttonsStyling:false,
                        });
                        @endif
                        @if(session('info'))
                        Swal.fire({
                            icon:'info',
                            title:'<span style="font-family:\'Libre Baskerville\',serif;font-size:1.3rem;font-weight:700;">Note</span>',
                            html:'<p style="font-size:.9rem;color:#6b5740;">{{ session('info') }}</p>',
                            confirmButtonText:'Got it', confirmButtonColor:'#2d8176',
                            customClass:{popup:'rounded-2xl',confirmButton:'rounded-lg px-8 py-2.5 text-xs font-bold uppercase tracking-widest'},
                            buttonsStyling:false,
                        });
                        @endif
                        @if(session('warning'))
                        Swal.fire({
                            icon:'warning',
                            title:'<span style="font-family:\'Libre Baskerville\',serif;font-size:1.3rem;font-weight:700;">Warning</span>',
                            html:'<p style="font-size:.9rem;color:#6b5740;">{{ session('warning') }}</p>',
                            confirmButtonText:'Understood', confirmButtonColor:'#c9a84c',
                            customClass:{popup:'rounded-2xl',confirmButton:'rounded-lg px-8 py-2.5 text-xs font-bold uppercase tracking-widest'},
                            buttonsStyling:false,
                        });
                        @endif
                        function onTemplateFileSelected(input) {
                    const file = input.files[0];
                    if (!file) return;
                    document.getElementById('templateFileName').textContent = file.name;
                    document.getElementById('templateFileSize').textContent = (file.size/1024/1024).toFixed(2) + ' MB';
                    document.getElementById('templateFileSelected').classList.add('show');
                }
    </script>
@endpush
