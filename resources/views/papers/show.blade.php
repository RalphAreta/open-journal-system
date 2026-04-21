<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ $paper['title'] }} - Published Paper</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=IBM+Plex+Sans:wght@300;400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap"
            rel="stylesheet"
        />
        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
            html { scroll-behavior: smooth; font-size: 15px; }

            :root {
                --teal:       #1d6e65;
                --teal-dark:  #134e47;
                --teal-mid:   #25857a;
                --teal-light: rgba(29,110,101,0.08);
                --gold:       #b8922a;
                --gold-pale:  rgba(184,146,42,0.1);
                --cream:      #f6f2eb;
                --cream-mid:  #eee9df;
                --white:      #ffffff;
                --border:     #ddd8ce;
                --border-mid: #e8e3d8;
                --muted:      #7a7264;
                --body:       #2c2a26;
                --heading:    #1a1714;
                --shadow-sm:  0 1px 3px rgba(0,0,0,0.07), 0 1px 2px rgba(0,0,0,0.05);
                --shadow-md:  0 4px 12px rgba(0,0,0,0.08), 0 2px 4px rgba(0,0,0,0.05);
                --shadow-lg:  0 12px 32px rgba(0,0,0,0.1), 0 4px 8px rgba(0,0,0,0.06);
                --r-sm:       6px;
                --r-md:       10px;
                --r-lg:       14px;
            }

            body {
                font-family: 'IBM Plex Sans', system-ui, sans-serif;
                background: var(--cream);
                color: var(--body);
                min-height: 100vh;
                -webkit-font-smoothing: antialiased;
            }

            /* ── Animations ── */
            @keyframes fadeUp {
                from { opacity: 0; transform: translateY(12px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            @keyframes fadeIn {
                from { opacity: 0; } to { opacity: 1; }
            }
            @keyframes slideUp {
                from { opacity: 0; transform: translateY(20px) scale(0.98); }
                to   { opacity: 1; transform: translateY(0) scale(1); }
            }
            @keyframes spin { to { transform: rotate(360deg); } }
            @keyframes shimmer {
                0%   { background-position: -200% 0; }
                100% { background-position:  200% 0; }
            }

            .reveal {
                opacity: 0; transform: translateY(10px);
                transition: opacity 0.5s ease, transform 0.5s cubic-bezier(.22,.68,0,1.2);
            }
            .reveal.visible { opacity: 1; transform: none; }

            /* ══ TOP ACCENT BAR ══ */
            .accent-bar {
                height: 3px;
                background: linear-gradient(90deg, var(--teal-dark) 0%, var(--teal-mid) 55%, #3aaba0 100%);
            }

            /* ══ HEADER ══ */
            .site-header {
                position: sticky; top: 0; z-index: 50;
                background: rgba(246,242,235,0.95);
                backdrop-filter: blur(12px);
                border-bottom: 1px solid var(--border);
            }
            .header-inner {
                max-width: 76rem; margin: 0 auto;
                padding: 0 1.5rem;
                height: 3.5rem;
                display: flex; align-items: center; justify-content: space-between; gap: 1rem;
            }
            .header-brand {
                display: flex; align-items: center; gap: 0.6rem;
                text-decoration: none; flex-shrink: 0;
            }
            .brand-icon {
                width: 1.9rem; height: 1.9rem;
                background: var(--teal-dark); border-radius: 6px;
                display: flex; align-items: center; justify-content: center;
                color: #f0d678;
                box-shadow: var(--shadow-sm);
            }
            .brand-name {
                font-family: 'Lora', serif;
                font-size: 1rem; font-weight: 700;
                color: var(--teal-dark);
                line-height: 1;
            }
            .brand-sub {
                font-size: 0.48rem; font-weight: 600;
                text-transform: uppercase; letter-spacing: 0.12em;
                color: var(--gold);
            }
            .back-btn {
                display: inline-flex; align-items: center; gap: 0.3rem;
                font-size: 0.72rem; font-weight: 500;
                color: var(--muted); text-decoration: none;
                padding: 0.3rem 0.75rem;
                border: 1px solid var(--border);
                border-radius: 999px;
                transition: color .2s, border-color .2s, background .2s;
            }
            .back-btn:hover { color: var(--teal); border-color: var(--teal); background: var(--teal-light); }

            /* ══ HERO ══ */
            .paper-hero {
                background: linear-gradient(155deg, var(--teal-dark) 0%, var(--teal-mid) 60%, #2a9088 100%);
                position: relative; overflow: hidden;
                padding: 2.5rem 1.5rem 2rem;
            }
            .paper-hero::before {
                content: '';
                position: absolute; inset: 0;
                background-image: radial-gradient(circle, rgba(255,255,255,0.05) 1px, transparent 1px);
                background-size: 22px 22px;
                pointer-events: none;
            }
            .paper-hero::after {
                content: '';
                position: absolute; inset: 0;
                background:
                    radial-gradient(ellipse 60% 55% at 95% 5%,  rgba(184,146,42,0.18) 0%, transparent 55%),
                    radial-gradient(ellipse 40% 60% at 0% 95%, rgba(0,0,0,0.25) 0%, transparent 50%);
                pointer-events: none;
            }
            .hero-shimmer {
                position: absolute; top: 0; left: 0; right: 0; height: 2px;
                background: linear-gradient(90deg, transparent, rgba(240,214,120,0.8) 50%, transparent);
                background-size: 200% 100%;
                animation: shimmer 3.5s linear infinite;
                z-index: 5;
            }
            .hero-inner {
                position: relative; z-index: 5;
                max-width: 76rem; margin: 0 auto;
                display: grid; grid-template-columns: 1fr auto; gap: 1.5rem 2rem;
                align-items: end;
            }
            .hero-main { min-width: 0; }

            .status-badge {
                display: inline-flex; align-items: center; gap: 0.4rem;
                padding: 0.22rem 0.65rem;
                border: 1px solid rgba(255,255,255,0.22);
                background: rgba(0,0,0,0.18);
                border-radius: 999px;
                font-size: 0.58rem; font-weight: 700;
                letter-spacing: 0.14em; text-transform: uppercase;
                color: #f0d678;
                margin-bottom: 0.9rem;
            }
            .pulse-dot {
                width: 5px; height: 5px; border-radius: 50%;
                background: var(--gold);
                box-shadow: 0 0 0 0 rgba(184,146,42,0.5);
                animation: pulse 2s ease-in-out infinite;
            }
            @keyframes pulse {
                0%,100% { box-shadow: 0 0 0 0 rgba(184,146,42,0.5); }
                50%      { box-shadow: 0 0 0 4px rgba(184,146,42,0); }
            }

            .paper-title {
                font-family: 'Lora', serif;
                font-size: clamp(1.2rem, 3.2vw, 2.1rem);
                font-weight: 700;
                line-height: 1.3;
                color: #fff;
                text-shadow: 0 2px 8px rgba(0,0,0,0.2);
                margin-bottom: 0;
            }

            /* Hero Stats Panel */
            .hero-stats {
                display: flex; flex-direction: column; gap: 0.6rem;
                padding: 1rem 1.1rem;
                background: rgba(0,0,0,0.18);
                border: 1px solid rgba(255,255,255,0.14);
                border-radius: var(--r-md);
                min-width: 160px;
                backdrop-filter: blur(6px);
                flex-shrink: 0;
                align-self: start;
            }
            .hero-stat {
                display: flex; flex-direction: column; gap: 0.1rem;
                padding-bottom: 0.5rem;
                border-bottom: 1px solid rgba(255,255,255,0.1);
            }
            .hero-stat:last-child { border-bottom: none; padding-bottom: 0; }
            .hs-label {
                font-size: 0.5rem; font-weight: 700;
                letter-spacing: 0.12em; text-transform: uppercase;
                color: rgba(255,255,255,0.5);
            }
            .hs-value {
                font-size: 0.8rem; font-weight: 600; color: #fff;
                line-height: 1.2;
            }

            /* Hero meta strip */
            .hero-meta {
                grid-column: 1 / -1;
                display: flex; flex-wrap: wrap; align-items: center;
                gap: 0.5rem 1rem;
                padding-top: 0.9rem;
                border-top: 1px solid rgba(255,255,255,0.14);
                margin-top: 0.75rem;
            }
            .hm-item {
                display: flex; align-items: center; gap: 0.35rem;
                font-size: 0.72rem; color: rgba(255,255,255,0.75);
            }
            .hm-item svg { color: rgba(255,255,255,0.4); flex-shrink: 0; }
            .hm-item strong { color: #fff; font-weight: 600; }
            .hm-sep { width: 1px; height: 14px; background: rgba(255,255,255,0.18); }

            /* ══ BODY LAYOUT ══ */
            .body-wrap {
                max-width: 76rem; margin: 0 auto;
                padding: 1.5rem 1.5rem 3.5rem;
                display: grid;
                grid-template-columns: 1fr 256px;
                gap: 1.25rem;
                align-items: start;
            }

            /* ── MAIN ── */
            .main-col { min-width: 0; display: flex; flex-direction: column; gap: 1rem; }

            /* Section heading */
            .sec-head {
                display: flex; align-items: center; gap: 0.5rem;
                font-family: 'Lora', serif;
                font-size: 1.05rem; font-weight: 700;
                color: var(--teal-dark);
                margin-bottom: 0.65rem;
                padding-bottom: 0.45rem;
                border-bottom: 1px solid var(--border-mid);
            }
            .sec-icon {
                width: 1.4rem; height: 1.4rem;
                background: var(--gold-pale);
                border-radius: 5px;
                display: flex; align-items: center; justify-content: center;
                color: var(--gold); flex-shrink: 0;
            }

            /* Cards */
            .card {
                background: var(--white);
                border: 1px solid var(--border);
                border-radius: var(--r-lg);
                overflow: hidden;
                box-shadow: var(--shadow-sm);
            }
            .card-body { padding: 1.1rem 1.25rem; }

            /* Abstract */
            .abstract-text {
                font-size: 1rem;
                line-height: 1.85;
                color: var(--body);
                border-left: 3px solid var(--gold);
                padding-left: 1rem;
                margin: 0;
            }

            /* Keywords */
            .kw-list { display: flex; flex-wrap: wrap; gap: 0.45rem; }
            .kw-tag {
                display: inline-flex; align-items: center;
                padding: 0.4rem 1rem;
                background: var(--teal-light);
                border: 1px solid rgba(29,110,101,0.18);
                border-radius: 999px;
                font-size: 0.88rem; font-weight: 500;
                color: var(--teal);
                transition: background .2s, border-color .2s;
                font-family: 'IBM Plex Mono', monospace;
            }
            .kw-tag:hover { background: rgba(29,110,101,0.14); border-color: rgba(29,110,101,0.3); }

            /* Access / Download */
            .access-card {
                background: linear-gradient(130deg, var(--teal-dark) 0%, var(--teal-mid) 65%, #2da89c 100%);
                border-radius: var(--r-lg);
                position: relative; overflow: hidden;
                box-shadow: var(--shadow-md);
            }
            .access-card::before {
                content: '';
                position: absolute; inset: 0;
                background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px);
                background-size: 18px 18px;
            }
            .access-card::after {
                content: '';
                position: absolute; inset: 0;
                background: radial-gradient(ellipse 70% 50% at 100% 0%, rgba(184,146,42,0.16) 0%, transparent 55%);
            }
            .access-inner {
                position: relative; z-index: 2;
                padding: 1.1rem 1.25rem;
                display: flex; align-items: center; justify-content: space-between;
                gap: 1rem; flex-wrap: wrap;
            }
            .access-text h3 {
                font-family: 'Lora', serif;
                font-size: 0.95rem; font-weight: 700;
                color: #fff; margin-bottom: 0.2rem;
            }
            .access-text p { font-size: 0.72rem; color: rgba(255,255,255,0.65); }
            .access-btns { display: flex; gap: 0.5rem; flex-shrink: 0; }
            .btn-read {
                display: inline-flex; align-items: center; gap: 0.4rem;
                padding: 0.45rem 1rem;
                background: linear-gradient(135deg, var(--gold) 0%, #9a7520 100%);
                border: none;
                border-radius: var(--r-sm);
                color: #fff;
                font-size: 0.7rem; font-weight: 700;
                letter-spacing: 0.04em; text-transform: uppercase;
                cursor: pointer;
                box-shadow: 0 3px 10px rgba(184,146,42,0.35);
                transition: transform .2s, box-shadow .2s;
                white-space: nowrap;
            }
            .btn-read:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(184,146,42,0.5); }
            .btn-dl {
                display: inline-flex; align-items: center; gap: 0.4rem;
                padding: 0.45rem 1rem;
                background: rgba(255,255,255,0.95);
                border: none; border-radius: var(--r-sm);
                color: var(--teal-dark);
                font-size: 0.7rem; font-weight: 700;
                letter-spacing: 0.04em; text-transform: uppercase;
                text-decoration: none; cursor: pointer;
                box-shadow: 0 2px 8px rgba(0,0,0,0.14);
                transition: transform .2s, box-shadow .2s;
                white-space: nowrap;
            }
            .btn-dl:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(0,0,0,0.18); }

            /* Citation section */
            .cite-section-inner { display: flex; flex-direction: column; gap: 0.6rem; }
            .cite-desc { font-size: 0.75rem; color: var(--muted); margin-bottom: 0.2rem; }
            .btn-cite {
                display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem;
                padding: 0.5rem 1rem;
                background: linear-gradient(135deg, var(--gold) 0%, #9a7520 100%);
                color: #fff;
                font-size: 0.7rem; font-weight: 700;
                letter-spacing: 0.06em; text-transform: uppercase;
                border: none; border-radius: var(--r-sm);
                cursor: pointer;
                box-shadow: 0 3px 10px rgba(184,146,42,0.3);
                transition: transform .2s, box-shadow .2s;
                text-decoration: none;
            }
            .btn-cite:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(184,146,42,0.4); }
            .btn-ris {
                display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem;
                padding: 0.5rem 1rem;
                background: var(--white);
                color: var(--teal);
                font-size: 0.7rem; font-weight: 700;
                letter-spacing: 0.06em; text-transform: uppercase;
                border: 1.5px solid rgba(29,110,101,0.25);
                border-radius: var(--r-sm);
                cursor: pointer;
                transition: background .2s, border-color .2s;
                text-decoration: none;
            }
            .btn-ris:hover { background: var(--teal-light); border-color: rgba(29,110,101,0.4); }
            .cite-note { font-size: 0.66rem; color: var(--muted); text-align: center; }

            /* ── SIDEBAR ── */
            .side-col { display: flex; flex-direction: column; gap: 0.9rem; }

            .side-card {
                background: var(--white);
                border: 1px solid var(--border);
                border-radius: var(--r-lg);
                overflow: hidden;
                box-shadow: var(--shadow-sm);
            }
            .sc-head {
                padding: 0.55rem 0.9rem;
                border-bottom: 1px solid var(--border-mid);
                background: var(--cream);
                display: flex; align-items: center; gap: 0.4rem;
                font-size: 0.58rem; font-weight: 700;
                letter-spacing: 0.12em; text-transform: uppercase;
                color: var(--muted);
            }
            .sc-head svg { color: var(--gold); }
            .sc-body { padding: 0.75rem 0.9rem; }

            /* info rows */
            .info-list { display: flex; flex-direction: column; gap: 0; }
            .info-row {
                padding: 0.5rem 0;
                border-bottom: 1px solid var(--border-mid);
                display: flex; flex-direction: column; gap: 0.1rem;
            }
            .info-row:last-child { border-bottom: none; }
            .ir-label {
                font-size: 0.55rem; font-weight: 700;
                letter-spacing: 0.1em; text-transform: uppercase;
                color: var(--muted);
            }
            .ir-value { font-size: 0.78rem; font-weight: 500; color: var(--heading); }

            /* Stats strip */
            .stats-strip {
                display: grid; grid-template-columns: repeat(3,1fr);
                border-bottom: 1px solid var(--border-mid);
            }
            .stat-cell {
                display: flex; flex-direction: column; align-items: center;
                padding: 0.75rem 0.5rem;
                text-align: center;
            }
            .stat-cell + .stat-cell { border-left: 1px solid var(--border-mid); }
            .stat-val {
                font-family: 'Lora', serif;
                font-size: 1.5rem; font-weight: 700;
                color: var(--teal); line-height: 1;
                margin-bottom: 0.15rem;
            }
            .stat-lbl {
                font-size: 0.52rem; font-weight: 700;
                letter-spacing: 0.1em; text-transform: uppercase;
                color: var(--muted);
            }

            /* Author card */
            .author-avatar {
                width: 44px; height: 44px; border-radius: 50%;
                background: linear-gradient(135deg, var(--teal) 0%, var(--teal-dark) 100%);
                display: flex; align-items: center; justify-content: center;
                color: #fff; font-weight: 700; font-size: 1rem;
                margin-bottom: 0.6rem;
                box-shadow: 0 2px 8px rgba(29,110,101,0.25);
            }
            .author-name { font-size: 0.85rem; font-weight: 700; color: var(--heading); margin-bottom: 0.15rem; }
            .author-role { font-size: 0.68rem; color: var(--gold); font-weight: 600; margin-bottom: 0.5rem; }
            .author-bio { font-size: 0.73rem; color: var(--muted); line-height: 1.6; }

            /* Quick actions */
            .qa-list { display: flex; flex-direction: column; gap: 0; }
            .qa-item {
                display: flex; align-items: center; gap: 0.6rem;
                padding: 0.55rem 0.6rem;
                border-radius: var(--r-sm);
                cursor: pointer; border: none;
                width: 100%; text-align: left;
                background: none; text-decoration: none;
                transition: background .15s;
                color: inherit;
            }
            .qa-item:hover { background: var(--teal-light); }
            .qa-ic {
                width: 1.75rem; height: 1.75rem;
                border-radius: 6px;
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0;
            }
            .qa-lbl { font-size: 0.75rem; font-weight: 500; color: var(--body); }
            .qa-sub { font-size: 0.6rem; color: var(--muted); }

            /* ══ CITATION MODAL ══ */
            .citation-modal {
                display: none; position: fixed; inset: 0; z-index: 1000;
                background: rgba(10,18,26,0.5);
                backdrop-filter: blur(5px);
                align-items: center; justify-content: center;
                padding: 1rem;
            }
            .citation-modal.show { display: flex; animation: fadeIn .2s ease; }
            .modal-box {
                background: var(--white); border-radius: var(--r-lg);
                width: 100%; max-width: 36rem; max-height: 90vh;
                overflow: hidden;
                box-shadow: var(--shadow-lg);
                animation: slideUp .28s cubic-bezier(.22,.68,0,1.2);
                display: flex; flex-direction: column;
            }
            .modal-header {
                padding: 0.9rem 1.1rem;
                border-bottom: 1px solid var(--border);
                display: flex; align-items: center; justify-content: space-between;
                background: var(--cream);
                flex-shrink: 0;
            }
            .modal-title { font-family: 'Lora', serif; font-size: 1rem; font-weight: 700; color: var(--teal-dark); }
            .modal-sub { font-size: 0.68rem; color: var(--muted); margin-top: 0.1rem; }
            .modal-close {
                width: 1.75rem; height: 1.75rem; border-radius: 50%;
                background: var(--cream-mid); border: 1px solid var(--border);
                display: flex; align-items: center; justify-content: center;
                cursor: pointer; color: var(--muted); font-size: 0.9rem;
                transition: background .2s, color .2s; flex-shrink: 0;
            }
            .modal-close:hover { background: #fee2e2; color: #dc2626; border-color: #fecaca; }
            .modal-body { padding: 1rem 1.1rem; overflow-y: auto; }

            .cite-tabs { display: flex; gap: 0.35rem; flex-wrap: wrap; margin-bottom: 0.9rem; }
            .ct-btn {
                padding: 0.28rem 0.7rem;
                border: 1.5px solid var(--border); background: var(--cream);
                color: var(--muted); border-radius: 999px;
                font-size: 0.65rem; font-weight: 700; letter-spacing: 0.04em;
                cursor: pointer;
                transition: border-color .2s, background .2s, color .2s;
            }
            .ct-btn:hover { border-color: var(--teal); color: var(--teal); }
            .ct-btn.active { background: var(--teal); color: #fff; border-color: var(--teal); }

            .cite-content {
                display: none; padding: 0.85rem 1rem;
                background: var(--cream);
                border: 1px solid var(--border);
                border-left: 3px solid var(--gold);
                border-radius: var(--r-sm);
                font-size: 0.76rem; line-height: 1.75;
                color: var(--body); word-break: break-word;
                font-family: 'IBM Plex Mono', monospace;
            }
            .cite-content.active { display: block; }

            .copy-btn {
                margin-top: 0.75rem;
                display: inline-flex; align-items: center; gap: 0.4rem;
                padding: 0.45rem 1rem;
                background: linear-gradient(135deg, var(--teal) 0%, var(--teal-dark) 100%);
                color: #fff; font-size: 0.7rem; font-weight: 600;
                border: none; border-radius: var(--r-sm);
                cursor: pointer;
                box-shadow: 0 3px 10px rgba(29,110,101,0.3);
                transition: transform .2s, box-shadow .2s;
            }
            .copy-btn:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(29,110,101,0.4); }

            /* ══ PDF VIEWER ══ */
            .pdf-modal {
                display: none; position: fixed; inset: 0; z-index: 2000;
                background: rgba(10,18,26,0.65);
                backdrop-filter: blur(5px);
                align-items: center; justify-content: center; padding: 1rem;
            }
            .pdf-modal.open { display: flex; }
            .pdf-box {
                background: #fff; border-radius: var(--r-lg);
                width: 100%; max-width: 880px; height: 90vh;
                display: flex; flex-direction: column; overflow: hidden;
                box-shadow: var(--shadow-lg);
                animation: slideUp .28s cubic-bezier(.22,.68,0,1.2);
            }
            .pdf-head {
                display: flex; align-items: center; justify-content: space-between;
                padding: 0.65rem 1rem;
                border-bottom: 1px solid var(--border);
                background: var(--cream);
                flex-shrink: 0; gap: 0.75rem;
            }
            .pdf-head-left { display: flex; align-items: center; gap: 0.5rem; min-width: 0; }
            .pdf-icon {
                width: 1.6rem; height: 1.6rem;
                background: var(--gold-pale); border-radius: 5px;
                display: flex; align-items: center; justify-content: center;
                color: var(--gold); flex-shrink: 0;
            }
            .pdf-label { font-size: 0.58rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); }
            .pdf-title-txt { font-size: 0.8rem; font-weight: 600; color: var(--teal-dark); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
            .pdf-head-right { display: flex; align-items: center; gap: 0.4rem; flex-shrink: 0; }
            .pdf-dl-btn {
                display: inline-flex; align-items: center; gap: 0.35rem;
                padding: 0.38rem 0.8rem;
                background: var(--teal); color: #fff;
                font-size: 0.65rem; font-weight: 700; letter-spacing: 0.04em; text-transform: uppercase;
                border-radius: 6px; text-decoration: none;
                transition: background .2s;
            }
            .pdf-dl-btn:hover { background: var(--teal-dark); }
            .pdf-close-btn {
                width: 1.75rem; height: 1.75rem; border-radius: 6px;
                background: var(--cream-mid); border: 1px solid var(--border);
                display: flex; align-items: center; justify-content: center;
                cursor: pointer; color: var(--muted); font-size: 0.9rem;
                transition: background .2s;
            }
            .pdf-close-btn:hover { background: #fee2e2; color: #dc2626; }
            .pdf-frame-wrap { flex: 1; position: relative; background: #525659; overflow: hidden; }
            .pdf-loading {
                position: absolute; inset: 0; z-index: 1;
                display: flex; flex-direction: column; align-items: center; justify-content: center;
                background: #525659; gap: 0.75rem;
            }
            .spin-ring {
                width: 36px; height: 36px;
                border: 3px solid rgba(255,255,255,0.15);
                border-top-color: var(--gold);
                border-radius: 50%;
                animation: spin .7s linear infinite;
            }
            .pdf-loading p { color: rgba(255,255,255,0.6); font-size: 0.75rem; }
            #pdfFrame { width: 100%; height: 100%; border: none; display: block; }

            .pdf-fallback {
                display: none; padding: 0.55rem 1rem;
                background: #fffbf0;
                border-top: 1px solid rgba(184,146,42,0.25);
                font-size: 0.72rem; color: var(--body); text-align: center;
                flex-shrink: 0;
            }
            .pdf-fallback a { color: var(--teal); font-weight: 600; }

            /* ══ FOOTER ══ */
            .site-footer {
                background: var(--white); border-top: 1px solid var(--border);
                padding: 1.5rem;
            }
            .footer-inner {
                max-width: 76rem; margin: 0 auto;
                display: flex; flex-wrap: wrap;
                align-items: center; justify-content: space-between; gap: 0.75rem;
            }
            .footer-brand { font-family: 'Lora', serif; font-size: 0.85rem; font-weight: 700; color: var(--teal); }
            .footer-copy { font-size: 0.68rem; color: var(--muted); }
            .footer-links { display: flex; gap: 1.25rem; }
            .footer-links a { font-size: 0.7rem; color: var(--muted); text-decoration: none; transition: color .2s; }
            .footer-links a:hover { color: var(--teal); }

            /* ══ RESPONSIVE ══ */
            @media (max-width: 860px) {
                .body-wrap { grid-template-columns: 1fr; }
                .side-col { order: -1; }
                .hero-inner { grid-template-columns: 1fr; }
                .hero-stats { display: none; }
            }
            @media (max-width: 600px) {
                .paper-hero { padding: 1.75rem 1rem 1.5rem; }
                .paper-title { font-size: 1.15rem; }
                .body-wrap { padding: 1rem 1rem 2.5rem; gap: 1rem; }
                .access-inner { flex-direction: column; align-items: stretch; }
                .access-btns { flex-direction: column; }
                .btn-read, .btn-dl { justify-content: center; }
                .hero-meta { gap: 0.4rem 0.75rem; }
                .hm-sep { display: none; }
            }
        </style>
    </head>
    <body>
        {{-- Accent bar --}}
        <div class="accent-bar"></div>

        {{-- ══ HEADER ══ --}}
        <header class="site-header">
            <div class="header-inner">
                <a href="/" class="header-brand">
                    <div class="brand-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div style="display:flex;flex-direction:column;">
                        <span class="brand-name">Journal System</span>
                        <span class="brand-sub">Academic Publishing Portal</span>
                    </div>
                </a>
                <a href="/" class="back-btn">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <line x1="19" y1="12" x2="5" y2="12"/>
                        <polyline points="12 19 5 12 12 5"/>
                    </svg>
                    Back to Home
                </a>
            </div>
        </header>

        {{-- ══ HERO ══ --}}
        <section class="paper-hero">
            <div class="hero-shimmer"></div>
            <div class="hero-inner">
                <div class="hero-main">
                    <div class="status-badge">
                        <span class="pulse-dot"></span>
                        {{ $paper['category'] ?? 'Research Article' }}
                    </div>
                    <h1 class="paper-title">{{ $paper['title'] }}</h1>

                    <div class="hero-meta">
                        <div class="hm-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                            </svg>
                            <strong>{{ $paper['author'] ?? 'Unknown Author' }}</strong>
                        </div>
                        <div class="hm-sep"></div>
                        <div class="hm-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            Published <strong>{{ $paper['publishedAt']->format('M d, Y') }}</strong>
                        </div>
                        <div class="hm-sep"></div>
                        <div class="hm-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            </svg>
                            Open Access
                        </div>
                    </div>
                </div>

                {{-- Sidebar stats (desktop only) --}}
                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="hs-label">Status</span>
                        <span class="hs-value" style="color:#7effd4;">✓ Published</span>
                    </div>
                    <div class="hero-stat">
                        <span class="hs-label">Year</span>
                        <span class="hs-value">{{ $paper['publishedAt']->format('Y') }}</span>
                    </div>
                    <div class="hero-stat">
                        <span class="hs-label">Category</span>
                        <span class="hs-value">{{ $paper['category'] ?? '—' }}</span>
                    </div>
                    <div class="hero-stat">
                        <span class="hs-label">Format</span>
                        <span class="hs-value">PDF / Online</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ══ BODY ══ --}}
        <div class="body-wrap">

            {{-- ── MAIN COLUMN ── --}}
            <main class="main-col">

                {{-- Abstract --}}
                <div class="reveal">
                    <div class="sec-head">
                        <div class="sec-icon">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 12h6m-6 4h4M7 20H5a2 2 0 01-2-2V5a2 2 0 012-2h6.414a2 2 0 011.414.586l4.586 4.586A2 2 0 0117 9.414V18a2 2 0 01-2 2H7z"/>
                            </svg>
                        </div>
                        Abstract
                    </div>
                    <div class="card">
                        <div class="card-body" style="background:var(--cream);">
                            <p class="abstract-text">
                                {{ $paper['abstract'] ?? 'Lorem ipsum dolor es ma et al' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Keywords --}}
                <div class="reveal" style="transition-delay:.05s">
                    <div class="sec-head">
                        <div class="sec-icon">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        Keywords
                    </div>
                    <div class="kw-list">
                        @if(isset($paper['keywords']) && is_array($paper['keywords']) && count($paper['keywords']) > 0)
                            @foreach($paper['keywords'] as $keyword)
                                <span class="kw-tag">{{ $keyword }}</span>
                            @endforeach
                        @else
                            <span class="kw-tag">Keyword 1</span>
                            <span class="kw-tag">Keyword 2</span>
                            <span class="kw-tag">Keyword 3</span>
                        @endif
                    </div>
                </div>

                {{-- Access Paper --}}
                <div class="reveal" style="transition-delay:.1s">
                    <div class="sec-head">
                        <div class="sec-icon">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>
                        Access Paper
                    </div>
                    <div class="access-card">
                        <div class="access-inner">
                            <div class="access-text">
                                <h3>Full Paper Available</h3>
                                <p>Read online or download the complete PDF — methodology, results, and references included.</p>
                            </div>
                            <div class="access-btns">
                                <button class="btn-read"
                                    onclick="openPdfViewer('{{ route('papers.view', ['submission' => $paper['id']]) }}')">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    Read Online
                                </button>
                                <a href="{{ route('papers.download', ['submission' => $paper['id']]) }}" class="btn-dl">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Download PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Citation --}}
                <div class="reveal" style="transition-delay:.15s">
                    <div class="sec-head">
                        <div class="sec-icon">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/>
                            </svg>
                        </div>
                        Cite This Paper
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <p class="cite-desc">Select a citation style or export to your reference manager.</p>
                            <div class="cite-section-inner">
                                <button class="btn-cite"
                                    onclick="openCitationModal(event)"
                                    data-paper-title="{{ $paper['title'] }}"
                                    data-paper-author="{{ $paper['author'] }}"
                                    data-publication-year="{{ $paper['publishedAt']->format('Y') }}"
                                    data-category="{{ $paper['category'] }}">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/>
                                    </svg>
                                    Generate Citation
                                </button>
                                <a href="{{ route('papers.download-ris', ['submission' => $paper['id']]) }}" class="btn-ris">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                                    </svg>
                                    Export as RIS
                                </a>
                                <p class="cite-note">RIS works with Zotero, Mendeley, EndNote &amp; more</p>
                            </div>
                        </div>
                    </div>
                </div>

            </main>

            {{-- ── SIDEBAR ── --}}
            <aside class="side-col">

                {{-- Stats --}}
                <div class="side-card reveal">
                    <div class="stats-strip">
                        <div class="stat-cell">
                            <span class="stat-val">{{ $paper['views'] ?? '—' }}</span>
                            <span class="stat-lbl">Views</span>
                        </div>
                        <div class="stat-cell">
                            <span class="stat-val">{{ $paper['downloads'] ?? '—' }}</span>
                            <span class="stat-lbl">Downloads</span>
                        </div>
                        <div class="stat-cell">
                            <span class="stat-val">{{ $paper['citations'] ?? '0' }}</span>
                            <span class="stat-lbl">Citations</span>
                        </div>
                    </div>
                </div>

                {{-- Paper Details --}}
                <div class="side-card reveal" style="transition-delay:.05s">
                    <div class="sc-head">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        Paper Details
                    </div>
                    <div class="sc-body">
                        <div class="info-list">
                            <div class="info-row">
                                <span class="ir-label">Author</span>
                                <span class="ir-value">{{ $paper['author'] ?? '—' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="ir-label">Published</span>
                                <span class="ir-value">{{ $paper['publishedAt']->format('F d, Y') }}</span>
                            </div>
                            <div class="info-row">
                                <span class="ir-label">Category</span>
                                <span class="ir-value">{{ $paper['category'] ?? '—' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="ir-label">Journal</span>
                                <span class="ir-value">Open Journal System</span>
                            </div>
                            <div class="info-row">
                                <span class="ir-label">Access</span>
                                <span class="ir-value" style="color:var(--teal);font-weight:600;">Open Access</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Author --}}
                <div class="side-card reveal" style="transition-delay:.1s">
                    <div class="sc-head">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                        About the Author
                    </div>
                    <div class="sc-body" style="text-align:center;">
                        <div style="display:flex;flex-direction:column;align-items:center;">
                            <div class="author-avatar">
                                {{ substr($paper['author'] ?? 'RA', 0, 2) }}
                            </div>
                            <p class="author-name">{{ $paper['author'] ?? 'Unknown Author' }}</p>
                            <p class="author-role">Lead Researcher</p>
                            <p class="author-bio">Contributing researcher in the Open Journal System academic community.</p>
                        </div>
                    </div>
                </div>

           
        {{-- ══ CITATION MODAL ══ --}}
        <div id="citationModal" class="citation-modal">
            <div class="modal-box">
                <div class="modal-header">
                    <div>
                        <div class="modal-title">Cite This Paper</div>
                        <div class="modal-sub">Select a format, then copy the reference.</div>
                    </div>
                    <button class="modal-close" onclick="closeCitationModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="cite-tabs">
                        <button class="ct-btn active" onclick="switchCite(this,'apa')">APA</button>
                        <button class="ct-btn" onclick="switchCite(this,'chicago')">Chicago</button>
                        <button class="ct-btn" onclick="switchCite(this,'mla')">MLA</button>
                        <button class="ct-btn" onclick="switchCite(this,'harvard')">Harvard</button>
                    </div>
                    <div id="apa"     class="cite-content active"></div>
                    <div id="chicago" class="cite-content"></div>
                    <div id="mla"     class="cite-content"></div>
                    <div id="harvard" class="cite-content"></div>
                    <button class="copy-btn" onclick="copyCitation()">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/>
                        </svg>
                        Copy Citation
                    </button>
                </div>
            </div>
        </div>

        {{-- ══ PDF VIEWER MODAL ══ --}}
        <div id="pdfViewerModal" class="pdf-modal">
            <div class="pdf-box">
                <div class="pdf-head">
                    <div class="pdf-head-left">
                        <div class="pdf-icon">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </div>
                        <div>
                            <div class="pdf-label">Reading</div>
                            <div class="pdf-title-txt" id="pdfViewerTitle">{{ $paper['title'] }}</div>
                        </div>
                    </div>
                    <div class="pdf-head-right">
                        <a id="pdfDownloadBtn" href="#" class="pdf-dl-btn">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download
                        </a>
                        <button class="pdf-close-btn" onclick="closePdfViewer()">&times;</button>
                    </div>
                </div>
                <div class="pdf-frame-wrap">
                    <div class="pdf-loading" id="pdfLoading">
                        <div class="spin-ring"></div>
                        <p>Loading manuscript…</p>
                    </div>
                    <iframe id="pdfFrame" src=""
                        onload="document.getElementById('pdfLoading').style.display='none'">
                    </iframe>
                </div>
                <div class="pdf-fallback" id="pdfFallback">
                    📱 If the PDF doesn't load,
                    <a id="pdfFallbackLink" href="#">download it directly</a>.
                </div>
            </div>
        </div>

        <script>
            /* ── Scroll reveal ── */
            const ro = new IntersectionObserver(entries => {
                entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
            }, { threshold: 0.1 });
            document.querySelectorAll('.reveal').forEach(el => ro.observe(el));

            /* ── Citation modal ── */
            let _pd = {};

            function openCitationModal(e) {
                const btn = e.currentTarget;
                _pd = {
                    title:  btn.getAttribute('data-paper-title'),
                    author: btn.getAttribute('data-paper-author'),
                    year:   btn.getAttribute('data-publication-year'),
                    journal:'Open Journal System',
                    doi:    Math.floor(Math.random() * 100000),
                    url:    window.location.href,
                };
                buildCitations();
                document.getElementById('citationModal').classList.add('show');
                document.body.style.overflow = 'hidden';
            }

            function closeCitationModal() {
                document.getElementById('citationModal').classList.remove('show');
                document.body.style.overflow = '';
            }

            function buildCitations() {
                const d = _pd;
                document.getElementById('apa').innerHTML     = `${d.author}. (${d.year}). ${d.title}. <em>${d.journal}</em>. https://doi.org/10.1234/js.${d.doi}`;
                document.getElementById('chicago').innerHTML = `${d.author}. "${d.title}." <em>${d.journal}</em> (${d.year}). Accessed ${new Date().toLocaleDateString()}. ${d.url}`;
                document.getElementById('mla').innerHTML     = `${d.author}. "${d.title}." <em>${d.journal}</em>, ${d.year}. DOI: 10.1234/js.${d.doi}.`;
                document.getElementById('harvard').innerHTML = `${d.author}, ${d.year}. ${d.title}. <em>${d.journal}</em>. Available at: ${d.url} (Accessed: ${new Date().toLocaleDateString()}).`;
            }

            function switchCite(btn, style) {
                document.querySelectorAll('.ct-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.cite-content').forEach(d => d.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById(style).classList.add('active');
            }

            function copyCitation() {
                const active = document.querySelector('.cite-content.active');
                if (!active) return;
                navigator.clipboard.writeText(active.innerText).then(() => {
                    const btn = event.currentTarget;
                    const orig = btn.innerHTML;
                    btn.innerHTML = `<svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg> Copied!`;
                    setTimeout(() => btn.innerHTML = orig, 2000);
                });
            }

            document.getElementById('citationModal').addEventListener('click', function(e) {
                if (e.target === this) closeCitationModal();
            });

            /* ── PDF viewer ── */
            function openPdfViewer(url) {
                const modal   = document.getElementById('pdfViewerModal');
                const frame   = document.getElementById('pdfFrame');
                const loading = document.getElementById('pdfLoading');
                const dlBtn   = document.getElementById('pdfDownloadBtn');
                const fbLink  = document.getElementById('pdfFallbackLink');
                const fb      = document.getElementById('pdfFallback');

                loading.style.display = 'flex';
                frame.src = '';
                dlBtn.href = url;
                fbLink.href = url;
                fb.style.display = 'none';

                modal.classList.add('open');
                document.body.style.overflow = 'hidden';

                setTimeout(() => { frame.src = url + '#toolbar=1&view=FitH'; }, 100);

                const fbTimer = setTimeout(() => {
                    if (loading.style.display !== 'none') fb.style.display = 'block';
                }, 4000);

                frame.addEventListener('load', function onLoad() {
                    clearTimeout(fbTimer);
                    frame.removeEventListener('load', onLoad);
                    if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) fb.style.display = 'block';
                }, { once: true });
            }

            function closePdfViewer() {
                const modal = document.getElementById('pdfViewerModal');
                const frame = document.getElementById('pdfFrame');
                modal.classList.remove('open');
                frame.src = '';
                document.body.style.overflow = '';
                document.getElementById('pdfLoading').style.display = 'flex';
                document.getElementById('pdfFallback').style.display = 'none';
            }

            document.getElementById('pdfViewerModal').addEventListener('click', function(e) {
                if (e.target === this) closePdfViewer();
            });
            document.addEventListener('keydown', e => { if (e.key === 'Escape') { closePdfViewer(); closeCitationModal(); } });
        </script>
    </body>
</html>