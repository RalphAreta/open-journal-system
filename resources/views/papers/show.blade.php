<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ $paper['title'] }} - Published Paper</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                --gold-lt: #fdf8ec;
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
                margin: 0;
                padding: 0;
            }

            body {
                font-family: 'Source Sans 3', sans-serif;
                background-color: var(--cream);
                background-image:
                    radial-gradient(
                        ellipse 80% 50% at 50% -10%,
                        rgba(45, 129, 118, 0.08) 0%,
                        transparent 70%
                    ),
                    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Crect width='4' height='4' fill='%23faf6ef'/%3E%3Ccircle cx='1' cy='1' r='.4' fill='%23e8dfd0' opacity='.5'/%3E%3C/svg%3E");
                color: var(--ink);
            }

            /* ── NAV ── */
            .site-nav {
                background: #2d8176;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                position: sticky;
                top: 0;
                z-index: 50;
            }
            .nav-shimmer-bar {
                height: 3px;
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
            @keyframes shimmer {
                0% {
                    background-position: -100% 0;
                }
                100% {
                    background-position: 100% 0;
                }
            }
            .nav-inner {
                max-width: 1100px;
                margin: 0 auto;
                padding: 0 24px;
                height: 72px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .nav-brand {
                display: flex;
                align-items: center;
                gap: 12px;
                text-decoration: none;
            }
            .nav-brand-icon {
                width: 44px;
                height: 44px;
                border-radius: 50%;
                background: linear-gradient(135deg, #c9a84c, #a07830);
                border: 2px solid rgba(255, 255, 255, 0.3);
                display: flex;
                align-items: center;
                justify-content: center;
                transition: transform 0.5s;
            }
            .nav-brand:hover .nav-brand-icon {
                transform: rotate(12deg);
            }
            .nav-brand-text {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.4rem;
                font-weight: 700;
                color: #fff;
            }
            .nav-brand-sub {
                font-size: 9px;
                font-weight: 700;
                letter-spacing: 0.2em;
                text-transform: uppercase;
                color: #f0d678;
            }
            .nav-back {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                font-size: 0.78rem;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: rgba(255, 255, 255, 0.8);
                text-decoration: none;
                padding: 8px 18px;
                border-radius: 6px;
                border: 1.5px solid rgba(255, 255, 255, 0.2);
                background: rgba(255, 255, 255, 0.08);
                transition: all 0.15s;
            }
            .nav-back:hover {
                background: rgba(255, 255, 255, 0.18);
                color: #f0d678;
            }

            /* ── LAYOUT ── */
            .page-wrap {
                max-width: 1100px;
                margin: 0 auto;
                padding: 0 24px;
            }

            /* ── HERO ── */
            .paper-hero {
                position: relative;
                padding: 56px 0 40px;
                border-bottom: 1px solid var(--border);
                margin-bottom: 40px;
            }
            .paper-hero::after {
                content: '';
                position: absolute;
                bottom: -1px;
                left: 0;
                width: 80px;
                height: 3px;
                background: linear-gradient(90deg, var(--teal), transparent);
            }
            .paper-eyebrow {
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
            .paper-eyebrow::before {
                content: '';
                width: 24px;
                height: 1px;
                background: var(--teal);
            }
            .paper-category-badge {
                display: inline-block;
                background: rgba(45, 129, 118, 0.1);
                color: var(--teal);
                padding: 5px 16px;
                border-radius: 20px;
                font-size: 0.72rem;
                font-weight: 800;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                border: 1px solid rgba(45, 129, 118, 0.25);
                margin-bottom: 16px;
            }
            .paper-title {
                font-family: 'Libre Baskerville', serif;
                font-size: clamp(1.8rem, 4vw, 2.8rem);
                font-weight: 700;
                color: var(--ink);
                line-height: 1.2;
                letter-spacing: -0.01em;
                margin-bottom: 28px;
            }
            .paper-meta-row {
                display: flex;
                align-items: center;
                gap: 0;
                flex-wrap: wrap;
                border-top: 1px solid var(--border);
                padding-top: 24px;
            }
            .meta-block {
                padding: 0 32px 0 0;
            }
            .meta-block:first-child {
                padding-left: 0;
            }
            .meta-block + .meta-block {
                border-left: 1px solid var(--border);
                padding-left: 32px;
            }
            .meta-label {
                font-size: 0.65rem;
                font-weight: 800;
                letter-spacing: 0.14em;
                text-transform: uppercase;
                color: var(--ink-soft);
                margin-bottom: 5px;
            }
            .meta-value {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.05rem;
                font-weight: 700;
                color: var(--teal);
            }

            /* ── STATS GRID ── */
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                background: var(--parchment);
                border: 1px solid var(--border-dk);
                border-radius: 14px;
                overflow: hidden;
                box-shadow: 0 2px 12px rgba(26, 18, 9, 0.07);
                margin-bottom: 40px;
            }
            .stat-cell {
                padding: 24px 28px 20px;
                border-right: 1px solid var(--border);
                position: relative;
                transition: background 0.18s;
                cursor: default;
            }
            .stat-cell:last-child {
                border-right: none;
            }
            .stat-cell:hover {
                background: #fff;
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
                color: var(--teal);
            }
            .stat-accent {
                position: absolute;
                bottom: 0;
                left: 28px;
                height: 2px;
                width: 0;
                border-radius: 2px;
                background: var(--teal);
                transition: width 0.3s ease;
            }
            .stat-cell:hover .stat-accent {
                width: 36px;
            }

            /* ── CONTENT SECTIONS ── */
            .section-wrap {
                background: #fff;
                border: 1px solid var(--border-dk);
                border-radius: 14px;
                overflow: hidden;
                box-shadow: 0 2px 16px rgba(26, 18, 9, 0.07);
                margin-bottom: 24px;
            }
            .section-head {
                padding: 16px 28px 14px;
                background: var(--parchment);
                border-bottom: 1px solid var(--border);
                display: flex;
                align-items: center;
                gap: 12px;
            }
            .section-head-icon {
                width: 32px;
                height: 32px;
                border-radius: 8px;
                background: rgba(45, 129, 118, 0.1);
                color: var(--teal);
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            .section-title {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.1rem;
                font-weight: 700;
                color: var(--ink);
            }
            .section-body {
                padding: 24px 28px;
            }

            /* Abstract */
            .abstract-text {
                font-size: 0.98rem;
                color: var(--ink-mid);
                line-height: 1.85;
            }

            /* Keywords */
            .keyword-chip {
                display: inline-flex;
                align-items: center;
                background: var(--parchment);
                color: var(--teal);
                padding: 6px 16px;
                border-radius: 8px;
                font-size: 0.82rem;
                font-weight: 600;
                border: 1px solid var(--border-dk);
                transition: all 0.15s;
            }
            .keyword-chip:hover {
                background: var(--teal-lt);
                border-color: var(--teal);
            }

            /* Download */
            .download-banner {
                background: linear-gradient(
                    135deg,
                    var(--teal) 0%,
                    var(--teal-dk) 100%
                );
                border-radius: 10px;
                padding: 28px 32px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
                flex-wrap: wrap;
                position: relative;
                overflow: hidden;
            }
            .download-banner::before {
                content: '';
                position: absolute;
                top: -30px;
                right: -30px;
                width: 120px;
                height: 120px;
                border-radius: 50%;
                background: rgba(201, 168, 76, 0.12);
            }
            .download-banner-text {
                font-size: 1rem;
                color: rgba(255, 255, 255, 0.9);
                line-height: 1.5;
            }
            .download-banner-text strong {
                display: block;
                font-family: 'Libre Baskerville', serif;
                font-size: 1.15rem;
                color: #fff;
                margin-bottom: 4px;
            }
            .btn-download {
                display: inline-flex;
                align-items: center;
                gap: 9px;
                background: linear-gradient(135deg, var(--gold), #a07830);
                color: #fff;
                font-size: 0.78rem;
                font-weight: 800;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                padding: 12px 26px;
                border-radius: 8px;
                text-decoration: none;
                border: none;
                cursor: pointer;
                transition: all 0.15s;
                box-shadow: 0 4px 14px rgba(201, 168, 76, 0.4);
                white-space: nowrap;
                flex-shrink: 0;
            }
            .btn-download:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 22px rgba(201, 168, 76, 0.5);
            }

            /* Citation */
            .btn-cite {
                display: inline-flex;
                align-items: center;
                gap: 9px;
                background: var(--teal);
                color: #fff;
                font-size: 0.78rem;
                font-weight: 800;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                padding: 12px 26px;
                border-radius: 8px;
                border: none;
                cursor: pointer;
                transition: all 0.15s;
                box-shadow: 0 4px 14px rgba(45, 129, 118, 0.3);
            }
            .btn-cite:hover {
                background: var(--teal-dk);
                transform: translateY(-2px);
            }

            /* Related papers */
            .related-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }
            @media (max-width: 640px) {
                .related-grid {
                    grid-template-columns: 1fr;
                }
            }
            .related-card {
                background: var(--parchment);
                border: 1px solid var(--border);
                border-radius: 10px;
                padding: 20px 22px;
                transition: all 0.2s;
                cursor: pointer;
            }
            .related-card:hover {
                background: #fff;
                border-color: var(--teal);
                transform: translateY(-3px);
                box-shadow: 0 8px 24px rgba(45, 129, 118, 0.12);
            }
            .related-tag {
                font-size: 0.65rem;
                font-weight: 800;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: var(--gold-dk);
                margin-bottom: 10px;
            }
            .related-title {
                font-family: 'Libre Baskerville', serif;
                font-size: 1rem;
                font-weight: 700;
                font-style: italic;
                color: var(--ink);
                line-height: 1.4;
                margin-bottom: 10px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                transition: color 0.15s;
            }
            .related-card:hover .related-title {
                color: var(--teal);
            }
            .related-desc {
                font-size: 0.84rem;
                color: var(--ink-soft);
                line-height: 1.5;
                margin-bottom: 14px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .related-meta {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 0.72rem;
                color: #b5a595;
                font-weight: 600;
            }
            .related-meta .dot {
                color: var(--border-dk);
            }

            /* ── CITATION MODAL ── */
            .modal-overlay {
                display: none;
                position: fixed;
                inset: 0;
                z-index: 1000;
                background: rgba(26, 18, 9, 0.6);
                animation: fadeIn 0.25s ease;
                align-items: center;
                justify-content: center;
            }
            .modal-overlay.show {
                display: flex;
            }
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }
            .modal-box {
                background: #fff;
                border: 1px solid var(--border-dk);
                border-radius: 16px;
                max-width: 600px;
                width: 90%;
                max-height: 85vh;
                overflow-y: auto;
                box-shadow: 0 24px 64px rgba(26, 18, 9, 0.25);
                animation: slideUp 0.25s ease;
                position: relative;
            }
            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .modal-head {
                padding: 22px 28px 18px;
                background: var(--parchment);
                border-bottom: 1px solid var(--border);
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .modal-title {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.2rem;
                font-weight: 700;
                color: var(--ink);
            }
            .modal-close {
                width: 32px;
                height: 32px;
                border-radius: 8px;
                background: none;
                border: 1.5px solid var(--border);
                color: var(--ink-soft);
                font-size: 1.1rem;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.15s;
            }
            .modal-close:hover {
                border-color: var(--teal);
                color: var(--teal);
                background: var(--teal-lt);
            }
            .modal-body {
                padding: 24px 28px;
            }
            .citation-tabs {
                display: flex;
                gap: 8px;
                flex-wrap: wrap;
                margin-bottom: 18px;
            }
            .tab-btn {
                padding: 7px 16px;
                border: 1.5px solid var(--border-dk);
                background: var(--parchment);
                color: var(--ink-soft);
                border-radius: 6px;
                font-size: 0.75rem;
                font-weight: 800;
                letter-spacing: 0.06em;
                text-transform: uppercase;
                cursor: pointer;
                transition: all 0.15s;
            }
            .tab-btn:hover {
                border-color: var(--teal);
                color: var(--teal);
                background: var(--teal-lt);
            }
            .tab-btn.active {
                background: var(--teal);
                color: #fff;
                border-color: var(--teal);
            }
            .citation-content {
                display: none;
                padding: 16px 20px;
                background: var(--parchment);
                border: 1px solid var(--border);
                border-left: 3px solid var(--gold);
                border-radius: 8px;
                font-family: 'Courier New', monospace;
                font-size: 0.84rem;
                line-height: 1.7;
                word-wrap: break-word;
                color: var(--ink-mid);
            }
            .citation-content.active {
                display: block;
            }
            .btn-copy {
                margin-top: 16px;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: var(--teal);
                color: #fff;
                font-size: 0.75rem;
                font-weight: 800;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                padding: 10px 22px;
                border-radius: 8px;
                border: none;
                cursor: pointer;
                transition: all 0.15s;
                box-shadow: 0 4px 14px rgba(45, 129, 118, 0.25);
            }
            .btn-copy:hover {
                background: var(--teal-dk);
                transform: translateY(-1px);
            }

            /* ── FOOTER ── */
            .site-footer {
                background: #1a4d46;
                border-top: 1px solid rgba(255, 255, 255, 0.05);
                margin-top: 64px;
                padding: 48px 0;
            }
            .footer-inner {
                max-width: 1100px;
                margin: 0 auto;
                padding: 0 24px;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 16px;
            }
            .footer-text {
                font-size: 0.82rem;
                color: rgba(255, 255, 255, 0.5);
            }
            .footer-links {
                display: flex;
                gap: 24px;
            }
            .footer-links a {
                font-size: 0.8rem;
                color: rgba(255, 255, 255, 0.5);
                text-decoration: none;
                transition: color 0.15s;
            }
            .footer-links a:hover {
                color: #f0d678;
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

            @media (max-width: 640px) {
                .paper-meta-row {
                    flex-direction: column;
                    gap: 16px;
                }
                .meta-block + .meta-block {
                    border-left: none;
                    padding-left: 0;
                    border-top: 1px solid var(--border);
                    padding-top: 16px;
                }
                .download-banner {
                    flex-direction: column;
                }
            }
        </style>
    </head>
    <body>
        {{-- Nav shimmer --}}
        <div class="nav-shimmer-bar"></div>

        {{-- Nav --}}
        <nav class="site-nav">
            <div class="nav-inner">
                <a href="/" class="nav-brand">
                    <div class="nav-brand-icon">
                        <svg
                            class="w-6 h-6 text-white"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                            />
                        </svg>
                    </div>
                    <div>
                        <div class="nav-brand-text">Journal System</div>
                        <div class="nav-brand-sub">
                            Academic Publishing Portal
                        </div>
                    </div>
                </a>
                <a href="/" class="nav-back">
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
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"
                        />
                    </svg>
                    Back to Home
                </a>
            </div>
        </nav>

        <main style="padding-bottom: 0">
            <div class="page-wrap">
                {{-- Hero --}}
                <div class="paper-hero fu">
                    <p class="paper-eyebrow">Published Research</p>
                    <div class="paper-category-badge">
                        {{ $paper['category'] }}
                    </div>
                    <h1 class="paper-title">{{ $paper['title'] }}</h1>
                    <div class="paper-meta-row">
                        <div class="meta-block">
                            <p class="meta-label">Author</p>
                            <p class="meta-value">{{ $paper['author'] }}</p>
                        </div>
                        <div class="meta-block">
                            <p class="meta-label">Published</p>
                            <p class="meta-value">
                                {{ $paper['publishedAt']->format('M d, Y') }}
                            </p>
                        </div>
                        <div class="meta-block">
                            <p class="meta-label">Field</p>
                            <p class="meta-value">{{ $paper['category'] }}</p>
                        </div>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="stats-grid fu1">
                    <div class="stat-cell">
                        <p class="stat-lbl">Citations</p>
                        <p class="stat-val">{{ $paper['citations'] }}</p>
                        <div class="stat-accent"></div>
                    </div>
                    <div class="stat-cell">
                        <p class="stat-lbl">Downloads</p>
                        <p class="stat-val">{{ $paper['downloads'] }}</p>
                        <div class="stat-accent"></div>
                    </div>
                    <div class="stat-cell">
                        <p class="stat-lbl">Peer Reviews</p>
                        <p class="stat-val">{{ $paper['reviews'] }}</p>
                        <div class="stat-accent"></div>
                    </div>
                </div>

                {{-- Abstract --}}
                <div class="section-wrap fu2">
                    <div class="section-head">
                        <div class="section-head-icon">
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                        </div>
                        <h2 class="section-title">Abstract</h2>
                    </div>
                    <div class="section-body">
                        <p class="abstract-text">{{ $paper['abstract'] }}</p>
                    </div>
                </div>

                {{-- Keywords --}}
                @if ($paper['keywords'])
                    <div class="section-wrap fu2">
                        <div class="section-head">
                            <div class="section-head-icon">
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z"
                                    />
                                </svg>
                            </div>
                            <h2 class="section-title">Keywords</h2>
                        </div>
                        <div class="section-body">
                            <div
                                style="
                                    display: flex;
                                    flex-wrap: wrap;
                                    gap: 10px;
                                "
                            >
                                @foreach (array_filter(array_map('trim', explode(',', $paper['keywords']))) as $keyword)
                                    <span class="keyword-chip">
                                        {{ $keyword }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Download --}}
                <div class="section-wrap fu3">
                    <div class="section-head">
                        <div class="section-head-icon">
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                />
                            </svg>
                        </div>
                        <h2 class="section-title">Access Paper</h2>
                    </div>
                    <div class="section-body">
                        <div class="download-banner">
                            <div class="download-banner-text">
                                <strong>Full Manuscript Available</strong>
                                Download the complete research paper including
                                methodology, results, and references.
                            </div>
                            <a
                                href="{{ route('papers.download', ['submission' => $paper['id']]) }}"
                                class="btn-download"
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
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                    />
                                </svg>
                                Download PDF
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Citation --}}
                <div class="section-wrap fu3">
                    <div class="section-head">
                        <div class="section-head-icon">
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                                />
                            </svg>
                        </div>
                        <h2 class="section-title">Citation</h2>
                    </div>
                    <div class="section-body">
                        <p
                            style="
                                font-size: 0.88rem;
                                color: var(--ink-soft);
                                margin-bottom: 18px;
                            "
                        >
                            Select your preferred citation format below.
                        </p>
                        <button
                            class="btn-cite"
                            onclick="openCitationModal()"
                            data-paper-title="{{ $paper['title'] }}"
                            data-paper-author="{{ $paper['author'] }}"
                            data-publication-year="{{ $paper['publishedAt']->format('Y') }}"
                            data-category="{{ $paper['category'] }}"
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
                                    stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                />
                            </svg>
                            Cite This Paper
                        </button>
                    </div>
                </div>

                {{-- Related --}}
                <div class="section-wrap fu4">
                    <div class="section-head">
                        <div class="section-head-icon">
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                                />
                            </svg>
                        </div>
                        <h2 class="section-title">Related Research</h2>
                    </div>
                    <div class="section-body">
                        <div class="related-grid">
                            @for ($i = 0; $i < 2; $i++)
                                <div class="related-card">
                                    <p class="related-tag">Similar Research</p>
                                    <p class="related-title">
                                        {{ ['Advanced Neural Network Optimization', 'Quantum Computing Applications'][$i] }}
                                    </p>
                                    <p class="related-desc">
                                        {{ ['Exploring state-of-the-art techniques for neural network efficiency and performance.', 'Contemporary approaches to quantum computational advantage in applied settings.'][$i] }}
                                    </p>
                                    <div class="related-meta">
                                        <span>
                                            {{ rand(20, 100) }} citations
                                        </span>
                                        <span class="dot">•</span>
                                        <span>
                                            {{ rand(500, 3000) }} downloads
                                        </span>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            {{-- /page-wrap --}}
        </main>

        {{-- Footer --}}
        <footer class="site-footer">
            <div class="footer-inner">
                <p class="footer-text">
                    © {{ now()->year }} Journal System. All rights reserved.
                </p>
                <div class="footer-links">
                    <a href="/">Home</a>
                    <a href="/">Browse Papers</a>
                    <a href="/">Submit Research</a>
                </div>
            </div>
        </footer>

        {{-- Citation Modal --}}
        <div id="citationModal" class="modal-overlay">
            <div class="modal-box">
                <div class="modal-head">
                    <h2 class="modal-title">Cite This Paper</h2>
                    <button class="modal-close" onclick="closeCitationModal()">
                        ✕
                    </button>
                </div>
                <div class="modal-body">
                    <div class="citation-tabs">
                        <button
                            class="tab-btn active"
                            onclick="switchCitationStyle(this, 'apa')"
                        >
                            APA
                        </button>
                        <button
                            class="tab-btn"
                            onclick="switchCitationStyle(this, 'chicago')"
                        >
                            Chicago
                        </button>
                        <button
                            class="tab-btn"
                            onclick="switchCitationStyle(this, 'mla')"
                        >
                            MLA
                        </button>
                        <button
                            class="tab-btn"
                            onclick="switchCitationStyle(this, 'harvard')"
                        >
                            Harvard
                        </button>
                    </div>
                    <div id="apa" class="citation-content active"></div>
                    <div id="chicago" class="citation-content"></div>
                    <div id="mla" class="citation-content"></div>
                    <div id="harvard" class="citation-content"></div>
                    <button class="btn-copy" onclick="copyCitation()">
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
                            />
                        </svg>
                        Copy Citation
                    </button>
                </div>
            </div>
        </div>

        <script>
            let currentPaperData = {};

            function openCitationModal() {
                const button = event.target.closest('button');
                currentPaperData = {
                    title: button.getAttribute('data-paper-title'),
                    author: button.getAttribute('data-paper-author'),
                    year: button.getAttribute('data-publication-year'),
                    category: button.getAttribute('data-category'),
                    journal: 'Journal System',
                    doi: Math.floor(Math.random() * 100000),
                    url: window.location.href,
                };
                generateCitations();
                document.getElementById('citationModal').classList.add('show');
            }

            function closeCitationModal() {
                document
                    .getElementById('citationModal')
                    .classList.remove('show');
            }

            function generateCitations() {
                const d = currentPaperData;
                document.getElementById('apa').innerHTML =
                    `${d.author}. (${d.year}). ${d.title}. <i>${d.journal}</i>. https://doi.org/10.1234/js.${d.doi}`;
                document.getElementById('chicago').innerHTML =
                    `${d.author}. "${d.title}." <i>${d.journal}</i> (${d.year}). Accessed ${new Date().toLocaleDateString()} ${d.url}.`;
                document.getElementById('mla').innerHTML =
                    `${d.author}. "${d.title}." <i>${d.journal}</i>, ${d.year}, ${d.url}. DOI: 10.1234/js.${d.doi}.`;
                document.getElementById('harvard').innerHTML =
                    `${d.author}, ${d.year}. ${d.title}. <i>${d.journal}</i>. Available at: ${d.url} (Accessed: ${new Date().toLocaleDateString()}).`;
            }

            function switchCitationStyle(button, style) {
                document
                    .querySelectorAll('.tab-btn')
                    .forEach((b) => b.classList.remove('active'));
                document
                    .querySelectorAll('.citation-content')
                    .forEach((d) => d.classList.remove('active'));
                button.classList.add('active');
                document.getElementById(style).classList.add('active');
            }

            function copyCitation() {
                const active = document.querySelector(
                    '.citation-content.active',
                );
                if (active) {
                    navigator.clipboard.writeText(active.innerText).then(() => {
                        const btn = event.target.closest('button');
                        const orig = btn.innerHTML;
                        btn.innerHTML = '✓ Copied!';
                        setTimeout(() => {
                            btn.innerHTML = orig;
                        }, 2000);
                    });
                }
            }

            window.onclick = function (e) {
                const modal = document.getElementById('citationModal');
                if (e.target === modal) modal.classList.remove('show');
            };
        </script>
    </body>
</html>
