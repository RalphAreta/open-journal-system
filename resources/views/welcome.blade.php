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
                from {
                    background-position: -200% 0;
                }
                to {
                    background-position: 200% 0;
                }
            }

            /* ── Navbar ── */
            .navbar {
                background: rgba(250, 246, 239, 0.95);
                backdrop-filter: blur(14px);
                border-bottom: 1px solid var(--border);
                position: sticky;
                top: 3px;
                z-index: 50;
            }
            .nav-inner {
                max-width: 1280px;
                margin: 0 auto;
                padding: 0 20px;
                height: 64px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
            }
            @media (min-width: 768px) {
                .nav-inner {
                    padding: 0 32px;
                    height: 72px;
                }
            }

            .nav-logo {
                display: flex;
                align-items: center;
                gap: 10px;
                text-decoration: none;
                flex-shrink: 0;
            }
            .nav-logo-icon {
                width: 36px;
                height: 36px;
                background: var(--teal);
                border-radius: 9px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 14px rgba(45, 129, 118, 0.25);
                transition: transform 0.2s;
                flex-shrink: 0;
            }
            @media (min-width: 768px) {
                .nav-logo-icon {
                    width: 42px;
                    height: 42px;
                    border-radius: 10px;
                }
            }
            .nav-logo:hover .nav-logo-icon {
                transform: rotate(8deg);
            }
            .nav-logo-text {
                line-height: 1;
                min-width: 0;
            }
            .nav-logo-name {
                font-family: 'Libre Baskerville', serif;
                font-size: 1rem;
                font-weight: 700;
                color: var(--teal-dk);
                display: block;
                white-space: nowrap;
            }
            @media (min-width: 768px) {
                .nav-logo-name {
                    font-size: 1.15rem;
                }
            }
            .nav-logo-sub {
                font-size: 0.55rem;
                font-weight: 700;
                letter-spacing: 0.16em;
                text-transform: uppercase;
                color: var(--gold-dk);
                display: none;
                margin-top: 2px;
            }
            @media (min-width: 640px) {
                .nav-logo-sub {
                    display: block;
                }
            }

            .nav-links {
                display: none;
                align-items: center;
                gap: 36px;
            }
            @media (min-width: 768px) {
                .nav-links {
                    display: flex;
                }
            }

            .nav-link {
                font-size: 0.82rem;
                font-weight: 600;
                letter-spacing: 0.03em;
                color: var(--ink-soft);
                text-decoration: none;
                transition: color 0.15s;
                position: relative;
                white-space: nowrap;
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
            .nav-link:hover {
                color: var(--teal);
            }
            .nav-link:hover::after {
                width: 100%;
            }

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
                transition:
                    background 0.15s,
                    transform 0.12s,
                    box-shadow 0.15s;
                white-space: nowrap;
            }
            .btn-nav-register:hover {
                background: var(--teal-dk);
                transform: translateY(-1px);
                box-shadow: 0 8px 20px rgba(45, 129, 118, 0.32);
            }

            .nav-hamburger {
                display: flex;
                flex-direction: column;
                justify-content: center;
                gap: 5px;
                width: 36px;
                height: 36px;
                padding: 6px;
                background: none;
                border: none;
                cursor: pointer;
                border-radius: 8px;
                transition: background 0.15s;
                flex-shrink: 0;
            }
            .nav-hamburger:hover {
                background: rgba(45, 129, 118, 0.08);
            }
            @media (min-width: 768px) {
                .nav-hamburger {
                    display: none;
                }
            }
            .nav-hamburger span {
                display: block;
                width: 100%;
                height: 2px;
                background: var(--teal-dk);
                border-radius: 2px;
                transition: all 0.25s ease;
                transform-origin: center;
            }
            .nav-hamburger.open span:nth-child(1) {
                transform: translateY(7px) rotate(45deg);
            }
            .nav-hamburger.open span:nth-child(2) {
                opacity: 0;
                transform: scaleX(0);
            }
            .nav-hamburger.open span:nth-child(3) {
                transform: translateY(-7px) rotate(-45deg);
            }

            .mobile-menu {
                display: none;
                background: #fff;
                border-top: 1px solid var(--border);
                border-bottom: 1px solid var(--border);
                box-shadow: 0 8px 24px rgba(26, 77, 70, 0.08);
            }
            .mobile-menu.open {
                display: block;
            }
            @media (min-width: 768px) {
                .mobile-menu {
                    display: none !important;
                }
            }

            .mobile-menu-inner {
                max-width: 1280px;
                margin: 0 auto;
                padding: 16px 20px;
                display: flex;
                flex-direction: column;
                gap: 4px;
            }
            .mobile-nav-link {
                display: block;
                padding: 12px 14px;
                font-size: 0.9rem;
                font-weight: 600;
                color: var(--ink-soft);
                text-decoration: none;
                border-radius: 10px;
                transition: all 0.15s;
            }
            .mobile-nav-link:hover {
                color: var(--teal);
                background: var(--teal-lt);
            }
            .mobile-nav-register {
                display: block;
                margin-top: 8px;
                padding: 13px 14px;
                font-size: 0.85rem;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: #fff;
                background: var(--teal);
                border-radius: 10px;
                text-decoration: none;
                text-align: center;
                box-shadow: 0 4px 14px rgba(45, 129, 118, 0.25);
            }

            /* ── Hero ── */
            .hero {
                position: relative;
                min-height: 75vh;
                display: flex;
                align-items: center;
                overflow: hidden;
                background: var(--teal-dk);
            }
            @media (min-width: 768px) {
                .hero {
                    min-height: 88vh;
                }
            }

            .hero-photo {
                position: absolute;
                inset: 0;
                background-image: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1800&q=80');
                background-size: cover;
                background-position: center 30%;
                opacity: 0.18;
            }
            .hero-bg {
                position: absolute;
                inset: 0;
                overflow: hidden;
            }
            .hero-bg-grid {
                position: absolute;
                inset: 0;
                background-image:
                    linear-gradient(
                        rgba(201, 168, 76, 0.08) 1px,
                        transparent 1px
                    ),
                    linear-gradient(
                        90deg,
                        rgba(201, 168, 76, 0.08) 1px,
                        transparent 1px
                    );
                background-size: 60px 60px;
            }
            .hero-bg-glow {
                position: absolute;
                top: -20%;
                right: -10%;
                width: 70%;
                height: 140%;
                background: radial-gradient(
                    ellipse at center,
                    rgba(201, 168, 76, 0.12) 0%,
                    rgba(45, 129, 118, 0.06) 40%,
                    transparent 70%
                );
            }
            .hero-bg-accent {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 1px;
                background: linear-gradient(
                    90deg,
                    transparent,
                    rgba(201, 168, 76, 0.5),
                    transparent
                );
            }
            .hero-circle-1 {
                position: absolute;
                top: 15%;
                right: 8%;
                width: 220px;
                height: 220px;
                border-radius: 50%;
                border: 1px solid rgba(201, 168, 76, 0.15);
            }
            @media (min-width: 768px) {
                .hero-circle-1 {
                    width: 320px;
                    height: 320px;
                }
            }
            .hero-circle-2 {
                position: absolute;
                top: 10%;
                right: 3%;
                width: 340px;
                height: 340px;
                border-radius: 50%;
                border: 1px solid rgba(201, 168, 76, 0.08);
            }
            @media (min-width: 768px) {
                .hero-circle-2 {
                    width: 480px;
                    height: 480px;
                }
            }
            .hero-circle-3 {
                position: absolute;
                bottom: -10%;
                left: -5%;
                width: 280px;
                height: 280px;
                border-radius: 50%;
                border: 1px solid rgba(201, 168, 76, 0.06);
            }
            @media (min-width: 768px) {
                .hero-circle-3 {
                    width: 400px;
                    height: 400px;
                }
            }

            .hero-inner {
                position: relative;
                z-index: 10;
                max-width: 760px;
                margin: 0 auto;
                padding: 64px 20px 56px;
                width: 100%;
            }
            @media (min-width: 640px) {
                .hero-inner {
                    padding: 80px 28px 70px;
                }
            }
            @media (min-width: 900px) {
                .hero-inner {
                    padding: 100px 32px;
                }
            }

            .hero-eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                font-size: 0.65rem;
                font-weight: 700;
                letter-spacing: 0.2em;
                text-transform: uppercase;
                color: var(--gold);
                margin-bottom: 16px;
                flex-wrap: wrap;
            }
            @media (min-width: 480px) {
                .hero-eyebrow {
                    font-size: 0.7rem;
                    margin-bottom: 22px;
                }
            }
            .hero-eyebrow::before {
                content: '';
                width: 22px;
                height: 1px;
                background: var(--gold);
                flex-shrink: 0;
            }

            .hero-h1 {
                font-family: 'Libre Baskerville', serif;
                font-size: clamp(2rem, 6vw, 4.4rem);
                font-weight: 700;
                color: #fff;
                line-height: 1.12;
                letter-spacing: -0.02em;
                margin-bottom: 16px;
            }
            @media (min-width: 480px) {
                .hero-h1 {
                    margin-bottom: 22px;
                }
            }
            .hero-h1 em {
                font-style: italic;
                color: var(--gold);
            }

            .hero-p {
                font-size: 0.95rem;
                color: rgba(255, 255, 255, 0.65);
                line-height: 1.7;
                max-width: 540px;
                margin-bottom: 28px;
            }
            @media (min-width: 480px) {
                .hero-p {
                    font-size: 1.05rem;
                    margin-bottom: 38px;
                }
            }

            .hero-cta {
                display: flex;
                gap: 12px;
                flex-wrap: wrap;
            }

            .btn-hero-primary {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 13px 24px;
                background: var(--gold);
                color: var(--ink);
                font-size: 0.78rem;
                font-weight: 800;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                border-radius: 10px;
                text-decoration: none;
                box-shadow: 0 8px 28px rgba(201, 168, 76, 0.4);
                transition:
                    background 0.2s,
                    transform 0.2s,
                    box-shadow 0.28s;
                position: relative;
                overflow: hidden;
                border: 2px solid var(--gold);
            }
            @media (min-width: 480px) {
                .btn-hero-primary {
                    padding: 16px 36px;
                    font-size: 0.82rem;
                }
            }
            .btn-hero-primary::before {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(
                    135deg,
                    rgba(255, 255, 255, 0.3),
                    transparent
                );
                opacity: 0;
                transition: opacity 0.2s;
            }
            .btn-hero-primary:hover {
                background: #d9b85c;
                transform: translateY(-4px);
                box-shadow: 0 16px 48px rgba(201, 168, 76, 0.5);
                border-color: #e5c873;
            }
            .btn-hero-primary:hover::before {
                opacity: 1;
            }

            .btn-hero-secondary {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 13px 24px;
                border: 2px solid rgba(255, 255, 255, 0.25);
                color: rgba(255, 255, 255, 0.92);
                font-size: 0.78rem;
                font-weight: 800;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                border-radius: 10px;
                text-decoration: none;
                transition: all 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
                background: rgba(255, 255, 255, 0.08);
                backdrop-filter: blur(4px);
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            }
            @media (min-width: 480px) {
                .btn-hero-secondary {
                    padding: 16px 36px;
                    font-size: 0.82rem;
                }
            }
            .btn-hero-secondary:hover {
                border-color: rgba(255, 255, 255, 0.6);
                color: #fff;
                background: rgba(255, 255, 255, 0.15);
                transform: translateY(-4px);
                box-shadow: 0 12px 28px rgba(0, 0, 0, 0.25);
            }

            /* ── Index bar ── */
            .index-bar {
                background: var(--parchment);
                border-bottom: 1px solid var(--border);
                padding: 12px 16px;
                overflow: hidden;
            }
            @media (min-width: 640px) {
                .index-bar {
                    padding: 14px 32px;
                }
            }
            .index-bar-inner {
                max-width: 1280px;
                margin: 0 auto;
                display: flex;
                align-items: center;
                gap: 12px;
            }
            .index-bar-label {
                font-size: 0.58rem;
                font-weight: 800;
                letter-spacing: 0.18em;
                text-transform: uppercase;
                color: var(--ink-soft);
                white-space: nowrap;
                flex-shrink: 0;
            }
            @media (min-width: 480px) {
                .index-bar-label {
                    font-size: 0.62rem;
                }
            }
            .index-bar-divider {
                width: 1px;
                height: 18px;
                background: var(--border-dk);
                flex-shrink: 0;
            }
            .index-marquee-wrap {
                overflow: hidden;
                flex: 1;
            }
            .index-marquee {
                display: flex;
                gap: 36px;
                width: max-content;
                animation: marquee 28s linear infinite;
            }
            .index-marquee:hover {
                animation-play-state: paused;
            }
            @keyframes marquee {
                from {
                    transform: translateX(0);
                }
                to {
                    transform: translateX(-50%);
                }
            }
            .index-chip {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                font-size: 0.7rem;
                font-weight: 700;
                color: var(--ink-mid);
                white-space: nowrap;
            }
            .index-chip-dot {
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: var(--teal);
                flex-shrink: 0;
            }

            /* ── Section base ── */
            .section {
                padding: 60px 20px;
            }
            @media (min-width: 640px) {
                .section {
                    padding: 80px 28px;
                }
            }
            @media (min-width: 1024px) {
                .section {
                    padding: 96px 32px;
                }
            }

            .section-inner {
                max-width: 1280px;
                margin: 0 auto;
            }
            .section-header {
                text-align: center;
                margin-bottom: 40px;
            }
            @media (min-width: 640px) {
                .section-header {
                    margin-bottom: 60px;
                }
            }

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
                width: 20px;
                height: 1px;
                background: var(--teal);
            }
            .section-title {
                font-family: 'Libre Baskerville', serif;
                font-size: clamp(1.5rem, 3.5vw, 2.6rem);
                font-weight: 700;
                color: var(--ink);
                line-height: 1.2;
                letter-spacing: -0.01em;
            }
            .section-title em {
                font-style: italic;
                color: var(--teal);
            }
            .section-sub {
                font-size: 0.9rem;
                color: var(--ink-soft);
                margin-top: 10px;
            }
            @media (min-width: 640px) {
                .section-sub {
                    font-size: 0.95rem;
                }
            }

            /* ── Metrics ── */
            .metrics-section {
                background: linear-gradient(
                    135deg,
                    var(--teal-dk) 0%,
                    #1f5c54 100%
                );
                padding: 56px 20px;
            }
            @media (min-width: 640px) {
                .metrics-section {
                    padding: 80px 32px;
                }
            }

            .metrics-grid {
                max-width: 1280px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 2px;
                background: rgba(201, 168, 76, 0.1);
                padding: 2px;
                border-radius: 16px;
                overflow: hidden;
            }
            @media (min-width: 480px) {
                .metrics-grid {
                    grid-template-columns: repeat(3, 1fr);
                }
            }
            @media (min-width: 900px) {
                .metrics-grid {
                    grid-template-columns: repeat(5, 1fr);
                }
            }

            .metric-cell {
                padding: 28px 18px;
                background: rgba(26, 77, 70, 0.6);
                backdrop-filter: blur(8px);
                text-align: center;
                position: relative;
                transition: all 0.28s ease;
                border: 1px solid rgba(201, 168, 76, 0.12);
            }
            @media (min-width: 640px) {
                .metric-cell {
                    padding: 40px 28px;
                }
            }
            .metric-cell:hover {
                background: rgba(26, 77, 70, 0.9);
                border-color: rgba(201, 168, 76, 0.25);
            }
            .metric-val {
                font-family: 'Libre Baskerville', serif;
                font-size: 2.2rem;
                font-weight: 700;
                color: var(--gold);
                line-height: 1;
                letter-spacing: -0.02em;
                transition: transform 0.3s ease;
            }
            @media (min-width: 640px) {
                .metric-val {
                    font-size: 3.2rem;
                }
            }
            .metric-cell:hover .metric-val {
                transform: scale(1.08);
            }
            .metric-lbl {
                font-size: 0.62rem;
                font-weight: 700;
                letter-spacing: 0.14em;
                text-transform: uppercase;
                color: rgba(255, 255, 255, 0.5);
                margin-top: 10px;
                transition: color 0.25s ease;
            }
            @media (min-width: 640px) {
                .metric-lbl {
                    letter-spacing: 0.18em;
                    margin-top: 14px;
                }
            }
            .metric-cell:hover .metric-lbl {
                color: rgba(255, 255, 255, 0.8);
            }
            .metric-cell::before {
                content: '';
                position: absolute;
                top: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 0;
                height: 3px;
                background: linear-gradient(
                    90deg,
                    transparent,
                    var(--gold),
                    transparent
                );
                transition: width 0.4s ease;
            }
            .metric-cell:hover::before {
                width: 60%;
            }

            /* ── Features ── */
            .features-grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: 20px;
            }
            @media (min-width: 560px) {
                .features-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }
            @media (min-width: 900px) {
                .features-grid {
                    grid-template-columns: repeat(3, 1fr);
                    gap: 28px;
                }
            }

            .feature-card {
                background: #fff;
                border: 1.5px solid var(--border);
                border-radius: 20px;
                padding: 28px 24px;
                transition:
                    transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1),
                    box-shadow 0.3s ease,
                    border-color 0.28s;
                position: relative;
                overflow: hidden;
                box-shadow: 0 4px 16px rgba(45, 129, 118, 0.06);
            }
            @media (min-width: 640px) {
                .feature-card {
                    padding: 36px 32px;
                }
            }
            .feature-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 4px;
                background: linear-gradient(90deg, var(--teal), var(--gold));
                transform: scaleX(0);
                transform-origin: left;
                transition: transform 0.4s ease;
            }
            .feature-card::after {
                content: '';
                position: absolute;
                inset: 0;
                background: radial-gradient(
                    circle at top right,
                    rgba(201, 168, 76, 0.04),
                    transparent 80%
                );
                opacity: 0;
                transition: opacity 0.3s ease;
            }
            .feature-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 24px 56px rgba(45, 129, 118, 0.14);
                border-color: rgba(45, 129, 118, 0.3);
            }
            .feature-card:hover::before {
                transform: scaleX(1);
            }
            .feature-card:hover::after {
                opacity: 1;
            }
            .feature-icon {
                width: 52px;
                height: 52px;
                border-radius: 14px;
                background: linear-gradient(
                    135deg,
                    var(--teal-lt),
                    rgba(45, 129, 118, 0.08)
                );
                border: 1.5px solid rgba(45, 129, 118, 0.18);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 20px;
                color: var(--teal);
                transition: all 0.32s cubic-bezier(0.34, 1.56, 0.64, 1);
                box-shadow: 0 4px 12px rgba(45, 129, 118, 0.1);
            }
            .feature-card:hover .feature-icon {
                transform: rotate(-8deg) scale(1.12);
                box-shadow: 0 8px 20px rgba(45, 129, 118, 0.18);
                border-color: var(--teal);
            }
            .feature-title {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.08rem;
                font-weight: 700;
                color: var(--ink);
                margin-bottom: 10px;
                transition: color 0.25s;
            }
            .feature-card:hover .feature-title {
                color: var(--teal);
            }
            .feature-desc {
                font-size: 0.86rem;
                color: var(--ink-soft);
                line-height: 1.7;
            }

            /* ── Process ── */
            .process-section {
                background: linear-gradient(
                    180deg,
                    var(--parchment) 0%,
                    rgba(243, 236, 224, 0.5) 100%
                );
                border-top: 1px solid var(--border);
                border-bottom: 1px solid var(--border);
            }
            .process-grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: 16px;
            }
            @media (min-width: 480px) {
                .process-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }
            @media (min-width: 900px) {
                .process-grid {
                    grid-template-columns: repeat(4, 1fr);
                    gap: 24px;
                }
            }

            .process-step {
                padding: 28px 22px;
                background: #fff;
                border: 1.5px solid var(--border);
                border-radius: 16px;
                position: relative;
                transition: all 0.32s cubic-bezier(0.34, 1.56, 0.64, 1);
                box-shadow: 0 4px 12px rgba(45, 129, 118, 0.04);
            }
            @media (min-width: 640px) {
                .process-step {
                    padding: 40px 28px;
                }
            }
            .process-step::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--teal), var(--gold));
                border-radius: 16px 16px 0 0;
                opacity: 0;
                transition: opacity 0.3s;
            }
            .process-step:hover {
                transform: translateY(-6px);
                box-shadow: 0 16px 40px rgba(45, 129, 118, 0.12);
                border-color: rgba(45, 129, 118, 0.3);
            }
            .process-step:hover::before {
                opacity: 1;
            }
            .process-step-head {
                display: flex;
                align-items: center;
                gap: 14px;
                margin-bottom: 16px;
            }
            .process-num-wrap {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                background: linear-gradient(
                    135deg,
                    var(--teal-lt),
                    rgba(45, 129, 118, 0.12)
                );
                border: 2px solid var(--teal);
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                transition: all 0.32s ease;
                box-shadow: 0 6px 16px rgba(45, 129, 118, 0.12);
            }
            .process-step:hover .process-num-wrap {
                transform: scale(1.15) rotate(6deg);
                box-shadow: 0 12px 28px rgba(45, 129, 118, 0.2);
                background: linear-gradient(
                    135deg,
                    var(--teal),
                    var(--teal-lt)
                );
                border-color: var(--gold);
            }
            .process-num {
                font-family: 'Libre Baskerville', serif;
                font-size: 0.9rem;
                font-weight: 700;
                color: var(--teal);
                transition: color 0.25s;
            }
            .process-step:hover .process-num {
                color: #fff;
            }
            .process-title {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.1rem;
                font-weight: 700;
                color: var(--ink);
                transition: color 0.25s;
            }
            .process-step:hover .process-title {
                color: var(--teal);
            }
            .process-days {
                display: inline-block;
                font-size: 0.65rem;
                font-weight: 800;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: var(--teal);
                background: linear-gradient(
                    135deg,
                    rgba(45, 129, 118, 0.1),
                    rgba(201, 168, 76, 0.08)
                );
                border: 1.5px solid rgba(45, 129, 118, 0.2);
                padding: 5px 12px;
                border-radius: 24px;
                margin-bottom: 10px;
                transition: all 0.25s;
            }
            .process-step:hover .process-days {
                background: var(--teal-lt);
                border-color: var(--teal);
            }
            .process-desc {
                font-size: 0.84rem;
                color: var(--ink-soft);
                line-height: 1.7;
            }

            /* ── Live Activity ── */
            .activity-section {
                background: #fff;
            }
            .activity-wrapper {
                display: grid;
                grid-template-columns: 1fr;
                gap: 40px;
                align-items: start;
            }
            @media (min-width: 900px) {
                .activity-wrapper {
                    grid-template-columns: 1fr 420px;
                    gap: 64px;
                }
            }

            .activity-feed-wrap {
                background: linear-gradient(180deg, #fff 0%, var(--cream) 100%);
                border: 1.5px solid var(--border);
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 8px 24px rgba(45, 129, 118, 0.08);
                order: -1;
            }
            @media (min-width: 900px) {
                .activity-feed-wrap {
                    order: 0;
                }
            }

            .activity-feed-head {
                padding: 18px 22px;
                background: linear-gradient(
                    90deg,
                    var(--parchment) 0%,
                    rgba(232, 244, 242, 0.6) 100%
                );
                border-bottom: 1.5px solid var(--border);
                display: flex;
                align-items: center;
                gap: 12px;
            }
            .live-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: var(--teal);
                animation: live-pulse 2s infinite;
            }
            @keyframes live-pulse {
                0%,
                100% {
                    box-shadow: 0 0 0 0 rgba(45, 129, 118, 0.5);
                }
                50% {
                    box-shadow: 0 0 0 7px rgba(45, 129, 118, 0);
                }
            }
            .activity-feed-body {
                height: 300px;
                overflow: hidden;
                position: relative;
            }
            @media (min-width: 640px) {
                .activity-feed-body {
                    height: 340px;
                }
            }
            .activity-feed-body::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 60px;
                background: linear-gradient(
                    to bottom,
                    transparent,
                    var(--cream)
                );
                pointer-events: none;
                z-index: 2;
            }
            .activity-feed-scroll {
                animation: feed-scroll 18s linear infinite;
            }
            @keyframes feed-scroll {
                0% {
                    transform: translateY(0);
                }
                100% {
                    transform: translateY(-50%);
                }
            }
            .activity-feed-scroll:hover {
                animation-play-state: paused;
            }
            .activity-item {
                display: flex;
                align-items: flex-start;
                gap: 14px;
                padding: 14px 22px;
                border-bottom: 1px solid var(--border);
                transition:
                    background 0.18s,
                    padding 0.18s;
                position: relative;
            }
            @media (min-width: 640px) {
                .activity-item {
                    padding: 16px 26px;
                    gap: 16px;
                }
            }
            .activity-item:hover {
                background: linear-gradient(
                    90deg,
                    rgba(45, 129, 118, 0.03),
                    transparent
                );
                padding-left: 26px;
            }
            .activity-item::before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                bottom: 0;
                width: 3px;
                background: var(--teal);
                opacity: 0;
                transition: opacity 0.2s;
            }
            .activity-item:hover::before {
                opacity: 1;
            }
            .activity-icon {
                width: 38px;
                height: 38px;
                border-radius: 10px;
                background: linear-gradient(
                    135deg,
                    var(--teal-lt),
                    rgba(45, 129, 118, 0.08)
                );
                border: 1.5px solid rgba(45, 129, 118, 0.18);
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                font-size: 1rem;
                transition: all 0.25s;
                box-shadow: 0 3px 10px rgba(45, 129, 118, 0.08);
            }
            @media (min-width: 640px) {
                .activity-icon {
                    width: 42px;
                    height: 42px;
                    font-size: 1.1rem;
                }
            }
            .activity-item:hover .activity-icon {
                transform: scale(1.12) rotate(-6deg);
            }
            .activity-title {
                font-size: 0.85rem;
                font-weight: 700;
                color: var(--ink);
            }
            .activity-desc {
                font-size: 0.78rem;
                color: var(--ink-soft);
                line-height: 1.6;
                margin-top: 2px;
            }
            .activity-time {
                font-size: 0.68rem;
                color: var(--border-dk);
                margin-top: 5px;
                font-weight: 600;
            }

            /* ── Editorial board ── */
            .board-section {
                background: var(--parchment);
                border-top: 1px solid var(--border);
            }
            .board-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 14px;
            }
            @media (min-width: 640px) {
                .board-grid {
                    grid-template-columns: repeat(3, 1fr);
                    gap: 16px;
                }
            }
            @media (min-width: 900px) {
                .board-grid {
                    grid-template-columns: repeat(3, 1fr);
                    gap: 18px;
                }
            }

            .board-card {
                background: #fff;
                border: 1.5px solid var(--border);
                border-radius: 18px;
                overflow: hidden;
                transition: all 0.32s cubic-bezier(0.34, 1.56, 0.64, 1);
                box-shadow: 0 6px 20px rgba(45, 129, 118, 0.08);
            }
            .board-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 48px rgba(45, 129, 118, 0.16);
                border-color: rgba(45, 129, 118, 0.35);
            }
            .board-card-top {
                height: 90px;
                background: linear-gradient(
                    135deg,
                    var(--teal-lt) 0%,
                    rgba(201, 168, 76, 0.12) 100%
                );
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                border-bottom: 2px solid rgba(45, 129, 118, 0.1);
            }
            @media (min-width: 640px) {
                .board-card-top {
                    height: 120px;
                }
            }
            .board-card-top::before {
                content: '';
                position: absolute;
                inset: 0;
                background: radial-gradient(
                    circle at 20% 80%,
                    rgba(201, 168, 76, 0.15),
                    transparent 50%
                );
            }
            .board-avatar {
                width: 56px;
                height: 56px;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--teal), #1f6550);
                border: 3px solid #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: 'Libre Baskerville', serif;
                font-size: 1rem;
                font-weight: 700;
                color: #fff;
                box-shadow: 0 8px 24px rgba(45, 129, 118, 0.3);
                transition: all 0.3s;
                position: relative;
                z-index: 2;
            }
            @media (min-width: 640px) {
                .board-avatar {
                    width: 68px;
                    height: 68px;
                    font-size: 1.2rem;
                    border-width: 4px;
                }
            }
            .board-card:hover .board-avatar {
                transform: scale(1.12) translateY(-4px);
            }
            .board-card-body {
                padding: 14px 14px 18px;
            }
            @media (min-width: 640px) {
                .board-card-body {
                    padding: 16px 18px 20px;
                }
            }
            .board-name {
                font-family: 'Libre Baskerville', serif;
                font-size: 0.88rem;
                font-weight: 700;
                color: var(--ink);
                margin-bottom: 5px;
                transition: color 0.25s;
            }
            @media (min-width: 640px) {
                .board-name {
                    font-size: 0.98rem;
                }
            }
            .board-card:hover .board-name {
                color: var(--teal);
            }
            .board-role {
                font-size: 0.62rem;
                font-weight: 800;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                color: var(--teal);
                margin-bottom: 6px;
                transition: color 0.25s;
            }
            .board-card:hover .board-role {
                color: var(--gold);
            }
            .board-expertise {
                font-size: 0.78rem;
                color: var(--ink-soft);
                line-height: 1.6;
            }

            /* ── Research Fields ── */
            .fields-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }
            @media (min-width: 480px) {
                .fields-grid {
                    gap: 12px;
                }
            }
            @media (min-width: 640px) {
                .fields-grid {
                    grid-template-columns: repeat(3, 1fr);
                }
            }
            @media (min-width: 860px) {
                .fields-grid {
                    grid-template-columns: repeat(4, 1fr);
                    gap: 14px;
                }
            }
            @media (min-width: 1100px) {
                .fields-grid {
                    grid-template-columns: repeat(5, 1fr);
                }
            }

            .field-card {
                background: #fff;
                border: 1.5px solid var(--border);
                border-radius: 16px;
                padding: 20px 16px 18px;
                transition: all 0.36s cubic-bezier(0.34, 1.56, 0.64, 1);
                cursor: pointer;
                position: relative;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                box-shadow: 0 4px 14px rgba(45, 129, 118, 0.06);
            }
            @media (min-width: 640px) {
                .field-card {
                    padding: 26px 22px 24px;
                    border-radius: 20px;
                }
            }
            .field-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: var(--field-color, var(--teal));
                border-radius: 16px 16px 0 0;
                transition: height 0.36s;
                z-index: 2;
            }
            .field-card::after {
                content: '';
                position: absolute;
                inset: 0;
                background: radial-gradient(
                    circle at top right,
                    var(--field-bg, rgba(45, 129, 118, 0.04)),
                    transparent 65%
                );
                opacity: 0;
                transition: opacity 0.28s;
                border-radius: 16px;
                z-index: 0;
            }
            .field-card:hover::after {
                opacity: 1;
            }
            .field-card:hover::before {
                height: 6px;
            }
            .field-card:hover {
                transform: translateY(-6px) scale(1.02);
                box-shadow: 0 20px 48px rgba(45, 129, 118, 0.12);
                border-color: var(--field-color, var(--teal));
            }
            .field-card > * {
                position: relative;
                z-index: 1;
            }

            .field-icon {
                width: 44px;
                height: 44px;
                border-radius: 12px;
                background: var(--field-icon-bg, var(--teal-lt));
                border: 2px solid
                    var(--field-icon-border, rgba(45, 129, 118, 0.2));
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 14px;
                color: var(--field-color, var(--teal));
                transition: all 0.36s cubic-bezier(0.34, 1.56, 0.64, 1);
                flex-shrink: 0;
                font-size: 1.2rem;
                box-shadow: 0 5px 14px
                    var(--field-shadow, rgba(45, 129, 118, 0.1));
            }
            @media (min-width: 640px) {
                .field-icon {
                    width: 52px;
                    height: 52px;
                    font-size: 1.4rem;
                    margin-bottom: 18px;
                }
            }
            .field-card:hover .field-icon {
                background: var(--field-color, var(--teal));
                border-color: var(--field-color, var(--teal));
                color: #fff;
                transform: rotate(-10deg) scale(1.2);
            }

            .field-name {
                font-family: 'Libre Baskerville', serif;
                font-size: 0.8rem;
                font-weight: 700;
                color: var(--ink);
                line-height: 1.4;
                margin-bottom: 8px;
                transition: color 0.25s;
                letter-spacing: 0.1px;
            }
            @media (min-width: 640px) {
                .field-name {
                    font-size: 0.88rem;
                }
            }
            .field-card:hover .field-name {
                color: var(--field-color, var(--teal));
            }

            .field-count {
                font-size: 0.64rem;
                font-weight: 700;
                color: var(--ink-soft);
                letter-spacing: 0.06em;
                display: flex;
                align-items: center;
                gap: 6px;
                margin-top: auto;
                text-transform: uppercase;
            }
            .field-count::before {
                content: '';
                width: 14px;
                height: 2px;
                background: var(--field-color, var(--teal));
                opacity: 0.6;
                border-radius: 2px;
            }

            .field-c1 {
                --field-color: #2d8176;
                --field-bg: rgba(45, 129, 118, 0.05);
                --field-icon-bg: #e8f4f2;
                --field-icon-border: rgba(45, 129, 118, 0.18);
                --field-shadow: rgba(45, 129, 118, 0.2);
            }
            .field-c2 {
                --field-color: #7c3aed;
                --field-bg: rgba(124, 58, 237, 0.05);
                --field-icon-bg: #f3eeff;
                --field-icon-border: rgba(124, 58, 237, 0.15);
                --field-shadow: rgba(124, 58, 237, 0.2);
            }
            .field-c3 {
                --field-color: #b45309;
                --field-bg: rgba(180, 83, 9, 0.05);
                --field-icon-bg: #fff4e0;
                --field-icon-border: rgba(180, 83, 9, 0.15);
                --field-shadow: rgba(180, 83, 9, 0.2);
            }
            .field-c4 {
                --field-color: #0e7490;
                --field-bg: rgba(14, 116, 144, 0.05);
                --field-icon-bg: #e0f6fc;
                --field-icon-border: rgba(14, 116, 144, 0.16);
                --field-shadow: rgba(14, 116, 144, 0.2);
            }
            .field-c5 {
                --field-color: #c9a84c;
                --field-bg: rgba(201, 168, 76, 0.06);
                --field-icon-bg: #fdf6e3;
                --field-icon-border: rgba(201, 168, 76, 0.2);
                --field-shadow: rgba(201, 168, 76, 0.22);
            }
            .field-c6 {
                --field-color: #be185d;
                --field-bg: rgba(190, 24, 93, 0.05);
                --field-icon-bg: #fce7f3;
                --field-icon-border: rgba(190, 24, 93, 0.14);
                --field-shadow: rgba(190, 24, 93, 0.2);
            }
            .field-c7 {
                --field-color: #166534;
                --field-bg: rgba(22, 101, 52, 0.05);
                --field-icon-bg: #dcfce7;
                --field-icon-border: rgba(22, 101, 52, 0.15);
                --field-shadow: rgba(22, 101, 52, 0.18);
            }
            .field-c8 {
                --field-color: #1d4ed8;
                --field-bg: rgba(29, 78, 216, 0.05);
                --field-icon-bg: #e0eaff;
                --field-icon-border: rgba(29, 78, 216, 0.14);
                --field-shadow: rgba(29, 78, 216, 0.2);
            }
            .field-c9 {
                --field-color: #9d174d;
                --field-bg: rgba(157, 23, 77, 0.05);
                --field-icon-bg: #fdf2f8;
                --field-icon-border: rgba(157, 23, 77, 0.14);
                --field-shadow: rgba(157, 23, 77, 0.2);
            }
            .field-c10 {
                --field-color: #0f766e;
                --field-bg: rgba(15, 118, 110, 0.05);
                --field-icon-bg: #ccfbf1;
                --field-icon-border: rgba(15, 118, 110, 0.15);
                --field-shadow: rgba(15, 118, 110, 0.2);
            }

            /* ── Trust bar ── */
            .trust-section {
                background: linear-gradient(
                    135deg,
                    var(--teal-dk) 0%,
                    #1f5c54 100%
                );
                padding: 48px 20px;
                border-top: 1px solid rgba(201, 168, 76, 0.15);
            }
            @media (min-width: 640px) {
                .trust-section {
                    padding: 72px 32px;
                }
            }
            .trust-inner {
                max-width: 1280px;
                margin: 0 auto;
            }
            .trust-label {
                text-align: center;
                font-size: 0.65rem;
                font-weight: 800;
                letter-spacing: 0.2em;
                text-transform: uppercase;
                color: rgba(255, 255, 255, 0.4);
                margin-bottom: 24px;
            }
            @media (min-width: 640px) {
                .trust-label {
                    margin-bottom: 32px;
                }
            }
            .trust-items {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 20px;
                flex-wrap: wrap;
            }
            @media (min-width: 640px) {
                .trust-items {
                    gap: 32px;
                }
            }
            @media (min-width: 900px) {
                .trust-items {
                    gap: 48px;
                }
            }
            .trust-item {
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 0.75rem;
                font-weight: 700;
                letter-spacing: 0.06em;
                text-transform: uppercase;
                color: rgba(255, 255, 255, 0.6);
                transition: all 0.25s;
            }
            @media (min-width: 640px) {
                .trust-item {
                    font-size: 0.8rem;
                    letter-spacing: 0.08em;
                    gap: 12px;
                }
            }
            .trust-item:hover {
                color: var(--gold);
                transform: translateY(-2px);
            }
            .trust-check {
                width: 22px;
                height: 22px;
                border-radius: 50%;
                background: rgba(201, 168, 76, 0.2);
                border: 1.5px solid rgba(201, 168, 76, 0.4);
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--gold);
                flex-shrink: 0;
                font-size: 0.82rem;
                transition: all 0.25s;
            }
            .trust-item:hover .trust-check {
                background: rgba(201, 168, 76, 0.4);
                border-color: var(--gold);
                transform: scale(1.15);
            }
            .trust-divider {
                display: none;
            }
            @media (min-width: 900px) {
                .trust-divider {
                    display: block;
                    width: 1px;
                    height: 18px;
                    background: rgba(255, 255, 255, 0.12);
                }
            }

            /* ── Footer ── */
            footer {
                background: var(--ink);
                color: rgba(255, 255, 255, 0.45);
                padding: 48px 20px 32px;
            }
            @media (min-width: 640px) {
                footer {
                    padding: 64px 32px 40px;
                }
            }

            .footer-inner {
                max-width: 1280px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: 1fr;
                gap: 32px;
                padding-bottom: 36px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
                margin-bottom: 28px;
            }
            @media (min-width: 480px) {
                .footer-inner {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 28px;
                }
            }
            @media (min-width: 860px) {
                .footer-inner {
                    grid-template-columns: 1.4fr 1fr 1fr 1fr;
                    gap: 48px;
                }
            }

            .footer-brand {
                grid-column: 1 / -1;
            }
            @media (min-width: 860px) {
                .footer-brand {
                    grid-column: auto;
                }
            }

            .footer-brand-name {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.05rem;
                font-weight: 700;
                color: #fff;
                margin-bottom: 4px;
            }
            .footer-brand-sub {
                font-size: 0.6rem;
                font-weight: 700;
                letter-spacing: 0.14em;
                text-transform: uppercase;
                color: var(--gold);
            }
            .footer-brand-desc {
                font-size: 0.82rem;
                line-height: 1.65;
                margin-top: 12px;
            }
            .footer-col-title {
                font-size: 0.65rem;
                font-weight: 700;
                letter-spacing: 0.18em;
                text-transform: uppercase;
                color: rgba(255, 255, 255, 0.6);
                margin-bottom: 14px;
            }
            .footer-links {
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
                flex-direction: column;
                gap: 8px;
            }
            .footer-links a {
                font-size: 0.82rem;
                color: rgba(255, 255, 255, 0.4);
                text-decoration: none;
                transition: color 0.15s;
            }
            .footer-links a:hover {
                color: var(--gold);
            }

            .footer-bottom {
                max-width: 1280px;
                margin: 0 auto;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                flex-wrap: wrap;
            }
            .footer-copy {
                font-size: 0.7rem;
                color: rgba(255, 255, 255, 0.25);
                letter-spacing: 0.02em;
            }
            .footer-tagline {
                font-size: 0.6rem;
                font-weight: 700;
                letter-spacing: 0.16em;
                text-transform: uppercase;
                color: rgba(255, 255, 255, 0.18);
            }

            /* ── Scroll-top ── */
            #scroll-top {
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: 44px;
                height: 44px;
                background: var(--teal);
                color: #fff;
                border-radius: 50%;
                border: none;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 6px 20px rgba(45, 129, 118, 0.35);
                z-index: 40;
                opacity: 0;
                transform: translateY(16px);
                transition:
                    opacity 0.3s,
                    transform 0.3s,
                    background 0.15s;
            }
            @media (min-width: 640px) {
                #scroll-top {
                    width: 48px;
                    height: 48px;
                    bottom: 32px;
                    right: 32px;
                }
            }
            #scroll-top.show {
                opacity: 1;
                transform: translateY(0);
            }
            #scroll-top:hover {
                background: var(--teal-dk);
            }

            /* ── Animations ── */
            .fade-up {
                opacity: 0;
                transform: translateY(22px);
                transition:
                    opacity 0.6s ease,
                    transform 0.6s ease;
            }
            .fade-up.visible {
                opacity: 1;
                transform: translateY(0);
            }
            .fade-up-1 {
                transition-delay: 0.08s;
            }
            .fade-up-2 {
                transition-delay: 0.16s;
            }
            .fade-up-3 {
                transition-delay: 0.24s;
            }
            .fade-up-4 {
                transition-delay: 0.32s;
            }

            /* ══════════════════════════════════════
               ── FLOATING FAQ BUTTON & PANEL ──
            ══════════════════════════════════════ */

            /* Floating trigger button — always visible pill */
            #faq-trigger {
                position: fixed;
                bottom: 76px;
                right: 20px;
                z-index: 45;
                display: flex;
                align-items: center;
                gap: 0;
                background: var(--teal-dk);
                color: #fff;
                border: 2px solid rgba(201, 168, 76, 0.5);
                border-radius: 50px;
                cursor: pointer;
                padding: 0;
                box-shadow:
                    0 8px 28px rgba(26, 77, 70, 0.45),
                    0 0 0 4px rgba(45, 129, 118, 0.15);
                overflow: hidden;
                /* Always expanded as a pill */
                width: auto;
                height: 52px;
                transition:
                    box-shadow 0.2s,
                    transform 0.2s,
                    border-color 0.2s;
            }
            @media (min-width: 640px) {
                #faq-trigger {
                    bottom: 90px;
                    right: 32px;
                    height: 56px;
                }
            }
            #faq-trigger:hover {
                transform: translateY(-3px);
                box-shadow:
                    0 14px 36px rgba(26, 77, 70, 0.5),
                    0 0 0 4px rgba(45, 129, 118, 0.25);
                border-color: var(--gold);
            }
            #faq-trigger:active {
                transform: scale(0.97);
            }

            .faq-trigger-icon {
                width: 52px;
                height: 52px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                position: relative;
                background: rgba(255, 255, 255, 0.08);
                border-right: 1px solid rgba(255, 255, 255, 0.12);
            }
            @media (min-width: 640px) {
                .faq-trigger-icon {
                    width: 56px;
                    height: 56px;
                }
            }

            /* Pulse ring */
            .faq-trigger-icon::before {
                content: '';
                position: absolute;
                inset: -3px;
                border-radius: 50%;
                border: 2px solid rgba(201, 168, 76, 0.6);
                animation: faq-ring 2.4s ease-out infinite;
            }
            @keyframes faq-ring {
                0% {
                    transform: scale(1);
                    opacity: 0.8;
                }
                80% {
                    transform: scale(1.6);
                    opacity: 0;
                }
                100% {
                    transform: scale(1.6);
                    opacity: 0;
                }
            }
            /* Stop pulse when open */
            #faq-trigger.open .faq-trigger-icon::before {
                animation: none;
                opacity: 0;
            }

            /* Label — always visible */
            .faq-trigger-label {
                font-size: 0.75rem;
                font-weight: 800;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                white-space: nowrap;
                opacity: 1;
                padding: 0 20px 0 14px;
                color: #fff;
            }

            /* Gold shimmer stripe on top of button */
            #faq-trigger::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 2px;
                background: linear-gradient(
                    90deg,
                    transparent,
                    var(--gold),
                    transparent
                );
            }

            /* ── FAQ Panel ── */
            #faq-panel {
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                width: min(440px, 100vw);
                z-index: 200;
                display: flex;
                flex-direction: column;
                background: var(--cream);
                border-left: 1px solid var(--border-dk);
                box-shadow: -16px 0 60px rgba(26, 18, 9, 0.16);
                transform: translateX(100%);
                transition: transform 0.4s cubic-bezier(0.32, 0.72, 0, 1);
                overflow: hidden;
            }
            #faq-panel.open {
                transform: translateX(0);
            }
            /* Mobile: bottom sheet */
            @media (max-width: 640px) {
                #faq-panel {
                    top: auto;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    width: 100%;
                    max-height: 88vh;
                    border-left: none;
                    border-top: 1px solid var(--border-dk);
                    border-radius: 22px 22px 0 0;
                    box-shadow: 0 -16px 60px rgba(26, 18, 9, 0.18);
                    transform: translateY(100%);
                }
                #faq-panel.open {
                    transform: translateY(0);
                }
            }

            /* Shimmer accent top of panel */
            .faq-panel-shimmer {
                height: 3px;
                flex-shrink: 0;
                background: linear-gradient(
                    90deg,
                    transparent 0%,
                    var(--gold-lt) 20%,
                    var(--gold) 50%,
                    var(--gold-lt) 80%,
                    transparent 100%
                );
                background-size: 200% 100%;
                animation: shimmer 3s linear infinite;
            }

            /* Panel header */
            .faq-panel-header {
                display: flex;
                align-items: center;
                gap: 14px;
                padding: 20px 22px 16px;
                background: var(--parchment);
                border-bottom: 1px solid var(--border);
                flex-shrink: 0;
            }
            .faq-panel-icon {
                width: 40px;
                height: 40px;
                border-radius: 10px;
                background: var(--teal);
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                box-shadow: 0 4px 14px rgba(45, 129, 118, 0.28);
            }
            .faq-panel-titles {
                flex: 1;
                min-width: 0;
            }
            .faq-panel-eyebrow {
                font-size: 0.58rem;
                font-weight: 800;
                letter-spacing: 0.18em;
                text-transform: uppercase;
                color: var(--gold-dk);
                margin-bottom: 2px;
            }
            .faq-panel-title {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.1rem;
                font-weight: 700;
                color: var(--ink);
                line-height: 1.2;
            }
            #faq-close {
                width: 34px;
                height: 34px;
                border-radius: 50%;
                background: var(--border);
                border: none;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--ink-soft);
                flex-shrink: 0;
                transition:
                    background 0.15s,
                    color 0.15s,
                    transform 0.2s;
            }
            #faq-close:hover {
                background: #fecaca;
                color: #c0392b;
                transform: rotate(90deg);
            }

            /* Mobile drag handle */
            .faq-drag-handle {
                display: none;
                width: 40px;
                height: 4px;
                background: var(--border-dk);
                border-radius: 4px;
                margin: 10px auto 0;
                flex-shrink: 0;
            }
            @media (max-width: 640px) {
                .faq-drag-handle {
                    display: block;
                }
            }

            /* Search bar */
            .faq-search-wrap {
                padding: 14px 22px 12px;
                background: var(--parchment);
                border-bottom: 1px solid var(--border);
                flex-shrink: 0;
                position: relative;
            }
            .faq-search-wrap svg {
                position: absolute;
                left: 36px;
                top: 50%;
                transform: translateY(-50%);
                color: var(--ink-soft);
                pointer-events: none;
                width: 16px;
                height: 16px;
            }
            #faq-search {
                width: 100%;
                background: #fff;
                border: 1.5px solid var(--border);
                border-radius: 8px;
                padding: 10px 14px 10px 40px;
                font-family: 'Source Sans 3', sans-serif;
                font-size: 0.9rem;
                color: var(--ink);
                outline: none;
                transition:
                    border-color 0.15s,
                    box-shadow 0.15s;
            }
            #faq-search:focus {
                border-color: var(--teal);
                box-shadow: 0 0 0 3px rgba(45, 129, 118, 0.1);
            }
            #faq-search::placeholder {
                color: #b5a595;
            }

            /* Scrollable FAQ body */
            .faq-body {
                flex: 1;
                overflow-y: auto;
                padding: 16px 22px 100px;
                overscroll-behavior: contain;
            }
            .faq-body::-webkit-scrollbar {
                width: 4px;
            }
            .faq-body::-webkit-scrollbar-track {
                background: transparent;
            }
            .faq-body::-webkit-scrollbar-thumb {
                background: var(--border-dk);
                border-radius: 4px;
            }

            /* Category label */
            .faq-category {
                font-size: 0.6rem;
                font-weight: 800;
                letter-spacing: 0.18em;
                text-transform: uppercase;
                color: var(--teal);
                margin: 20px 0 10px;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .faq-category::after {
                content: '';
                flex: 1;
                height: 1px;
                background: rgba(45, 129, 118, 0.18);
            }
            .faq-category:first-child {
                margin-top: 4px;
            }

            /* Accordion item */
            .faq-item {
                background: #fff;
                border: 1.5px solid var(--border);
                border-radius: 12px;
                margin-bottom: 8px;
                overflow: hidden;
                transition:
                    border-color 0.2s,
                    box-shadow 0.2s;
            }
            .faq-item.active {
                border-color: rgba(45, 129, 118, 0.4);
                box-shadow: 0 4px 20px rgba(45, 129, 118, 0.1);
            }
            .faq-item.hidden {
                display: none;
            }

            .faq-q {
                width: 100%;
                text-align: left;
                background: none;
                border: none;
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 14px 16px;
                cursor: pointer;
                transition: background 0.15s;
            }
            .faq-q:hover {
                background: var(--teal-lt);
            }
            .faq-item.active .faq-q {
                background: var(--teal-lt);
            }

            .faq-q-num {
                width: 24px;
                height: 24px;
                border-radius: 50%;
                background: var(--parchment);
                border: 1px solid var(--border-dk);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.62rem;
                font-weight: 800;
                color: var(--ink-soft);
                flex-shrink: 0;
                transition: all 0.2s;
            }
            .faq-item.active .faq-q-num {
                background: var(--teal);
                border-color: var(--teal);
                color: #fff;
            }
            .faq-q-text {
                flex: 1;
                text-align: left;
                font-size: 0.88rem;
                font-weight: 700;
                color: var(--ink);
                line-height: 1.4;
                transition: color 0.15s;
            }
            .faq-item.active .faq-q-text {
                color: var(--teal-dk);
            }
            .faq-q-chevron {
                width: 20px;
                height: 20px;
                flex-shrink: 0;
                color: var(--ink-soft);
                transition:
                    transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1),
                    color 0.15s;
            }
            .faq-item.active .faq-q-chevron {
                transform: rotate(180deg);
                color: var(--teal);
            }

            .faq-a {
                max-height: 0;
                overflow: hidden;
                transition:
                    max-height 0.38s cubic-bezier(0.4, 0, 0.2, 1),
                    padding 0.2s;
            }
            .faq-item.active .faq-a {
                max-height: 400px;
            }
            .faq-a-inner {
                padding: 0 16px 16px 52px;
                font-size: 0.84rem;
                color: var(--ink-soft);
                line-height: 1.72;
                border-top: 1px solid rgba(45, 129, 118, 0.1);
                padding-top: 12px;
            }
            .faq-a-inner a {
                color: var(--teal);
                font-weight: 600;
                text-decoration: none;
                border-bottom: 1px dashed rgba(45, 129, 118, 0.4);
                transition:
                    color 0.15s,
                    border-color 0.15s;
            }
            .faq-a-inner a:hover {
                color: var(--teal-dk);
                border-color: var(--teal-dk);
            }

            /* No results */
            #faq-no-results {
                display: none;
                text-align: center;
                padding: 40px 16px;
            }
            #faq-no-results p:first-child {
                font-size: 2rem;
                margin-bottom: 10px;
            }
            #faq-no-results p:last-child {
                font-size: 0.84rem;
                color: var(--ink-soft);
            }

            /* CTA footer inside panel */
            .faq-panel-cta {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                padding: 14px 22px;
                background: linear-gradient(
                    to top,
                    var(--cream) 70%,
                    transparent 100%
                );
            }
            .faq-panel-cta a {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                width: 100%;
                padding: 12px;
                background: var(--teal-dk);
                color: #fff;
                font-size: 0.76rem;
                font-weight: 800;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                border-radius: 10px;
                text-decoration: none;
                box-shadow: 0 6px 20px rgba(26, 77, 70, 0.28);
                transition:
                    background 0.15s,
                    transform 0.12s;
            }
            .faq-panel-cta a:hover {
                background: var(--teal);
                transform: translateY(-1px);
            }

            /* ── Backdrop ── */
            #faq-backdrop {
                position: fixed;
                inset: 0;
                background: rgba(26, 18, 9, 0.45);
                backdrop-filter: blur(3px);
                z-index: 199;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.35s;
            }
            #faq-backdrop.open {
                opacity: 1;
                pointer-events: all;
            }
        </style>
    </head>
    <body>
        {{-- Shimmer --}}
        <div class="shimmer-bar sticky top-0 z-60"></div>

        {{-- Navbar --}}
        <nav class="navbar">
            <div class="nav-inner">
                <a href="/" class="nav-logo">
                    <div class="nav-logo-icon">
                        <svg
                            width="20"
                            height="20"
                            fill="none"
                            stroke="#f0d678"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                            />
                        </svg>
                    </div>
                    <div class="nav-logo-text">
                        <span class="nav-logo-name">Journal System</span>
                        <span class="nav-logo-sub">
                            Academic Publishing Portal
                        </span>
                    </div>
                </a>

                <div class="nav-links">
                    <a href="/published-papers" class="nav-link">
                        Published Papers
                    </a>
                    <a href="#fields" class="nav-link">Research Fields</a>
                    <a href="/login" class="nav-link">Sign In</a>
                    <a href="/register" class="btn-nav-register">Register</a>
                </div>

                <button
                    class="nav-hamburger"
                    id="nav-hamburger"
                    aria-label="Toggle menu"
                >
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

            <div class="mobile-menu" id="mobile-menu">
                <div class="mobile-menu-inner">
                    <a href="/published-papers" class="mobile-nav-link">
                        📄 Published Papers
                    </a>
                    <a href="#fields" class="mobile-nav-link">
                        🔬 Research Fields
                    </a>
                    <a href="#process" class="mobile-nav-link">
                        ⚙️ Review Process
                    </a>
                    <a href="/login" class="mobile-nav-link">🔑 Sign In</a>
                    <a href="/register" class="mobile-nav-register">
                        Register — Submit Now →
                    </a>
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
                    <p class="hero-eyebrow">
                        Peer-Reviewed · Open Access · ISSN Registered
                    </p>
                    <h1 class="hero-h1">
                        Advancing Research.
                        <br />
                        <em>Inspiring Innovation.</em>
                    </h1>
                    <p class="hero-p">
                        The official international peer-reviewed journal
                        publishing high-impact research in engineering, science,
                        information technology, and innovation.
                    </p>
                    <div class="hero-cta">
                        <a href="/register" class="btn-hero-primary">
                            <svg
                                width="15"
                                height="15"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2.5"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 4v16m8-8H4"
                                />
                            </svg>
                            Submit Manuscript
                        </a>
                        <a href="#process" class="btn-hero-secondary">
                            Review Process
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
                                    d="M19 9l-7 7-7-7"
                                />
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
                            $indexItems = ['Analie', 'Macky', 'Nicko', 'Ralph', 'Carlos', 'Analie', 'Macky', 'Nicko', 'Ralph', 'Carlos', 'Analie', 'Macky', 'Nicko', 'Ralph', 'Carlos', 'Analie', 'Macky', 'Nicko', 'Ralph', 'Carlos'];
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
                        <div class="metric-val">
                            {{ $publishedPapersCount }}
                        </div>
                        <div class="metric-lbl">Published Articles</div>
                    </div>
                    <div class="metric-cell">
                        <div class="metric-val">
                            {{ $activeReviewersCount }}
                        </div>
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
                            <svg
                                width="28"
                                height="28"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="var(--gold)"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <div class="metric-lbl">DOI Registered</div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Why Publish --}}
        <section class="section" style="background: #fff">
            <div class="section-inner">
                <div class="section-header fade-up">
                    <p class="section-eyebrow">Benefits</p>
                    <h2 class="section-title">
                        Why Publish With
                        <em>Journal System</em>
                    </h2>
                    <p class="section-sub">
                        Key advantages of our double-blind peer-reviewed journal
                    </p>
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
                        <div
                            class="feature-card fade-up fade-up-{{ ($i % 3) + 1 }}"
                        >
                            <div class="feature-icon">
                                <svg
                                    width="22"
                                    height="22"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
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
                    <h2 class="section-title">
                        From Submission to
                        <em>Publication</em>
                    </h2>
                    <p class="section-sub">
                        A transparent, structured process designed for scholarly
                        excellence
                    </p>
                </div>
                <div class="process-grid">
                    @php
                        $steps = [
                            ['num' => '01', 'title' => 'Submit', 'days' => '1–2 days', 'desc' => 'Upload your manuscript, abstract, keywords, and author affiliations through our secure portal.'],
                            ['num' => '02', 'title' => 'Screen', 'days' => '3–5 days', 'desc' => 'Editorial board conducts initial screening for scope, formatting, and ethical compliance.'],
                            ['num' => '03', 'title' => 'Review', 'days' => '10–14 days', 'desc' => 'Two or more expert reviewers provide detailed double-blind evaluations and recommendations.'],
                            ['num' => '04', 'title' => 'Publish', 'days' => '3–5 days', 'desc' => 'Accepted articles receive DOI registration, professional layout, and global distribution.'],
                        ];
                    @endphp

                    @foreach ($steps as $s)
                        <div class="process-step fade-up">
                            <div class="process-step-head">
                                <div class="process-num-wrap">
                                    <span class="process-num">
                                        {{ $s['num'] }}
                                    </span>
                                </div>
                                <h3 class="process-title">
                                    {{ $s['title'] }}
                                </h3>
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
                        <div class="fade-up" style="margin-bottom: 36px">
                            <p
                                class="section-eyebrow"
                                style="
                                    justify-content: flex-start;
                                    margin-bottom: 12px;
                                "
                            >
                                Live Feed
                            </p>
                            <h2
                                class="section-title"
                                style="text-align: left; margin-bottom: 10px"
                            >
                                Research Activity
                                <em>In Progress</em>
                            </h2>
                            <p class="section-sub" style="text-align: left">
                                Real-time updates from our scholarly community —
                                submissions, reviews, and publications happening
                                now.
                            </p>
                        </div>
                        <div
                            style="
                                display: flex;
                                flex-direction: column;
                                gap: 12px;
                            "
                            class="fade-up fade-up-2"
                        >
                            <div
                                style="
                                    background: var(--teal-dk);
                                    border-radius: 14px;
                                    padding: 22px 22px 20px;
                                    border: 1px solid rgba(201, 168, 76, 0.15);
                                "
                            >
                                <p
                                    style="
                                        font-size: 0.62rem;
                                        font-weight: 800;
                                        letter-spacing: 0.2em;
                                        text-transform: uppercase;
                                        color: var(--gold);
                                        margin-bottom: 8px;
                                    "
                                >
                                    For Authors
                                </p>
                                <p
                                    style="
                                        font-family: 'Libre Baskerville', serif;
                                        font-size: 1rem;
                                        font-weight: 700;
                                        color: #fff;
                                        margin-bottom: 6px;
                                    "
                                >
                                    Ready to submit your research?
                                </p>
                                <p
                                    style="
                                        font-size: 0.82rem;
                                        color: rgba(255, 255, 255, 0.55);
                                        margin-bottom: 16px;
                                        line-height: 1.6;
                                    "
                                >
                                    Join hundreds of researchers publishing
                                    their work through our platform.
                                </p>
                                <a
                                    href="/register"
                                    style="
                                        display: inline-flex;
                                        align-items: center;
                                        gap: 8px;
                                        padding: 10px 20px;
                                        background: var(--gold);
                                        color: var(--ink);
                                        font-size: 0.74rem;
                                        font-weight: 700;
                                        letter-spacing: 0.1em;
                                        text-transform: uppercase;
                                        border-radius: 7px;
                                        text-decoration: none;
                                    "
                                >
                                    Begin Submission →
                                </a>
                            </div>
                            <div
                                style="
                                    background: var(--parchment);
                                    border-radius: 14px;
                                    padding: 22px 22px 20px;
                                    border: 1px solid var(--border-dk);
                                "
                            >
                                <p
                                    style="
                                        font-size: 0.62rem;
                                        font-weight: 800;
                                        letter-spacing: 0.2em;
                                        text-transform: uppercase;
                                        color: var(--teal);
                                        margin-bottom: 8px;
                                    "
                                >
                                    For Reviewers
                                </p>
                                <p
                                    style="
                                        font-family: 'Libre Baskerville', serif;
                                        font-size: 1rem;
                                        font-weight: 700;
                                        color: var(--ink);
                                        margin-bottom: 6px;
                                    "
                                >
                                    Become a peer reviewer
                                </p>
                                <p
                                    style="
                                        font-size: 0.82rem;
                                        color: var(--ink-soft);
                                        margin-bottom: 16px;
                                        line-height: 1.6;
                                    "
                                >
                                    Contribute to scholarly excellence and build
                                    your academic reputation.
                                </p>
                                <a
                                    href="/register"
                                    style="
                                        display: inline-flex;
                                        align-items: center;
                                        gap: 8px;
                                        padding: 10px 20px;
                                        background: var(--teal);
                                        color: #fff;
                                        font-size: 0.74rem;
                                        font-weight: 700;
                                        letter-spacing: 0.1em;
                                        text-transform: uppercase;
                                        border-radius: 7px;
                                        text-decoration: none;
                                        box-shadow: 0 4px 14px
                                            rgba(45, 129, 118, 0.25);
                                    "
                                >
                                    Join as Reviewer →
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="activity-feed-wrap fade-up fade-up-3">
                        <div class="activity-feed-head">
                            <div class="live-dot"></div>
                            <span
                                style="
                                    font-size: 0.65rem;
                                    font-weight: 800;
                                    letter-spacing: 0.16em;
                                    text-transform: uppercase;
                                    color: var(--teal);
                                "
                            >
                                Live Feed
                            </span>
                            <span
                                style="
                                    margin-left: auto;
                                    font-size: 0.68rem;
                                    color: var(--border-dk);
                                    font-weight: 600;
                                "
                            >
                                {{ $liveActivities->count() }} recent events
                            </span>
                        </div>
                        <div class="activity-feed-body">
                            <div class="activity-feed-scroll">
                                @php
                                    $icons = ['📄', '🔍', '✅', '📝', '🏆', '📬', '✍️', '🔔'];
                                @endphp

                                @forelse ($liveActivities as $i => $activity)
                                    <div class="activity-item">
                                        <div class="activity-icon">
                                            {{ $icons[$i % count($icons)] }}
                                        </div>
                                        <div>
                                            <div class="activity-title">
                                                {{ $activity['title'] }}
                                            </div>
                                            <div class="activity-desc">
                                                {{ Str::limit($activity['description'], 72) }}
                                            </div>
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
                                            <div class="activity-title">
                                                Awaiting submissions
                                            </div>
                                            <div class="activity-desc">
                                                Be the first to submit your
                                                research to Journal System.
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                                @forelse ($liveActivities as $i => $activity)
                                    <div class="activity-item">
                                        <div class="activity-icon">
                                            {{ $icons[$i % count($icons)] }}
                                        </div>
                                        <div>
                                            <div class="activity-title">
                                                {{ $activity['title'] }}
                                            </div>
                                            <div class="activity-desc">
                                                {{ Str::limit($activity['description'], 72) }}
                                            </div>
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
                    <h2 class="section-title">
                        The Scholars Behind
                        <em>Journal System</em>
                    </h2>
                    <p class="section-sub">
                        Leading academics ensuring the highest standards of
                        scholarly excellence
                    </p>
                </div>
                @php
                    function boardInitials(string $name): string
                    {
                        $clean = preg_replace('/\b(Dr|Prof|Mr|Mrs|Ms|Engr|Atty|Rev)\.?\s*/i', '', $name);
                        $words = array_values(array_filter(explode(' ', trim($clean))));
                        if (count($words) === 0) {
                            return '?';
                        }
                        if (count($words) === 1) {
                            return mb_strtoupper(mb_substr($words[0], 0, 2));
                        }
                        return mb_strtoupper(mb_substr($words[0], 0, 1) . mb_substr(end($words), 0, 1));
                    }
                @endphp

                @php
                    $roleOrder = [
                        'editor_in_chief' => 'Editor-in-Chief',
                        'guest_editor' => 'Guest Editors',
                        'editor' => 'Editors',
                        'managing_editor' => 'Managing Editor',
                        'layout_editor' => 'Layout Editor',
                        'editorial_advisor' => 'Editorial Advisors',
                    ];

                    $grouped = collect($editorialBoard)->groupBy('role');
                @endphp

                @foreach ($roleOrder as $roleKey => $roleLabel)
                    @if ($grouped->has($roleKey))
                        <div
                            style="
                                grid-column: 1 / -1;
                                margin-top: 32px;
                                margin-bottom: 4px;
                                display: flex;
                                align-items: center;
                                gap: 14px;
                            "
                        >
                            <span
                                style="
                                    font-size: 0.62rem;
                                    font-weight: 800;
                                    letter-spacing: 0.2em;
                                    text-transform: uppercase;
                                    color: var(--teal);
                                    white-space: nowrap;
                                "
                            >
                                {{ $roleLabel }}
                            </span>
                            <span
                                style="
                                    flex: 1;
                                    height: 1px;
                                    background: linear-gradient(
                                        to right,
                                        rgba(45, 129, 118, 0.3),
                                        transparent
                                    );
                                "
                            ></span>
                        </div>

                        {{-- Editor-in-Chief: centered single card --}}
                        @if ($roleKey === 'editor_in_chief')
                            <div
                                style="
                                    grid-column: 1 / -1;
                                    display: flex;
                                    justify-content: center;
                                "
                            >
                                @foreach ($grouped[$roleKey] as $member)
                                    <div
                                        class="board-card"
                                        style="width: 260px"
                                    >
                                        <div
                                            class="board-card-top"
                                            style="height: 140px"
                                        >
                                            <div
                                                class="board-avatar"
                                                style="
                                                    width: 80px;
                                                    height: 80px;
                                                    font-size: 1.4rem;
                                                "
                                            >
                                                {{ boardInitials($member['name']) }}
                                            </div>
                                        </div>
                                        <div
                                            class="board-card-body"
                                            style="text-align: center"
                                        >
                                            <div
                                                class="board-name"
                                                style="font-size: 1rem"
                                            >
                                                {{ $member['name'] }}
                                            </div>
                                            <div class="board-role">
                                                {{ $roleLabel }}
                                            </div>
                                            <div class="board-expertise">
                                                {{ $member['expertise'] }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- All other roles: normal grid --}}
                        @else
                            @foreach ($grouped[$roleKey] as $i => $member)
                                <div
                                    class="board-card fade-up fade-up-{{ ($i % 3) + 1 }}"
                                >
                                    <div class="board-card-top">
                                        <div class="board-avatar">
                                            {{ boardInitials($member['name']) }}
                                        </div>
                                    </div>
                                    <div class="board-card-body">
                                        <div class="board-name">
                                            {{ $member['name'] }}
                                        </div>
                                        <div class="board-role">
                                            {{ $roleLabel }}
                                        </div>
                                        <div class="board-expertise">
                                            {{ $member['expertise'] }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endif
                @endforeach
            </div>
        </section>

        {{-- Research Fields --}}
        <section class="section" id="fields" style="background: #fff">
            <div class="section-inner">
                <div class="section-header fade-up">
                    <p class="section-eyebrow">Scope</p>
                    <h2 class="section-title">
                        Research
                        <em>Fields & Topics</em>
                    </h2>
                    <p class="section-sub">
                        Explore the diverse disciplines covered in our journal
                    </p>
                </div>
                @php
                    $fieldIconMap = ['science' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3v6.75l-1.5 2.25m1.5-2.25h4.5m-4.5 0L7.5 15.75M12 3v6.75m2.25 2.25L12 15.75m0 0L9.75 15.75m2.25 0v3.75m0 0H9.75m2.25 0h2.25M3.375 15.75h17.25"/>', 'technolog' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3v6.75l-1.5 2.25m1.5-2.25h4.5m-4.5 0L7.5 15.75M12 3v6.75m2.25 2.25L12 15.75m0 0L9.75 15.75m2.25 0v3.75m0 0H9.75m2.25 0h2.25M3.375 15.75h17.25"/>', 'engineer' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437"/>', 'health' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>', 'medical' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>', 'information' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"/>', 'computer' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"/>', 'software' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"/>', 'business' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0"/>', 'educat' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>', 'data' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>', 'energy' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>', 'artificial' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714a2.25 2.25 0 001.357 2.059l.537.268a2.25 2.25 0 001.357.208l1.26-.252m-5.511-7.235c.251.023.501.05.75.082M15 3.186a24.3 24.3 0 01-4.5 0M5 14.5l-.408.816a2.25 2.25 0 002.01 3.25h10.797a2.25 2.25 0 002.01-3.25L19 14.5M5 14.5h14"/>', 'machine' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714a2.25 2.25 0 001.357 2.059l.537.268a2.25 2.25 0 001.357.208l1.26-.252m-5.511-7.235c.251.023.501.05.75.082M15 3.186a24.3 24.3 0 01-4.5 0M5 14.5l-.408.816a2.25 2.25 0 002.01 3.25h10.797a2.25 2.25 0 002.01-3.25L19 14.5M5 14.5h14"/>', 'cloud' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z"/>', 'default' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>'];

                    function getFieldIcon(string $name, array $map): string
                    {
                        $lower = strtolower($name);
                        foreach ($map as $keyword => $svg) {
                            if ($keyword !== 'default' && str_contains($lower, $keyword)) {
                                return $svg;
                            }
                        }
                        return $map['default'];
                    }

                    $colorClasses = ['field-c1', 'field-c2', 'field-c3', 'field-c4', 'field-c5', 'field-c6', 'field-c7', 'field-c8', 'field-c9', 'field-c10'];
                @endphp

                <div class="fields-grid">
                    @forelse ($researchFields as $idx => $field)
                        <div
                            class="field-card {{ $colorClasses[$idx % count($colorClasses)] }} fade-up"
                        >
                            <div class="field-icon">
                                <svg
                                    width="20"
                                    height="20"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24"
                                >
                                    {!! getFieldIcon($field['name'], $fieldIconMap) !!}
                                </svg>
                            </div>
                            <div class="field-name">{{ $field['name'] }}</div>
                            @if (! empty($field['count']) && $field['count'] > 0)
                                <div class="field-count">
                                    {{ $field['count'] }}
                                    {{ $field['count'] == 1 ? 'paper' : 'papers' }}
                                </div>
                            @endif
                        </div>
                    @empty
                        @foreach (['Artificial Intelligence', 'Software Engineering', 'Cybersecurity', 'Renewable Energy', 'Data Science', 'Biotechnology', 'Networking', 'Cloud Computing', 'IoT Systems', 'Innovation'] as $idx => $name)
                            <div
                                class="field-card {{ $colorClasses[$idx % count($colorClasses)] }} fade-up"
                            >
                                <div class="field-icon">
                                    <svg
                                        width="20"
                                        height="20"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24"
                                    >
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
        {{-- About --}}
        <section
            id="about"
            class="section"
            style="
                background: linear-gradient(
                    160deg,
                    #f8f5ef 0%,
                    #fffdf8 55%,
                    #f0f7f4 100%
                );
                position: relative;
                overflow: hidden;
            "
        >
            <div
                style="
                    position: absolute;
                    top: -40px;
                    right: -40px;
                    width: 320px;
                    height: 320px;
                    background: radial-gradient(
                        circle,
                        rgba(15, 110, 86, 0.07) 0%,
                        transparent 70%
                    );
                    border-radius: 50%;
                    pointer-events: none;
                "
            ></div>
            <div
                style="
                    position: absolute;
                    bottom: -60px;
                    left: -30px;
                    width: 240px;
                    height: 240px;
                    background: radial-gradient(
                        circle,
                        rgba(201, 168, 76, 0.09) 0%,
                        transparent 70%
                    );
                    border-radius: 50%;
                    pointer-events: none;
                "
            ></div>

            <div class="section-inner">
                {{-- Header --}}
                <div class="section-header fade-up">
                    <p class="section-eyebrow">About</p>
                    <h2 class="section-title">
                        The Team Behind
                        <em>Journal System</em>
                    </h2>
                    <p class="section-sub">
                        An academic publishing portal built to streamline
                        manuscript submission, double-blind peer review, and
                        open-access publication.
                    </p>
                </div>

                {{-- Team Layout --}}
                <div
                    class="fade-up"
                    style="
                        display: flex;
                        gap: 20px;
                        align-items: stretch;
                        flex-wrap: wrap;
                        justify-content: center;
                    "
                >
                    {{-- LEFT: Supervisor --}}
                    <div
                        style="
                            flex: 0 0 240px;
                            display: flex;
                            flex-direction: column;
                            gap: 12px;
                        "
                    >
                        <p
                            style="
                                font-size: 0.55rem;
                                font-weight: 700;
                                letter-spacing: 0.22em;
                                text-transform: uppercase;
                                color: var(--teal);
                                display: flex;
                                align-items: center;
                                gap: 8px;
                                margin: 0;
                            "
                        >
                            <span
                                style="
                                    flex: 1;
                                    height: 1px;
                                    background: linear-gradient(
                                        to right,
                                        transparent,
                                        var(--teal)
                                    );
                                "
                            ></span>
                            Supervisor
                            <span
                                style="
                                    flex: 1;
                                    height: 1px;
                                    background: linear-gradient(
                                        to left,
                                        transparent,
                                        var(--teal)
                                    );
                                "
                            ></span>
                        </p>
                        <div
                            style="
                                flex: 1;
                                background: #fff;
                                border: 1.5px solid var(--border);
                                border-radius: 16px;
                                padding: 36px 24px;
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                justify-content: center;
                                text-align: center;
                                box-shadow: 0 8px 32px rgba(15, 110, 86, 0.08);
                                position: relative;
                                overflow: hidden;
                            "
                        >
                            <div
                                style="
                                    position: absolute;
                                    top: 0;
                                    left: 0;
                                    width: 100%;
                                    height: 4px;
                                    background: linear-gradient(
                                        to right,
                                        var(--gold),
                                        var(--teal)
                                    );
                                "
                            ></div>
                            <div
                                style="
                                    position: absolute;
                                    bottom: -30px;
                                    right: -30px;
                                    width: 100px;
                                    height: 100px;
                                    background: radial-gradient(
                                        circle,
                                        rgba(201, 168, 76, 0.1) 0%,
                                        transparent 70%
                                    );
                                    border-radius: 50%;
                                "
                            ></div>

                            <div
                                style="
                                    width: 96px;
                                    height: 96px;
                                    border-radius: 50%;
                                    background: linear-gradient(
                                        135deg,
                                        var(--teal),
                                        #0a7a60
                                    );
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-size: 1.5rem;
                                    font-weight: 700;
                                    color: #fff;
                                    letter-spacing: 0.05em;
                                    margin-bottom: 20px;
                                    box-shadow: 0 6px 24px
                                        rgba(15, 110, 86, 0.25);
                                "
                            >
                                ELV
                            </div>

                            <div
                                style="
                                    display: inline-flex;
                                    align-items: center;
                                    gap: 5px;
                                    background: linear-gradient(
                                        135deg,
                                        #fdf6e3,
                                        #fef9ed
                                    );
                                    border: 1px solid rgba(201, 168, 76, 0.4);
                                    border-radius: 20px;
                                    padding: 4px 12px;
                                    margin-bottom: 14px;
                                "
                            >
                                <svg
                                    width="10"
                                    height="10"
                                    viewBox="0 0 24 24"
                                    fill="var(--gold)"
                                >
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
                                    />
                                </svg>
                                <span
                                    style="
                                        font-size: 0.55rem;
                                        font-weight: 700;
                                        letter-spacing: 0.15em;
                                        text-transform: uppercase;
                                        color: #a07820;
                                    "
                                >
                                    Project Lead
                                </span>
                            </div>

                            <div
                                style="
                                    font-size: 1rem;
                                    font-weight: 700;
                                    color: var(--ink);
                                    line-height: 1.3;
                                    margin-bottom: 6px;
                                "
                            >
                                Dr. Eleazer L. Vivas
                            </div>
                            <div
                                style="
                                    font-size: 0.75rem;
                                    font-weight: 600;
                                    color: var(--teal);
                                "
                            >
                                Project Supervisor
                            </div>

                            <div
                                style="
                                    width: 40px;
                                    height: 1.5px;
                                    background: linear-gradient(
                                        to right,
                                        var(--gold),
                                        var(--teal)
                                    );
                                    border-radius: 2px;
                                    margin-top: 20px;
                                "
                            ></div>
                        </div>
                    </div>

                    {{-- RIGHT: Developers --}}
                    <div
                        style="
                            flex: 0 0 480px;
                            display: flex;
                            flex-direction: column;
                            gap: 12px;
                        "
                    >
                        <p
                            style="
                                font-size: 0.55rem;
                                font-weight: 700;
                                letter-spacing: 0.22em;
                                text-transform: uppercase;
                                color: var(--teal);
                                display: flex;
                                align-items: center;
                                gap: 8px;
                                margin: 0;
                            "
                        >
                            <span
                                style="
                                    flex: 1;
                                    height: 1px;
                                    background: linear-gradient(
                                        to right,
                                        transparent,
                                        var(--teal)
                                    );
                                "
                            ></span>
                            Developers
                            <span
                                style="
                                    flex: 1;
                                    height: 1px;
                                    background: linear-gradient(
                                        to left,
                                        transparent,
                                        var(--teal)
                                    );
                                "
                            ></span>
                        </p>
                        <div
                            style="
                                flex: 1;
                                display: grid;
                                grid-template-columns: repeat(2, 1fr);
                                gap: 12px;
                            "
                        >
                            @foreach ([
                                    ['name' => 'Mac Kenny G. Aleta', 'initials' => 'MKA'],
                                    ['name' => 'Nicko C. Ilag', 'initials' => 'NCI'],
                                    ['name' => 'Ralph Jan L. Areta', 'initials' => 'RJA'],
                                    ['name' => 'Carlos Ruben A. Gupit', 'initials' => 'CRG']
                                ]
                                as $i => $dev)
                                <div
                                    class="fade-up fade-up-{{ $i + 1 }}"
                                    style="
                                        background: #fff;
                                        border: 1.5px solid var(--border);
                                        border-radius: 12px;
                                        padding: 22px 16px;
                                        display: flex;
                                        flex-direction: column;
                                        align-items: center;
                                        justify-content: center;
                                        text-align: center;
                                        box-shadow: 0 4px 14px
                                            rgba(15, 110, 86, 0.05);
                                        position: relative;
                                        overflow: hidden;
                                    "
                                >
                                    <div
                                        style="
                                            position: absolute;
                                            top: 0;
                                            left: 0;
                                            width: 100%;
                                            height: 2.5px;
                                            background: linear-gradient(
                                                to right,
                                                var(--teal),
                                                rgba(15, 110, 86, 0.2)
                                            );
                                        "
                                    ></div>
                                    <div
                                        style="
                                            width: 52px;
                                            height: 52px;
                                            border-radius: 50%;
                                            background: linear-gradient(
                                                135deg,
                                                rgba(15, 110, 86, 0.12),
                                                rgba(15, 110, 86, 0.04)
                                            );
                                            border: 1.5px solid
                                                rgba(15, 110, 86, 0.2);
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            font-size: 0.7rem;
                                            font-weight: 700;
                                            color: var(--teal);
                                            letter-spacing: 0.04em;
                                            margin-bottom: 10px;
                                        "
                                    >
                                        {{ $dev['initials'] }}
                                    </div>
                                    <div
                                        style="
                                            font-size: 0.78rem;
                                            font-weight: 700;
                                            color: var(--ink);
                                            line-height: 1.3;
                                            margin-bottom: 4px;
                                        "
                                    >
                                        {{ $dev['name'] }}
                                    </div>
                                    <div
                                        style="
                                            font-size: 0.65rem;
                                            font-weight: 600;
                                            color: var(--teal);
                                        "
                                    >
                                        Developer
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Quote --}}
                <div
                    class="fade-up fade-up-3"
                    style="
                        margin-top: 28px;
                        padding: 18px 28px;
                        background: #fff;
                        border: 1.5px solid var(--border);
                        border-left: 3px solid var(--gold);
                        border-radius: 12px;
                        text-align: center;
                        box-shadow: 0 4px 16px rgba(45, 129, 118, 0.06);
                    "
                >
                    <p
                        style="
                            font-size: 0.84rem;
                            color: var(--ink-soft);
                            line-height: 1.75;
                            margin: 0;
                            font-style: italic;
                        "
                    >
                        Built with passion for the
                        <strong
                            style="
                                color: var(--teal);
                                font-weight: 600;
                                font-style: normal;
                            "
                        >
                            academic community
                        </strong>
                        — making scholarly publishing accessible, transparent,
                        and efficient for researchers everywhere.
                    </p>
                </div>
            </div>
        </section>
        {{-- Footer --}}
        <footer>
            <div class="footer-inner">
                <div class="footer-brand">
                    <div class="footer-brand-name">Journal System</div>
                    <div class="footer-brand-sub">
                        Academic Publishing Portal Int'l Research Journal
                    </div>
                    <p class="footer-brand-desc">
                        The official peer-reviewed international journal
                        committed to advancing knowledge in engineering,
                        science, and technology.
                    </p>
                </div>
                <div>
                    <p class="footer-col-title">Journal</p>
                    <ul class="footer-links">
                        <li>
                            <a href="/published-papers">Published Papers</a>
                        </li>
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
                    © {{ date('Y') }} Journal System — All rights reserved.
                </span>
                <span class="footer-tagline">
                    Advancing Knowledge · Inspiring Innovation
                </span>
            </div>
        </footer>

        {{-- FLOATING FAQ BUTTON --}}
        <button
            id="faq-trigger"
            aria-label="Frequently Asked Questions"
            aria-expanded="false"
            aria-controls="faq-panel"
        >
            <span class="faq-trigger-icon">
                <svg
                    width="22"
                    height="22"
                    fill="none"
                    stroke="#fff"
                    stroke-width="2.2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
            </span>
            <span class="faq-trigger-label">FAQ</span>
        </button>

        {{-- FAQ BACKDROP --}}
        <div id="faq-backdrop" aria-hidden="true"></div>

        {{-- FAQ PANEL --}}
        <div
            id="faq-panel"
            role="dialog"
            aria-modal="true"
            aria-label="Frequently Asked Questions"
        >
            <div class="faq-drag-handle"></div>
            <div class="faq-panel-shimmer"></div>

            <div class="faq-panel-header">
                <div class="faq-panel-icon">
                    <svg
                        width="20"
                        height="20"
                        fill="none"
                        stroke="#fff"
                        stroke-width="2.2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                </div>
                <div class="faq-panel-titles">
                    <p class="faq-panel-eyebrow">Help Center</p>
                    <p class="faq-panel-title">
                        Frequently Asked
                        <em style="font-style: italic; color: var(--teal)">
                            Questions
                        </em>
                    </p>
                </div>
                <button id="faq-close" aria-label="Close FAQ panel">
                    <svg
                        width="16"
                        height="16"
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

            <div class="faq-search-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                        stroke-width="2.5"
                    />
                </svg>
                <input
                    type="text"
                    id="faq-search"
                    placeholder="Search questions…"
                    autocomplete="off"
                />
            </div>

            <div class="faq-body" id="faq-body">
                <div class="faq-category" data-cat="Submissions">
                    Submissions
                </div>

                <div
                    class="faq-item"
                    data-q="How do I submit a manuscript to Journal System?"
                >
                    <button class="faq-q" aria-expanded="false">
                        <span class="faq-q-num">1</span>
                        <span class="faq-q-text">
                            How do I submit a manuscript?
                        </span>
                        <svg
                            class="faq-q-chevron"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <div class="faq-a">
                        <div class="faq-a-inner">
                            <a href="/register">Register an account</a>
                            or sign in, then click
                            <strong>New Submission</strong>
                            in your Author Dashboard. Upload your manuscript
                            file (PDF, DOC, or DOCX), fill in the title,
                            abstract and keywords, then click Submit. You'll
                            receive a confirmation email with your reference
                            number.
                        </div>
                    </div>
                </div>

                <div
                    class="faq-item"
                    data-q="What file formats are accepted for manuscript submission?"
                >
                    <button class="faq-q" aria-expanded="false">
                        <span class="faq-q-num">2</span>
                        <span class="faq-q-text">
                            What file formats are accepted?
                        </span>
                        <svg
                            class="faq-q-chevron"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <div class="faq-a">
                        <div class="faq-a-inner">
                            We accept
                            <strong>PDF</strong>
                            ,
                            <strong>DOC</strong>
                            , and
                            <strong>DOCX</strong>
                            files for the main manuscript.
                        </div>
                    </div>
                </div>

                <div
                    class="faq-item"
                    data-q="Is there a submission fee or article processing charge?"
                >
                    <button class="faq-q" aria-expanded="false">
                        <span class="faq-q-num">3</span>
                        <span class="faq-q-text">
                            Is there a submission fee?
                        </span>
                        <svg
                            class="faq-q-chevron"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <div class="faq-a">
                        <div class="faq-a-inner">
                            Submission and peer review are
                            <strong>free of charge</strong>
                            . An Article Processing Charge (APC) applies only
                            upon acceptance to cover open-access publishing and
                            DOI registration. Authors are notified of the exact
                            fee at the acceptance stage.
                        </div>
                    </div>
                </div>

                <div
                    class="faq-item"
                    data-q="Can I submit a manuscript that is currently under review elsewhere?"
                >
                    <button class="faq-q" aria-expanded="false">
                        <span class="faq-q-num">4</span>
                        <span class="faq-q-text">
                            Can I submit to multiple journals simultaneously?
                        </span>
                        <svg
                            class="faq-q-chevron"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <div class="faq-a">
                        <div class="faq-a-inner">
                            No. We follow strict
                            <strong>single-submission policy</strong>
                            . Submitting the same manuscript to another journal
                            while it is under review here constitutes a
                            violation of publication ethics and may result in
                            immediate rejection and blacklisting.
                        </div>
                    </div>
                </div>

                <div class="faq-category" data-cat="Review Process">
                    Review Process
                </div>

                <div
                    class="faq-item"
                    data-q="How long does the peer review process take from submission to decision?"
                >
                    <button class="faq-q" aria-expanded="false">
                        <span class="faq-q-num">5</span>
                        <span class="faq-q-text">
                            How long does peer review take?
                        </span>
                        <svg
                            class="faq-q-chevron"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <div class="faq-a">
                        <div class="faq-a-inner">
                            Initial screening takes
                            <strong>3–5 days</strong>
                            . Full peer review typically takes
                            <strong>10–14 days</strong>
                            . The total time from submission to first decision
                            is usually 2–3 weeks. Revision and final decision
                            adds another 1–2 weeks depending on the scope of
                            changes requested.
                        </div>
                    </div>
                </div>

                <div
                    class="faq-item"
                    data-q="What is double-blind peer review and how does it protect authors?"
                >
                    <button class="faq-q" aria-expanded="false">
                        <span class="faq-q-num">6</span>
                        <span class="faq-q-text">
                            What is double-blind peer review?
                        </span>
                        <svg
                            class="faq-q-chevron"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <div class="faq-a">
                        <div class="faq-a-inner">
                            In double-blind review, both the
                            <strong>
                                reviewers' identities are hidden from authors
                            </strong>
                            and the
                            <strong>
                                authors' identities are hidden from reviewers
                            </strong>
                            . This eliminates bias based on institutional
                            affiliation, gender, nationality, or prior
                            reputation, ensuring evaluation is based purely on
                            scholarly merit.
                        </div>
                    </div>
                </div>

                <div
                    class="faq-item"
                    data-q="What happens after I receive a revisions requested decision?"
                >
                    <button class="faq-q" aria-expanded="false">
                        <span class="faq-q-num">7</span>
                        <span class="faq-q-text">
                            What happens if revisions are requested?
                        </span>
                        <svg
                            class="faq-q-chevron"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <div class="faq-a">
                        <div class="faq-a-inner">
                            You'll receive detailed reviewer comments in your
                            dashboard. Address each point in a
                            <strong>point-by-point response letter</strong>
                            and upload the revised manuscript. Revisions are
                            typically due within
                            <strong>14–21 days</strong>
                            . The revised manuscript goes back to the original
                            reviewers for final assessment.
                        </div>
                    </div>
                </div>

                <div
                    class="faq-item"
                    data-q="Can I appeal a rejection decision from the editorial board?"
                >
                    <button class="faq-q" aria-expanded="false">
                        <span class="faq-q-num">8</span>
                        <span class="faq-q-text">
                            Can I appeal a rejection?
                        </span>
                        <svg
                            class="faq-q-chevron"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <div class="faq-a">
                        <div class="faq-a-inner">
                            Yes. You may submit a formal appeal through your
                            Author Dashboard within
                            <strong>30 days</strong>
                            of the rejection decision. Appeals must include a
                            detailed rebuttal addressing the reviewers'
                            concerns. The Editor-in-Chief reviews all appeals.
                            Each manuscript is limited to two appeal attempts.
                        </div>
                    </div>
                </div>

                <div class="faq-category" data-cat="Publication">
                    Publication & Copyright
                </div>

                <div
                    class="faq-item"
                    data-q="What is a copyright transfer form CTF and when do I need to sign it?"
                >
                    <button class="faq-q" aria-expanded="false">
                        <span class="faq-q-num">9</span>
                        <span class="faq-q-text">
                            What is the Copyright Transfer Form (CTF)?
                        </span>
                        <svg
                            class="faq-q-chevron"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <div class="faq-a">
                        <div class="faq-a-inner">
                            Upon acceptance, we issue a
                            <strong>Copyright Transfer Form</strong>
                            which assigns publication rights to the journal
                            while allowing authors to retain the right to use
                            their work for educational and research purposes.
                            Download it from your dashboard, sign it, and upload
                            the signed copy. Publication will not proceed until
                            the CTF is received.
                        </div>
                    </div>
                </div>

                <div
                    class="faq-item"
                    data-q="How will my article be distributed and can readers access it for free?"
                >
                    <button class="faq-q" aria-expanded="false">
                        <span class="faq-q-num">10</span>
                        <span class="faq-q-text">
                            Is my article freely accessible after publication?
                        </span>
                        <svg
                            class="faq-q-chevron"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <div class="faq-a">
                        <div class="faq-a-inner">
                            Yes. All published articles are
                            <strong>open access</strong>
                            — freely available to anyone worldwide, permanently.
                            Each article receives a
                            <strong>DOI</strong>
                            (Digital Object Identifier) for permanent citation,
                            and is indexed and distributed through academic
                            databases and search engines.
                        </div>
                    </div>
                </div>

                <div class="faq-category" data-cat="Account">
                    Account & Technical
                </div>

                <div
                    class="faq-item"
                    data-q="How do I track the status of my submitted manuscript?"
                >
                    <button class="faq-q" aria-expanded="false">
                        <span class="faq-q-num">11</span>
                        <span class="faq-q-text">
                            How do I track my submission status?
                        </span>
                        <svg
                            class="faq-q-chevron"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <div class="faq-a">
                        <div class="faq-a-inner">
                            Sign in to your account and visit the
                            <strong>Author Dashboard</strong>
                            . Each submission shows a real-time status badge:
                            Submitted → Under Review → Revisions Requested →
                            Accepted/Rejected. You'll also receive email
                            notifications at every major status change.
                        </div>
                    </div>
                </div>

                <div
                    class="faq-item"
                    data-q="I forgot my password how do I reset it and regain access?"
                >
                    <button class="faq-q" aria-expanded="false">
                        <span class="faq-q-num">12</span>
                        <span class="faq-q-text">
                            I forgot my password. How do I reset it?
                        </span>
                        <svg
                            class="faq-q-chevron"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <div class="faq-a">
                        <div class="faq-a-inner">
                            On the
                            <a href="/login">Sign In page</a>
                            , click
                            <strong>"Forgot password?"</strong>
                            . Enter your registered email address and we'll send
                            a password reset link within a few minutes. Check
                            your spam folder if you don't see it. The link
                            expires after 60 minutes.
                        </div>
                    </div>
                </div>

                <div id="faq-no-results">
                    <p>🔍</p>
                    <p>
                        No questions match your search.
                        <br />
                        Try different keywords.
                    </p>
                </div>
            </div>

            <div class="faq-panel-cta">
                <a href="/register">
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
                            d="M12 4v16m8-8H4"
                        />
                    </svg>
                    Ready to Submit Your Research?
                </a>
            </div>
        </div>

        {{-- Scroll top --}}
        <button
            id="scroll-top"
            onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
            aria-label="Scroll to top"
        >
            <svg
                width="18"
                height="18"
                fill="none"
                stroke="currentColor"
                stroke-width="2.5"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M5 15l7-7 7 7"
                />
            </svg>
        </button>

        <script>
            /* ── Navbar hamburger ── */
            const hamburger = document.getElementById('nav-hamburger');
            const mobileMenu = document.getElementById('mobile-menu');
            hamburger.addEventListener('click', () => {
                const isOpen = mobileMenu.classList.toggle('open');
                hamburger.classList.toggle('open', isOpen);
            });
            mobileMenu.querySelectorAll('a').forEach((a) => {
                a.addEventListener('click', () => {
                    mobileMenu.classList.remove('open');
                    hamburger.classList.remove('open');
                });
            });

            /* ── Scroll-top ── */
            const scrollBtn = document.getElementById('scroll-top');
            window.addEventListener('scroll', () => {
                scrollBtn.classList.toggle('show', window.scrollY > 400);
            });

            /* ── Fade-up animations ── */
            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((e) => {
                        if (e.isIntersecting) {
                            e.target.classList.add('visible');
                            observer.unobserve(e.target);
                        }
                    });
                },
                { threshold: 0.1, rootMargin: '0px 0px -40px 0px' },
            );
            document
                .querySelectorAll('.fade-up')
                .forEach((el) => observer.observe(el));

            /* ── FAQ PANEL LOGIC ── */
            const faqTrigger = document.getElementById('faq-trigger');
            const faqPanel = document.getElementById('faq-panel');
            const faqBackdrop = document.getElementById('faq-backdrop');
            const faqClose = document.getElementById('faq-close');
            const faqSearch = document.getElementById('faq-search');
            const faqNoRes = document.getElementById('faq-no-results');

            function openFaq() {
                faqPanel.classList.add('open');
                faqBackdrop.classList.add('open');
                faqTrigger.classList.add('open');
                faqTrigger.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
                setTimeout(() => faqSearch.focus(), 420);
            }

            function closeFaq() {
                faqPanel.classList.remove('open');
                faqBackdrop.classList.remove('open');
                faqTrigger.classList.remove('open');
                faqTrigger.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
                faqSearch.value = '';
                filterFaq('');
            }

            faqTrigger.addEventListener('click', () => {
                faqPanel.classList.contains('open') ? closeFaq() : openFaq();
            });
            faqClose.addEventListener('click', closeFaq);
            faqBackdrop.addEventListener('click', closeFaq);

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && faqPanel.classList.contains('open'))
                    closeFaq();
            });

            /* ── Accordion ── */
            document.querySelectorAll('.faq-q').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const item = btn.closest('.faq-item');
                    const isOpen = item.classList.contains('active');
                    document
                        .querySelectorAll('.faq-item.active')
                        .forEach((i) => {
                            i.classList.remove('active');
                            i.querySelector('.faq-q').setAttribute(
                                'aria-expanded',
                                'false',
                            );
                        });
                    if (!isOpen) {
                        item.classList.add('active');
                        btn.setAttribute('aria-expanded', 'true');
                    }
                });
            });

            /* ── Search / filter ── */
            function filterFaq(query) {
                const q = query.toLowerCase().trim();
                const items = document.querySelectorAll('.faq-item');
                const cats = document.querySelectorAll('.faq-category');
                let anyVisible = false;

                items.forEach((item) => {
                    const text =
                        (item.dataset.q || '').toLowerCase() +
                        item
                            .querySelector('.faq-q-text')
                            .textContent.toLowerCase() +
                        item
                            .querySelector('.faq-a-inner')
                            .textContent.toLowerCase();
                    const match = !q || text.includes(q);
                    item.classList.toggle('hidden', !match);
                    if (match) anyVisible = true;
                });

                cats.forEach((cat) => {
                    let next = cat.nextElementSibling;
                    let hasVis = false;
                    while (next && !next.classList.contains('faq-category')) {
                        if (
                            next.classList.contains('faq-item') &&
                            !next.classList.contains('hidden')
                        )
                            hasVis = true;
                        next = next.nextElementSibling;
                    }
                    cat.style.display = hasVis ? '' : 'none';
                });

                faqNoRes.style.display = anyVisible ? 'none' : 'block';
            }

            faqSearch.addEventListener('input', (e) =>
                filterFaq(e.target.value),
            );

            /* ── Mobile swipe-down to close ── */
            let touchStartY = 0;
            faqPanel.addEventListener(
                'touchstart',
                (e) => {
                    touchStartY = e.touches[0].clientY;
                },
                { passive: true },
            );
            faqPanel.addEventListener(
                'touchend',
                (e) => {
                    const delta = e.changedTouches[0].clientY - touchStartY;
                    if (delta > 80) closeFaq();
                },
                { passive: true },
            );
        </script>
    </body>
</html>
