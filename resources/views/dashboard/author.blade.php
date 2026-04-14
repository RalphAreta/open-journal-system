@extends('layouts.app')

@section('title', 'Author Dashboard')

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
                font-size: 1.9rem;
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
        .btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            background: var(--teal);
            color: #fff;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 12px 26px;
            border-radius: 6px;
            text-decoration: none;
            transition:
                background 0.15s,
                transform 0.12s,
                box-shadow 0.15s;
            box-shadow: 0 4px 14px rgba(45, 129, 118, 0.3);
            position: relative;
            overflow: hidden;
            white-space: nowrap;
        }
        @media (max-width: 400px) {
            .btn-submit {
                padding: 10px 18px;
                font-size: 0.75rem;
                width: 100%;
                justify-content: center;
            }
        }
        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(201, 168, 76, 0.18) 0%,
                transparent 60%
            );
        }
        .btn-submit:hover {
            background: var(--teal-dk);
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(45, 129, 118, 0.36);
        }

        /* ── Stats Grid ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            background: var(--parchment);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.07);
        }
        @media (max-width: 900px) {
            .stat-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        @media (max-width: 480px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
                border-radius: 10px;
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
        @media (max-width: 480px) {
            .stat-cell {
                padding: 16px 14px 14px;
            }
        }
        .stat-cell:hover {
            background: #fff;
        }
        /* Desktop: 7-col — last cell + 7th no right border, 4th+ no bottom border */
        .stat-cell:last-child,
        .stat-cell:nth-child(7) {
            border-right: none;
        }
        .stat-cell:nth-child(n + 5) {
            border-bottom: none;
        }
        /* Tablet: 3-col */
        @media (max-width: 900px) {
            .stat-cell:nth-child(7) {
                border-right: 1px solid var(--border); /* reset desktop override */
            }
            .stat-cell:nth-child(n + 5) {
                border-bottom: 1px solid var(--border); /* reset */
            }
            .stat-cell:nth-child(3n) {
                border-right: none;
            }
            .stat-cell:nth-child(n + 6) {
                border-bottom: none;
            }
            .stat-cell:nth-child(-n + 5) {
                border-bottom: 1px solid var(--border);
            }
        }
        /* Mobile: 2-col */
        @media (max-width: 480px) {
            .stat-cell:nth-child(3n) {
                border-right: 1px solid var(--border); /* reset tablet */
            }
            .stat-cell:nth-child(n + 6) {
                border-bottom: 1px solid var(--border); /* reset tablet */
            }
            .stat-cell:nth-child(-n + 5) {
                border-bottom: 1px solid var(--border);
            }
            .stat-cell:nth-child(2n) {
                border-right: none;
            }
            .stat-cell:nth-child(n + 7) {
                border-bottom: none;
            }
            /* 7th cell spans full width on mobile (odd one out) */
            .stat-cell:nth-child(7) {
                grid-column: 1 / -1;
                border-right: none;
                border-bottom: none;
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
        @media (max-width: 480px) {
            .stat-lbl {
                font-size: 0.6rem;
                letter-spacing: 0.06em;
                margin-bottom: 6px;
            }
        }
        .stat-val {
            font-family: 'Libre Baskerville', serif;
            font-size: 2.6rem;
            font-weight: 700;
            line-height: 1;
        }
        @media (max-width: 480px) {
            .stat-val {
                font-size: 1.9rem;
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
        .sv-orange {
            color: #c2410c;
        }
        .sv-amber {
            color: #a07830;
        }
        .sv-emerald {
            color: var(--teal-dk);
        }
        .sv-red {
            color: #c0392b;
        }
        .al-teal {
            background: var(--teal);
        }
        .al-gold {
            background: var(--gold);
        }
        .al-orange {
            background: #ea580c;
        }
        .al-amber {
            background: #a07830;
        }
        .al-emerald {
            background: var(--teal-dk);
        }
        .al-red {
            background: #c0392b;
        }

        /* ── Search ── */
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
        @media (max-width: 480px) {
            .search-inp {
                font-size: 16px; /* prevent iOS auto-zoom */
                padding: 11px 16px 11px 44px;
            }
        }

        /* ── Alert strip ── */
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
            min-width: 0;
        }
        @media (max-width: 480px) {
            .alert-strip-body {
                padding: 14px 14px;
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
        @media (max-width: 480px) {
            .alert-desc {
                font-size: 0.82rem;
            }
        }
        .btn-alert-action {
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 7px 16px;
            border-radius: 5px;
            text-decoration: none;
            border: 1.5px solid;
            transition: all 0.15s;
            white-space: nowrap;
        }

        /* CTF list */
        .ctf-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }
        .ctf-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            background: #fff;
            border: 1px solid rgba(201, 168, 76, 0.3);
            border-radius: 8px;
            padding: 10px 14px;
        }
        .ctf-item-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 0.9rem;
            font-style: italic;
            color: var(--ink-mid);
            flex: 1;
            min-width: 0;
            word-break: break-word;
        }
        .ctf-item-ref {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--gold-dk);
            background: rgba(201, 168, 76, 0.1);
            border: 1px solid rgba(201, 168, 76, 0.25);
            padding: 2px 8px;
            border-radius: 4px;
            white-space: nowrap;
        }
        .btn-ctf-download {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 7px 14px;
            border-radius: 6px;
            background: var(--gold);
            color: #fff;
            text-decoration: none;
            border: none;
            transition:
                background 0.15s,
                transform 0.1s;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .btn-ctf-download:hover {
            background: var(--gold-dk);
            transform: translateY(-1px);
        }
        @media (max-width: 480px) {
            .btn-ctf-download {
                width: 100%;
                justify-content: center;
                padding: 9px 14px;
            }
        }

        /* ── Manuscript table ── */
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
        @media (max-width: 480px) {
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
            cursor: pointer;
        }
        table.mst tbody tr:hover td {
            background: var(--teal-lt);
        }
        table.mst tbody tr:hover .ms-row-title {
            color: var(--teal);
        }

        /* Mobile table: hide Ref No., Status, and Updated columns */
        @media (max-width: 640px) {
            /* Hide Ref No. (col 1) */
            table.mst th:first-child,
            table.mst td:first-child {
                display: none;
            }
            /* Hide Status (col 3) — shown in ms-mobile-meta instead */
            table.mst th:nth-child(3),
            table.mst td:nth-child(3) {
                display: none;
            }
            /* Hide Updated (col 4) — shown in ms-mobile-meta instead */
            table.mst th:last-child,
            table.mst td:last-child {
                display: none;
            }
            table.mst th {
                padding: 10px 16px;
            }
            table.mst td {
                padding: 14px 16px;
            }
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
            word-break: break-word;
        }
        @media (max-width: 640px) {
            .ms-row-title {
                font-size: 0.95rem;
                margin-top: 0;
            }
            /* Show ref inline on mobile since we hid the ref column */
            .ms-ref-inline {
                display: inline-block;
                margin-bottom: 4px;
            }
        }
        /* Hide inline ref on desktop (the column handles it) */
        .ms-ref-inline {
            display: none;
        }
        @media (max-width: 640px) {
            .ms-ref-inline {
                display: inline-block;
            }
        }

        /* Status + date row on mobile */
        .ms-mobile-meta {
            display: none;
        }
        @media (max-width: 640px) {
            .ms-mobile-meta {
                display: flex;
                align-items: center;
                gap: 8px;
                flex-wrap: wrap;
                margin-top: 8px;
            }
            .ms-mobile-date {
                font-size: 0.72rem;
                font-weight: 600;
                color: var(--ink-soft);
            }
        }

        /* CTF badge on row */
        .ctf-row-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 6px;
            padding: 4px 10px;
            border-radius: 5px;
            background: #fdf8ec;
            border: 1px solid rgba(201, 168, 76, 0.35);
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--gold-dk);
            text-decoration: none;
            transition: background 0.12s;
        }
        .ctf-row-badge:hover {
            background: rgba(201, 168, 76, 0.15);
        }
        .ctf-row-badge svg {
            flex-shrink: 0;
        }

        /* ── Status badges ── */
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
        @media (max-width: 480px) {
            .sbadge {
                font-size: 0.62rem;
                padding: 4px 9px;
                letter-spacing: 0.04em;
            }
        }
        .sbadge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .sbadge.submitted {
            background: var(--teal-lt);
            border-color: rgba(45, 129, 118, 0.35);
            color: var(--teal-dk);
        }
        .sbadge.submitted .dot {
            background: var(--teal);
        }
        .sbadge.under_review {
            background: #fdf8ec;
            border-color: rgba(201, 168, 76, 0.4);
            color: var(--gold-dk);
        }
        .sbadge.under_review .dot {
            background: var(--gold);
        }
        .sbadge.revisions_requested {
            background: #fff7ed;
            border-color: #fed7aa;
            color: #9a3412;
        }
        .sbadge.revisions_requested .dot {
            background: #f97316;
        }
        .sbadge.revision_review {
            background: #fefce8;
            border-color: #fde68a;
            color: #78350f;
        }
        .sbadge.revision_review .dot {
            background: #f59e0b;
        }
        .sbadge.accepted {
            background: #f0fdf4;
            border-color: #86efac;
            color: var(--teal-dk);
        }
        .sbadge.accepted .dot {
            background: var(--teal);
        }
        .sbadge.rejected {
            background: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }
        .sbadge.rejected .dot {
            background: #c0392b;
        }
        .sbadge.ctf_pending {
            background: #fdf8ec;
            border-color: rgba(201, 168, 76, 0.4);
            color: var(--gold-dk);
        }
        .sbadge.ctf_pending .dot {
            background: var(--gold);
        }

        /* ── Note chips ── */
        .note-chip {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-top: 8px;
            padding: 9px 12px;
            border-radius: 7px;
            border-left: 3px solid;
        }
        .note-chip.teal {
            background: var(--teal-lt);
            border-color: var(--teal);
        }
        .note-chip.gold {
            background: #fdf8ec;
            border-color: var(--gold);
        }
        .note-chip.emerald {
            background: #f0fdf4;
            border-color: var(--teal-dk);
        }
        .note-chip.red {
            background: #fef2f2;
            border-color: #c0392b;
        }
        .note-chip-tag {
            font-size: 0.65rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .note-chip.teal .note-chip-tag {
            color: var(--teal-dk);
        }
        .note-chip.gold .note-chip-tag {
            color: var(--gold-dk);
        }
        .note-chip.emerald .note-chip-tag {
            color: var(--teal-dk);
        }
        .note-chip.red .note-chip-tag {
            color: #991b1b;
        }
        .note-chip-text {
            font-size: 0.85rem;
            color: var(--ink-soft);
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .ms-date {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--ink-soft);
            letter-spacing: 0.04em;
            white-space: nowrap;
        }

        /* ── Empty state ── */
        .empty-state {
            padding: 80px 24px;
            text-align: center;
        }
        @media (max-width: 480px) {
            .empty-state {
                padding: 48px 16px;
            }
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

        /* ── Animations ── */
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

        /* ── Pagination ── */
        @media (max-width: 480px) {
            nav[role='navigation'] {
                font-size: 0.78rem;
            }
        }

        /* ── File History Drawer ── */
        .btn-history {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--parchment);
            color: var(--ink-mid);
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 12px 22px;
            border-radius: 6px;
            border: 1.5px solid var(--border-dk);
            cursor: pointer;
            transition: all 0.15s;
            white-space: nowrap;
        }
        .btn-history:hover {
            background: var(--border);
            border-color: #b0a08a;
        }
        @media (max-width: 400px) {
            .btn-history {
                padding: 10px 16px;
                font-size: 0.75rem;
                width: 100%;
                justify-content: center;
            }
        }
        .fh-overlay {
            position: fixed;
            inset: 0;
            background: rgba(26, 18, 9, 0.45);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s;
            z-index: 50;
        }
        .fh-overlay.open {
            opacity: 1;
            pointer-events: all;
        }
        .fh-drawer {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: min(520px, 100vw);
            background: var(--cream);
            border-left: 1px solid var(--border-dk);
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1);
            z-index: 51;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .fh-drawer.open {
            transform: translateX(0);
        }
        .fh-hd {
            padding: 20px 24px 16px;
            background: var(--parchment);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            flex-shrink: 0;
        }
        .fh-eyebrow {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--teal);
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .fh-eyebrow::before {
            content: '';
            width: 18px;
            height: 1px;
            background: var(--teal);
        }
        .fh-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--ink);
        }
        .fh-sub {
            font-size: 0.82rem;
            color: var(--ink-soft);
            margin-top: 3px;
        }
        .fh-close {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: var(--border);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ink-soft);
            transition: background 0.12s;
            flex-shrink: 0;
        }
        .fh-close:hover {
            background: var(--border-dk);
        }
        .fh-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px 24px 28px;
        }
        .fh-body::-webkit-scrollbar {
            width: 4px;
        }
        .fh-body::-webkit-scrollbar-thumb {
            background: var(--border-dk);
            border-radius: 4px;
        }
        .fh-note {
            font-size: 0.76rem;
            color: var(--ink-soft);
            background: var(--parchment);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        .fh-sub-block {
            margin-bottom: 28px;
        }
        .fh-sub-hd {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border);
        }
        .fh-ref {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            background: rgba(45, 129, 118, 0.08);
            border: 1px solid rgba(45, 129, 118, 0.22);
            color: var(--teal);
            padding: 3px 9px;
            border-radius: 4px;
            white-space: nowrap;
        }
        .fh-sub-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 0.92rem;
            font-style: italic;
            color: var(--ink-mid);
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .fh-timeline {
            position: relative;
            padding-left: 28px;
        }
        .fh-timeline::before {
            content: '';
            position: absolute;
            left: 9px;
            top: 8px;
            bottom: 8px;
            width: 1px;
            background: var(--border-dk);
        }
        .fh-tl-item {
            position: relative;
            margin-bottom: 10px;
        }
        .fh-dot {
            position: absolute;
            left: -28px;
            top: 7px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 2px solid var(--cream);
        }
        .fh-dot-original {
            background: var(--teal);
        }
        .fh-dot-revision {
            background: var(--gold);
        }
        .fh-dot-ctf {
            background: #a07830;
        }
        .fh-dot-signed {
            background: var(--teal-dk);
        }
        .fh-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .fh-icon {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .fh-icon-original {
            background: var(--teal-lt);
            color: var(--teal);
        }
        .fh-icon-revision {
            background: #fdf8ec;
            color: var(--gold-dk);
        }
        .fh-icon-ctf {
            background: #fdf8ec;
            color: #a07830;
        }
        .fh-icon-signed {
            background: #f0fdf4;
            color: var(--teal-dk);
        }
        .fh-info {
            flex: 1;
            min-width: 0;
        }
        .fh-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 1px;
        }
        .fh-filename {
            font-size: 0.82rem;
            color: var(--ink);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .fh-date {
            font-size: 0.7rem;
            color: var(--ink-soft);
            margin-top: 1px;
        }
        .fh-btn-dl {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 5px 11px;
            border-radius: 5px;
            border: 1.5px solid var(--border-dk);
            background: var(--parchment);
            color: var(--ink-mid);
            transition: all 0.12s;
            white-space: nowrap;
            flex-shrink: 0;
            text-decoration: none;
        }
        .fh-btn-dl:hover {
            background: var(--border);
        }
        .fh-empty-tl {
            font-size: 0.8rem;
            color: #b5a595;
            padding: 12px 0;
        }
    </style>
@endpush

@section('content')
    <div class="aw aw-bg max-w-7xl mx-auto px-4 sm:px-4 lg:px-1">
        {{-- Hero --}}
        <div class="hero-header fu">
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div>
                    <p class="hero-eyebrow">Author Workspace</p>
                    <h1 class="hero-title">
                        Your
                        <em>Manuscript</em>
                        Pipeline
                    </h1>
                    <p class="hero-sub">
                        Track submissions, revisions, and editorial decisions in
                        one place
                    </p>
                </div>
                <div
                    class="flex items-center gap-3 self-start md:self-auto shrink-0 w-full sm:w-auto"
                >
                    <span class="date-pill hidden sm:inline-block">
                        {{ now()->format('D, M j Y') }}
                    </span>
                    <button
                        type="button"
                        class="btn-history"
                        onclick="
                            document
                                .getElementById('fileHistoryDrawer')
                                .classList.add('open');
                            document
                                .getElementById('fileHistoryOverlay')
                                .classList.add('open');
                        "
                    >
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                        File History
                    </button>
                    <a
                        href="{{ route('submissions.create') }}"
                        class="btn-submit"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2.5"
                                d="M12 4v16m8-8H4"
                            />
                        </svg>
                        New Submission
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="stat-grid fu1 mb-8 sm:mb-10">
            @foreach ([
                    ['Submitted', $stats['submitted'], 'sv-teal', 'al-teal'],
                    ['Under Review', $stats['under_review'], 'sv-gold', 'al-gold'],
                    [
                        'Revisions Requested',
                        $stats['revisions_requested'],
                        'sv-orange',
                        'al-orange'
                    ],
                    [
                        'Revision Under Review',
                        $stats['revision_under_review'],
                        'sv-amber',
                        'al-amber'
                    ],
                    ['Accepted', $stats['accepted'], 'sv-emerald', 'al-emerald'],
                    ['Rejected', $stats['rejected'], 'sv-red', 'al-red'],
                    ['Published', $stats['published'], 'sv-teal', 'al-teal']
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

        {{-- Search --}}
        <div class="fu2 mb-5 sm:mb-6">
            <form
                method="GET"
                action="{{ route('submissions.index') }}"
                class="search-wrap"
                id="searchForm"
            >
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                        stroke-width="2.5"
                    />
                </svg>
                <input
                    type="text"
                    name="search"
                    id="dashboardSearch"
                    class="search-inp"
                    placeholder="Search by title or reference number…"
                    value="{{ $search ?? '' }}"
                    autocomplete="off"
                />
                @if (! empty($search))
                    <a
                        href="{{ route('submissions.index') }}"
                        style="
                            position: absolute;
                            right: 14px;
                            top: 50%;
                            transform: translateY(-50%);
                            color: #b5a595;
                            text-decoration: none;
                            font-size: 1.1rem;
                            line-height: 1;
                        "
                        title="Clear search"
                    >
                        &times;
                    </a>
                @endif
            </form>
        </div>

        {{-- ── CTF Alert ── --}}
        @php
            $ctfTemplate = \App\Models\CtfTemplate::latest()->first();
            $ctfPending =
                $ctfTemplate && $ctfTemplate->is_released
                    ? auth()
                        ->user()
                        ->submissionsAsAuthor()
                        ->where('managing_editor_status', 'ctf_sent')
                        ->orderBy('ctf_sent_at', 'desc')
                        ->get()
                    : collect();
        @endphp

        @if ($ctfPending->count() > 0)
            <div class="fu2 mb-4">
                <div
                    class="alert-strip"
                    style="
                        border-color: rgba(201, 168, 76, 0.4);
                        background: #fffdf5;
                    "
                >
                    <div
                        class="alert-strip-accent"
                        style="background: var(--gold)"
                    ></div>
                    <div
                        class="alert-strip-body"
                        style="flex-direction: column; align-items: flex-start"
                    >
                        <div
                            style="
                                display: flex;
                                align-items: center;
                                gap: 12px;
                                width: 100%;
                                flex-wrap: wrap;
                            "
                        >
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
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    />
                                </svg>
                            </div>
                            <div style="flex: 1; min-width: 0">
                                <p
                                    class="alert-tag"
                                    style="color: var(--gold-dk)"
                                >
                                    Action Required — Copyright Transfer Form
                                </p>
                                <p
                                    class="alert-desc"
                                    style="color: var(--ink-mid)"
                                >
                                    {{ $ctfPending->count() === 1 ? 'A copyright transfer form has' : $ctfPending->count() . ' copyright transfer forms have' }}
                                    been uploaded. Please download, sign, and
                                    return.
                                </p>
                            </div>
                        </div>

                        <div class="ctf-list mt-2 w-full">
                            @foreach ($ctfPending as $cs)
                                <div
                                    class="ctf-item"
                                    style="
                                        flex-direction: column;
                                        align-items: flex-start;
                                        gap: 10px;
                                    "
                                >
                                    <div
                                        style="
                                            display: flex;
                                            align-items: center;
                                            gap: 10px;
                                            width: 100%;
                                            flex-wrap: wrap;
                                        "
                                    >
                                        <span class="ctf-item-ref">
                                            #{{ str_pad($cs->id, 5, '0', STR_PAD_LEFT) }}
                                        </span>
                                        <span class="ctf-item-title">
                                            {{ Str::limit($cs->title, 60) }}
                                        </span>
                                        <a
                                            href="{{ route('ctf-template.download') }}"
                                            class="btn-ctf-download"
                                            style="margin-left: auto"
                                        >
                                            <svg
                                                width="13"
                                                height="13"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2.5"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                                />
                                            </svg>
                                            Download CTF
                                        </a>
                                    </div>

                                    <div
                                        style="
                                            background: #fffbf0;
                                            border: 1px solid
                                                rgba(201, 168, 76, 0.3);
                                            border-radius: 8px;
                                            padding: 10px 14px;
                                            font-size: 0.82rem;
                                            color: var(--ink-mid);
                                            line-height: 1.6;
                                            width: 100%;
                                        "
                                    >
                                        <strong style="color: var(--gold-dk)">
                                            Instructions:
                                        </strong>
                                        Download the form above, fill it out
                                        completely, sign it, then upload the
                                        completed form below.
                                    </div>

                                    <form
                                        method="POST"
                                        action="{{ route('submissions.upload-signed-ctf', $cs) }}"
                                        enctype="multipart/form-data"
                                        style="
                                            width: 100%;
                                            display: flex;
                                            align-items: center;
                                            gap: 10px;
                                            flex-wrap: wrap;
                                        "
                                    >
                                        @csrf
                                        <input
                                            type="file"
                                            name="signed_ctf_file"
                                            accept=".pdf,.doc,.docx"
                                            required
                                            style="
                                                font-size: 0.82rem;
                                                color: var(--ink);
                                                flex: 1;
                                                min-width: 200px;
                                            "
                                        />
                                        <button
                                            type="submit"
                                            class="btn-ctf-download"
                                            style="background: var(--teal)"
                                        >
                                            <svg
                                                width="13"
                                                height="13"
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
                                            Upload Signed CTF
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ── Revision Alert ── --}}
        @if ($stats['revisions_requested'] > 0)
            @php
                $revisionsNeeded = auth()
                    ->user()
                    ->submissionsAsAuthor()
                    ->where('status', 'revisions_requested')
                    ->orderBy('updated_at', 'desc')
                    ->get();
            @endphp

            <div class="fu2 mb-4">
                <div
                    class="alert-strip"
                    style="border-color: #fed7aa; background: #fffdf9"
                >
                    <div
                        class="alert-strip-accent"
                        style="background: #f97316"
                    ></div>
                    <div class="alert-strip-body">
                        <div
                            style="
                                display: flex;
                                align-items: center;
                                gap: 12px;
                            "
                        >
                            <div
                                style="
                                    width: 38px;
                                    height: 38px;
                                    border-radius: 8px;
                                    background: #fff7ed;
                                    color: #ea580c;
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
                                <p class="alert-tag" style="color: #9a3412">
                                    Action Required
                                </p>
                                <p class="alert-desc" style="color: #7c2d12">
                                    {{ $stats['revisions_requested'] }}
                                    manuscript{{ $stats['revisions_requested'] > 1 ? 's require' : ' requires' }}
                                    your attention
                                </p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap">
                            @foreach ($revisionsNeeded->take(2) as $rev)
                                <a
                                    href="{{ route('submissions.show', $rev) }}"
                                    class="btn-alert-action"
                                    style="
                                        color: #ea580c;
                                        border-color: #fed7aa;
                                    "
                                >
                                    Revise
                                    #{{ str_pad($rev->id, 5, '0', STR_PAD_LEFT) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ── Manuscripts Table ── --}}
        <div class="ms-table-wrap fu3">
            <div class="ms-table-head">
                <span class="ms-table-head-title">Manuscripts</span>
                <span class="ms-table-head-count">
                    {{ $submissions->total() ?? $submissions->count() }}
                    records
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="mst" id="submissionsTable">
                    <thead>
                        <tr>
                            <th style="width: 110px">Ref No.</th>
                            <th>Manuscript Title &amp; Notes</th>
                            <th style="width: 170px">Status</th>
                            <th style="width: 120px; text-align: right">
                                Updated
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($submissions as $s)
                            <tr
                                class="submission-row"
                                onclick="
                                    window.location =
                                        '{{ route('submissions.show', $s) }}'
                                "
                            >
                                {{-- Ref No. column (hidden on mobile) --}}
                                <td>
                                    <span class="ms-ref">
                                        #{{ str_pad($s->id, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>

                                {{-- Title + notes column --}}
                                <td>
                                    {{-- Inline ref badge visible only on mobile --}}
                                    <span class="ms-ref ms-ref-inline">
                                        #{{ str_pad($s->id, 5, '0', STR_PAD_LEFT) }}
                                    </span>

                                    <p class="ms-row-title title-cell">
                                        {{ $s->title }}
                                    </p>

                                    {{-- CTF download badge inline --}}
                                    @if ($s->managing_editor_status === 'ctf_sent' && $ctfTemplate?->is_released)
                                        <a
                                            href="{{ route('ctf-template.download') }}"
                                            onclick="event.stopPropagation()"
                                            class="ctf-row-badge"
                                        >
                                            <svg
                                                width="11"
                                                height="11"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2.5"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                                />
                                            </svg>
                                            Download CTF
                                        </a>
                                    @endif

                                    @if ($s->initial_screening_comments || $s->editor_notes || $s->initial_screening_status !== 'pending')
                                        <div
                                            onclick="event.stopPropagation()"
                                            class="mt-2 space-y-1"
                                        >
                                            @if ($s->initial_screening_comments)
                                                <div class="note-chip teal">
                                                    <div
                                                        style="margin-top: 1px"
                                                    >
                                                        <p
                                                            class="note-chip-tag"
                                                        >
                                                            Screening Note
                                                        </p>
                                                        <p
                                                            class="note-chip-text"
                                                        >
                                                            {{ $s->initial_screening_comments }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($s->editor_notes)
                                                <div class="note-chip gold">
                                                    <div
                                                        style="margin-top: 1px"
                                                    >
                                                        <p
                                                            class="note-chip-tag"
                                                        >
                                                            Editor's Note
                                                        </p>
                                                        <p
                                                            class="note-chip-text"
                                                        >
                                                            {{ $s->editor_notes }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif

                                            @php
                                                $appeal = $s
                                                    ->appeals()
                                                    ->latest()
                                                    ->first();
                                                $submissionIsRejected = $s->status === 'rejected';
                                                $allAppealsExhausted =
                                                    $s->appeals()->count() >= 2 &&
                                                    $s
                                                        ->appeals()
                                                        ->where('status', 'rejected')
                                                        ->count() >= 2;
                                            @endphp

                                            @if ($appeal && ! $submissionIsRejected && ! $allAppealsExhausted)
                                                <div
                                                    class="note-chip {{ $appeal->status === 'approved' ? 'emerald' : 'red' }}"
                                                >
                                                    <div
                                                        style="margin-top: 1px"
                                                    >
                                                        <p
                                                            class="note-chip-tag"
                                                        >
                                                            Appeal
                                                            {{ ucfirst($appeal->status) }}
                                                        </p>
                                                        <p
                                                            class="note-chip-text"
                                                        >
                                                            {{ $appeal->editor_response ?? 'Awaiting editor-in-chief review…' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    {{-- Mobile-only: status badge + date shown under title --}}
                                    <div class="ms-mobile-meta">
                                        @php
                                            $screeningFailed = $s->initial_screening_status === 'failed';
                                            $cls = $screeningFailed
                                                ? 'rejected'
                                                : match ($s->status) {
                                                    'accepted' => 'accepted',
                                                    'under_review' => 'under_review',
                                                    'revision_under_review' => 'revision_review',
                                                    'revisions_requested' => 'revisions_requested',
                                                    'rejected' => 'rejected',
                                                    default => 'submitted',
                                                };
                                            $lbl = $screeningFailed
                                                ? 'Failed Initial Screening'
                                                : match ($s->status) {
                                                    'revision_under_review' => 'Revision Review',
                                                    default => ucfirst(str_replace('_', ' ', $s->status)),
                                                };
                                        @endphp

                                        <span class="sbadge {{ $cls }}">
                                            <span class="dot"></span>
                                            {{ $lbl }}
                                        </span>
                                        @if ($s->managing_editor_status === 'ctf_sent' && $s->ctf_file_path)
                                            <span
                                                class="sbadge ctf_pending"
                                                style="
                                                    font-size: 0.6rem;
                                                    padding: 3px 8px;
                                                "
                                            >
                                                <span class="dot"></span>
                                                CTF Pending
                                            </span>
                                        @endif

                                        <span class="ms-mobile-date">
                                            {{ $s->updated_at->format('d M Y') }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Status column (hidden on mobile — shown in ms-mobile-meta above) --}}
                                <td>
                                    @php
                                        $screeningFailed = $s->initial_screening_status === 'failed';
                                        $cls = $screeningFailed
                                            ? 'rejected'
                                            : match ($s->status) {
                                                'accepted' => 'accepted',
                                                'under_review' => 'under_review',
                                                'revision_under_review' => 'revision_review',
                                                'revisions_requested' => 'revisions_requested',
                                                'rejected' => 'rejected',
                                                default => 'submitted',
                                            };
                                        $lbl = $screeningFailed
                                            ? 'Failed Initial Screening'
                                            : match ($s->status) {
                                                'revision_under_review' => 'Revision Review',
                                                default => ucfirst(str_replace('_', ' ', $s->status)),
                                            };
                                    @endphp

                                    <span
                                        class="sbadge {{ $cls }} status-cell"
                                    >
                                        <span class="dot"></span>
                                        {{ $lbl }}
                                    </span>

                                    @if ($s->managing_editor_status === 'ctf_sent' && $s->ctf_file_path)
                                        <div class="mt-2">
                                            <span
                                                class="sbadge ctf_pending"
                                                style="
                                                    font-size: 0.65rem;
                                                    padding: 3px 9px;
                                                "
                                            >
                                                <span class="dot"></span>
                                                CTF Awaiting Signature
                                            </span>
                                        </div>
                                    @endif
                                </td>

                                {{-- Date column (hidden on mobile) --}}
                                <td style="text-align: right">
                                    <span class="ms-date">
                                        {{ $s->updated_at->format('d M Y') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <svg
                                                class="w-8 h-8"
                                                fill="none"
                                                stroke="#c9b99a"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                                    stroke-width="1.5"
                                                    stroke-linecap="round"
                                                />
                                            </svg>
                                        </div>
                                        <p class="empty-state-label">
                                            No manuscripts found
                                        </p>
                                        <p
                                            style="
                                                font-size: 0.88rem;
                                                color: #b5a595;
                                                margin-top: 6px;
                                            "
                                        >
                                            Submit your first manuscript to get
                                            started
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if (method_exists($submissions, 'hasPages') && $submissions->hasPages())
            <div class="fu4 mt-5">{{ $submissions->links() }}</div>
        @endif

        {{-- ── File History Drawer ── --}}
        <div
            id="fileHistoryOverlay"
            class="fh-overlay"
            onclick="
                document
                    .getElementById('fileHistoryDrawer')
                    .classList.remove('open');
                this.classList.remove('open');
            "
        ></div>

        <div id="fileHistoryDrawer" class="fh-drawer">
            <div class="fh-hd">
                <div>
                    <div class="fh-eyebrow">Submission Archive</div>
                    <div class="fh-title">File History</div>
                    <div class="fh-sub">
                        All uploaded files across your submissions
                    </div>
                </div>
                <button
                    type="button"
                    class="fh-close"
                    onclick="
                        document
                            .getElementById('fileHistoryDrawer')
                            .classList.remove('open');
                        document
                            .getElementById('fileHistoryOverlay')
                            .classList.remove('open');
                    "
                >
                    <svg
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                        class="w-4 h-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>

            <div class="fh-body">
                <p class="fh-note">
                    All files uploaded throughout the editorial journey of each
                    submission — original manuscript, revisions, and copyright
                    transfer forms.
                </p>

                @forelse (auth()->user()->submissionsAsAuthor()->with('revisionRequests')->orderBy('updated_at', 'desc')->get() as $hs)
                    @php
                        $originalFile = $hs->original_file_path;
                        $originalName = $hs->original_file_name ?? basename($hs->original_file_path ?? '');
                        $currentFile = $hs->file_path;
                        $currentName = $hs->file_name ?? basename($hs->file_path ?? '');
                        $isRevised = $hs->original_file_path && $hs->file_path !== $hs->original_file_path;
                        $ctfFile = $hs->ctf_file_path;
                        $signedCtfFile = $hs->ctf_signed_file_path;
                    @endphp

                    <div class="fh-sub-block">
                        <div class="fh-sub-hd">
                            <span class="fh-ref">
                                #{{ str_pad($hs->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                            <span class="fh-sub-title">
                                {{ Str::limit($hs->title, 55) }}
                            </span>
                        </div>

                        <div class="fh-timeline">
                            {{-- Original manuscript --}}

                            @if ($originalFile)
                                <div class="fh-tl-item">
                                    <div class="fh-dot fh-dot-original"></div>
                                    <div class="fh-card">
                                        <div class="fh-icon fh-icon-original">
                                            <svg
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                viewBox="0 0 24 24"
                                                class="w-3.5 h-3.5"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                                />
                                            </svg>
                                        </div>
                                        <div class="fh-info">
                                            <div class="fh-label">
                                                Original Manuscript
                                            </div>
                                            <div class="fh-filename">
                                                {{ $originalName }}
                                            </div>
                                            <div class="fh-date">
                                                Submitted
                                                {{ $hs->created_at->format('d M Y') }}
                                            </div>
                                        </div>
                                        <a
                                            href="{{ route('submissions.download-original', $hs) }}"
                                            class="fh-btn-dl"
                                            onclick="event.stopPropagation()"
                                        >
                                            <svg
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2.5"
                                                viewBox="0 0 24 24"
                                                style="
                                                    width: 11px;
                                                    height: 11px;
                                                "
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                                />
                                            </svg>
                                            Download
                                        </a>
                                    </div>
                                </div>
                            @else
                                {{-- Fallback: no original, show current as the only file --}}
                                <div class="fh-tl-item">
                                    <div class="fh-dot fh-dot-original"></div>
                                    <div class="fh-card">
                                        <div class="fh-icon fh-icon-original">
                                            <svg
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                viewBox="0 0 24 24"
                                                class="w-3.5 h-3.5"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                                />
                                            </svg>
                                        </div>
                                        <div class="fh-info">
                                            <div class="fh-label">
                                                Manuscript
                                            </div>
                                            <div class="fh-filename">
                                                {{ $currentName }}
                                            </div>
                                            <div class="fh-date">
                                                Submitted
                                                {{ $hs->created_at->format('d M Y') }}
                                            </div>
                                        </div>
                                        <a
                                            href="{{ route('submissions.download', $hs) }}"
                                            class="fh-btn-dl"
                                            onclick="event.stopPropagation()"
                                        >
                                            <svg
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2.5"
                                                viewBox="0 0 24 24"
                                                style="
                                                    width: 11px;
                                                    height: 11px;
                                                "
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                                />
                                            </svg>
                                            Download
                                        </a>
                                    </div>
                                </div>
                            @endif

                            {{-- Revision files --}}
                            @foreach ($hs->revisionRequests->whereNotNull('file_path')->sortBy('created_at') as $ri => $rv)
                                <div class="fh-tl-item">
                                    <div class="fh-dot fh-dot-revision"></div>
                                    <div class="fh-card">
                                        <div class="fh-icon fh-icon-revision">
                                            <svg
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                viewBox="0 0 24 24"
                                                class="w-3.5 h-3.5"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                />
                                            </svg>
                                        </div>
                                        <div class="fh-info">
                                            <div class="fh-label">
                                                Revision {{ $ri + 1 }}
                                            </div>
                                            <div class="fh-filename">
                                                {{ $rv->file_name ?? basename($rv->file_path) }}
                                            </div>
                                            <div class="fh-date">
                                                Uploaded
                                                {{ $rv->updated_at->format('d M Y') }}
                                            </div>
                                        </div>
                                        <a
                                            href="{{ route('submissions.revision-file.download', [$hs, $rv]) }}"
                                            class="fh-btn-dl"
                                            onclick="event.stopPropagation()"
                                        >
                                            <svg
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2.5"
                                                viewBox="0 0 24 24"
                                                style="
                                                    width: 11px;
                                                    height: 11px;
                                                "
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                                />
                                            </svg>
                                            Download
                                        </a>
                                    </div>
                                </div>
                            @endforeach

                            {{-- CTF --}}

                            @if ($hs->ctf_sent_at && $ctfTemplate?->is_released)
                                <div class="fh-tl-item">
                                    <div class="fh-dot fh-dot-ctf"></div>
                                    <div class="fh-card">
                                        <div class="fh-icon fh-icon-ctf">
                                            ...
                                        </div>
                                        <div class="fh-info">
                                            <div class="fh-label">
                                                Copyright Transfer Form
                                            </div>
                                            <div class="fh-filename">
                                                {{ $ctfTemplate->file_name }}
                                            </div>
                                            <div class="fh-date">
                                                Sent
                                                {{ $hs->ctf_sent_at->format('d M Y') }}
                                            </div>
                                        </div>
                                        <a
                                            href="{{ route('ctf-template.download') }}"
                                            class="fh-btn-dl"
                                            onclick="event.stopPropagation()"
                                        >
                                            <svg
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2.5"
                                                viewBox="0 0 24 24"
                                                style="
                                                    width: 11px;
                                                    height: 11px;
                                                "
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                                />
                                            </svg>
                                            Download
                                        </a>
                                    </div>
                                </div>
                            @elseif ($hs->ctf_sent_at && ! $ctfTemplate?->is_released)
                                <div class="fh-tl-item">
                                    <div class="fh-dot fh-dot-ctf"></div>
                                    <div class="fh-card">
                                        <div class="fh-icon fh-icon-ctf">
                                            ...
                                        </div>
                                        <div class="fh-info">
                                            <div class="fh-label">
                                                Copyright Transfer Form
                                            </div>
                                            <div
                                                class="fh-filename"
                                                style="
                                                    color: var(--ink-soft);
                                                    font-style: italic;
                                                "
                                            >
                                                Awaiting release by managing
                                                editor
                                            </div>
                                            <div class="fh-date">
                                                Sent
                                                {{ $hs->ctf_sent_at->format('d M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Signed CTF --}}
                            @if ($signedCtfFile)
                                <div class="fh-tl-item">
                                    <div class="fh-dot fh-dot-signed"></div>
                                    <div class="fh-card">
                                        <div class="fh-icon fh-icon-signed">
                                            <svg
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                viewBox="0 0 24 24"
                                                class="w-3.5 h-3.5"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                                                />
                                            </svg>
                                        </div>
                                        <div class="fh-info">
                                            <div class="fh-label">
                                                Signed CTF (Returned)
                                            </div>
                                            <div class="fh-filename">
                                                {{ $hs->ctf_signed_file_name }}
                                            </div>
                                            <div class="fh-date">
                                                Uploaded
                                                {{ $hs->ctf_returned_at?->format('d M Y') }}
                                            </div>
                                        </div>
                                        <span
                                            class="fh-btn-dl"
                                            style="
                                                opacity: 0.5;
                                                cursor: default;
                                            "
                                            title="Download coming soon"
                                        >
                                            <svg
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2.5"
                                                viewBox="0 0 24 24"
                                                style="
                                                    width: 11px;
                                                    height: 11px;
                                                "
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                                />
                                            </svg>
                                            Download
                                        </span>
                                    </div>
                                </div>
                            @endif

                            @if (! $currentFile && ! $ctfFile)
                                <div class="fh-empty-tl">
                                    No files uploaded yet
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div
                        class="fh-empty-tl"
                        style="text-align: center; padding: 48px 16px"
                    >
                        No submissions found
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let searchTimer;
                document.getElementById('dashboardSearch')?.addEventListener('input', function () {
                    clearTimeout(searchTimer);
                    searchTimer = setTimeout(() => {
                        const form = document.getElementById('searchForm');
                        const existing = form.querySelector('input[name="page"]');
                        if (existing) existing.remove();
                        const currentPage = new URLSearchParams(window.location.search).get('page');
                        if (currentPage) {
                            const pageInput = document.createElement('input');
                            pageInput.type  = 'hidden';
                            pageInput.name  = 'page';
                            pageInput.value = currentPage;
                            form.appendChild(pageInput);
                        }
                        form.submit();
                    }, 400);
                });

                window.addEventListener('load', function () {
                    const search = document.getElementById('dashboardSearch');
                    if (search && search.value.trim() !== '') {
                        search.focus();
                        const val = search.value;
                        search.value = '';
                        search.value = val;
                    }
                });

                @if(session('success'))
                Swal.fire({
                    icon:'success',
                    title:'<span style="font-family:\'Libre Baskerville\',serif;font-size:1.3rem;font-weight:700;">Confirmed</span>',
                    html:'<p style="font-size:.9rem;color:#6b5740;">{{ session('success') }}</p>',
                    confirmButtonText:'Close',
                    confirmButtonColor:'#2d8176',
                    customClass:{popup:'rounded-2xl',confirmButton:'rounded-lg px-8 py-2.5 text-xs font-bold uppercase tracking-widest'},
                    buttonsStyling:false,
                });
                @endif

                document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('fileHistoryDrawer').classList.remove('open');
                document.getElementById('fileHistoryOverlay').classList.remove('open');
            }
        });
    </script>
@endpush
