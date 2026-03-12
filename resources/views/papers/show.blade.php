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
                background: linear-gradient(135deg, #2d8176 0%, #239679 100%);
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                position: sticky;
                top: 0;
                z-index: 50;
                box-shadow: 0 4px 16px rgba(45, 129, 118, 0.15);
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
                transition: all 0.3s ease;
            }
            .nav-brand:hover {
                transform: translateX(-2px);
            }
            .nav-brand-icon {
                width: 44px;
                height: 44px;
                border-radius: 50%;
                background: linear-gradient(135deg, #c9a84c, #a07830);
                border: 2px solid rgba(255, 255, 255, 0.4);
                display: flex;
                align-items: center;
                justify-content: center;
                transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            }
            .nav-brand:hover .nav-brand-icon {
                transform: rotate(12deg) scale(1.08);
            }
            .nav-brand-text {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.4rem;
                font-weight: 700;
                color: #fff;
                letter-spacing: -0.5px;
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
                gap: 8px;
                font-size: 0.8rem;
                font-weight: 800;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                color: rgba(255, 255, 255, 0.9);
                text-decoration: none;
                padding: 10px 20px;
                border-radius: 8px;
                border: 1.5px solid rgba(255, 255, 255, 0.3);
                background: rgba(255, 255, 255, 0.1);
                transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
            }
            .nav-back:hover {
                background: rgba(255, 255, 255, 0.2);
                color: #f0d678;
                border-color: #f0d678;
                transform: translateX(-3px);
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
                padding: 64px 0 48px;
                border-bottom: 2px solid var(--parchment);
                margin-bottom: 48px;
                background: linear-gradient(135deg, rgba(45, 129, 118, 0.03) 0%, rgba(201, 168, 76, 0.02) 100%);
            }
            .paper-hero::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                width: 120px;
                height: 3px;
                background: linear-gradient(90deg, var(--teal), var(--gold), transparent);
                border-radius: 3px;
            }
            .paper-eyebrow {
                font-size: 12px;
                font-weight: 800;
                letter-spacing: 0.15em;
                text-transform: uppercase;
                color: var(--teal);
                margin-bottom: 14px;
                display: flex;
                align-items: center;
                gap: 10px;
            }
            .paper-eyebrow::before {
                content: '';
                width: 28px;
                height: 2px;
                background: linear-gradient(90deg, var(--teal), transparent);
                border-radius: 2px;
            }
            .paper-category-badge {
                display: inline-block;
                background: linear-gradient(135deg, rgba(45, 129, 118, 0.15), rgba(45, 129, 118, 0.08));
                color: var(--teal);
                padding: 8px 20px;
                border-radius: 24px;
                font-size: 0.75rem;
                font-weight: 900;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                border: 1.5px solid rgba(45, 129, 118, 0.3);
                margin-bottom: 18px;
                display: inline-block;
                backdrop-filter: blur(2px);
            }
            .paper-title {
                font-family: 'Libre Baskerville', serif;
                font-size: clamp(2rem, 5vw, 3.2rem);
                font-weight: 700;
                color: var(--ink);
                line-height: 1.15;
                letter-spacing: -0.015em;
                margin-bottom: 32px;
                max-width: 90%;
            }
            .paper-meta-row {
                display: flex;
                align-items: center;
                gap: 0;
                flex-wrap: wrap;
                border-top: 1.5px solid var(--border);
                padding-top: 28px;
            }
            .meta-block {
                padding: 0 40px 0 0;
            }
            .meta-block:first-child {
                padding-left: 0;
            }
            .meta-block + .meta-block {
                border-left: 1.5px solid var(--border);
                padding-left: 40px;
            }
            .meta-label {
                font-size: 0.67rem;
                font-weight: 900;
                letter-spacing: 0.15em;
                text-transform: uppercase;
                color: var(--teal);
                margin-bottom: 6px;
            }
            .meta-value {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.12rem;
                font-weight: 700;
                color: var(--ink);
            }

            /* ── STATS GRID ── */
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                background: linear-gradient(135deg, var(--parchment) 0%, #fefaf5 100%);
                border: 2px solid var(--border-dk);
                border-radius: 18px;
                overflow: hidden;
                box-shadow: 0 8px 32px rgba(26, 18, 9, 0.08);
                margin-bottom: 48px;
            }
            .stat-cell {
                padding: 32px 32px 28px;
                border-right: 1px solid var(--border);
                position: relative;
                transition: all 0.25s ease;
                cursor: default;
                background: transparent;
            }
            .stat-cell:last-child {
                border-right: none;
            }
            .stat-cell:hover {
                background: rgba(45, 129, 118, 0.04);
                transform: translateY(-2px);
            }
            .stat-lbl {
                font-size: 0.70rem;
                font-weight: 900;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: var(--teal);
                margin-bottom: 12px;
            }
            .stat-val {
                font-family: 'Libre Baskerville', serif;
                font-size: 3rem;
                font-weight: 700;
                line-height: 1;
                color: var(--teal);
                margin-bottom: 4px;
            }
            .stat-accent {
                position: absolute;
                bottom: 0;
                left: 32px;
                height: 3px;
                width: 0;
                border-radius: 3px;
                background: linear-gradient(90deg, var(--teal), var(--gold));
                transition: width 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            }
            .stat-cell:hover .stat-accent {
                width: 52px;
            }

            /* ── CONTENT SECTIONS ── */
            .section-wrap {
                background: #fff;
                border: 1.5px solid var(--border-dk);
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 4px 20px rgba(26, 18, 9, 0.06);
                margin-bottom: 32px;
                transition: all 0.3s ease;
            }
            .section-wrap:hover {
                box-shadow: 0 8px 32px rgba(26, 18, 9, 0.1);
                border-color: var(--teal);
            }
            .section-head {
                padding: 18px 32px 16px;
                background: linear-gradient(135deg, var(--parchment) 0%, rgba(232, 223, 208, 0.5) 100%);
                border-bottom: 1.5px solid var(--border);
                display: flex;
                align-items: center;
                gap: 14px;
            }
            .section-head-icon {
                width: 38px;
                height: 38px;
                border-radius: 10px;
                background: linear-gradient(135deg, rgba(45, 129, 118, 0.15), rgba(45, 129, 118, 0.08));
                color: var(--teal);
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                border: 1px solid rgba(45, 129, 118, 0.25);
            }
            .section-title {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.2rem;
                font-weight: 700;
                color: var(--ink);
                letter-spacing: -0.01em;
            }
            .section-body {
                padding: 32px 32px;
            }

            /* Abstract */
            .abstract-text {
                font-size: 1.02rem;
                color: var(--ink-mid);
                line-height: 1.92;
                letter-spacing: 0.3px;
            }

            /* Keywords */
            .keyword-chip {
                display: inline-flex;
                align-items: center;
                background: linear-gradient(135deg, rgba(45, 129, 118, 0.08), rgba(45, 129, 118, 0.04));
                color: var(--teal);
                padding: 8px 18px;
                border-radius: 12px;
                font-size: 0.88rem;
                font-weight: 700;
                border: 1.5px solid rgba(45, 129, 118, 0.25);
                transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
            }
            .keyword-chip:hover {
                background: var(--teal-lt);
                border-color: var(--teal);
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(45, 129, 118, 0.2);
            }

            /* Download */
            .download-banner {
                background: linear-gradient(
                    135deg,
                    var(--teal) 0%,
                    #239679 50%,
                    var(--teal-dk) 100%
                );
                border-radius: 14px;
                padding: 36px 40px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 24px;
                flex-wrap: wrap;
                position: relative;
                overflow: hidden;
                box-shadow: 0 12px 32px rgba(45, 129, 118, 0.25);
            }
            .download-banner::before {
                content: '';
                position: absolute;
                top: -40px;
                right: -40px;
                width: 140px;
                height: 140px;
                border-radius: 50%;
                background: rgba(201, 168, 76, 0.15);
            }
            .download-banner::after {
                content: '';
                position: absolute;
                bottom: -30px;
                left: -30px;
                width: 100px;
                height: 100px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.08);
            }
            .download-banner-text {
                font-size: 1.05rem;
                color: rgba(255, 255, 255, 0.95);
                line-height: 1.6;
                position: relative;
                z-index: 1;
            }
            .download-banner-text strong {
                display: block;
                font-family: 'Libre Baskerville', serif;
                font-size: 1.28rem;
                color: #fff;
                margin-bottom: 6px;
                font-weight: 700;
            }
            .btn-download {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                background: linear-gradient(135deg, var(--gold), #a07830);
                color: #fff;
                font-size: 0.82rem;
                font-weight: 900;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                padding: 14px 32px;
                border-radius: 10px;
                text-decoration: none;
                border: none;
                cursor: pointer;
                transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
                box-shadow: 0 6px 20px rgba(201, 168, 76, 0.35);
                white-space: nowrap;
                flex-shrink: 0;
                position: relative;
                z-index: 1;
            }
            .btn-download:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 32px rgba(201, 168, 76, 0.5);
            }
            .btn-download:active {
                transform: translateY(-1px);
            }

            /* Citation */
            .btn-cite {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                background: linear-gradient(135deg, var(--teal), #239679);
                color: #fff;
                font-size: 0.82rem;
                font-weight: 900;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                padding: 14px 32px;
                border-radius: 10px;
                border: none;
                cursor: pointer;
                transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
                box-shadow: 0 6px 20px rgba(45, 129, 118, 0.3);
            }
            .btn-cite:hover {
                background: linear-gradient(135deg, var(--teal-dk), #1a4d46);
                transform: translateY(-3px);
                box-shadow: 0 10px 32px rgba(45, 129, 118, 0.4);
            }
            .btn-cite:active {
                transform: translateY(-1px);
            }

            /* Related papers */
            .related-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
            @media (max-width: 640px) {
                .related-grid {
                    grid-template-columns: 1fr;
                }
            }
            .related-card {
                background: linear-gradient(135deg, var(--parchment) 0%, rgba(232, 223, 208, 0.5) 100%);
                border: 1.5px solid var(--border);
                border-radius: 12px;
                padding: 24px 26px;
                transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
                cursor: pointer;
            }
            .related-card:hover {
                background: #fff;
                border-color: var(--teal);
                transform: translateY(-4px);
                box-shadow: 0 12px 32px rgba(45, 129, 118, 0.15);
            }
            .related-tag {
                font-size: 0.68rem;
                font-weight: 900;
                letter-spacing: 0.13em;
                text-transform: uppercase;
                color: var(--teal);
                margin-bottom: 12px;
            }
            .related-title {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.08rem;
                font-weight: 700;
                font-style: italic;
                color: var(--ink);
                line-height: 1.45;
                margin-bottom: 12px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                transition: color 0.2s;
            }
            .related-card:hover .related-title {
                color: var(--teal);
            }
            .related-desc {
                font-size: 0.88rem;
                color: var(--ink-soft);
                line-height: 1.6;
                margin-bottom: 16px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .related-meta {
                display: flex;
                align-items: center;
                gap: 10px;
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
                background: rgba(26, 18, 9, 0.7);
                backdrop-filter: blur(4px);
                animation: fadeIn 0.3s ease;
                align-items: center;
                justify-content: center;
            }
            .modal-overlay.show {
                display: flex;
            }
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    backdrop-filter: blur(0);
                }
                to {
                    opacity: 1;
                    backdrop-filter: blur(4px);
                }
            }
            .modal-box {
                background: #fff;
                border: 1.5px solid var(--border-dk);
                border-radius: 18px;
                max-width: 640px;
                width: 90%;
                max-height: 85vh;
                overflow-y: auto;
                box-shadow: 0 32px 96px rgba(26, 18, 9, 0.3);
                animation: slideUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
                position: relative;
            }
            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(32px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .modal-head {
                padding: 24px 32px 20px;
                background: linear-gradient(135deg, var(--parchment) 0%, rgba(232, 223, 208, 0.5) 100%);
                border-bottom: 1.5px solid var(--border);
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .modal-title {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.3rem;
                font-weight: 700;
                color: var(--ink);
            }
            .modal-close {
                width: 36px;
                height: 36px;
                border-radius: 10px;
                background: none;
                border: 1.5px solid var(--border);
                color: var(--ink-soft);
                font-size: 1.2rem;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s;
            }
            .modal-close:hover {
                border-color: var(--teal);
                color: var(--teal);
                background: var(--teal-lt);
                transform: rotate(90deg);
            }
            .modal-body {
                padding: 32px;
            }
            .citation-tabs {
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
                margin-bottom: 20px;
            }
            .tab-btn {
                padding: 9px 18px;
                border: 1.5px solid var(--border-dk);
                background: var(--parchment);
                color: var(--ink-soft);
                border-radius: 8px;
                font-size: 0.77rem;
                font-weight: 800;
                letter-spacing: 0.08em;
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
                background: linear-gradient(135deg, var(--teal), #239679);
                color: #fff;
                border-color: var(--teal);
            }
            .citation-content {
                display: none;
                padding: 18px 22px;
                background: var(--parchment);
                border: 1.5px solid var(--border);
                border-left: 4px solid var(--gold);
                border-radius: 10px;
                font-family: 'Courier New', monospace;
                font-size: 0.88rem;
                line-height: 1.8;
                word-wrap: break-word;
                color: var(--ink-mid);
            }
            .citation-content.active {
                display: block;
            }
            .btn-copy {
                margin-top: 18px;
                display: inline-flex;
                align-items: center;
                gap: 10px;
                background: linear-gradient(135deg, var(--teal), #239679);
                color: #fff;
                font-size: 0.77rem;
                font-weight: 900;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                padding: 12px 28px;
                border-radius: 10px;
                border: none;
                cursor: pointer;
                transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
                box-shadow: 0 6px 20px rgba(45, 129, 118, 0.3);
            }
            .btn-copy:hover {
                background: linear-gradient(135deg, var(--teal-dk), #1a4d46);
                transform: translateY(-2px);
                box-shadow: 0 10px 32px rgba(45, 129, 118, 0.4);
            }

            /* ── FOOTER ── */
            .site-footer {
                background: linear-gradient(135deg, #1a4d46 0%, #0d2a25 100%);
                border-top: 2px solid rgba(201, 168, 76, 0.15);
                margin-top: 80px;
                padding: 56px 0;
            }
            .footer-inner {
                max-width: 1100px;
                margin: 0 auto;
                padding: 0 24px;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 20px;
            }
            .footer-text {
                font-size: 0.85rem;
                color: rgba(255, 255, 255, 0.6);
                letter-spacing: 0.5px;
            }
            .footer-links {
                display: flex;
                gap: 32px;
            }
            .footer-links a {
                font-size: 0.82rem;
                color: rgba(255, 255, 255, 0.6);
                text-decoration: none;
                font-weight: 600;
                transition: all 0.2s;
            }
            .footer-links a:hover {
                color: #f0d678;
                text-decoration: underline;
            }

            /* Animations */
            .fu {
                animation: fu 0.5s ease both;
            }
            .fu1 {
                animation: fu 0.5s 0.1s ease both;
            }
            .fu2 {
                animation: fu 0.5s 0.2s ease both;
            }
            .fu3 {
                animation: fu 0.5s 0.3s ease both;
            }
            .fu4 {
                animation: fu 0.5s 0.4s ease both;
            }
            @keyframes fu {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @media (max-width: 640px) {
                .paper-meta-row {
                    flex-direction: column;
                    gap: 20px;
                }
                .meta-block + .meta-block {
                    border-left: none;
                    padding-left: 0;
                    border-top: 1.5px solid var(--border);
                    padding-top: 20px;
                }
                .download-banner {
                    flex-direction: column;
                    text-align: center;
                }
                .stats-grid {
                    grid-template-columns: 1fr;
                }
                .stat-cell + .stat-cell {
                    border-right: none;
                    border-top: 1.5px solid var(--border);
                }
                .paper-title {
                    font-size: clamp(1.6rem, 3.5vw, 2.4rem);
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
