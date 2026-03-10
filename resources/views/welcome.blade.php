<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>
            Journal System | Academic Publishing Portal International Research
            Journal
        </title>

        <link
            href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap"
            rel="stylesheet"
        />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --teal: #2d8176;
                --teal-dk: #1a4d46;
                --teal-lt: #e8f4f2;
                --gold: #c9a84c;
                --gold-lt: #f5e9c4;
                --gold-dk: #8a6e28;
                --ink: #1a1209;
                --ink-mid: #3d2f1a;
                --ink-soft: #6b5740;
                --cream: #faf6ef;
                --parchment: #f3ece0;
                --border: #e8dfd0;
                --border-dk: #c9b99a;
            }

            *,
            *::before,
            *::after {
                box-sizing: border-box;
            }

            html {
                scroll-behavior: smooth;
            }

            body {
                font-family: 'Source Sans 3', sans-serif;
                background: var(--cream);
                color: var(--ink);
                overflow-x: hidden;
                -webkit-font-smoothing: antialiased;
            }

            .font-serif {
                font-family: 'Libre Baskerville', serif;
            }

            /* ── Shimmer bar ── */
            .shimmer-bar {
                height: 3px;
                background: linear-gradient(
                    90deg,
                    transparent 0%,
                    var(--gold-lt) 20%,
                    var(--gold) 40%,
                    #f0d678 50%,
                    var(--gold) 60%,
                    var(--gold-lt) 80%,
                    transparent 100%
                );
                background-size: 200% 100%;
                animation: shimmer 3s linear infinite;
            }
            @keyframes shimmer {
                from { background-position: -200% 0; }
                to   { background-position:  200% 0; }
            }

            /* ── Navbar ── */
            .navbar {
                background: rgba(250, 246, 239, 0.92);
                backdrop-filter: blur(14px);
                border-bottom: 1px solid var(--border);
                position: sticky;
                top: 3px;
                z-index: 50;
            }
            .nav-inner {
                max-width: 1280px;
                margin: 0 auto;
                padding: 0 32px;
                height: 72px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .nav-logo {
                display: flex;
                align-items: center;
                gap: 14px;
                text-decoration: none;
            }
            .nav-logo-icon {
                width: 42px;
                height: 42px;
                background: var(--teal);
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 14px rgba(45, 129, 118, 0.25);
                transition: transform 0.2s;
            }
            .nav-logo:hover .nav-logo-icon { transform: rotate(8deg); }
            .nav-logo-text { line-height: 1; }
            .nav-logo-name {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.15rem;
                font-weight: 700;
                color: var(--teal-dk);
                display: block;
            }
            .nav-logo-sub {
                font-size: 0.62rem;
                font-weight: 700;
                letter-spacing: 0.18em;
                text-transform: uppercase;
                color: var(--gold-dk);
                display: block;
                margin-top: 2px;
            }
            .nav-links {
                display: flex;
                align-items: center;
                gap: 36px;
            }
            .nav-link {
                font-size: 0.82rem;
                font-weight: 600;
                letter-spacing: 0.03em;
                color: var(--ink-soft);
                text-decoration: none;
                transition: color 0.15s;
                position: relative;
            }
            .nav-link::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                width: 0;
                height: 1.5px;
                background: var(--teal);
                transition: width 0.2s;
            }
            .nav-link:hover { color: var(--teal); }
            .nav-link:hover::after { width: 100%; }
            .btn-nav-register {
                font-size: 0.78rem;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                padding: 10px 24px;
                background: var(--teal);
                color: #fff;
                border-radius: 8px;
                text-decoration: none;
                box-shadow: 0 4px 14px rgba(45, 129, 118, 0.28);
                transition: background 0.15s, transform 0.12s, box-shadow 0.15s;
            }
            .btn-nav-register:hover {
                background: var(--teal-dk);
                transform: translateY(-1px);
                box-shadow: 0 8px 20px rgba(45, 129, 118, 0.32);
            }

            /* ── Hero ── */
            .hero {
                position: relative;
                min-height: 88vh;
                display: flex;
                align-items: center;
                overflow: hidden;
                background: var(--teal-dk);
            }
            .hero-photo {
                position: absolute;
                inset: 0;
                background-image: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1800&q=80');
                background-size: cover;
                background-position: center 30%;
                opacity: 0.18;
            }
            .hero-bg { position: absolute; inset: 0; overflow: hidden; }
            .hero-bg-grid {
                position: absolute;
                inset: 0;
                background-image:
                    linear-gradient(rgba(201,168,76,0.08) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(201,168,76,0.08) 1px, transparent 1px);
                background-size: 60px 60px;
            }
            .hero-bg-glow {
                position: absolute;
                top: -20%; right: -10%;
                width: 70%; height: 140%;
                background: radial-gradient(ellipse at center,
                    rgba(201,168,76,0.12) 0%,
                    rgba(45,129,118,0.06) 40%,
                    transparent 70%);
            }
            .hero-bg-accent {
                position: absolute;
                bottom: 0; left: 0;
                width: 100%; height: 1px;
                background: linear-gradient(90deg, transparent, rgba(201,168,76,0.5), transparent);
            }
            .hero-circle-1 {
                position: absolute; top: 15%; right: 8%;
                width: 320px; height: 320px;
                border-radius: 50%;
                border: 1px solid rgba(201,168,76,0.15);
            }
            .hero-circle-2 {
                position: absolute; top: 10%; right: 3%;
                width: 480px; height: 480px;
                border-radius: 50%;
                border: 1px solid rgba(201,168,76,0.08);
            }
            .hero-circle-3 {
                position: absolute; bottom: -10%; left: -5%;
                width: 400px; height: 400px;
                border-radius: 50%;
                border: 1px solid rgba(201,168,76,0.06);
            }
            .hero-inner {
                position: relative;
                z-index: 10;
                max-width: 760px;
                margin: 0 auto;
                padding: 100px 32px;
            }
            @media (max-width: 900px) {
                .hero-inner { padding: 72px 24px 60px; }
                .hero-right  { display: none; }
            }
            .hero-eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                font-size: 0.7rem;
                font-weight: 700;
                letter-spacing: 0.22em;
                text-transform: uppercase;
                color: var(--gold);
                margin-bottom: 22px;
            }
            .hero-eyebrow::before {
                content: '';
                width: 28px; height: 1px;
                background: var(--gold);
            }
            .hero-h1 {
                font-family: 'Libre Baskerville', serif;
                font-size: clamp(2.8rem, 5vw, 4.4rem);
                font-weight: 700;
                color: #fff;
                line-height: 1.12;
                letter-spacing: -0.02em;
                margin-bottom: 22px;
            }
            .hero-h1 em { font-style: italic; color: var(--gold); }
            .hero-p {
                font-size: 1.05rem;
                color: rgba(255,255,255,0.65);
                line-height: 1.7;
                max-width: 540px;
                margin-bottom: 38px;
            }
            .hero-cta { display: flex; gap: 14px; flex-wrap: wrap; }
            .btn-hero-primary {
                display: inline-flex;
                align-items: center;
                gap: 9px;
                padding: 14px 30px;
                background: var(--gold);
                color: var(--ink-dk, #1a1209);
                font-size: 0.8rem;
                font-weight: 700;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                border-radius: 8px;
                text-decoration: none;
                box-shadow: 0 6px 24px rgba(201,168,76,0.35);
                transition: background 0.15s, transform 0.12s, box-shadow 0.15s;
            }
            .btn-hero-primary:hover {
                background: #d9b85c;
                transform: translateY(-2px);
                box-shadow: 0 12px 32px rgba(201,168,76,0.4);
            }
            .btn-hero-secondary {
                display: inline-flex;
                align-items: center;
                gap: 9px;
                padding: 14px 30px;
                border: 1.5px solid rgba(255,255,255,0.2);
                color: rgba(255,255,255,0.85);
                font-size: 0.8rem;
                font-weight: 700;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                border-radius: 8px;
                text-decoration: none;
                transition: all 0.15s;
            }
            .btn-hero-secondary:hover {
                border-color: rgba(255,255,255,0.45);
                color: #fff;
                background: rgba(255,255,255,0.06);
            }

            /* ── Index bar ── */
            .index-bar {
                background: var(--parchment);
                border-bottom: 1px solid var(--border);
                padding: 14px 32px;
                overflow: hidden;
            }
            .index-bar-inner {
                max-width: 1280px;
                margin: 0 auto;
                display: flex;
                align-items: center;
                gap: 14px;
            }
            .index-bar-label {
                font-size: 0.62rem;
                font-weight: 800;
                letter-spacing: 0.18em;
                text-transform: uppercase;
                color: var(--ink-soft);
                white-space: nowrap;
                flex-shrink: 0;
            }
            .index-bar-divider {
                width: 1px; height: 18px;
                background: var(--border-dk);
                flex-shrink: 0;
            }
            .index-marquee-wrap { overflow: hidden; flex: 1; }
            .index-marquee {
                display: flex;
                gap: 40px;
                width: max-content;
                animation: marquee 28s linear infinite;
            }
            .index-marquee:hover { animation-play-state: paused; }
            @keyframes marquee {
                from { transform: translateX(0); }
                to   { transform: translateX(-50%); }
            }
            .index-chip {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                font-size: 0.72rem;
                font-weight: 700;
                color: var(--ink-mid);
                white-space: nowrap;
            }
            .index-chip-dot {
                width: 6px; height: 6px;
                border-radius: 50%;
                background: var(--teal);
                flex-shrink: 0;
            }

            /* ── Section base ── */
            .section { padding: 96px 32px; }
            .section-inner { max-width: 1280px; margin: 0 auto; }
            .section-header { text-align: center; margin-bottom: 60px; }
            .section-eyebrow {
                font-size: 0.68rem;
                font-weight: 700;
                letter-spacing: 0.22em;
                text-transform: uppercase;
                color: var(--teal);
                margin-bottom: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
            }
            .section-eyebrow::before,
            .section-eyebrow::after {
                content: '';
                width: 20px; height: 1px;
                background: var(--teal);
            }
            .section-title {
                font-family: 'Libre Baskerville', serif;
                font-size: clamp(1.8rem, 3vw, 2.6rem);
                font-weight: 700;
                color: var(--ink);
                line-height: 1.2;
                letter-spacing: -0.01em;
            }
            .section-title em { font-style: italic; color: var(--teal); }
            .section-sub { font-size: 0.95rem; color: var(--ink-soft); margin-top: 10px; }

            /* ── Metrics bar ── */
            .metrics-section { background: var(--teal-dk); padding: 64px 32px; }
            .metrics-grid {
                max-width: 1280px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                gap: 0;
            }
            @media (max-width: 800px) {
                .metrics-grid { grid-template-columns: repeat(3, 1fr); }
            }
            .metric-cell {
                padding: 28px 24px;
                border-right: 1px solid rgba(255,255,255,0.08);
                text-align: center;
                position: relative;
                transition: background 0.18s;
            }
            .metric-cell:last-child { border-right: none; }
            .metric-cell:hover { background: rgba(255,255,255,0.04); }
            .metric-val {
                font-family: 'Libre Baskerville', serif;
                font-size: 2.6rem;
                font-weight: 700;
                color: var(--gold);
                line-height: 1;
            }
            .metric-lbl {
                font-size: 0.65rem;
                font-weight: 700;
                letter-spacing: 0.16em;
                text-transform: uppercase;
                color: rgba(255,255,255,0.4);
                margin-top: 10px;
            }
            .metric-cell::after {
                content: '';
                position: absolute;
                bottom: 0; left: 50%;
                transform: translateX(-50%);
                width: 0; height: 2px;
                background: var(--gold);
                border-radius: 2px;
                transition: width 0.3s;
            }
            .metric-cell:hover::after { width: 32px; }

            /* ── Features / Why Publish ── */
            .features-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 20px;
            }
            @media (max-width: 900px) { .features-grid { grid-template-columns: repeat(2, 1fr); } }
            @media (max-width: 580px) { .features-grid { grid-template-columns: 1fr; } }
            .feature-card {
                background: #fff;
                border: 1px solid var(--border);
                border-radius: 16px;
                padding: 28px;
                transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
                position: relative;
                overflow: hidden;
            }
            .feature-card::before {
                content: '';
                position: absolute;
                top: 0; left: 0;
                width: 100%; height: 3px;
                background: linear-gradient(90deg, var(--teal), var(--gold));
                transform: scaleX(0);
                transform-origin: left;
                transition: transform 0.3s;
            }
            .feature-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 16px 40px rgba(45,129,118,0.1);
                border-color: rgba(45,129,118,0.2);
            }
            .feature-card:hover::before { transform: scaleX(1); }
            .feature-icon {
                width: 48px; height: 48px;
                border-radius: 12px;
                background: var(--teal-lt);
                border: 1px solid rgba(45,129,118,0.15);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 18px;
                color: var(--teal);
            }
            .feature-title {
                font-family: 'Libre Baskerville', serif;
                font-size: 1rem;
                font-weight: 700;
                color: var(--ink);
                margin-bottom: 8px;
            }
            .feature-desc { font-size: 0.85rem; color: var(--ink-soft); line-height: 1.65; }

            /* ── Process timeline ── */
            .process-section {
                background: var(--parchment);
                border-top: 1px solid var(--border);
                border-bottom: 1px solid var(--border);
            }
            .process-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 0;
            }
            @media (max-width: 760px) { .process-grid { grid-template-columns: repeat(2, 1fr); } }
            @media (max-width: 480px) { .process-grid { grid-template-columns: 1fr; } }
            .process-step {
                padding: 36px 28px;
                border-right: 1px solid var(--border);
                position: relative;
            }
            .process-step:last-child { border-right: none; }
            .process-step:not(:last-child)::after {
                content: '';
                position: absolute;
                top: 57px; right: -1px;
                width: 30px; height: 1px;
                background: linear-gradient(90deg, var(--border-dk), transparent);
                z-index: 2;
            }
            .process-step-head {
                display: flex;
                align-items: center;
                gap: 14px;
                margin-bottom: 18px;
            }
            .process-num-wrap {
                width: 44px; height: 44px;
                border-radius: 50%;
                background: #fff;
                border: 1.5px solid var(--border-dk);
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                transition: border-color 0.2s, box-shadow 0.2s;
            }
            .process-step:hover .process-num-wrap {
                border-color: var(--teal);
                box-shadow: 0 0 0 5px rgba(45,129,118,0.08);
            }
            .process-num {
                font-family: 'Libre Baskerville', serif;
                font-size: 0.78rem;
                font-weight: 700;
                color: var(--teal);
            }
            .process-title {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.05rem;
                font-weight: 700;
                color: var(--ink);
            }
            .process-days {
                display: inline-block;
                font-size: 0.63rem;
                font-weight: 700;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                color: var(--teal);
                background: var(--teal-lt);
                border: 1px solid rgba(45,129,118,0.18);
                padding: 3px 10px;
                border-radius: 20px;
                margin-bottom: 10px;
            }
            .process-desc { font-size: 0.83rem; color: var(--ink-soft); line-height: 1.6; }

            /* ── Live activity ── */
            .activity-section { background: #fff; }
            .activity-wrapper {
                display: grid;
                grid-template-columns: 1fr 420px;
                gap: 64px;
                align-items: start;
            }
            @media (max-width: 900px) { .activity-wrapper { grid-template-columns: 1fr; } }
            .activity-feed-wrap {
                background: var(--cream);
                border: 1px solid var(--border);
                border-radius: 16px;
                overflow: hidden;
            }
            .activity-feed-head {
                padding: 16px 22px;
                background: var(--parchment);
                border-bottom: 1px solid var(--border);
                display: flex;
                align-items: center;
                gap: 10px;
            }
            .live-dot {
                width: 8px; height: 8px;
                border-radius: 50%;
                background: var(--teal);
                animation: live-pulse 2s infinite;
            }
            @keyframes live-pulse {
                0%, 100% { box-shadow: 0 0 0 0 rgba(45,129,118,0.5); }
                50%       { box-shadow: 0 0 0 7px rgba(45,129,118,0); }
            }
            .activity-feed-body {
                height: 340px;
                overflow: hidden;
                position: relative;
            }
            .activity-feed-body::after {
                content: '';
                position: absolute;
                bottom: 0; left: 0;
                width: 100%; height: 60px;
                background: linear-gradient(to bottom, transparent, var(--cream));
                pointer-events: none;
                z-index: 2;
            }
            .activity-feed-scroll { animation: feed-scroll 18s linear infinite; }
            @keyframes feed-scroll {
                0%   { transform: translateY(0); }
                100% { transform: translateY(-50%); }
            }
            .activity-feed-scroll:hover { animation-play-state: paused; }
            .activity-item {
                display: flex;
                align-items: flex-start;
                gap: 14px;
                padding: 14px 22px;
                border-bottom: 1px solid var(--border);
                transition: background 0.12s;
            }
            .activity-item:hover { background: #fff; }
            .activity-icon {
                width: 36px; height: 36px;
                border-radius: 9px;
                background: var(--teal-lt);
                border: 1px solid rgba(45,129,118,0.15);
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                font-size: 1rem;
            }
            .activity-title { font-size: 0.85rem; font-weight: 700; color: var(--ink); }
            .activity-desc  { font-size: 0.78rem; color: var(--ink-soft); line-height: 1.5; margin-top: 2px; }
            .activity-time  { font-size: 0.68rem; color: var(--border-dk); margin-top: 4px; font-weight: 600; }

            /* ── Editorial board ── */
            .board-section { background: var(--parchment); border-top: 1px solid var(--border); }
            .board-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 18px;
            }
            @media (max-width: 900px) { .board-grid { grid-template-columns: repeat(2, 1fr); } }
            .board-card {
                background: #fff;
                border: 1px solid var(--border);
                border-radius: 14px;
                overflow: hidden;
                transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
            }
            .board-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 14px 36px rgba(45,129,118,0.1);
                border-color: rgba(45,129,118,0.2);
            }
            .board-card-top {
                height: 110px;
                background: linear-gradient(135deg, var(--teal-lt), rgba(201,168,76,0.08));
                display: flex; align-items: center; justify-content: center;
                position: relative;
            }
            .board-avatar {
                width: 60px; height: 60px;
                border-radius: 50%;
                background: var(--teal);
                border: 3px solid #fff;
                display: flex; align-items: center; justify-content: center;
                font-family: 'Libre Baskerville', serif;
                font-size: 1.1rem; font-weight: 700; color: #fff;
                box-shadow: 0 4px 14px rgba(45,129,118,0.25);
            }
            .board-card-body { padding: 16px 18px 20px; }
            .board-name {
                font-family: 'Libre Baskerville', serif;
                font-size: 0.92rem; font-weight: 700;
                color: var(--ink); margin-bottom: 3px;
            }
            .board-role {
                font-size: 0.65rem; font-weight: 700;
                letter-spacing: 0.1em; text-transform: uppercase;
                color: var(--teal); margin-bottom: 6px;
            }
            .board-expertise { font-size: 0.78rem; color: var(--ink-soft); }

            /* ══════════════════════════════════════════════
               ── Research Fields  (REDESIGNED) ────────────
               ══════════════════════════════════════════════ */
            .fields-grid {
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                gap: 14px;
            }
            @media (max-width: 1100px) { .fields-grid { grid-template-columns: repeat(4, 1fr); } }
            @media (max-width: 860px)  { .fields-grid { grid-template-columns: repeat(3, 1fr); } }
            @media (max-width: 560px)  { .fields-grid { grid-template-columns: repeat(2, 1fr); } }

            .field-card {
                background: #fff;
                border: 1px solid var(--border);
                border-radius: 16px;
                padding: 22px 18px 20px;
                transition: all 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
                cursor: pointer;
                position: relative;
                overflow: hidden;
                display: flex;
                flex-direction: column;
            }

            /* Colored top stripe */
            .field-card::before {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0;
                height: 3px;
                background: var(--field-color, var(--teal));
                border-radius: 16px 16px 0 0;
                transition: height 0.28s ease;
                z-index: 2;
            }

            /* Subtle background tint on hover */
            .field-card::after {
                content: '';
                position: absolute;
                inset: 0;
                background: var(--field-bg, rgba(45,129,118,0.04));
                opacity: 0;
                transition: opacity 0.22s ease;
                border-radius: 16px;
                z-index: 0;
            }

            .field-card:hover::after  { opacity: 1; }
            .field-card:hover::before { height: 5px; }
            .field-card:hover {
                transform: translateY(-6px) scale(1.02);
                box-shadow: 0 20px 48px -8px var(--field-shadow, rgba(45,129,118,0.18));
                border-color: var(--field-color, var(--teal));
            }

            /* Push all children above the pseudo bg */
            .field-card > * { position: relative; z-index: 1; }

            .field-icon {
                width: 46px; height: 46px;
                border-radius: 13px;
                background: var(--field-icon-bg, var(--teal-lt));
                border: 1.5px solid var(--field-icon-border, rgba(45,129,118,0.15));
                display: flex; align-items: center; justify-content: center;
                margin-bottom: 16px;
                color: var(--field-color, var(--teal));
                transition: all 0.28s ease;
                flex-shrink: 0;
            }
            .field-card:hover .field-icon {
                background: var(--field-color, var(--teal));
                border-color: var(--field-color, var(--teal));
                color: #fff;
                transform: rotate(-6deg) scale(1.1);
                box-shadow: 0 6px 18px var(--field-shadow, rgba(45,129,118,0.3));
            }

            .field-name {
                font-family: 'Libre Baskerville', serif;
                font-size: 0.82rem;
                font-weight: 700;
                color: var(--ink);
                line-height: 1.4;
                margin-bottom: 8px;
                transition: color 0.2s;
            }
            .field-card:hover .field-name { color: var(--field-color, var(--teal)); }

            .field-count {
                font-size: 0.65rem;
                font-weight: 700;
                color: var(--ink-soft);
                letter-spacing: 0.04em;
                display: flex;
                align-items: center;
                gap: 5px;
                margin-top: auto;
            }
            .field-count::before {
                content: '';
                width: 14px; height: 1.5px;
                background: var(--field-color, var(--teal));
                display: inline-block;
                opacity: 0.5;
                border-radius: 2px;
            }

            /* ── 10 color themes (cycling) ── */
            .field-c1 {
                --field-color: #2d8176;
                --field-bg: rgba(45,129,118,0.05);
                --field-icon-bg: #e8f4f2;
                --field-icon-border: rgba(45,129,118,0.18);
                --field-shadow: rgba(45,129,118,0.2);
            }
            .field-c2 {
                --field-color: #7c3aed;
                --field-bg: rgba(124,58,237,0.05);
                --field-icon-bg: #f3eeff;
                --field-icon-border: rgba(124,58,237,0.15);
                --field-shadow: rgba(124,58,237,0.2);
            }
            .field-c3 {
                --field-color: #b45309;
                --field-bg: rgba(180,83,9,0.05);
                --field-icon-bg: #fff4e0;
                --field-icon-border: rgba(180,83,9,0.15);
                --field-shadow: rgba(180,83,9,0.2);
            }
            .field-c4 {
                --field-color: #0e7490;
                --field-bg: rgba(14,116,144,0.05);
                --field-icon-bg: #e0f6fc;
                --field-icon-border: rgba(14,116,144,0.16);
                --field-shadow: rgba(14,116,144,0.2);
            }
            .field-c5 {
                --field-color: #c9a84c;
                --field-bg: rgba(201,168,76,0.06);
                --field-icon-bg: #fdf6e3;
                --field-icon-border: rgba(201,168,76,0.2);
                --field-shadow: rgba(201,168,76,0.22);
            }
            .field-c6 {
                --field-color: #be185d;
                --field-bg: rgba(190,24,93,0.05);
                --field-icon-bg: #fce7f3;
                --field-icon-border: rgba(190,24,93,0.14);
                --field-shadow: rgba(190,24,93,0.2);
            }
            .field-c7 {
                --field-color: #166534;
                --field-bg: rgba(22,101,52,0.05);
                --field-icon-bg: #dcfce7;
                --field-icon-border: rgba(22,101,52,0.15);
                --field-shadow: rgba(22,101,52,0.18);
            }
            .field-c8 {
                --field-color: #1d4ed8;
                --field-bg: rgba(29,78,216,0.05);
                --field-icon-bg: #e0eaff;
                --field-icon-border: rgba(29,78,216,0.14);
                --field-shadow: rgba(29,78,216,0.2);
            }
            .field-c9 {
                --field-color: #9d174d;
                --field-bg: rgba(157,23,77,0.05);
                --field-icon-bg: #fdf2f8;
                --field-icon-border: rgba(157,23,77,0.14);
                --field-shadow: rgba(157,23,77,0.2);
            }
            .field-c10 {
                --field-color: #0f766e;
                --field-bg: rgba(15,118,110,0.05);
                --field-icon-bg: #ccfbf1;
                --field-icon-border: rgba(15,118,110,0.15);
                --field-shadow: rgba(15,118,110,0.2);
            }
            /* ══════════════════════════════════════════════ */

            /* ── Trust badges ── */
            .trust-section { background: var(--teal-dk); padding: 60px 32px; }
            .trust-inner { max-width: 1280px; margin: 0 auto; }
            .trust-label {
                text-align: center;
                font-size: 0.65rem; font-weight: 700;
                letter-spacing: 0.22em; text-transform: uppercase;
                color: rgba(255,255,255,0.35);
                margin-bottom: 28px;
            }
            .trust-items {
                display: flex; align-items: center;
                justify-content: center;
                gap: 40px; flex-wrap: wrap;
            }
            .trust-item {
                display: flex; align-items: center; gap: 9px;
                font-size: 0.78rem; font-weight: 700;
                letter-spacing: 0.06em; text-transform: uppercase;
                color: rgba(255,255,255,0.5);
                transition: color 0.15s;
            }
            .trust-item:hover { color: var(--gold); }
            .trust-check {
                width: 20px; height: 20px;
                border-radius: 50%;
                background: rgba(201,168,76,0.18);
                border: 1px solid rgba(201,168,76,0.3);
                display: flex; align-items: center; justify-content: center;
                color: var(--gold); flex-shrink: 0;
            }
            .trust-divider { width: 1px; height: 16px; background: rgba(255,255,255,0.1); }

            /* ── Footer ── */
            footer {
                background: var(--ink);
                color: rgba(255,255,255,0.45);
                padding: 64px 32px 40px;
            }
            .footer-inner {
                max-width: 1280px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: 1.4fr 1fr 1fr 1fr;
                gap: 48px;
                padding-bottom: 48px;
                border-bottom: 1px solid rgba(255,255,255,0.08);
                margin-bottom: 32px;
            }
            @media (max-width: 860px) { .footer-inner { grid-template-columns: 1fr 1fr; gap: 32px; } }
            .footer-brand-name { font-family: 'Libre Baskerville', serif; font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 4px; }
            .footer-brand-sub  { font-size: 0.62rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--gold); }
            .footer-brand-desc { font-size: 0.82rem; line-height: 1.65; margin-top: 14px; }
            .footer-col-title  { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 16px; }
            .footer-links { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 9px; }
            .footer-links a { font-size: 0.82rem; color: rgba(255,255,255,0.4); text-decoration: none; transition: color 0.15s; }
            .footer-links a:hover { color: var(--gold); }
            .footer-bottom {
                max-width: 1280px; margin: 0 auto;
                display: flex; align-items: center;
                justify-content: space-between;
                gap: 16px; flex-wrap: wrap;
            }
            .footer-copy    { font-size: 0.72rem; color: rgba(255,255,255,0.25); letter-spacing: 0.04em; }
            .footer-tagline { font-size: 0.62rem; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase; color: rgba(255,255,255,0.18); }

            /* ── Scroll-top ── */
            #scroll-top {
                position: fixed;
                bottom: 32px; right: 32px;
                width: 48px; height: 48px;
                background: var(--teal); color: #fff;
                border-radius: 50%; border: none; cursor: pointer;
                display: flex; align-items: center; justify-content: center;
                box-shadow: 0 6px 20px rgba(45,129,118,0.35);
                z-index: 40;
                opacity: 0; transform: translateY(16px);
                transition: opacity 0.3s, transform 0.3s, background 0.15s;
            }
            #scroll-top.show { opacity: 1; transform: translateY(0); }
            #scroll-top:hover { background: var(--teal-dk); }

            /* ── Animations ── */
            .fade-up {
                opacity: 0;
                transform: translateY(22px);
                transition: opacity 0.6s ease, transform 0.6s ease;
            }
            .fade-up.visible { opacity: 1; transform: translateY(0); }
            .fade-up-1 { transition-delay: 0.08s; }
            .fade-up-2 { transition-delay: 0.16s; }
            .fade-up-3 { transition-delay: 0.24s; }
            .fade-up-4 { transition-delay: 0.32s; }
        </style>
    </head>
    <body>
        {{-- Shimmer --}}
        <div class="shimmer-bar sticky top-0 z-[60]"></div>

        {{-- Navbar --}}
        <nav class="navbar">
            <div class="nav-inner">
                <a href="/" class="nav-logo">
                    <div class="nav-logo-icon">
                        <svg width="22" height="22" fill="none" stroke="#f0d678" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="nav-logo-text">
                        <span class="nav-logo-name">Journal System</span>
                        <span class="nav-logo-sub">Academic Publishing Portal Research Journal</span>
                    </div>
                </a>
                <div class="nav-links hidden md:flex">
                    <a href="/published-papers" class="nav-link">Published Papers</a>
                    <a href="#process"           class="nav-link">Review Process</a>
                    <a href="#fields"            class="nav-link">Research Fields</a>
                    <a href="/login"             class="nav-link">Sign In</a>
                    <a href="/register"          class="btn-nav-register">Submit Manuscript</a>
                </div>
            </div>
        </nav>

        {{-- Hero --}}
        <header class="hero">
            <div class="hero-photo"></div>
            <div class="hero-bg">
                <div class="hero-bg-grid"></div>
                <div class="hero-bg-glow"></div>
                <div class="hero-bg-accent"></div>
                <div class="hero-circle-1"></div>
                <div class="hero-circle-2"></div>
                <div class="hero-circle-3"></div>
            </div>
            <div class="hero-inner">
                <div>
                    <p class="hero-eyebrow">Peer-Reviewed · Open Access · ISSN Registered</p>
                    <h1 class="hero-h1">
                        Advancing Research.<br>
                        <em>Inspiring Innovation.</em>
                    </h1>
                    <p class="hero-p">
                        The official international peer-reviewed journal publishing high-impact research
                        in engineering, science, information technology, and innovation.
                    </p>
                    <div class="hero-cta">
                        <a href="/register" class="btn-hero-primary">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Submit Manuscript
                        </a>
                        <a href="#process" class="btn-hero-secondary">
                            Review Process
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        {{-- Index bar --}}
        <div class="index-bar">
            <div class="index-bar-inner">
                <span class="index-bar-label">Indexed In</span>
                <div class="index-bar-divider"></div>
                <div class="index-marquee-wrap">
                    <div class="index-marquee">
                        @php
                            $indexItems = ['Analie','Macky','Nicko','Ralph','Carlos','Analie','Macky','Nicko','Ralph','Carlos','Analie','Macky','Nicko','Ralph','Carlos','Analie','Macky','Nicko','Ralph','Carlos'];
                        @endphp
                        @foreach ($indexItems as $item)
                            <span class="index-chip">
                                <span class="index-chip-dot"></span>
                                {{ $item }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Metrics --}}
        @if ($publishedPapersCount > 0 || $activeReviewersCount > 0 || $avgReviewDays > 0 || $acceptanceRate > 0)
            <div class="metrics-section">
                <div class="metrics-grid">
                    <div class="metric-cell">
                        <div class="metric-val">{{ $publishedPapersCount }}</div>
                        <div class="metric-lbl">Published Articles</div>
                    </div>
                    <div class="metric-cell">
                        <div class="metric-val">{{ $activeReviewersCount }}</div>
                        <div class="metric-lbl">Active Reviewers</div>
                    </div>
                    <div class="metric-cell">
                        <div class="metric-val">{{ $avgReviewDays }}d</div>
                        <div class="metric-lbl">Avg. Review Time</div>
                    </div>
                    <div class="metric-cell">
                        <div class="metric-val">{{ $acceptanceRate }}%</div>
                        <div class="metric-lbl">Acceptance Rate</div>
                    </div>
                    <div class="metric-cell">
                        <div class="metric-val">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="metric-lbl">DOI Registered</div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Why Publish --}}
        <section class="section" style="background:#fff">
            <div class="section-inner">
                <div class="section-header fade-up">
                    <p class="section-eyebrow">Benefits</p>
                    <h2 class="section-title">Why Publish With <em>Journal System</em></h2>
                    <p class="section-sub">Key advantages of our double-blind peer-reviewed journal</p>
                </div>
                <div class="features-grid">
                    @php
                        $features = [
                            ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>', 'title' => 'Fast Review Cycle', 'desc' => 'Quality editorial decisions delivered promptly. We respect your time without compromising on scholarly standards.'],
                            ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>', 'title' => 'Global Reach', 'desc' => 'International expert reviewers across all engineering and science domains ensuring world-class evaluation.'],
                            ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>', 'title' => 'Double-Blind Review', 'desc' => 'Rigorous anonymous peer evaluation ensuring unbiased, merit-based assessment.'],
                            ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>', 'title' => 'Real-Time Tracking', 'desc' => 'Live status updates throughout the entire review process — no more waiting in the dark.'],
                            ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>', 'title' => 'Open Access & DOI', 'desc' => 'Every published article receives a unique DOI and is freely accessible to maximize global impact.'],
                            ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>', 'title' => 'Dedicated Support', 'desc' => 'Expert editorial guidance from submission to publication, every step of the way.'],
                        ];
                    @endphp
                    @foreach ($features as $i => $f)
                        <div class="feature-card fade-up fade-up-{{ ($i % 3) + 1 }}">
                            <div class="feature-icon">
                                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    {!! $f['icon'] !!}
                                </svg>
                            </div>
                            <h3 class="feature-title">{{ $f['title'] }}</h3>
                            <p class="feature-desc">{{ $f['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Process --}}
        <section class="section process-section" id="process">
            <div class="section-inner">
                <div class="section-header fade-up">
                    <p class="section-eyebrow">Workflow</p>
                    <h2 class="section-title">From Submission to <em>Publication</em></h2>
                    <p class="section-sub">A transparent, structured process designed for scholarly excellence</p>
                </div>
                <div class="process-grid">
                    @php
                        $steps = [
                            ['num' => '01', 'title' => 'Submit',  'days' => '1–2 days',   'desc' => 'Upload your manuscript, abstract, keywords, and author affiliations through our secure portal.'],
                            ['num' => '02', 'title' => 'Screen',  'days' => '3–5 days',   'desc' => 'Editorial board conducts initial screening for scope, formatting, and ethical compliance.'],
                            ['num' => '03', 'title' => 'Review',  'days' => '10–14 days', 'desc' => 'Two or more expert reviewers provide detailed double-blind evaluations and recommendations.'],
                            ['num' => '04', 'title' => 'Publish', 'days' => '3–5 days',   'desc' => 'Accepted articles receive DOI registration, professional layout, and global distribution.'],
                        ];
                    @endphp
                    @foreach ($steps as $s)
                        <div class="process-step fade-up">
                            <div class="process-step-head">
                                <div class="process-num-wrap">
                                    <span class="process-num">{{ $s['num'] }}</span>
                                </div>
                                <h3 class="process-title">{{ $s['title'] }}</h3>
                            </div>
                            <span class="process-days">{{ $s['days'] }}</span>
                            <p class="process-desc">{{ $s['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Live Activity + CTA --}}
        <section class="section activity-section">
            <div class="section-inner">
                <div class="activity-wrapper">
                    <div>
                        <div class="fade-up" style="margin-bottom:48px">
                            <p class="section-eyebrow" style="justify-content:flex-start;margin-bottom:12px">Live Feed</p>
                            <h2 class="section-title" style="text-align:left;margin-bottom:10px">
                                Research Activity <em>In Progress</em>
                            </h2>
                            <p class="section-sub" style="text-align:left">
                                Real-time updates from our scholarly community — submissions, reviews, and publications happening now.
                            </p>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:14px" class="fade-up fade-up-2">
                            <div style="background:var(--teal-dk);border-radius:14px;padding:28px 28px 24px;border:1px solid rgba(201,168,76,0.15)">
                                <p style="font-size:0.62rem;font-weight:800;letter-spacing:0.2em;text-transform:uppercase;color:var(--gold);margin-bottom:10px">For Authors</p>
                                <p style="font-family:'Libre Baskerville',serif;font-size:1.05rem;font-weight:700;color:#fff;margin-bottom:6px">Ready to submit your research?</p>
                                <p style="font-size:0.82rem;color:rgba(255,255,255,0.55);margin-bottom:18px;line-height:1.6">Join hundreds of researchers publishing their work through our platform.</p>
                                <a href="/register" style="display:inline-flex;align-items:center;gap:8px;padding:10px 22px;background:var(--gold);color:var(--ink);font-size:0.74rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;border-radius:7px;text-decoration:none">
                                    Begin Submission →
                                </a>
                            </div>
                            <div style="background:var(--parchment);border-radius:14px;padding:28px 28px 24px;border:1px solid var(--border-dk)">
                                <p style="font-size:0.62rem;font-weight:800;letter-spacing:0.2em;text-transform:uppercase;color:var(--teal);margin-bottom:10px">For Reviewers</p>
                                <p style="font-family:'Libre Baskerville',serif;font-size:1.05rem;font-weight:700;color:var(--ink);margin-bottom:6px">Become a peer reviewer</p>
                                <p style="font-size:0.82rem;color:var(--ink-soft);margin-bottom:18px;line-height:1.6">Contribute to scholarly excellence and build your academic reputation.</p>
                                <a href="/register" style="display:inline-flex;align-items:center;gap:8px;padding:10px 22px;background:var(--teal);color:#fff;font-size:0.74rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;border-radius:7px;text-decoration:none;box-shadow:0 4px 14px rgba(45,129,118,0.25)">
                                    Join as Reviewer →
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="activity-feed-wrap fade-up fade-up-3">
                        <div class="activity-feed-head">
                            <div class="live-dot"></div>
                            <span style="font-size:0.65rem;font-weight:800;letter-spacing:0.16em;text-transform:uppercase;color:var(--teal)">Live Feed</span>
                            <span style="margin-left:auto;font-size:0.68rem;color:var(--border-dk);font-weight:600">
                                {{ $liveActivities->count() }} recent events
                            </span>
                        </div>
                        <div class="activity-feed-body">
                            <div class="activity-feed-scroll">
                                @php $icons = ['📄','🔍','✅','📝','🏆','📬','✍️','🔔']; @endphp
                                @forelse ($liveActivities as $i => $activity)
                                    <div class="activity-item">
                                        <div class="activity-icon">{{ $icons[$i % count($icons)] }}</div>
                                        <div>
                                            <div class="activity-title">{{ $activity['title'] }}</div>
                                            <div class="activity-desc">{{ Str::limit($activity['description'], 72) }}</div>
                                            <div class="activity-time">
                                                {{ $activity['timestamp'] ? $activity['timestamp']->diffForHumans() : 'recently' }}
                                                · {{ $activity['category'] }}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="activity-item">
                                        <div class="activity-icon">📄</div>
                                        <div>
                                            <div class="activity-title">Awaiting submissions</div>
                                            <div class="activity-desc">Be the first to submit your research to Journal System.</div>
                                        </div>
                                    </div>
                                @endforelse
                                {{-- duplicate for seamless scroll --}}
                                @forelse ($liveActivities as $i => $activity)
                                    <div class="activity-item">
                                        <div class="activity-icon">{{ $icons[$i % count($icons)] }}</div>
                                        <div>
                                            <div class="activity-title">{{ $activity['title'] }}</div>
                                            <div class="activity-desc">{{ Str::limit($activity['description'], 72) }}</div>
                                            <div class="activity-time">
                                                {{ $activity['timestamp'] ? $activity['timestamp']->diffForHumans() : 'recently' }}
                                                · {{ $activity['category'] }}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Editorial Board --}}
        <section class="section board-section">
            <div class="section-inner">
                <div class="section-header fade-up">
                    <p class="section-eyebrow">Editorial Board</p>
                    <h2 class="section-title">The Scholars Behind <em>Journal System</em></h2>
                    <p class="section-sub">Leading academics ensuring the highest standards of scholarly excellence</p>
                </div>
                @php
                    function boardInitials(string $name): string {
                        $clean = preg_replace('/\b(Dr|Prof|Mr|Mrs|Ms|Engr|Atty|Rev)\.?\s*/i', '', $name);
                        $words = array_values(array_filter(explode(' ', trim($clean))));
                        if (count($words) === 0) return '?';
                        if (count($words) === 1) return mb_strtoupper(mb_substr($words[0], 0, 2));
                        return mb_strtoupper(mb_substr($words[0], 0, 1) . mb_substr(end($words), 0, 1));
                    }
                @endphp
                <div class="board-grid">
                    @forelse ($editorialBoard as $i => $member)
                        <div class="board-card fade-up fade-up-{{ ($i % 4) + 1 }}">
                            <div class="board-card-top">
                                <div class="board-avatar">{{ boardInitials($member['name']) }}</div>
                            </div>
                            <div class="board-card-body">
                                <div class="board-name">{{ $member['name'] }}</div>
                                <div class="board-role">{{ ucfirst(str_replace('_', ' ', $member['role'])) }}</div>
                                <div class="board-expertise">{{ $member['expertise'] }}</div>
                            </div>
                        </div>
                    @empty
                        @foreach ([
                            ['name' => 'Dr. Rafael Santos', 'role' => 'Editor in Chief',  'expertise' => 'Computer Science'],
                            ['name' => 'Dr. Maria Reyes',   'role' => 'Managing Editor',  'expertise' => 'Information Technology'],
                            ['name' => 'Prof. Jose Lim',    'role' => 'Senior Editor',     'expertise' => 'Electrical Engineering'],
                            ['name' => 'Dr. Ana Cruz',      'role' => 'Associate Editor',  'expertise' => 'Data Science & AI'],
                        ] as $i => $m)
                            <div class="board-card fade-up fade-up-{{ $i + 1 }}">
                                <div class="board-card-top">
                                    <div class="board-avatar">{{ boardInitials($m['name']) }}</div>
                                </div>
                                <div class="board-card-body">
                                    <div class="board-name">{{ $m['name'] }}</div>
                                    <div class="board-role">{{ $m['role'] }}</div>
                                    <div class="board-expertise">{{ $m['expertise'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </section>

        {{-- ══════════════════════════════════════════
             Research Fields  (REDESIGNED)
             ══════════════════════════════════════════ --}}
        <section class="section" id="fields" style="background:#fff">
            <div class="section-inner">
                <div class="section-header fade-up">
                    <p class="section-eyebrow">Scope</p>
                    <h2 class="section-title">Research <em>Fields & Topics</em></h2>
                    <p class="section-sub">Explore the diverse disciplines covered in our journal</p>
                </div>

                @php
                    $fieldIconMap = [
                        'science'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3v6.75l-1.5 2.25m1.5-2.25h4.5m-4.5 0L7.5 15.75M12 3v6.75m2.25 2.25L12 15.75m0 0L9.75 15.75m2.25 0v3.75m0 0H9.75m2.25 0h2.25M3.375 15.75h17.25"/>',
                        'technolog'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3v6.75l-1.5 2.25m1.5-2.25h4.5m-4.5 0L7.5 15.75M12 3v6.75m2.25 2.25L12 15.75m0 0L9.75 15.75m2.25 0v3.75m0 0H9.75m2.25 0h2.25M3.375 15.75h17.25"/>',
                        'engineer'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437"/>',
                        'mechanical'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437"/>',
                        'health'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>',
                        'medical'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>',
                        'information' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"/>',
                        'system'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"/>',
                        'computer'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"/>',
                        'software'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"/>',
                        'business'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0"/>',
                        'manage'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0"/>',
                        'educat'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>',
                        'social'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>',
                        'environ'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 01-1.161.886l-.143.048a1.107 1.107 0 00-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 01-1.652.928l-.679-.906a1.125 1.125 0 00-1.906.172L4.5 15.75l-.612.153M12.75 3.03a9 9 0 10-8.831 12.329"/>',
                        'sustain'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 01-1.161.886l-.143.048a1.107 1.107 0 00-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 01-1.652.928l-.679-.906a1.125 1.125 0 00-1.906.172L4.5 15.75l-.612.153M12.75 3.03a9 9 0 10-8.831 12.329"/>',
                        'math'        => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.745 3A23.933 23.933 0 003 12c0 3.183.62 6.22 1.745 9M19.255 3A23.933 23.933 0 0121 12c0 3.183-.62 6.22-1.745 9M8.25 8.885l1.444-.89a.75.75 0 011.105.402l2.402 7.206a.75.75 0 001.104.401l1.445-.889m-8.25.75l.213.09a1.687 1.687 0 002.062-.617l4.45-6.676a1.688 1.688 0 012.062-.618l.213.09"/>',
                        'statistic'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.745 3A23.933 23.933 0 003 12c0 3.183.62 6.22 1.745 9M19.255 3A23.933 23.933 0 0121 12c0 3.183-.62 6.22-1.745 9M8.25 8.885l1.444-.89a.75.75 0 011.105.402l2.402 7.206a.75.75 0 001.104.401l1.445-.889m-8.25.75l.213.09a1.687 1.687 0 002.062-.617l4.45-6.676a1.688 1.688 0 012.062-.618l.213.09"/>',
                        'humanit'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>',
                        'arts'        => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>',
                        'data'        => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>',
                        'analytic'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>',
                        'energy'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>',
                        'renewable'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>',
                        'artificial'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714a2.25 2.25 0 001.357 2.059l.537.268a2.25 2.25 0 001.357.208l1.26-.252m-5.511-7.235c.251.023.501.05.75.082M15 3.186a24.3 24.3 0 01-4.5 0M5 14.5l-.408.816a2.25 2.25 0 002.01 3.25h10.797a2.25 2.25 0 002.01-3.25L19 14.5M5 14.5h14"/>',
                        'machine'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714a2.25 2.25 0 001.357 2.059l.537.268a2.25 2.25 0 001.357.208l1.26-.252m-5.511-7.235c.251.023.501.05.75.082M15 3.186a24.3 24.3 0 01-4.5 0M5 14.5l-.408.816a2.25 2.25 0 002.01 3.25h10.797a2.25 2.25 0 002.01-3.25L19 14.5M5 14.5h14"/>',
                        'network'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/>',
                        'cloud'       => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z"/>',
                        'default'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>',
                    ];

                    function getFieldIcon(string $name, array $map): string {
                        $lower = strtolower($name);
                        foreach ($map as $keyword => $svg) {
                            if ($keyword !== 'default' && str_contains($lower, $keyword)) return $svg;
                        }
                        return $map['default'];
                    }

                    $colorClasses = ['field-c1','field-c2','field-c3','field-c4','field-c5',
                                     'field-c6','field-c7','field-c8','field-c9','field-c10'];
                @endphp

                <div class="fields-grid">
                    @forelse ($researchFields as $idx => $field)
                        <div class="field-card {{ $colorClasses[$idx % count($colorClasses)] }} fade-up">
                            <div class="field-icon">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    {!! getFieldIcon($field['name'], $fieldIconMap) !!}
                                </svg>
                            </div>
                            <div class="field-name">{{ $field['name'] }}</div>
                            @if (!empty($field['count']) && $field['count'] > 0)
                                <div class="field-count">
                                    {{ $field['count'] }} {{ $field['count'] == 1 ? 'paper' : 'papers' }}
                                </div>
                            @endif
                        </div>
                    @empty
                        @foreach (['Artificial Intelligence','Software Engineering','Cybersecurity','Renewable Energy',
                                    'Data Science','Biotechnology','Networking','Cloud Computing','IoT Systems','Innovation']
                                  as $idx => $name)
                            <div class="field-card {{ $colorClasses[$idx % count($colorClasses)] }} fade-up">
                                <div class="field-icon">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        {!! getFieldIcon($name, $fieldIconMap) !!}
                                    </svg>
                                </div>
                                <div class="field-name">{{ $name }}</div>
                            </div>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </section>

        {{-- Trust bar --}}
        <div class="trust-section">
            <div class="trust-inner">
                <p class="trust-label">Trusted by the Academic Community</p>
                <div class="trust-items">
                    @foreach (['Double-Blind Review','Open Access Policy','DOI Registered','Crossref Member','Google Scholar'] as $i => $t)
                        @if ($i > 0)<div class="trust-divider"></div>@endif
                        <div class="trust-item">
                            <div class="trust-check">
                                <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            {{ $t }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <footer>
            <div class="footer-inner">
                <div>
                    <div class="footer-brand-name">Journal System</div>
                    <div class="footer-brand-sub">Academic Publishing Portal Int'l Research Journal</div>
                    <p class="footer-brand-desc">
                        The official peer-reviewed international journal of our institution, committed to advancing
                        knowledge in engineering, science, and technology.
                    </p>
                </div>
                <div>
                    <p class="footer-col-title">Journal</p>
                    <ul class="footer-links">
                        <li><a href="/published-papers">Published Papers</a></li>
                        <li><a href="#process">Review Process</a></li>
                        <li><a href="#fields">Research Fields</a></li>
                        <li><a href="#">Aims & Scope</a></li>
                        <li><a href="#">Author Guidelines</a></li>
                    </ul>
                </div>
                <div>
                    <p class="footer-col-title">Account</p>
                    <ul class="footer-links">
                        <li><a href="/register">Register</a></li>
                        <li><a href="/login">Sign In</a></li>
                        <li><a href="/register">Submit Manuscript</a></li>
                    </ul>
                </div>
                <div>
                    <p class="footer-col-title">Institution</p>
                    <ul class="footer-links">
                        <li><a href="#">our institution</a></li>
                        <li><a href="#">Editorial Board</a></li>
                        <li><a href="#">Ethics Policy</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span class="footer-copy">
                    © {{ date('Y') }} Journal System — Academic Publishing Portal International Research Journal. All rights reserved.
                </span>
                <span class="footer-tagline">Advancing Knowledge · Inspiring Innovation</span>
            </div>
        </footer>

        {{-- Scroll top --}}
        <button id="scroll-top" onclick="window.scrollTo({top:0,behavior:'smooth'})" aria-label="Scroll to top">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
            </svg>
        </button>

        <script>
            const scrollBtn = document.getElementById('scroll-top');
            window.addEventListener('scroll', () => {
                scrollBtn.classList.toggle('show', window.scrollY > 400);
            });

            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((e) => {
                        if (e.isIntersecting) {
                            e.target.classList.add('visible');
                            observer.unobserve(e.target);
                        }
                    });
                },
                { threshold: 0.12, rootMargin: '0px 0px -60px 0px' }
            );
            document.querySelectorAll('.fade-up').forEach((el) => observer.observe(el));
        </script>
    </body>
</html>