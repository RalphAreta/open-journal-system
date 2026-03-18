<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ $paper['title'] }} - Published Paper</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap"
            rel="stylesheet"
        />
        <style>
            /* ── Reset & Base ── */
            *,
            *::before,
            *::after {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }
            html {
                scroll-behavior: smooth;
            }
            body {
                font-family: 'DM Sans', system-ui, sans-serif;
                background: #f7f3ec;
                color: #1a202c;
                min-height: 100vh;
            }

            /* ── CSS Variables ── */
            :root {
                --teal: #2d8176;
                --teal-dark: #1a5e56;
                --teal-light: #3a9e91;
                --gold: #c9a84c;
                --gold-light: #f0d678;
                --gold-dim: rgba(201, 168, 76, 0.12);
                --cream: #f7f3ec;
                --cream-mid: #ede8df;
                --border: #e2ddd4;
                --text-muted: #6a7890;
                --text-body: #374151;
            }

            .font-playfair {
                font-family: 'Playfair Display', Georgia, serif;
            }

            /* ── Keyframes ── */
            @keyframes shimmer {
                0% {
                    background-position: -200% 0;
                }
                100% {
                    background-position: 200% 0;
                }
            }
            @keyframes fadeUp {
                from {
                    opacity: 0;
                    transform: translateY(16px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }
            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(24px) scale(0.98);
                }
                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }
            @keyframes pulse-dot {
                0%,
                100% {
                    box-shadow: 0 0 0 0 rgba(201, 168, 76, 0.6);
                }
                50% {
                    box-shadow: 0 0 0 5px rgba(201, 168, 76, 0);
                }
            }
            .fade-up {
                animation: fadeUp 0.65s cubic-bezier(0.22, 0.68, 0, 1.2) both;
            }

            /* ── Shimmer bar ── */
            .shimmer-bar {
                background: linear-gradient(
                    90deg,
                    transparent 0%,
                    rgba(201, 168, 76, 0.2) 30%,
                    rgba(240, 214, 120, 0.8) 50%,
                    rgba(201, 168, 76, 0.2) 70%,
                    transparent 100%
                );
                background-size: 200% 100%;
                animation: shimmer 3.5s linear infinite;
            }

            /* ══ HEADER ══ */
            .site-header {
                position: sticky;
                top: 0;
                z-index: 50;
                background: rgba(255, 255, 255, 0.92);
                backdrop-filter: blur(16px);
                border-bottom: 1px solid var(--border);
            }
            .header-inner {
                max-width: 68rem;
                margin: 0 auto;
                padding: 0.875rem 1.5rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .header-logo {
                display: flex;
                align-items: center;
                gap: 0.6rem;
                text-decoration: none;
            }
            .logo-icon {
                width: 2rem;
                height: 2rem;
                border-radius: 8px;
                background: linear-gradient(
                    135deg,
                    var(--teal),
                    var(--teal-dark)
                );
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 2px 8px rgba(45, 129, 118, 0.3);
            }
            .logo-text {
                font-family: 'Playfair Display', serif;
                font-size: 1.1rem;
                font-weight: 700;
                color: var(--teal);
            }
            .back-link {
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                font-size: 0.8rem;
                font-weight: 500;
                color: var(--text-muted);
                text-decoration: none;
                padding: 0.4rem 0.875rem;
                border: 1px solid var(--border);
                border-radius: 999px;
                transition:
                    color 0.2s,
                    border-color 0.2s,
                    background 0.2s;
            }
            .back-link:hover {
                color: var(--teal);
                border-color: var(--teal);
                background: rgba(45, 129, 118, 0.04);
            }

            /* ══ HERO ══ */
            .paper-hero {
                background: linear-gradient(
                    160deg,
                    var(--teal-dark) 0%,
                    var(--teal) 50%,
                    #246059 100%
                );
                position: relative;
                overflow: hidden;
                padding: 4rem 1.5rem 3.5rem;
            }
            .paper-hero::before {
                content: '';
                position: absolute;
                inset: 0;
                background-image: radial-gradient(
                    circle,
                    rgba(255, 255, 255, 0.06) 1px,
                    transparent 1px
                );
                background-size: 26px 26px;
                pointer-events: none;
            }
            .paper-hero::after {
                content: '';
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(
                        ellipse 70% 60% at 90% 10%,
                        rgba(201, 168, 76, 0.2) 0%,
                        transparent 55%
                    ),
                    radial-gradient(
                        ellipse 50% 70% at 0% 100%,
                        rgba(0, 0, 0, 0.3) 0%,
                        transparent 50%
                    );
                pointer-events: none;
            }
            .hero-shimmer {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 2px;
                z-index: 10;
            }
            .hero-inner {
                position: relative;
                z-index: 5;
                max-width: 52rem;
                margin: 0 auto;
            }

            .category-badge {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.3rem 0.875rem;
                border: 1px solid rgba(255, 255, 255, 0.25);
                background: rgba(0, 0, 0, 0.2);
                border-radius: 999px;
                font-size: 0.65rem;
                letter-spacing: 0.14em;
                text-transform: uppercase;
                color: var(--gold-light);
                font-weight: 600;
                margin-bottom: 1.5rem;
            }
            .pulse-dot {
                width: 0.45rem;
                height: 0.45rem;
                border-radius: 50%;
                background: var(--gold);
                animation: pulse-dot 2s ease-in-out infinite;
            }
            .paper-title {
                font-family: 'Playfair Display', serif;
                font-size: clamp(1.75rem, 4vw, 2.75rem);
                font-weight: 700;
                line-height: 1.2;
                color: #fff;
                text-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
                margin-bottom: 2rem;
            }
            .paper-meta-row {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 1.5rem;
                padding-top: 1.5rem;
                border-top: 1px solid rgba(255, 255, 255, 0.15);
            }
            .meta-item {
                display: flex;
                flex-direction: column;
                gap: 0.2rem;
            }
            .meta-label {
                font-size: 0.6rem;
                letter-spacing: 0.14em;
                text-transform: uppercase;
                color: rgba(255, 255, 255, 0.55);
                font-weight: 600;
            }
            .meta-value {
                font-size: 0.9rem;
                font-weight: 600;
                color: #fff;
            }
            .meta-divider {
                width: 1px;
                height: 2.5rem;
                background: rgba(255, 255, 255, 0.2);
            }

            /* ══ LAYOUT ══ */
            .main-wrap {
                max-width: 68rem;
                margin: 0 auto;
                padding: 2.5rem 1.5rem 5rem;
                display: grid;
                grid-template-columns: 1fr 280px;
                gap: 2rem;
                align-items: start;
                position: relative;
                z-index: 1;
            }
            @media (max-width: 900px) {
                .main-wrap {
                    grid-template-columns: 1fr;
                }
                .main-wrap > aside {
                    order: -1;
                }
            }

            .main-wrap > aside {
                display: flex;
                flex-direction: column;
            }

            .section-heading {
                font-family: 'Playfair Display', serif;
                font-size: 1.2rem;
                font-weight: 700;
                color: var(--teal-dark);
                display: flex;
                align-items: center;
                gap: 0.6rem;
                margin-bottom: 1rem;
            }
            .section-heading::after {
                content: '';
                flex: 1;
                height: 1px;
                background: linear-gradient(90deg, var(--border), transparent);
            }
            .section-icon {
                width: 1.6rem;
                height: 1.6rem;
                border-radius: 7px;
                background: var(--gold-dim);
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--gold);
                flex-shrink: 0;
            }

            .card {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(8px);
                border: 1px solid var(--border);
                border-radius: 16px;
                overflow: hidden;
            }
            .card-body {
                padding: 1.75rem;
            }

            /* Stats */
            .stats-card {
                background: rgba(255, 255, 255, 0.9);
                border: 1px solid var(--border);
                border-radius: 16px;
                overflow: hidden;
                margin-bottom: 2rem;
            }
            .stats-inner {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                padding: 1.25rem 1.75rem;
            }
            .stat-cell {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 0.75rem;
            }
            .stat-cell + .stat-cell {
                border-left: 1px solid var(--border);
            }
            .stat-val {
                font-family: 'Playfair Display', serif;
                font-size: 2rem;
                font-weight: 700;
                color: var(--teal);
                line-height: 1;
                margin-bottom: 0.3rem;
            }
            .stat-lbl {
                font-size: 0.6rem;
                letter-spacing: 0.14em;
                text-transform: uppercase;
                color: var(--text-muted);
                font-weight: 600;
            }

            /* Abstract */
            .abstract-text {
                font-size: 0.9rem;
                line-height: 1.85;
                color: var(--text-body);
                border-left: 3px solid var(--gold);
                padding-left: 1.25rem;
            }

            /* Keywords */
            .keyword-list {
                display: flex;
                flex-wrap: wrap;
                gap: 0.6rem;
            }
            .keyword-tag {
                display: inline-flex;
                align-items: center;
                gap: 0.35rem;
                padding: 0.35rem 0.875rem;
                background: rgba(45, 129, 118, 0.06);
                border: 1px solid rgba(45, 129, 118, 0.18);
                border-radius: 999px;
                font-size: 0.75rem;
                font-weight: 500;
                color: var(--teal);
                transition:
                    background 0.2s,
                    border-color 0.2s;
            }
            .keyword-tag:hover {
                background: rgba(45, 129, 118, 0.12);
                border-color: rgba(45, 129, 118, 0.35);
            }

            /* Download */
            .download-card {
                background: linear-gradient(
                    135deg,
                    var(--teal-dark) 0%,
                    var(--teal) 60%,
                    #3aaba0 100%
                );
                border-radius: 16px;
                overflow: hidden;
                position: relative;
            }
            .download-card::before {
                content: '';
                position: absolute;
                inset: 0;
                background-image: radial-gradient(
                    circle,
                    rgba(255, 255, 255, 0.05) 1px,
                    transparent 1px
                );
                background-size: 20px 20px;
                pointer-events: none;
            }
            .download-card::after {
                content: '';
                position: absolute;
                inset: 0;
                background: radial-gradient(
                    ellipse 80% 60% at 90% 0%,
                    rgba(201, 168, 76, 0.18) 0%,
                    transparent 55%
                );
                pointer-events: none;
            }
            .download-inner {
                position: relative;
                z-index: 2;
                padding: 1.75rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1.5rem;
                flex-wrap: wrap;
            }
            .download-text h3 {
                font-family: 'Playfair Display', serif;
                font-size: 1.1rem;
                font-weight: 700;
                color: #fff;
                margin-bottom: 0.35rem;
            }
            .download-text p {
                font-size: 0.8rem;
                color: rgba(255, 255, 255, 0.7);
            }
            .download-btn {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.7rem 1.5rem;
                background: rgba(255, 255, 255, 0.95);
                color: var(--teal-dark);
                font-size: 0.8rem;
                font-weight: 700;
                letter-spacing: 0.04em;
                text-transform: uppercase;
                border-radius: 10px;
                text-decoration: none;
                border: none;
                cursor: pointer;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
                transition:
                    transform 0.2s,
                    box-shadow 0.2s,
                    background 0.2s;
                white-space: nowrap;
            }
            .download-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
                background: #fff;
            }

            /* Cite button */
            .cite-btn {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.7rem 1.5rem;
                background: linear-gradient(
                    135deg,
                    var(--gold) 0%,
                    #a07830 100%
                );
                color: #fff;
                font-size: 0.8rem;
                font-weight: 700;
                letter-spacing: 0.04em;
                text-transform: uppercase;
                border: none;
                border-radius: 10px;
                cursor: pointer;
                box-shadow: 0 4px 16px rgba(160, 120, 48, 0.35);
                transition:
                    transform 0.2s,
                    box-shadow 0.2s;
            }
            .cite-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 24px rgba(160, 120, 48, 0.5);
            }

            /* Related */
            .related-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }
            @media (max-width: 600px) {
                .related-grid {
                    grid-template-columns: 1fr;
                }
            }
            .related-card {
                background: rgba(255, 255, 255, 0.9);
                border: 1.5px solid var(--border);
                border-radius: 14px;
                padding: 1.25rem;
                text-decoration: none;
                display: block;
                transition:
                    border-color 0.2s,
                    transform 0.2s,
                    box-shadow 0.2s;
            }
            .related-card:hover {
                border-color: var(--teal);
                transform: translateY(-2px);
                box-shadow: 0 8px 24px rgba(45, 129, 118, 0.1);
            }
            .related-tag {
                font-size: 0.6rem;
                font-weight: 700;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: var(--gold);
            }
            .related-title {
                font-family: 'Playfair Display', serif;
                font-size: 0.95rem;
                font-weight: 700;
                color: var(--teal-dark);
                margin: 0.5rem 0 0.4rem;
                line-height: 1.35;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .related-excerpt {
                font-size: 0.75rem;
                color: var(--text-muted);
                line-height: 1.55;
                margin-bottom: 0.75rem;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .related-stats {
                display: flex;
                align-items: center;
                gap: 0.4rem;
                font-size: 0.7rem;
                color: #a7b1c7;
            }

            /* ══ SIDEBAR ══ */
            .sidebar {
                display: flex;
                flex-direction: column;
                gap: 1.25rem;
            }
            .sidebar-card {
                background: rgba(255, 255, 255, 0.9);
                border: 1px solid var(--border);
                border-radius: 14px;
                overflow: hidden;
            }
            .sidebar-card-head {
                padding: 0.875rem 1.1rem;
                border-bottom: 1px solid var(--border);
                font-size: 0.65rem;
                font-weight: 700;
                letter-spacing: 0.14em;
                text-transform: uppercase;
                color: var(--text-muted);
                background: rgba(247, 243, 236, 0.6);
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            .sidebar-card-head svg {
                color: var(--gold);
            }
            .sidebar-card-body {
                padding: 1rem 1.1rem;
            }

            .info-row {
                display: flex;
                flex-direction: column;
                gap: 0.15rem;
                padding: 0.5rem 0;
                border-bottom: 1px solid var(--border);
            }
            .info-row:last-child {
                border-bottom: none;
            }
            .info-row-label {
                font-size: 0.6rem;
                font-weight: 600;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                color: var(--text-muted);
            }
            .info-row-value {
                font-size: 0.825rem;
                font-weight: 500;
                color: #1a202c;
            }

            .quick-action {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.6rem 0.75rem;
                border-radius: 10px;
                cursor: pointer;
                border: none;
                width: 100%;
                text-align: left;
                background: none;
                transition: background 0.15s;
                text-decoration: none;
            }
            .quick-action:hover {
                background: rgba(45, 129, 118, 0.06);
            }
            .qa-icon {
                width: 2rem;
                height: 2rem;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            .qa-label {
                font-size: 0.8rem;
                font-weight: 500;
                color: #374151;
            }
            .qa-sub {
                font-size: 0.65rem;
                color: var(--text-muted);
            }

            /* ══ CITATION MODAL ══ */
            .citation-modal {
                display: none;
                position: fixed;
                inset: 0;
                z-index: 1000;
                background: rgba(10, 20, 30, 0.55);
                backdrop-filter: blur(6px);
                align-items: center;
                justify-content: center;
            }
            .citation-modal.show {
                display: flex;
                animation: fadeIn 0.25s ease;
            }
            .modal-box {
                background: #fff;
                border-radius: 20px;
                width: 90%;
                max-width: 38rem;
                max-height: 85vh;
                overflow-y: auto;
                box-shadow: 0 32px 80px rgba(0, 0, 0, 0.25);
                animation: slideUp 0.3s cubic-bezier(0.22, 0.68, 0, 1.2);
                position: relative;
                overflow: hidden;
            }
            .modal-top-bar {
                height: 3px;
                background: linear-gradient(90deg, var(--teal-dark) 0%, var(--teal) 100%);
            }
            .modal-inner {
                padding: 2rem;
            }
            .modal-close {
                position: absolute;
                right: 1.25rem;
                top: 1.25rem;
                width: 2rem;
                height: 2rem;
                border-radius: 50%;
                background: var(--cream);
                border: 1px solid var(--border);
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                color: var(--text-muted);
                font-size: 1rem;
                transition:
                    background 0.2s,
                    color 0.2s;
                z-index: 5;
            }
            .modal-close:hover {
                background: #fee2e2;
                color: #dc2626;
                border-color: #fecaca;
            }
            .modal-title {
                font-family: 'Playfair Display', serif;
                font-size: 1.4rem;
                font-weight: 700;
                color: var(--teal-dark);
                margin-bottom: 0.35rem;
            }
            .modal-subtitle {
                font-size: 0.8rem;
                color: var(--text-muted);
                margin-bottom: 1.5rem;
            }

            .citation-tabs {
                display: flex;
                gap: 0.4rem;
                flex-wrap: wrap;
                margin-bottom: 1.25rem;
            }
            .citation-tab-btn {
                padding: 0.4rem 0.875rem;
                border: 1.5px solid var(--border);
                background: var(--cream);
                color: var(--text-muted);
                border-radius: 999px;
                font-size: 0.72rem;
                font-weight: 600;
                letter-spacing: 0.04em;
                cursor: pointer;
                transition:
                    border-color 0.2s,
                    background 0.2s,
                    color 0.2s;
            }
            .citation-tab-btn:hover {
                border-color: var(--teal);
                color: var(--teal);
            }
            .citation-tab-btn.active {
                background: var(--teal);
                color: #fff;
                border-color: var(--teal);
            }

            .citation-content {
                display: none;
                padding: 1rem 1.1rem;
                background: var(--cream);
                border: 1px solid var(--border);
                border-left: 3px solid var(--gold);
                border-radius: 10px;
                font-size: 0.8rem;
                line-height: 1.75;
                color: var(--text-body);
                word-break: break-word;
            }
            .citation-content.active {
                display: block;
            }

            .copy-btn {
                margin-top: 1rem;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.6rem 1.25rem;
                background: linear-gradient(
                    135deg,
                    var(--teal) 0%,
                    var(--teal-dark) 100%
                );
                color: #fff;
                font-size: 0.78rem;
                font-weight: 600;
                border: none;
                border-radius: 10px;
                cursor: pointer;
                box-shadow: 0 4px 14px rgba(45, 129, 118, 0.35);
                transition:
                    transform 0.2s,
                    box-shadow 0.2s;
            }
            .copy-btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 20px rgba(45, 129, 118, 0.45);
            }

            /* ══ FOOTER ══ */
            .site-footer {
                background: rgba(255, 255, 255, 0.9);
                border-top: 1px solid var(--border);
                padding: 2.5rem 1.5rem;
            }
            .footer-inner {
                max-width: 68rem;
                margin: 0 auto;
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
            }
            .footer-brand {
                font-family: 'Playfair Display', serif;
                font-size: 0.9rem;
                font-weight: 700;
                color: var(--teal);
            }
            .footer-copy {
                font-size: 0.75rem;
                color: var(--text-muted);
            }
            .footer-links {
                display: flex;
                gap: 1.5rem;
            }
            .footer-links a {
                font-size: 0.78rem;
                color: var(--text-muted);
                text-decoration: none;
                transition: color 0.2s;
            }
            .footer-links a:hover {
                color: var(--teal);
            }

            /* Scroll reveal */
            .reveal {
                opacity: 0;
                transform: translateY(16px);
                transition:
                    opacity 0.6s ease,
                    transform 0.6s cubic-bezier(0.22, 0.68, 0, 1.2);
            }
            .reveal.visible {
                opacity: 1;
                transform: translateY(0);
            }

            /* Page texture */
            .page-texture {
                position: fixed;
                inset: 0;
                pointer-events: none;
                z-index: 0;
                opacity: 0.025;
                background-image: repeating-linear-gradient(
                    -50deg,
                    #8a6520 0px,
                    #8a6520 1px,
                    transparent 1px,
                    transparent 22px
                );
            }
        </style>
    </head>
    <body>
        <div class="page-texture"></div>

        {{-- Decorative Top Bar --}}
        <div style="height: 12px; background: linear-gradient(90deg, var(--teal-dark) 0%, var(--teal) 50%, #3aaba0 100%);"></div>

        {{-- HEADER --}}
        <header style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(8px); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 50;">
            <div style="max-width: 90rem; margin: 0 auto; padding: 0 1.5rem; height: 5rem; display: flex; justify-content: space-between; align-items: center;">
                <a href="/" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; group: true;">
                    <div style="width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center; background: var(--teal-dark); border-radius: 50%; border: 1px solid rgba(201, 168, 76, 0.3); box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <svg class="text-[#f0d678] w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div style="display: flex; flex-direction: column;">
                        <span style="font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 700; color: var(--teal-dark); line-height: 1;">Journal System</span>
                        <span style="font-size: 0.5625rem; font-weight: 700; color: var(--gold); text-transform: uppercase; letter-spacing: 0.0625rem;">Academic Publishing Portal</span>
                    </div>
                </a>

                <div style="display: none; gap: 2rem; margin-left: auto;">
                    <a href="/published-papers" style="font-size: 0.875rem; font-weight: 700; color: var(--teal-dark); text-decoration: none; transition: color 0.2s;">
                        Published Papers
                    </a>
                </div>

                <div style="display: flex; gap: 2rem; align-items: center; margin-left: auto;">
                    <a href="/" style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem; transition: color 0.2s;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        Back to Home
                    </a>
                </div>
            </div>
        </header>

        {{-- HERO --}}
        <div class="paper-hero">
            <div class="hero-shimmer shimmer-bar"></div>
            <div class="hero-inner">
                <div class="fade-up" style="animation-delay: 0.05s">
                    <div class="category-badge">
                        <span class="pulse-dot"></span>
                        {{ $paper['category'] }}
                    </div>
                </div>
                <h1 class="paper-title fade-up" style="animation-delay: 0.15s">
                    {{ $paper['title'] }}
                </h1>
                <div
                    class="paper-meta-row fade-up"
                    style="animation-delay: 0.28s"
                >
                    <div class="meta-item">
                        <span class="meta-label">Author</span>
                        <span class="meta-value">{{ $paper['author'] }}</span>
                    </div>
                    <div class="meta-divider"></div>
                    <div class="meta-item">
                        <span class="meta-label">Published</span>
                        <span class="meta-value">
                            {{ $paper['publishedAt']->format('M d, Y') }}
                        </span>
                    </div>
                    <div class="meta-divider"></div>
                    <div class="meta-item">
                        <span class="meta-label">Volume</span>
                        <span class="meta-value">Vol. 8, No. 1</span>
                    </div>
                    <div class="meta-divider"></div>
                    <div class="meta-item">
                        <span class="meta-label">DOI</span>
                        <span
                            class="meta-value"
                            style="font-size: 0.75rem; opacity: 0.85"
                        >
                            10.1234/js.{{ $paper['id'] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN --}}
        <div class="main-wrap">
            {{-- Primary Column --}}
            <main>
                {{-- Stats --}}
                <div class="stats-card reveal">
                    <div style="height: 3px" class="shimmer-bar"></div>
                    <div class="stats-inner">
                        <div class="stat-cell">
                            <div class="stat-val">
                                {{ $paper['citations'] }}
                            </div>
                            <div class="stat-lbl">Citations</div>
                        </div>
                        <div class="stat-cell">
                            <div class="stat-val">
                                {{ $paper['downloads'] }}
                            </div>
                            <div class="stat-lbl">Downloads</div>
                        </div>
                        <div class="stat-cell">
                            <div class="stat-val">{{ $paper['reviews'] }}</div>
                            <div class="stat-lbl">Peer Reviews</div>
                        </div>
                    </div>
                </div>

                {{-- Abstract Section --}}
                <div class="paper-section reveal" style="transition-delay:.05s">
                    <div class="section-heading">
                        <div class="section-icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 12h6m-6 4h4M7 20H5a2 2 0 01-2-2V5a2 2 0 012-2h6.414a2 2 0 011.414.586l4.586 4.586A2 2 0 0117 9.414V15a2 2 0 01-2 2h-4v4a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        Abstract
                    </div>
                    <div class="card">
                        <div class="card-body" style="border-left: 4px solid var(--gold); background: var(--cream);">
                            <p style="font-size:.85rem;color:var(--text-body);line-height:1.75;margin:0">
                                {{ $paper['abstract'] ?? 'Lorem ipsum dolor es ma et al' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Keywords Section --}}
                <div class="paper-section reveal" style="transition-delay:.1s">
                    <div class="section-heading">
                        <div class="section-icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        Keywords
                    </div>
                    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; padding: 0;">
                        @if(isset($paper['keywords']) && is_array($paper['keywords']) && count($paper['keywords']) > 0)
                            @foreach($paper['keywords'] as $keyword)
                                <span style="display: inline-block; padding: 0.5rem 1rem; background: rgba(45, 129, 118, 0.08); border: 1px solid rgba(45, 129, 118, 0.3); color: var(--teal); border-radius: 999px; font-size: 0.8rem; font-weight: 500;">
                                    {{ $keyword }}
                                </span>
                            @endforeach
                        @else
                            <span style="display: inline-block; padding: 0.5rem 1rem; background: rgba(45, 129, 118, 0.08); border: 1px solid rgba(45, 129, 118, 0.3); color: var(--teal); border-radius: 999px; font-size: 0.8rem; font-weight: 500;">Keyword 1</span>
                            <span style="display: inline-block; padding: 0.5rem 1rem; background: rgba(45, 129, 118, 0.08); border: 1px solid rgba(45, 129, 118, 0.3); color: var(--teal); border-radius: 999px; font-size: 0.8rem; font-weight: 500;">Keyword 2</span>
                            <span style="display: inline-block; padding: 0.5rem 1rem; background: rgba(45, 129, 118, 0.08); border: 1px solid rgba(45, 129, 118, 0.3); color: var(--teal); border-radius: 999px; font-size: 0.8rem; font-weight: 500;">Keyword 3</span>
                        @endif
                    </div>
                </div>

                {{-- Access Paper Section --}}
                <div class="paper-section reveal" style="transition-delay:.15s">
                    <div class="section-heading">
                        <div class="section-icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm8-5.5V5a2 2 0 00-2-2H6a2 2 0 00-2 2v6.5"/>
                            </svg>
                        </div>
                        Access Paper
                    </div>
                    <div class="download-card">
                        <div class="download-inner">
                            <div class="download-text">
                                <h3>Full Paper Available</h3>
                                <p>Download the complete PDF to access methodology, results, and references.</p>
                            </div>
                            <a href="{{ route('papers.download', ['submission' => $paper['id']]) }}" class="download-btn">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Download PDF
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Citation Section --}}
                <div class="paper-section reveal" style="transition-delay:.2s">
                    <div class="section-heading">
                        <div class="section-icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        Citation
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <p style="font-size:.82rem;color:var(--text-muted);margin-bottom:1.25rem">
                                Choose your preferred citation style or export to reference management software.
                            </p>
                            <div style="display: flex; gap: 0.75rem; flex-direction: column">
                                <!-- Cite Modal Button -->
                                <button class="cite-btn" onclick="openCitationModal()"
                                    data-paper-title="{{ $paper['title'] }}"
                                    data-paper-author="{{ $paper['author'] }}"
                                    data-publication-year="{{ $paper['publishedAt']->format('Y') }}"
                                    data-category="{{ $paper['category'] }}"
                                    style="width: 100%; display: flex; align-items: center; justify-content: center;">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                                    </svg>
                                    CITE THIS PAPER
                                </button>

                                <!-- RIS Download Button -->
                                <a href="{{ route('papers.download-ris', ['submission' => $paper['id']]) }}" 
                                   class="cite-btn" 
                                   style="width: 100%; display: flex; align-items: center; justify-content: center; text-decoration: none; background-color: #c9a84c; color: #fff; border: none; cursor: pointer;"
                                   title="Download RIS format for Zotero, Mendeley, EndNote">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                        <polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                                    </svg>
                                    EXPORT AS RIS
                                </a>
                            </div>
                            <p style="font-size:.75rem;color:var(--text-muted);margin-top:0.75rem;text-align:center">
                                RIS format works with Zotero, Mendeley, EndNote, and other reference managers
                            </p>
                        </div>
                    </div>
                </div>
            </main>

            {{-- Sidebar --}}
            <aside style="width: 100%; max-width: 280px;">
                {{-- Paper Details --}}
                <div class="card" style="margin-bottom: 1.5rem;">
                    <div class="card-header" style="padding: 1rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 6v6l4 2"/>
                        </svg>
                        Paper Details
                    </div>
                    <div class="card-body" style="padding: 1rem;">
                        <div style="margin-bottom: 1.25rem;">
                            <p style="font-size: 0.7rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem;">Category</p>
                            <p style="font-size: 0.9rem; font-weight: 600; color: var(--text-body); margin: 0;">{{ $paper['category'] ?? 'Engineering' }}</p>
                        </div>
                        <div style="margin-bottom: 1.25rem;">
                            <p style="font-size: 0.7rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem;">Journal</p>
                            <p style="font-size: 0.9rem; font-weight: 600; color: var(--text-body); margin: 0;">Open Journal System</p>
                        </div>
                        <div style="margin-bottom: 1.25rem;">
                            <p style="font-size: 0.7rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem;">Volume / Issue</p>
                            <p style="font-size: 0.9rem; font-weight: 600; color: var(--text-body); margin: 0;">Vol. 8, No. 1</p>
                        </div>
                        <div style="margin-bottom: 1.25rem;">
                            <p style="font-size: 0.7rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem;">Pages</p>
                            <p style="font-size: 0.9rem; font-weight: 600; color: var(--text-body); margin: 0;">pp. 14–28</p>
                        </div>
                        <div style="margin-bottom: 1.25rem;">
                            <p style="font-size: 0.7rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem;">Language</p>
                            <p style="font-size: 0.9rem; font-weight: 600; color: var(--text-body); margin: 0;">English</p>
                        </div>
                    </div>
                </div>

                {{-- About the Author --}}
                <div class="card">
                    <div class="card-header" style="padding: 1rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        About the Author
                    </div>
                    <div class="card-body" style="padding: 1.5rem; text-align: center;">
                        <div style="width: 60px; height: 60px; margin: 0 auto 1rem; background: var(--teal); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.4rem;">
                            {{ substr($paper['author'] ?? 'RA', 0, 2) }}
                        </div>
                        <p style="font-size: 0.95rem; font-weight: 700; color: var(--text-body); margin: 0 0 0.25rem;">{{ $paper['author'] ?? 'Ralph Areta' }}</p>
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0 0 0.75rem;">Lead Researcher</p>
                        <p style="font-size: 0.8rem; color: var(--text-body); line-height: 1.6; margin: 0;">
                            Researcher and author contributing to the Open Journal System academic community.
                        </p>
                    </div>
                </div>
            </aside>
        </div>

        <script>
            /* Scroll reveal */
            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((e) => {
                        if (e.isIntersecting) e.target.classList.add('visible');
                    });
                },
                { threshold: 0.12 },
            );
            document
                .querySelectorAll('.reveal')
                .forEach((el) => observer.observe(el));

            /* Citation modal */
            let currentPaperData = {};

            function openCitationModal() {
                const btn = event.currentTarget;
                currentPaperData = {
                    title: btn.getAttribute('data-paper-title'),
                    author: btn.getAttribute('data-paper-author'),
                    year: btn.getAttribute('data-publication-year'),
                    journal: 'Open Journal System',
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
                    `${d.author}. (${d.year}). ${d.title}. <em>${d.journal}</em>. https://doi.org/10.1234/js.${d.doi}`;
                document.getElementById('chicago').innerHTML =
                    `${d.author}. "${d.title}." <em>${d.journal}</em> (${d.year}). Accessed ${new Date().toLocaleDateString()}. ${d.url}`;
                document.getElementById('mla').innerHTML =
                    `${d.author}. "${d.title}." <em>${d.journal}</em>, ${d.year}. DOI: 10.1234/js.${d.doi}.`;
                document.getElementById('harvard').innerHTML =
                    `${d.author}, ${d.year}. ${d.title}. <em>${d.journal}</em>. Available at: ${d.url} (Accessed: ${new Date().toLocaleDateString()}).`;
            }

            function switchCitationStyle(btn, style) {
                document
                    .querySelectorAll('.citation-tab-btn')
                    .forEach((b) => b.classList.remove('active'));
                document
                    .querySelectorAll('.citation-content')
                    .forEach((d) => d.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById(style).classList.add('active');
            }

            function copyCitation() {
                const active = document.querySelector(
                    '.citation-content.active',
                );
                if (!active) return;
                navigator.clipboard.writeText(active.innerText).then(() => {
                    const btn = event.currentTarget;
                    const orig = btn.innerHTML;
                    btn.innerHTML = `<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg> Copied!`;
                    setTimeout(() => {
                        btn.innerHTML = orig;
                    }, 2000);
                });
            }

            document
                .getElementById('citationModal')
                .addEventListener('click', function (e) {
                    if (e.target === this) closeCitationModal();
                });
        </script>

        {{-- Citation Modal --}}
        <div id="citationModal" class="citation-modal">
            <div class="modal-box">
                <div class="modal-top-bar"></div>
                <button class="modal-close" onclick="closeCitationModal()">&times;</button>
                <div class="modal-inner">
                    <h2 class="modal-title">Cite This Paper</h2>
                    <p class="modal-subtitle">Select a format and copy the formatted reference.</p>

                    <div class="citation-tabs">
                        <button class="citation-tab-btn active" onclick="switchCitationStyle(this, 'apa')">APA</button>
                        <button class="citation-tab-btn" onclick="switchCitationStyle(this, 'chicago')">Chicago</button>
                        <button class="citation-tab-btn" onclick="switchCitationStyle(this, 'mla')">MLA</button>
                        <button class="citation-tab-btn" onclick="switchCitationStyle(this, 'harvard')">Harvard</button>
                    </div>

                    <div id="apa" class="citation-content active"></div>
                    <div id="chicago" class="citation-content"></div>
                    <div id="mla" class="citation-content"></div>
                    <div id="harvard" class="citation-content"></div>

                    <button class="copy-btn" onclick="copyCitation()">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/></svg>
                        Copy Citation
                    </button>
                </div>
            </div>
        </div>
    </body>
</html>
