<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ $heroTitle }} | Journal System</title>

        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap"
            rel="stylesheet"
        />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * {
                box-sizing: border-box;
            }
            body {
                font-family: 'Source Sans 3', sans-serif;
                scroll-behavior: smooth;
            }
            .font-libre {
                font-family: 'Libre Baskerville', serif;
            }

            .nav-shimmer {
                background: linear-gradient(
                    90deg,
                    transparent,
                    #c9a84c,
                    #f0d678,
                    #c9a84c,
                    transparent
                );
                background-size: 200% 100%;
                animation: lpShimmer 3s linear infinite;
            }

            @keyframes lpShimmer {
                0% {
                    background-position: -100% 0;
                }
                100% {
                    background-position: 100% 0;
                }
            }

            .card-hover-depth {
                transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            }

            @media (hover: hover) {
                .card-hover-depth:hover {
                    transform: translateY(-12px);
                    box-shadow: 0 28px 48px rgba(45, 129, 118, 0.2);
                }
            }

            #scroll-top-btn {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                transform: translateY(100px);
                opacity: 0;
            }
            #scroll-top-btn.visible {
                transform: translateY(0);
                opacity: 1;
            }

            /* ── Navbar ── */
            .nav-inner {
                max-width: 80rem;
                margin: 0 auto;
                padding: 0 24px;
                height: 80px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            @media (max-width: 640px) {
                .nav-inner {
                    height: 64px;
                    padding: 0 16px;
                }
            }

            .nav-logo-text {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.25rem;
                font-weight: 700;
                color: #2d8176;
                line-height: 1;
            }
            @media (max-width: 400px) {
                .nav-logo-text {
                    font-size: 1.05rem;
                }
            }

            .nav-links {
                display: flex;
                align-items: center;
                gap: 32px;
            }
            @media (max-width: 640px) {
                .nav-links {
                    gap: 12px;
                }
                .nav-links .nav-login {
                    display: none;
                }
            }

            /* ── Hero ── */
            .hero-section {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                padding: 32px 20px;
                overflow: hidden;
                background: linear-gradient(135deg, #2d8176, #2a8f84, #1a4d46);
                min-height: 16rem;
            }
            @media (max-width: 640px) {
                .hero-section {
                    min-height: auto;
                    padding: 24px 20px 28px;
                }
            }

            .hero-title {
                font-family: 'Libre Baskerville', serif;
                font-size: clamp(2rem, 6vw, 4rem);
                font-weight: 700;
                color: white;
                letter-spacing: -0.02em;
                line-height: 1;
                margin-bottom: 16px;
                text-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
            }

            .hero-desc {
                color: rgba(255, 255, 255, 0.9);
                font-size: clamp(0.9rem, 2vw, 1rem);
                max-width: 42rem;
                margin: 0 auto;
                line-height: 1.6;
                font-weight: 300;
            }

            .hero-stats {
                margin-top: 20px;
                display: flex;
                justify-content: center;
                gap: 24px;
                font-size: 0.8rem;
                color: rgba(255, 255, 255, 0.7);
                flex-wrap: wrap;
            }
            @media (max-width: 480px) {
                .hero-stats {
                    gap: 12px;
                    margin-top: 16px;
                }
                .hero-stats span {
                    font-size: 0.75rem;
                }
            }

            /* ── Listing section ── */
            .listing-section {
                padding: 60px 24px;
                max-width: 88rem;
                margin: 0 auto;
                display: block;
            }
            @media (max-width: 1024px) {
                .listing-section {
                    display: block;
                }
            }
            @media (max-width: 640px) {
                .listing-section {
                    padding: 36px 16px;
                }
            }

            .anchor-target {
                scroll-margin-top: 110px;
            }

            /* ── Section header row ── */
            .section-header-row {
                display: flex;
                flex-direction: row;
                align-items: flex-end;
                justify-content: space-between;
                gap: 24px;
                margin-bottom: 32px;
            }
            @media (max-width: 640px) {
                .section-header-row {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 12px;
                }
            }

            .section-title {
                font-family: 'Libre Baskerville', serif;
                font-size: clamp(2rem, 4vw, 3.15rem);
                font-weight: 700;
                color: #2d8176;
                margin-bottom: 8px;
            }

            .section-count {
                text-align: center;
                min-width: 120px;
                padding-bottom: 2px;
            }

            .section-count-number {
                font-family: 'Libre Baskerville', serif;
                font-size: 2.5rem;
                line-height: 1;
                color: #c9a84c;
            }

            .section-count-label {
                font-size: 0.68rem;
                font-weight: 800;
                letter-spacing: 0.18em;
                text-transform: uppercase;
                color: #6a7890;
                margin-top: 4px;
            }

            .archive-shell {
                display: grid;
                grid-template-columns: minmax(0, 1.6fr) 320px;
                gap: 24px;
                align-items: start;
                margin-bottom: 32px;
            }
            @media (max-width: 1024px) {
                .archive-shell {
                    grid-template-columns: 1fr;
                }
            }

            .archive-panel {
                background: rgba(255, 255, 255, 0.82);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(224, 216, 204, 0.9);
                border-radius: 28px;
                box-shadow: 0 18px 40px rgba(13, 22, 40, 0.06);
            }

            .archive-filters {
                padding: 18px;
            }

            .archive-form {
                display: grid;
                grid-template-columns: minmax(0, 1fr) 220px;
                gap: 12px;
                align-items: center;
            }
            @media (max-width: 1024px) {
                .archive-form {
                    grid-template-columns: 1fr 1fr;
                }
            }
            @media (max-width: 640px) {
                .archive-form {
                    grid-template-columns: 1fr;
                }
            }

            .archive-input,
            .archive-select {
                width: 100%;
                border: 1px solid #e0d8cc;
                background: #fff;
                color: #0d1628;
                border-radius: 16px;
                padding: 0.95rem 1rem;
                transition: border-color 0.2s ease, box-shadow 0.2s ease,
                    transform 0.2s ease;
                outline: none;
            }

            .archive-input:focus,
            .archive-select:focus {
                border-color: #2d8176;
                box-shadow: 0 0 0 4px rgba(45, 129, 118, 0.12);
            }

            .archive-btn,
            .archive-reset {
                border-radius: 16px;
                font-size: 0.72rem;
                font-weight: 800;
                letter-spacing: 0.14em;
                text-transform: uppercase;
                padding: 0.95rem 1.1rem;
                transition: transform 0.2s ease, box-shadow 0.2s ease,
                    background-color 0.2s ease, color 0.2s ease;
                white-space: nowrap;
            }

            .archive-btn {
                color: white;
                background: linear-gradient(135deg, #2d8176, #1a4d46);
                box-shadow: 0 14px 24px rgba(45, 129, 118, 0.2);
            }

            .archive-reset {
                border: 1px solid #2d8176;
                color: #2d8176;
                background: rgba(255, 255, 255, 0.9);
            }

            @media (hover: hover) {
                .archive-btn:hover,
                .archive-reset:hover {
                    transform: translateY(-1px);
                }
                .archive-btn:hover {
                    box-shadow: 0 18px 30px rgba(45, 129, 118, 0.26);
                }
                .archive-reset:hover {
                    background: #f3faf8;
                }
            }

            .archive-summary {
                padding: 18px;
            }

            @media (min-width: 1025px) {
                .archive-summary {
                    position: sticky;
                    top: 96px;
                }
            }

            .archive-summary-label {
                color: #a07830;
                text-transform: uppercase;
                letter-spacing: 0.2em;
                font-size: 0.68rem;
                font-weight: 800;
            }

            .archive-summary-number {
                font-family: 'Libre Baskerville', serif;
                font-size: clamp(2rem, 4vw, 2.9rem);
                color: #2d8176;
                line-height: 1;
                margin-top: 4px;
            }

            .archive-summary-copy {
                margin-top: 10px;
                color: #6a7890;
                font-size: 0.95rem;
                line-height: 1.6;
            }

            .archive-chip-row {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 16px;
            }

            .archive-chip {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 0.65rem 0.9rem;
                border-radius: 999px;
                border: 1px solid rgba(201, 168, 76, 0.25);
                background: rgba(249, 247, 242, 0.82);
                color: #6a7890;
                font-size: 0.78rem;
                font-weight: 700;
            }

            .archive-chip svg {
                width: 0.95rem;
                height: 0.95rem;
                color: #2d8176;
            }

            /* ── Search bar ── */
            .search-row {
                display: flex;
                flex-direction: row;
                gap: 12px;
                margin-bottom: 32px;
            }
            @media (max-width: 540px) {
                .search-row {
                    flex-direction: column;
                }
            }

            /* ── Paper card grid ── */
            .papers-grid {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 28px;
                align-items: stretch;
            }
            @media (max-width: 1024px) {
                .papers-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                    gap: 22px;
                }
            }
            @media (max-width: 640px) {
                .papers-grid {
                    gap: 18px;
                    grid-template-columns: 1fr;
                }
            }

            /* ── Card header bar ── */
            .card-header-bar {
                position: relative;
                height: 120px;
                background: linear-gradient(135deg, #2d8176, #2a8675, #c9a84c);
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
                border-bottom: 1px solid #e0d8cc;
                flex-shrink: 0;
            }

            /* ── Card actions ── */
            .card-actions {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .card-hover-depth {
                display: flex;
                flex-direction: column;
                min-height: 100%;
                overflow: hidden;
                background: #ffffff;
                border: 1px solid #e0d8cc;
                border-radius: 28px;
                box-shadow: 0 18px 38px rgba(13, 22, 40, 0.08);
            }

            @media (hover: hover) {
                .card-hover-depth:hover {
                    transform: translateY(-8px);
                    box-shadow: 0 26px 52px rgba(13, 22, 40, 0.14);
                }
            }

            .card-hover-depth .card-header-bar {
                min-height: 160px;
                padding: 20px;
            }

            .card-hover-depth .card-header-bar > div:last-child {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 4px;
                text-align: center;
            }

            .card-hover-depth .card-header-bar svg {
                width: 76px;
                height: 76px;
            }

            .card-hover-depth .card-header-bar p {
                color: rgba(255, 255, 255, 0.92);
                font-size: 0.72rem;
                font-weight: 800;
                letter-spacing: 0.14em;
                text-transform: uppercase;
            }

            .card-hover-depth > div:nth-child(2) {
                padding: 24px;
                display: flex;
                flex-direction: column;
                gap: 14px;
                flex: 1;
            }

            .card-hover-depth > div:nth-child(2) > div:first-child span {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.45rem 0.7rem;
                border-radius: 999px;
                border: 1px solid rgba(201, 168, 76, 0.25);
                background: rgba(201, 168, 76, 0.12);
                color: #a07830;
                font-size: 0.68rem;
                font-weight: 800;
                letter-spacing: 0.12em;
                text-transform: uppercase;
            }

            .card-hover-depth h3 {
                margin: 0;
                font-family: 'Libre Baskerville', serif;
                font-size: 1.15rem;
                line-height: 1.45;
                color: #2d8176;
            }

            .card-hover-depth > div:nth-child(2) > div:nth-child(3) {
                display: flex;
                align-items: center;
                gap: 10px;
                padding-bottom: 14px;
                border-bottom: 1px solid #e0d8cc;
            }

            .card-hover-depth > div:nth-child(2) > div:nth-child(3) svg {
                width: 18px;
                height: 18px;
                color: #c9a84c;
                flex-shrink: 0;
            }

            .card-hover-depth > div:nth-child(2) > div:nth-child(3) p {
                margin: 0;
                color: #6a7890;
                font-size: 0.95rem;
                font-weight: 700;
                line-height: 1.4;
            }

            .card-hover-depth > div:nth-child(2) > p {
                color: #6a7890;
                font-size: 0.96rem;
                line-height: 1.8;
                margin: 0;
            }

            .card-hover-depth > div:nth-child(2) > div:nth-child(5) {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 0;
                margin-top: 2px;
                padding: 16px;
                background: #f9f7f2;
                border-radius: 20px;
                overflow: hidden;
            }

            .card-hover-depth > div:nth-child(2) > div:nth-child(5) > div {
                text-align: center;
                padding: 6px 10px;
            }

            .card-hover-depth > div:nth-child(2) > div:nth-child(5) > div + div {
                border-left: 1px solid #e0d8cc;
            }

            .card-hover-depth > div:nth-child(2) > div:nth-child(5) > div > div:first-child {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.35rem;
                font-weight: 700;
                color: #2d8176;
                line-height: 1.1;
            }

            .card-hover-depth > div:nth-child(2) > div:nth-child(5) > div > div:last-child {
                margin-top: 4px;
                color: #c9a84c;
                font-size: 0.68rem;
                font-weight: 800;
                letter-spacing: 0.14em;
                text-transform: uppercase;
            }

            .card-hover-depth > div:nth-child(2) > div:nth-child(6) {
                display: flex;
                align-items: center;
                gap: 8px;
                color: #8b95a8;
                font-size: 0.78rem;
                font-weight: 700;
                line-height: 1.4;
            }

            .card-hover-depth > div:nth-child(2) > div:nth-child(6) svg {
                width: 14px;
                height: 14px;
                color: #a7b1c7;
                flex-shrink: 0;
            }

            .card-hover-depth .card-actions {
                margin-top: auto;
                padding-top: 4px;
            }

            .card-hover-depth .card-actions a {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                width: 100%;
                padding: 14px 18px;
                border-radius: 16px;
                text-decoration: none;
                text-align: center;
                font-size: 0.72rem;
                font-weight: 800;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                transition: transform 0.2s ease, box-shadow 0.2s ease,
                    background-color 0.2s ease, color 0.2s ease,
                    border-color 0.2s ease;
            }

            .card-hover-depth .card-actions a svg {
                width: 18px;
                height: 18px;
                flex-shrink: 0;
            }

            .card-hover-depth .card-actions a:first-child {
                color: #ffffff;
                background: linear-gradient(135deg, #2d8176, #1a4d46);
                box-shadow: 0 14px 24px rgba(45, 129, 118, 0.2);
            }

            .card-hover-depth .card-actions a:nth-child(2) {
                color: #c9a84c;
                border: 2px solid #c9a84c;
                background: #ffffff;
            }

            .card-hover-depth .card-actions a:nth-child(3) {
                color: #2d8176;
                border: 2px solid #2d8176;
                background: #ffffff;
            }

            @media (hover: hover) {
                .card-hover-depth .card-actions a:hover {
                    transform: translateY(-1px);
                }
                .card-hover-depth .card-actions a:first-child:hover {
                    box-shadow: 0 18px 30px rgba(45, 129, 118, 0.26);
                }
                .card-hover-depth .card-actions a:nth-child(2):hover {
                    background: #c9a84c;
                    color: #ffffff;
                }
                .card-hover-depth .card-actions a:nth-child(3):hover {
                    background: #2d8176;
                    color: #ffffff;
                }
            }

            /* ── CTA section ── */
            .cta-section {
                padding: 96px 24px;
                background: linear-gradient(135deg, #f9f7f2, #faf8f4, #f5f0e8);
                border-top: 1px solid #ede5d5;
                border-bottom: 1px solid #ede5d5;
                position: relative;
                overflow: hidden;
            }
            @media (max-width: 640px) {
                .cta-section {
                    padding: 64px 20px;
                }
            }

            .cta-title {
                font-family: 'Libre Baskerville', serif;
                font-size: clamp(1.8rem, 5vw, 3rem);
                font-weight: 700;
                color: #2d8176;
                margin-bottom: 24px;
            }

            .cta-btns {
                display: flex;
                flex-direction: row;
                gap: 16px;
                justify-content: center;
                flex-wrap: wrap;
            }
            @media (max-width: 480px) {
                .cta-btns {
                    flex-direction: column;
                    align-items: stretch;
                }
                .cta-btns a {
                    text-align: center;
                    justify-content: center;
                }
            }

            .cta-section > div:nth-child(3) {
                max-width: 56rem;
                margin: 0 auto;
                text-align: center;
                position: relative;
                z-index: 10;
            }

            .cta-section > div:nth-child(3) > p {
                color: #6a7890;
                font-size: 1rem;
                line-height: 1.8;
                margin-bottom: 28px;
            }

            .cta-btns a {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                min-width: 220px;
                padding: 16px 28px;
                border-radius: 18px;
                text-decoration: none;
                font-size: 0.75rem;
                font-weight: 800;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                transition: transform 0.2s ease, box-shadow 0.2s ease,
                    background-color 0.2s ease, color 0.2s ease,
                    border-color 0.2s ease;
            }

            .cta-btns a svg {
                width: 20px;
                height: 20px;
                flex-shrink: 0;
            }

            .cta-btns a:first-child {
                color: #ffffff;
                background: linear-gradient(135deg, #2d8176, #1a5451);
                box-shadow: 0 16px 28px rgba(45, 129, 118, 0.22);
            }

            .cta-btns a:last-child {
                color: #2d8176;
                border: 2px solid #2d8176;
                background: #ffffff;
            }

            @media (hover: hover) {
                .cta-btns a:hover {
                    transform: translateY(-2px);
                }
                .cta-btns a:first-child:hover {
                    box-shadow: 0 20px 34px rgba(45, 129, 118, 0.28);
                }
                .cta-btns a:last-child:hover {
                    background: #2d8176;
                    color: #ffffff;
                }
            }

            footer {
                background: linear-gradient(90deg, #1a4d46, #0d2a25);
                color: rgba(237, 229, 213, 0.7);
                padding: 3.5rem 1.5rem;
                border-top: 2px solid rgba(201, 168, 76, 0.2);
            }

            footer > div {
                max-width: 80rem;
                margin: 0 auto;
                text-align: center;
            }

            footer h3 {
                color: #ffffff;
                font-family: 'Libre Baskerville', serif;
                font-size: 1.5rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
            }

            footer > div > div {
                width: 5rem;
                height: 0.25rem;
                margin: 0 auto 1.25rem;
                background: linear-gradient(90deg, #c9a84c, transparent);
            }

            #scroll-top-btn {
                position: fixed;
                right: 2.5rem;
                bottom: 2.5rem;
                width: 4rem;
                height: 4rem;
                border: 0;
                border-radius: 999px;
                background: #ffffff;
                box-shadow: 0 22px 40px rgba(13, 22, 40, 0.18);
                z-index: 50;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                overflow: hidden;
            }

            #scroll-top-btn svg:first-child {
                width: 1.35rem;
                height: 1.35rem;
            }

            #scroll-top-btn svg:nth-child(2) {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                transform: rotate(-90deg);
            }

            /* ── Scroll-to-top btn ── */
            @media (max-width: 640px) {
                #scroll-top-btn {
                    bottom: 20px;
                    right: 16px;
                    width: 48px;
                    height: 48px;
                }
            }
        </style>
    </head>
    <body class="bg-[#f5f0e8] text-[#0d1628] antialiased overflow-x-hidden">
        <div class="h-1 w-full nav-shimmer sticky top-0 z-60"></div>

        <nav
            class="bg-white/90 backdrop-blur-md border-b border-[#c9a84c]/20 sticky top-1 z-50"
        >
            <div class="nav-inner">
                <a href="/" class="flex items-center gap-3 group">
                    <div
                        class="w-10 h-10 flex items-center justify-center bg-[#2D8176] rounded-full border border-[#c9a84c]/30 shadow-sm group-hover:rotate-12 transition-transform shrink-0"
                    >
                        <svg
                            class="text-[#f0d678] w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                            ></path>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="nav-logo-text">Journal System</span>
                        <span
                            class="text-[9px] font-bold text-[#a07830] uppercase tracking-widest"
                        >
                            Academic Publishing Portal
                        </span>
                    </div>
                </a>
                <div class="nav-links">
                    <a
                        href="/login"
                        class="nav-login text-sm font-bold text-[#2D8176] hover:text-[#c9a84c] transition-colors"
                    >
                        Login
                    </a>
                    <a
                        href="/register"
                        class="bg-linear-to-br from-[#c9a84c] to-[#a07830] text-white px-5 py-2 rounded-xl text-sm font-bold shadow-lg shadow-[#a07830]/20 hover:-translate-y-0.5 transition-all whitespace-nowrap"
                    >
                        Register
                    </a>
                </div>
            </div>
        </nav>

        <!-- HEADER SECTION -->
        <section class="hero-section">
            <!-- Decorative background elements -->
            <div class="absolute inset-0 pointer-events-none">
                <div
                    class="absolute -top-40 -right-40 w-80 h-80 bg-[#c9a84c]/10 rounded-full blur-3xl"
                ></div>
                <div
                    class="absolute -bottom-40 -left-40 w-80 h-80 bg-[#f0d678]/5 rounded-full blur-3xl"
                ></div>
                <svg
                    class="absolute inset-0 w-full h-full opacity-20"
                    viewBox="0 0 1000 600"
                    preserveAspectRatio="none"
                >
                    <defs>
                        <pattern
                            id="dotsPattern"
                            x="0"
                            y="0"
                            width="80"
                            height="80"
                            patternUnits="userSpaceOnUse"
                        >
                            <circle
                                cx="40"
                                cy="40"
                                r="1.5"
                                fill="white"
                                opacity="0.3"
                            />
                        </pattern>
                    </defs>
                    <rect width="1000" height="600" fill="url(#dotsPattern)" />
                </svg>
            </div>

            <div
                class="absolute inset-0 bg-linear-to-b from-transparent via-transparent to-[rgba(13,22,40,0.3)] pointer-events-none"
            ></div>

            <div class="relative z-10 w-full max-w-5xl mx-auto">
                <div
                    class="inline-block mb-6 px-5 py-2.5 bg-white/10 backdrop-blur-md rounded-full border border-white/20 shadow-lg"
                >
                    <p
                        class="text-[#f0d678] font-bold tracking-[0.25em] text-xs uppercase flex items-center gap-2"
                    >
                        <svg
                            class="w-4 h-4 shrink-0"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"
                            />
                        </svg>
                        Research Repository
                    </p>
                </div>

                <h1 class="hero-title">{{ $heroTitle }}</h1>

                <div
                    class="mx-auto mb-8 w-24 h-1 bg-linear-to-r from-transparent via-[#f0d678] to-transparent rounded-full"
                ></div>

                <p class="hero-desc">{{ $heroDescription }}</p>

                <div class="hero-stats">
                    <div class="flex items-center gap-2">
                        <svg
                            class="w-5 h-5 text-[#c9a84c] shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                        <span>Peer Reviewed</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg
                            class="w-5 h-5 text-[#c9a84c] shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"
                            />
                        </svg>
                        <span>Impact Driven</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg
                            class="w-5 h-5 text-[#c9a84c] shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                            />
                        </svg>
                        <span>Openly Accessible</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- PAPERS LISTING SECTION -->
        <section class="listing-section">
            <div class="mb-16">
                <div id="search" class="archive-panel archive-filters anchor-target">
                    <div class="section-header-row mb-6">
                        <div>
                            <h2 class="section-title">
                                {{ $isArchivePage ? 'Archive Directory' : 'All Published Research' }}
                            </h2>
                            <p class="text-[#6a7890] font-medium text-base md:text-lg max-w-2xl">
                                @if ($isArchivePage)
                                    Discover {{ $pagination->total() }} archived papers organized with dynamic volume and issue placeholders.
                                @else
                                    Discover {{ $pagination->total() }} peer-reviewed papers from leading researchers.
                                @endif
                            </p>
                        </div>

                        <div class="section-count">
                            <div class="section-count-number">{{ $pagination->total() }}</div>
                            <div class="section-count-label">
                                {{ $isArchivePage ? 'Papers Archived' : 'Papers Published' }}
                            </div>
                            <a href="{{ route($switchRouteName) }}" class="archive-reset text-center mt-3 inline-block">
                                {{ $switchLabel }}
                            </a>
                        </div>
                    </div>

                    <form method="GET" action="{{ route($formRouteName) }}" class="archive-form">
                        <input
                            type="text"
                            name="q"
                            value="{{ $search }}"
                            placeholder="Search title, author, keyword, or abstract"
                            class="archive-input"
                        />

                        <select name="category" class="archive-select">
                            <option value="">All Categories</option>

                            @foreach ($availableCategories as $optionCategory)
                                <option
                                    value="{{ $optionCategory }}"
                                    @selected($category === $optionCategory)
                                >
                                    {{ $optionCategory }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                @if ($papers->count() > 0)
                    @if ($isArchivePage && $groupedPapers)
                        <!-- ARCHIVE GROUPED VIEW -->
                        <div id="papers" class="anchor-target mt-10">
                        @foreach ($groupedPapers as $volumeGroup)
                            <div class="mb-16">
                                <!-- Volume Header -->
                                <div class="mb-8 pb-6 border-b-2 border-[#c9a84c]/30">
                                    <h2 class="text-3xl font-libre font-bold text-[#2D8176] mb-2">
                                        Volume {{ $volumeGroup['volume'] }}
                                    </h2>
                                    <p class="text-[#6a7890] font-semibold">
                                        Issue {{ $volumeGroup['issue'] }} • {{ $volumeGroup['category'] }} • {{ $volumeGroup['papers']->count() }} @if ($volumeGroup['papers']->count() === 1) paper @else papers @endif
                                    </p>
                                </div>

                                <!-- Papers Grid for this Volume -->
                                <div class="papers-grid">
                                @foreach ($volumeGroup['papers'] as $paper)
                                    <div
                                        class="card-hover-depth group bg-white rounded-2xl overflow-hidden border border-[#e0d8cc] shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col"
                                        data-paper-title="{{ $paper['title'] }}"
                                        data-paper-author="{{ $paper['author'] }}"
                                        data-paper-abstract="{{ $paper['abstract'] }}"
                                        data-paper-category="{{ $paper['category'] }}"
                                    >
                                        <!-- Card header gradient bar -->
                                        <div class="card-header-bar">
                                            <div
                                                class="absolute inset-0 opacity-20 pointer-events-none"
                                            >
                                                <svg
                                                    class="w-full h-full"
                                                    viewBox="0 0 200 160"
                                                    preserveAspectRatio="xMidYMid slice"
                                                >
                                                    <defs>
                                                        <linearGradient
                                                            id="linePattern{{ $paper['id'] }}"
                                                            x1="0%"
                                                            y1="0%"
                                                            x2="100%"
                                                            y2="100%"
                                                        >
                                                            <stop
                                                                offset="0%"
                                                                style="
                                                                    stop-color: white;
                                                                    stop-opacity: 0.1;
                                                                "
                                                            />
                                                            <stop
                                                                offset="100%"
                                                                style="
                                                                    stop-color: white;
                                                                    stop-opacity: 0;
                                                                "
                                                            />
                                                        </linearGradient>
                                                    </defs>
                                                    <circle
                                                        cx="180"
                                                        cy="-20"
                                                        r="80"
                                                        fill="url(#linePattern{{ $paper['id'] }})"
                                                    />
                                                    <circle
                                                        cx="20"
                                                        cy="180"
                                                        r="60"
                                                        fill="url(#linePattern{{ $paper['id'] }})"
                                                    />
                                                </svg>
                                            </div>
                                            <div class="relative z-10 text-center">
                                                <svg
                                                    class="w-14 h-14 text-white mx-auto mb-1 group-hover:scale-110 transition-transform duration-300"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                                    />
                                                </svg>
                                                <p
                                                    class="text-white/90 text-xs font-semibold tracking-wider"
                                                >
                                                    RESEARCH PAPER
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Card content -->
                                        <div class="p-6 md:p-8 flex flex-col flex-1">
                                            <div class="mb-3">
                                                <span
                                                    class="inline-block px-3 py-1.5 bg-[#c9a84c]/15 text-[#c9a84c] text-[10px] font-bold uppercase rounded-lg border border-[#c9a84c]/30"
                                                >
                                                    {{ $paper['category'] }}
                                                </span>
                                            </div>

                                            <h3
                                                class="font-libre text-lg font-bold text-[#2D8176] mb-3 leading-snug line-clamp-3 group-hover:text-[#c9a84c] transition-colors"
                                            >
                                                {{ $paper['title'] }}
                                            </h3>

                                            <div
                                                class="flex items-center gap-2 mb-4 pb-4 border-b border-[#e0d8cc]"
                                            >
                                                <svg
                                                    class="w-4 h-4 text-[#c9a84c] shrink-0"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                                    />
                                                </svg>
                                                <p
                                                    class="text-sm text-[#6a7890] font-semibold truncate"
                                                >
                                                    {{ $paper['author'] }}
                                                </p>
                                            </div>

                                            <p
                                                class="text-[#6a7890] text-sm mb-6 leading-relaxed line-clamp-3"
                                            >
                                                {{ $paper['abstract'] }}
                                            </p>

                                            <div
                                                class="grid grid-cols-2 gap-3 mb-6 p-4 bg-[#f9f7f2] rounded-lg"
                                            >
                                                <div class="text-center">
                                                    <div
                                                        class="text-lg font-libre font-bold text-[#2D8176]"
                                                    >
                                                        {{ number_format($paper['downloads']) }}
                                                    </div>
                                                    <div
                                                        class="text-[10px] font-bold text-[#c9a84c] uppercase tracking-wider"
                                                    >
                                                        Downloads
                                                    </div>
                                                </div>
                                                <div
                                                    class="text-center border-l border-[#e0d8cc]"
                                                >
                                                    <div
                                                        class="text-lg font-libre font-bold text-[#2D8176]"
                                                    >
                                                        {{ date('M', strtotime($paper['publishedAt'])) }}
                                                    </div>
                                                    <div
                                                        class="text-[10px] font-bold text-[#c9a84c] uppercase tracking-wider"
                                                    >
                                                        {{ date('Y', strtotime($paper['publishedAt'])) }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div
                                                class="text-[11px] text-[#a7b1c7] mb-5 font-medium flex items-center gap-2"
                                            >
                                                <svg
                                                    class="w-3.5 h-3.5 shrink-0"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                    />
                                                </svg>
                                                Published
                                                {{ $paper['publishedAt']?->format('M d, Y') ?? 'N/A' }}
                                            </div>

                                            <!-- Action buttons — pushed to bottom -->
                                            <div class="card-actions mt-auto">
                                                <a
                                                    href="{{ route('papers.show', ['submission' => $paper['id']]) }}"
                                                    class="flex items-center justify-center gap-2 w-full px-5 py-3.5 bg-linear-to-r from-[#2D8176] to-[#1a4d46] text-white rounded-xl font-bold text-sm uppercase tracking-wider hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 group-hover:from-[#c9a84c] group-hover:to-[#a07830]"
                                                >
                                                    <span>Read Full Article</span>
                                                    <svg
                                                        class="w-4 h-4 group-hover:translate-x-1 transition-transform shrink-0"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M13 7l5 5m0 0l-5 5m5-5H6"
                                                        />
                                                    </svg>
                                                </a>

                                                <a
                                                    href="{{ route('papers.download-ris', ['submission' => $paper['id']]) }}"
                                                    class="flex items-center justify-center gap-2 w-full px-5 py-2.5 bg-white border-2 border-[#c9a84c] text-[#c9a84c] rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-[#c9a84c] hover:text-white transition-all duration-200"
                                                    title="Download citation in RIS format for Zotero, Mendeley, EndNote"
                                                >
                                                    <svg
                                                        class="w-4 h-4 shrink-0"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm8-5.5V5a2 2 0 00-2-2H6a2 2 0 00-2 2v6.5"
                                                        />
                                                    </svg>
                                                    <span>Export Citation</span>
                                                </a>

                                                <a
                                                    href="{{ route('papers.download', ['submission' => $paper['id']]) }}"
                                                    class="flex items-center justify-center gap-2 w-full px-5 py-2.5 bg-white border-2 border-[#2D8176] text-[#2D8176] rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-[#2D8176] hover:text-white transition-all duration-200"
                                                    title="Download the full paper as PDF"
                                                >
                                                    <svg
                                                        class="w-4 h-4 shrink-0"
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
                                                    <span>Download PDF</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        @endforeach
                        </div>
                    @else
                        <!-- PUBLISHED FLAT VIEW -->
                        <div id="papers" class="papers-grid anchor-target mt-10">
                        @foreach ($papers as $paper)
                        <div
                            class="card-hover-depth group bg-white rounded-2xl overflow-hidden border border-[#e0d8cc] shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col"
                            data-paper-title="{{ $paper['title'] }}"
                            data-paper-author="{{ $paper['author'] }}"
                            data-paper-abstract="{{ $paper['abstract'] }}"
                            data-paper-category="{{ $paper['category'] }}"
                        >
                            <!-- Card header gradient bar -->
                            <div class="card-header-bar">
                                <div
                                    class="absolute inset-0 opacity-20 pointer-events-none"
                                >
                                    <svg
                                        class="w-full h-full"
                                        viewBox="0 0 200 160"
                                        preserveAspectRatio="xMidYMid slice"
                                    >
                                        <defs>
                                            <linearGradient
                                                id="linePattern{{ $paper['id'] }}"
                                                x1="0%"
                                                y1="0%"
                                                x2="100%"
                                                y2="100%"
                                            >
                                                <stop
                                                    offset="0%"
                                                    style="
                                                        stop-color: white;
                                                        stop-opacity: 0.1;
                                                    "
                                                />
                                                <stop
                                                    offset="100%"
                                                    style="
                                                        stop-color: white;
                                                        stop-opacity: 0;
                                                    "
                                                />
                                            </linearGradient>
                                        </defs>
                                        <circle
                                            cx="180"
                                            cy="-20"
                                            r="80"
                                            fill="url(#linePattern{{ $paper['id'] }})"
                                        />
                                        <circle
                                            cx="20"
                                            cy="180"
                                            r="60"
                                            fill="url(#linePattern{{ $paper['id'] }})"
                                        />
                                    </svg>
                                </div>
                                <div class="relative z-10 text-center">
                                    <svg
                                        class="w-14 h-14 text-white mx-auto mb-1 group-hover:scale-110 transition-transform duration-300"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                        />
                                    </svg>
                                    <p
                                        class="text-white/90 text-xs font-semibold tracking-wider"
                                    >
                                        RESEARCH PAPER
                                    </p>
                                </div>
                            </div>

                            <!-- Card content -->
                            <div class="p-6 md:p-8 flex flex-col flex-1">
                                <div class="mb-3">
                                    <span
                                        class="inline-block px-3 py-1.5 bg-[#c9a84c]/15 text-[#c9a84c] text-[10px] font-bold uppercase rounded-lg border border-[#c9a84c]/30"
                                    >
                                        {{ $paper['category'] }}
                                    </span>
                                </div>

                                <h3
                                    class="font-libre text-lg font-bold text-[#2D8176] mb-3 leading-snug line-clamp-3 group-hover:text-[#c9a84c] transition-colors"
                                >
                                    {{ $paper['title'] }}
                                </h3>

                                <div
                                    class="flex items-center gap-2 mb-4 pb-4 border-b border-[#e0d8cc]"
                                >
                                    <svg
                                        class="w-4 h-4 text-[#c9a84c] shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        />
                                    </svg>
                                    <p
                                        class="text-sm text-[#6a7890] font-semibold truncate"
                                    >
                                        {{ $paper['author'] }}
                                    </p>
                                </div>

                                <p
                                    class="text-[#6a7890] text-sm mb-6 leading-relaxed line-clamp-3"
                                >
                                    {{ $paper['abstract'] }}
                                </p>

                                <div
                                    class="grid grid-cols-2 gap-3 mb-6 p-4 bg-[#f9f7f2] rounded-lg"
                                >
                                    <div class="text-center">
                                        <div
                                            class="text-lg font-libre font-bold text-[#2D8176]"
                                        >
                                            {{ number_format($paper['downloads']) }}
                                        </div>
                                        <div
                                            class="text-[10px] font-bold text-[#c9a84c] uppercase tracking-wider"
                                        >
                                            Downloads
                                        </div>
                                    </div>
                                    <div
                                        class="text-center border-l border-[#e0d8cc]"
                                    >
                                        <div
                                            class="text-lg font-libre font-bold text-[#2D8176]"
                                        >
                                            {{ date('M', strtotime($paper['publishedAt'])) }}
                                        </div>
                                        <div
                                            class="text-[10px] font-bold text-[#c9a84c] uppercase tracking-wider"
                                        >
                                            {{ date('Y', strtotime($paper['publishedAt'])) }}
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="text-[11px] text-[#a7b1c7] mb-5 font-medium flex items-center gap-2"
                                >
                                    <svg
                                        class="w-3.5 h-3.5 shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                    Published
                                    {{ $paper['publishedAt']?->format('M d, Y') ?? 'N/A' }}
                                </div>

                                <!-- Action buttons — pushed to bottom -->
                                <div class="card-actions mt-auto">
                                    <a
                                        href="{{ route('papers.show', ['submission' => $paper['id']]) }}"
                                        class="flex items-center justify-center gap-2 w-full px-5 py-3.5 bg-linear-to-r from-[#2D8176] to-[#1a4d46] text-white rounded-xl font-bold text-sm uppercase tracking-wider hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 group-hover:from-[#c9a84c] group-hover:to-[#a07830]"
                                    >
                                        <span>Read Full Article</span>
                                        <svg
                                            class="w-4 h-4 group-hover:translate-x-1 transition-transform shrink-0"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6"
                                            />
                                        </svg>
                                    </a>

                                    <a
                                        href="{{ route('papers.download-ris', ['submission' => $paper['id']]) }}"
                                        class="flex items-center justify-center gap-2 w-full px-5 py-2.5 bg-white border-2 border-[#c9a84c] text-[#c9a84c] rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-[#c9a84c] hover:text-white transition-all duration-200"
                                        title="Download citation in RIS format for Zotero, Mendeley, EndNote"
                                    >
                                        <svg
                                            class="w-4 h-4 shrink-0"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm8-5.5V5a2 2 0 00-2-2H6a2 2 0 00-2 2v6.5"
                                            />
                                        </svg>
                                        <span>Export Citation</span>
                                    </a>

                                    <a
                                        href="{{ route('papers.download', ['submission' => $paper['id']]) }}"
                                        class="flex items-center justify-center gap-2 w-full px-5 py-2.5 bg-white border-2 border-[#2D8176] text-[#2D8176] rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-[#2D8176] hover:text-white transition-all duration-200"
                                        title="Download the full paper as PDF"
                                    >
                                        <svg
                                            class="w-4 h-4 shrink-0"
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
                                        <span>Download PDF</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        </div>
                    @endif

                <!-- PAGINATION -->
                <div class="mt-20 flex justify-center">
                    {{ $pagination->links('pagination::tailwind') }}
                </div>
            @else
                <div class="archive-panel text-center py-24 px-6 md:px-10">
                    <div class="text-7xl mb-6 animate-bounce">📚</div>
                    <h3 class="font-libre text-2xl md:text-3xl font-bold text-[#2D8176] mb-3">
                        @if ($search !== '' || $category !== '')
                            No Papers Match Your Filters
                        @else
                            {{ $isArchivePage ? 'No Archived Papers Yet' : 'No Published Papers Yet' }}
                        @endif
                    </h3>
                    <p class="text-[#6a7890] mb-10 text-lg max-w-xl mx-auto leading-relaxed">
                        @if ($search !== '' || $category !== '')
                            Try a broader search or clear the category filter to browse more of the archive.
                        @else
                            @if ($isArchivePage)
                                Archived papers will appear here when the managing editor archives them.
                            @else
                                Published papers will appear here once manuscripts are officially published.
                            @endif
                        @endif
                    </p>
                    <div class="flex justify-center gap-3 flex-wrap">
                        <a
                            href="{{ route($formRouteName) }}"
                            class="inline-block px-8 py-3 bg-[#2D8176] text-white rounded-xl font-bold text-sm uppercase tracking-wider hover:-translate-y-1 transition-all shadow-lg hover:shadow-xl"
                        >
                            View {{ $heroTitle }}
                        </a>
                        <a
                            href="/"
                            class="inline-block px-8 py-3 bg-white border border-[#2D8176] text-[#2D8176] rounded-xl font-bold text-sm uppercase tracking-wider hover:bg-[#f3faf8] transition-all"
                        >
                            Back to Home
                        </a>
                    </div>
                </div>
            @endif
        </section>

        <!-- CALL TO ACTION SECTION -->
        <section id="about" class="cta-section anchor-target">
            <div
                class="absolute top-0 right-0 w-96 h-96 bg-[#2D8176]/5 rounded-full -mr-32 -mt-32 blur-3xl pointer-events-none"
            ></div>
            <div
                class="absolute bottom-0 left-0 w-72 h-72 bg-[#c9a84c]/5 rounded-full -ml-32 -mb-32 blur-3xl pointer-events-none"
            ></div>

            <div class="max-w-4xl mx-auto text-center relative z-10">
                <h2 class="cta-title">Ready to Publish Your Research?</h2>
                <p
                    class="text-[#6a7890] text-base md:text-lg mb-12 leading-relaxed max-w-2xl mx-auto"
                >
                    Join our community of innovative researchers and get your
                    groundbreaking work published in a peer-reviewed journal.
                    Submit your manuscript today and contribute to advancing
                    knowledge in your field.
                </p>
                <div class="cta-btns">
                    <a
                        href="/register"
                        class="inline-flex items-center justify-center gap-2 px-10 py-4 bg-linear-to-r from-[#2D8176] to-[#1a5451] text-white rounded-2xl font-bold text-sm uppercase tracking-wider shadow-lg hover:shadow-2xl hover:-translate-y-1 transition-all duration-200 group"
                    >
                        <svg
                            class="w-5 h-5 group-hover:rotate-12 transition-transform shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4v16m8-8H4"
                            />
                        </svg>
                        <span>Submit Your Paper</span>
                    </a>
                    <a
                        href="/"
                        class="inline-flex items-center justify-center gap-2 px-10 py-4 bg-white border-2 border-[#2D8176] text-[#2D8176] rounded-2xl font-bold text-sm uppercase tracking-wider hover:bg-[#2D8176] hover:text-white transition-all duration-200 group"
                    >
                        <svg
                            class="w-5 h-5 group-hover:-rotate-12 transition-transform shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                        <span>Learn More</span>
                    </a>
                </div>
            </div>
        </section>

        <footer
            class="bg-linear-to-r from-[#1a4d46] to-[#0d2a25] text-[#ede5d5]/70 py-14 px-6 border-t-2 border-[#c9a84c]/20"
        >
            <div class="max-w-7xl mx-auto text-center">
                <h3 class="font-libre text-2xl font-bold text-white mb-2">
                    Journal System
                </h3>
                <p
                    class="text-[10px] font-bold uppercase tracking-[0.3em] mb-5 text-[#f0d678]"
                >
                    Advancing Knowledge • Inspiring Innovation
                </p>
                <div
                    class="h-1 w-20 bg-linear-to-r from-[#c9a84c] to-transparent mx-auto mb-6"
                ></div>
                <p class="text-[10px] font-semibold uppercase tracking-wider">
                    © 2026 Academic Publishing Portal • All Rights Reserved
                </p>
            </div>
        </footer>

        <button
            id="scroll-top-btn"
            onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed bottom-10 right-10 w-16 h-16 bg-white shadow-2xl rounded-full z-50 flex items-center justify-center group"
        >
            <svg
                class="w-6 h-6 text-[#2D8176] group-hover:-translate-y-1 transition-transform z-10"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 15l7-7 7 7"
                />
            </svg>
            <svg class="absolute inset-0 w-full h-full -rotate-90">
                <circle
                    cx="32"
                    cy="32"
                    r="30"
                    stroke="currentColor"
                    stroke-width="2"
                    fill="transparent"
                    class="text-slate-100"
                />
                <circle
                    id="progress-circle"
                    cx="32"
                    cy="32"
                    r="30"
                    stroke="currentColor"
                    stroke-width="2"
                    fill="transparent"
                    class="text-[#c9a84c]"
                    stroke-dasharray="188.4"
                    stroke-dashoffset="188.4"
                />
            </svg>
        </button>

        <script>
            const btn = document.getElementById('scroll-top-btn');
            const progressCircle = document.getElementById('progress-circle');
            const circumference = 188.4;

            window.onscroll = function () {
                const scrollTop = window.scrollY;
                const docHeight =
                    document.documentElement.scrollHeight - window.innerHeight;
                const scrolled = scrollTop / docHeight;
                btn.classList.toggle('visible', scrolled > 0.2);
                const dashoffset = circumference - scrolled * circumference;
                progressCircle.style.strokeDashoffset = dashoffset;
            };

        </script>
    </body>
</html>
