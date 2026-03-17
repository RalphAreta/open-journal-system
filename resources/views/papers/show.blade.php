<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $paper['title'] }} - Published Paper</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <style>
        /* ── Reset & Base ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'DM Sans', system-ui, sans-serif;
            background: #f7f3ec;
            color: #1a202c;
            min-height: 100vh;
        }

        /* ── CSS Variables ── */
        :root {
            --teal:       #2d8176;
            --teal-dark:  #1a5e56;
            --teal-light: #3a9e91;
            --gold:       #c9a84c;
            --gold-light: #f0d678;
            --gold-dim:   rgba(201,168,76,.12);
            --cream:      #f7f3ec;
            --cream-mid:  #ede8df;
            --border:     #e2ddd4;
            --text-muted: #6a7890;
            --text-body:  #374151;
        }

        .font-playfair { font-family: 'Playfair Display', Georgia, serif; }

        /* ── Keyframes ── */
        @keyframes shimmer {
            0%   { background-position: -200% 0; }
            100% { background-position:  200% 0; }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn  { from { opacity:0; } to { opacity:1; } }
        @keyframes slideUp {
            from { opacity:0; transform:translateY(24px) scale(.98); }
            to   { opacity:1; transform:translateY(0) scale(1); }
        }
        @keyframes pulse-dot {
            0%,100% { box-shadow:0 0 0 0 rgba(201,168,76,.6); }
            50%      { box-shadow:0 0 0 5px rgba(201,168,76,0); }
        }
        .fade-up { animation: fadeUp .65s cubic-bezier(.22,.68,0,1.2) both; }

        /* ── Shimmer bar ── */
        .shimmer-bar {
            background: linear-gradient(90deg,
                transparent 0%, rgba(201,168,76,.2) 30%,
                rgba(240,214,120,.8) 50%, rgba(201,168,76,.2) 70%, transparent 100%);
            background-size: 200% 100%;
            animation: shimmer 3.5s linear infinite;
        }

        /* ══ HEADER ══ */
        .site-header {
            position: sticky; top: 0; z-index: 50;
            background: rgba(255,255,255,.92);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
        }
        .header-inner {
            max-width: 68rem; margin: 0 auto;
            padding: .875rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
        }
        .header-logo {
            display: flex; align-items: center; gap: .6rem; text-decoration: none;
        }
        .logo-icon {
            width: 2rem; height: 2rem; border-radius: 8px;
            background: linear-gradient(135deg, var(--teal), var(--teal-dark));
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 8px rgba(45,129,118,.3);
        }
        .logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem; font-weight: 700; color: var(--teal);
        }
        .back-link {
            display: inline-flex; align-items: center; gap: .4rem;
            font-size: .8rem; font-weight: 500; color: var(--text-muted);
            text-decoration: none; padding: .4rem .875rem;
            border: 1px solid var(--border); border-radius: 999px;
            transition: color .2s, border-color .2s, background .2s;
        }
        .back-link:hover { color: var(--teal); border-color: var(--teal); background: rgba(45,129,118,.04); }

        /* ══ HERO ══ */
        .paper-hero {
            background: linear-gradient(160deg, var(--teal-dark) 0%, var(--teal) 50%, #246059 100%);
            position: relative; overflow: hidden;
            padding: 4rem 1.5rem 3.5rem;
        }
        .paper-hero::before {
            content:''; position:absolute; inset:0;
            background-image: radial-gradient(circle,rgba(255,255,255,.06) 1px,transparent 1px);
            background-size: 26px 26px; pointer-events: none;
        }
        .paper-hero::after {
            content:''; position:absolute; inset:0;
            background:
                radial-gradient(ellipse 70% 60% at 90% 10%,rgba(201,168,76,.2) 0%,transparent 55%),
                radial-gradient(ellipse 50% 70% at 0% 100%, rgba(0,0,0,.3) 0%,transparent 50%);
            pointer-events: none;
        }
        .hero-shimmer { position:absolute; top:0; left:0; right:0; height:2px; z-index:10; }
        .hero-inner { position:relative; z-index:5; max-width:52rem; margin:0 auto; }

        .category-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .3rem .875rem;
            border: 1px solid rgba(255,255,255,.25); background: rgba(0,0,0,.2);
            border-radius: 999px; font-size: .65rem; letter-spacing: .14em;
            text-transform: uppercase; color: var(--gold-light); font-weight: 600;
            margin-bottom: 1.5rem;
        }
        .pulse-dot {
            width: .45rem; height: .45rem; border-radius: 50%; background: var(--gold);
            animation: pulse-dot 2s ease-in-out infinite;
        }
        .paper-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.75rem, 4vw, 2.75rem); font-weight: 700; line-height: 1.2;
            color: #fff; text-shadow: 0 2px 8px rgba(0,0,0,.25); margin-bottom: 2rem;
        }
        .paper-meta-row {
            display: flex; flex-wrap: wrap; align-items: center; gap: 1.5rem;
            padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,.15);
        }
        .meta-item { display:flex; flex-direction:column; gap:.2rem; }
        .meta-label { font-size:.6rem; letter-spacing:.14em; text-transform:uppercase; color:rgba(255,255,255,.55); font-weight:600; }
        .meta-value { font-size:.9rem; font-weight:600; color:#fff; }
        .meta-divider { width:1px; height:2.5rem; background:rgba(255,255,255,.2); }

        /* ══ LAYOUT ══ */
        .main-wrap {
            max-width: 68rem; margin: 0 auto;
            padding: 2.5rem 1.5rem 5rem;
            display: grid; grid-template-columns: 1fr 18rem; gap: 2rem; align-items: start;
            position: relative; z-index: 1;
        }
        @media (max-width: 900px) {
            .main-wrap { grid-template-columns: 1fr; }
            .sidebar { order: -1; }
        }

        .paper-section { margin-bottom: 2rem; }

        .section-heading {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem; font-weight: 700; color: var(--teal-dark);
            display: flex; align-items: center; gap: .6rem; margin-bottom: 1rem;
        }
        .section-heading::after {
            content:''; flex:1; height:1px;
            background:linear-gradient(90deg, var(--border), transparent);
        }
        .section-icon {
            width:1.6rem; height:1.6rem; border-radius:7px;
            background:var(--gold-dim);
            display:flex; align-items:center; justify-content:center;
            color:var(--gold); flex-shrink:0;
        }

        .card {
            background: rgba(255,255,255,.9); backdrop-filter: blur(8px);
            border: 1px solid var(--border); border-radius: 16px; overflow: hidden;
        }
        .card-body { padding: 1.75rem; }

        /* Stats */
        .stats-card {
            background: rgba(255,255,255,.9); border: 1px solid var(--border);
            border-radius: 16px; overflow: hidden; margin-bottom: 2rem;
        }
        .stats-inner { display:grid; grid-template-columns:repeat(3,1fr); padding:1.25rem 1.75rem; }
        .stat-cell { display:flex; flex-direction:column; align-items:center; text-align:center; padding:.75rem; }
        .stat-cell + .stat-cell { border-left:1px solid var(--border); }
        .stat-val {
            font-family:'Playfair Display',serif; font-size:2rem; font-weight:700;
            color:var(--teal); line-height:1; margin-bottom:.3rem;
        }
        .stat-lbl { font-size:.6rem; letter-spacing:.14em; text-transform:uppercase; color:var(--text-muted); font-weight:600; }

        /* Abstract */
        .abstract-text {
            font-size:.9rem; line-height:1.85; color:var(--text-body);
            border-left:3px solid var(--gold); padding-left:1.25rem;
        }

        /* Keywords */
        .keyword-list { display:flex; flex-wrap:wrap; gap:.6rem; }
        .keyword-tag {
            display:inline-flex; align-items:center; gap:.35rem;
            padding:.35rem .875rem;
            background:rgba(45,129,118,.06); border:1px solid rgba(45,129,118,.18);
            border-radius:999px; font-size:.75rem; font-weight:500; color:var(--teal);
            transition:background .2s, border-color .2s;
        }
        .keyword-tag:hover { background:rgba(45,129,118,.12); border-color:rgba(45,129,118,.35); }

        /* Download */
        .download-card {
            background:linear-gradient(135deg,var(--teal-dark) 0%,var(--teal) 60%,#3aaba0 100%);
            border-radius:16px; overflow:hidden; position:relative;
        }
        .download-card::before {
            content:''; position:absolute; inset:0;
            background-image:radial-gradient(circle,rgba(255,255,255,.05) 1px,transparent 1px);
            background-size:20px 20px; pointer-events:none;
        }
        .download-card::after {
            content:''; position:absolute; inset:0;
            background:radial-gradient(ellipse 80% 60% at 90% 0%,rgba(201,168,76,.18) 0%,transparent 55%);
            pointer-events:none;
        }
        .download-inner {
            position:relative; z-index:2; padding:1.75rem;
            display:flex; align-items:center; justify-content:space-between;
            gap:1.5rem; flex-wrap:wrap;
        }
        .download-text h3 { font-family:'Playfair Display',serif; font-size:1.1rem; font-weight:700; color:#fff; margin-bottom:.35rem; }
        .download-text p { font-size:.8rem; color:rgba(255,255,255,.7); }
        .download-btn {
            display:inline-flex; align-items:center; gap:.5rem;
            padding:.7rem 1.5rem; background:rgba(255,255,255,.95);
            color:var(--teal-dark); font-size:.8rem; font-weight:700;
            letter-spacing:.04em; text-transform:uppercase;
            border-radius:10px; text-decoration:none; border:none; cursor:pointer;
            box-shadow:0 4px 16px rgba(0,0,0,.15);
            transition:transform .2s, box-shadow .2s, background .2s; white-space:nowrap;
        }
        .download-btn:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,.2); background:#fff; }

        /* Cite button */
        .cite-btn {
            display:inline-flex; align-items:center; gap:.5rem;
            padding:.7rem 1.5rem;
            background:linear-gradient(135deg,var(--gold) 0%,#a07830 100%);
            color:#fff; font-size:.8rem; font-weight:700; letter-spacing:.04em; text-transform:uppercase;
            border:none; border-radius:10px; cursor:pointer;
            box-shadow:0 4px 16px rgba(160,120,48,.35);
            transition:transform .2s, box-shadow .2s;
        }
        .cite-btn:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(160,120,48,.5); }

        /* Related */
        .related-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
        @media(max-width:600px) { .related-grid { grid-template-columns:1fr; } }
        .related-card {
            background:rgba(255,255,255,.9); border:1.5px solid var(--border);
            border-radius:14px; padding:1.25rem; text-decoration:none; display:block;
            transition:border-color .2s, transform .2s, box-shadow .2s;
        }
        .related-card:hover { border-color:var(--teal); transform:translateY(-2px); box-shadow:0 8px 24px rgba(45,129,118,.1); }
        .related-tag { font-size:.6rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:var(--gold); }
        .related-title {
            font-family:'Playfair Display',serif; font-size:.95rem; font-weight:700;
            color:var(--teal-dark); margin:.5rem 0 .4rem; line-height:1.35;
            display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
        }
        .related-excerpt {
            font-size:.75rem; color:var(--text-muted); line-height:1.55; margin-bottom:.75rem;
            display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
        }
        .related-stats { display:flex; align-items:center; gap:.4rem; font-size:.7rem; color:#a7b1c7; }

        /* ══ SIDEBAR ══ */
        .sidebar { display:flex; flex-direction:column; gap:1.25rem; }
        .sidebar-card { background:rgba(255,255,255,.9); border:1px solid var(--border); border-radius:14px; overflow:hidden; }
        .sidebar-card-head {
            padding:.875rem 1.1rem; border-bottom:1px solid var(--border);
            font-size:.65rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase;
            color:var(--text-muted); background:rgba(247,243,236,.6);
            display:flex; align-items:center; gap:.5rem;
        }
        .sidebar-card-head svg { color:var(--gold); }
        .sidebar-card-body { padding:1rem 1.1rem; }

        .info-row { display:flex; flex-direction:column; gap:.15rem; padding:.5rem 0; border-bottom:1px solid var(--border); }
        .info-row:last-child { border-bottom:none; }
        .info-row-label { font-size:.6rem; font-weight:600; letter-spacing:.1em; text-transform:uppercase; color:var(--text-muted); }
        .info-row-value { font-size:.825rem; font-weight:500; color:#1a202c; }

        .quick-action {
            display:flex; align-items:center; gap:.75rem;
            padding:.6rem .75rem; border-radius:10px; cursor:pointer;
            border:none; width:100%; text-align:left; background:none;
            transition:background .15s; text-decoration:none;
        }
        .quick-action:hover { background:rgba(45,129,118,.06); }
        .qa-icon { width:2rem; height:2rem; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .qa-label { font-size:.8rem; font-weight:500; color:#374151; }
        .qa-sub   { font-size:.65rem; color:var(--text-muted); }

        /* ══ CITATION MODAL ══ */
        .citation-modal {
            display:none; position:fixed; inset:0; z-index:1000;
            background:rgba(10,20,30,.55); backdrop-filter:blur(6px);
            align-items:center; justify-content:center;
        }
        .citation-modal.show { display:flex; animation:fadeIn .25s ease; }
        .modal-box {
            background:#fff; border-radius:20px; width:90%; max-width:38rem;
            max-height:85vh; overflow-y:auto;
            box-shadow:0 32px 80px rgba(0,0,0,.25);
            animation:slideUp .3s cubic-bezier(.22,.68,0,1.2);
            position:relative; overflow:hidden;
        }
        .modal-top-bar { height:3px; }
        .modal-inner { padding:2rem; }
        .modal-close {
            position:absolute; right:1.25rem; top:1.25rem;
            width:2rem; height:2rem; border-radius:50%;
            background:var(--cream); border:1px solid var(--border);
            display:flex; align-items:center; justify-content:center;
            cursor:pointer; color:var(--text-muted); font-size:1rem;
            transition:background .2s, color .2s; z-index:5;
        }
        .modal-close:hover { background:#fee2e2; color:#dc2626; border-color:#fecaca; }
        .modal-title { font-family:'Playfair Display',serif; font-size:1.4rem; font-weight:700; color:var(--teal-dark); margin-bottom:.35rem; }
        .modal-subtitle { font-size:.8rem; color:var(--text-muted); margin-bottom:1.5rem; }

        .citation-tabs { display:flex; gap:.4rem; flex-wrap:wrap; margin-bottom:1.25rem; }
        .citation-tab-btn {
            padding:.4rem .875rem;
            border:1.5px solid var(--border); background:var(--cream);
            color:var(--text-muted); border-radius:999px;
            font-size:.72rem; font-weight:600; letter-spacing:.04em; cursor:pointer;
            transition:border-color .2s, background .2s, color .2s;
        }
        .citation-tab-btn:hover { border-color:var(--teal); color:var(--teal); }
        .citation-tab-btn.active { background:var(--teal); color:#fff; border-color:var(--teal); }

        .citation-content {
            display:none; padding:1rem 1.1rem;
            background:var(--cream); border:1px solid var(--border); border-left:3px solid var(--gold);
            border-radius:10px; font-size:.8rem; line-height:1.75; color:var(--text-body); word-break:break-word;
        }
        .citation-content.active { display:block; }

        .copy-btn {
            margin-top:1rem; display:inline-flex; align-items:center; gap:.5rem;
            padding:.6rem 1.25rem;
            background:linear-gradient(135deg,var(--teal) 0%,var(--teal-dark) 100%);
            color:#fff; font-size:.78rem; font-weight:600;
            border:none; border-radius:10px; cursor:pointer;
            box-shadow:0 4px 14px rgba(45,129,118,.35);
            transition:transform .2s, box-shadow .2s;
        }
        .copy-btn:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(45,129,118,.45); }

        /* ══ FOOTER ══ */
        .site-footer { background:rgba(255,255,255,.9); border-top:1px solid var(--border); padding:2.5rem 1.5rem; }
        .footer-inner {
            max-width:68rem; margin:0 auto;
            display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:1rem;
        }
        .footer-brand { font-family:'Playfair Display',serif; font-size:.9rem; font-weight:700; color:var(--teal); }
        .footer-copy { font-size:.75rem; color:var(--text-muted); }
        .footer-links { display:flex; gap:1.5rem; }
        .footer-links a { font-size:.78rem; color:var(--text-muted); text-decoration:none; transition:color .2s; }
        .footer-links a:hover { color:var(--teal); }

        /* Scroll reveal */
        .reveal { opacity:0; transform:translateY(16px); transition:opacity .6s ease, transform .6s cubic-bezier(.22,.68,0,1.2); }
        .reveal.visible { opacity:1; transform:translateY(0); }

        /* Page texture */
        .page-texture {
            position:fixed; inset:0; pointer-events:none; z-index:0; opacity:.025;
            background-image:repeating-linear-gradient(-50deg,#8a6520 0px,#8a6520 1px,transparent 1px,transparent 22px);
        }
    </style>
</head>
<body>
<div class="page-texture"></div>

{{-- HEADER --}}
<header class="site-header">
    <div class="shimmer-bar" style="height:2px"></div>
    <div class="header-inner">
        <a href="/" class="header-logo">
            <div class="logo-icon">
                <svg width="14" height="14" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                </svg>
            </div>
            <span class="logo-text">Journals</span>
        </a>
        <a href="/" class="back-link">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </svg>
            Back to Home
        </a>
    </div>
</header>

{{-- HERO --}}
<div class="paper-hero">
    <div class="hero-shimmer shimmer-bar"></div>
    <div class="hero-inner">
        <div class="fade-up" style="animation-delay:.05s">
            <div class="category-badge">
                <span class="pulse-dot"></span>
                {{ $paper['category'] }}
            </div>
        </div>
        <h1 class="paper-title fade-up" style="animation-delay:.15s">
            {{ $paper['title'] }}
        </h1>
        <div class="paper-meta-row fade-up" style="animation-delay:.28s">
            <div class="meta-item">
                <span class="meta-label">Author</span>
                <span class="meta-value">{{ $paper['author'] }}</span>
            </div>
            <div class="meta-divider"></div>
            <div class="meta-item">
                <span class="meta-label">Published</span>
                <span class="meta-value">{{ $paper['publishedAt']->format('M d, Y') }}</span>
            </div>
            <div class="meta-divider"></div>
            <div class="meta-item">
                <span class="meta-label">Volume</span>
                <span class="meta-value">Vol. 8, No. 1</span>
            </div>
            <div class="meta-divider"></div>
            <div class="meta-item">
                <span class="meta-label">DOI</span>
                <span class="meta-value" style="font-size:.75rem;opacity:.85">10.1234/js.{{ $paper['id'] }}</span>
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
            <div style="height:3px" class="shimmer-bar"></div>
            <div class="stats-inner">
                <div class="stat-cell">
                    <div class="stat-val">{{ $paper['citations'] }}</div>
                    <div class="stat-lbl">Citations</div>
                </div>
                <div class="stat-cell">
                    <div class="stat-val">{{ $paper['downloads'] }}</div>
                    <div class="stat-lbl">Downloads</div>
                </div>
                <div class="stat-cell">
                    <div class="stat-val">{{ $paper['reviews'] }}</div>
                    <div class="stat-lbl">Peer Reviews</div>
                </div>
            </div>
        </div>

        {{-- Abstract --}}
        <div class="paper-section reveal" style="transition-delay:.08s">
            <div class="section-heading">
                <div class="section-icon">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                    </svg>
                </div>
                Abstract
            </div>
            <div class="card">
                <div class="card-body">
                    <p class="abstract-text">{{ $paper['abstract'] }}</p>
                </div>
            </div>
        </div>

        {{-- Keywords --}}
        @if($paper['keywords'])
        <div class="paper-section reveal" style="transition-delay:.12s">
            <div class="section-heading">
                <div class="section-icon">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                        <line x1="7" y1="7" x2="7.01" y2="7"/>
                    </svg>
                </div>
                Keywords
            </div>
            <div class="keyword-list">
                @foreach(array_filter(array_map('trim', explode(',', $paper['keywords']))) as $keyword)
                <span class="keyword-tag">{{ $keyword }}</span>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Download --}}
        <div class="paper-section reveal" style="transition-delay:.16s">
            <div class="section-heading">
                <div class="section-icon">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
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
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Download PDF
                    </a>
                </div>
            </div>
        </div>

        {{-- Citation --}}
        <div class="paper-section reveal" style="transition-delay:.2s">
            <div class="section-heading">
                <div class="section-icon">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/>
                        <path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/>
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
                            data-category="{{ $paper['category'] }}">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                            </svg>
                            Cite This Paper
                        </button>

                        <!-- RIS Download Button -->
                        <a href="{{ route('papers.download-ris', ['submission' => $paper['id']]) }}" 
                           class="cite-btn" 
                           style="text-decoration: none; background-color: #c9a84c; color: #fff; border: none; cursor: pointer;"
                           title="Download RIS format for Zotero, Mendeley, EndNote">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                            </svg>
                            Export as RIS
                        </a>
                    </div>
                    <p style="font-size:.75rem;color:var(--text-muted);margin-top:0.75rem;text-align:center">
                        RIS format works with Zotero, Mendeley, EndNote, and other reference managers
                    </p>
                </div>
            </div>
        </div>

        {{-- Related --}}
        <div class="paper-section reveal" style="transition-delay:.24s">
            <div class="section-heading">
                <div class="section-icon">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/>
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                    </svg>
                </div>
                Related Research
            </div>
            <div class="related-grid">
                @for($i = 0; $i < 2; $i++)
                <a href="#" class="related-card">
                    <span class="related-tag">Similar Research</span>
                    <div class="related-title">{{ ['Advanced Neural Network Optimization Techniques', 'Quantum Computing Applications in Research'][$i] }}</div>
                    <p class="related-excerpt">{{ ['Exploring state-of-the-art techniques for neural network efficiency in resource-constrained environments.', 'Contemporary approaches to quantum computational advantage in academic problem-solving contexts.'][$i] }}</p>
                    <div class="related-stats">
                        <span>{{ rand(20,100) }} citations</span><span>•</span><span>{{ rand(500,3000) }} downloads</span>
                    </div>
                </a>
                @endfor
            </div>
        </div>
    </main>

    {{-- Sidebar --}}
    <aside class="sidebar">

        <div class="sidebar-card reveal" style="transition-delay:.1s">
            <div class="sidebar-card-head">
                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                Paper Details
            </div>
            <div class="sidebar-card-body">
                <div class="info-row">
                    <span class="info-row-label">Category</span>
                    <span class="info-row-value">{{ $paper['category'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">Journal</span>
                    <span class="info-row-value">Open Journal System</span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">Volume / Issue</span>
                    <span class="info-row-value">Vol. 8, No. 1</span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">Pages</span>
                    <span class="info-row-value">pp. 14–28</span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">Language</span>
                    <span class="info-row-value">English</span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">License</span>
                    <span class="info-row-value" style="color:var(--teal);font-size:.75rem">CC BY 4.0 Open Access</span>
                </div>
            </div>
        </div>

        <div class="sidebar-card reveal" style="transition-delay:.22s">
            <div class="sidebar-card-head">
                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
                About the Author
            </div>
            <div class="sidebar-card-body">
                <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:.875rem">
                    <div style="width:2.5rem;height:2.5rem;border-radius:50%;
                                background:linear-gradient(135deg,var(--teal),var(--teal-dark));
                                display:flex;align-items:center;justify-content:center;
                                color:#fff;font-family:'Playfair Display',serif;
                                font-size:1rem;font-weight:700;flex-shrink:0">
                        {{ strtoupper(substr($paper['author'], 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:.85rem;font-weight:600;color:#1a202c">{{ $paper['author'] }}</div>
                        <div style="font-size:.72rem;color:var(--text-muted)">Lead Researcher</div>
                    </div>
                </div>
                <p style="font-size:.75rem;color:var(--text-muted);line-height:1.6">
                    Researcher and author contributing to the Open Journal System academic community.
                </p>
            </div>
        </div>
    </aside>
</div>

{{-- FOOTER --}}
<footer class="site-footer">
    <div class="footer-inner">
        <div>
            <div class="footer-brand">Open Journal System</div>
            <div class="footer-copy">&copy; {{ now()->year }} All rights reserved.</div>
        </div>
        <nav class="footer-links">
            <a href="/">Home</a>
            <a href="/">Browse Papers</a>
            <a href="/">Submit Research</a>
        </nav>
    </div>
</footer>

{{-- CITATION MODAL --}}
<div id="citationModal" class="citation-modal">
    <div class="modal-box">
        <div class="modal-top-bar shimmer-bar"></div>
        <div class="modal-inner">
            <button class="modal-close" onclick="closeCitationModal()" aria-label="Close">✕</button>
            <h2 class="modal-title">Cite This Paper</h2>
            <p class="modal-subtitle">Select a format and copy the formatted reference.</p>
            <div class="citation-tabs">
                <button class="citation-tab-btn active" onclick="switchCitationStyle(this,'apa')">APA</button>
                <button class="citation-tab-btn" onclick="switchCitationStyle(this,'chicago')">Chicago</button>
                <button class="citation-tab-btn" onclick="switchCitationStyle(this,'mla')">MLA</button>
                <button class="citation-tab-btn" onclick="switchCitationStyle(this,'harvard')">Harvard</button>
            </div>
            <div id="apa"     class="citation-content active"></div>
            <div id="chicago" class="citation-content"></div>
            <div id="mla"     class="citation-content"></div>
            <div id="harvard" class="citation-content"></div>
            <button class="copy-btn" onclick="copyCitation()">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <rect x="9" y="9" width="13" height="13" rx="2"/>
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                </svg>
                Copy Citation
            </button>
        </div>
    </div>
</div>

<script>
    /* Scroll reveal */
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
    }, { threshold: .12 });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    /* Citation modal */
    let currentPaperData = {};

    function openCitationModal() {
        const btn = event.currentTarget;
        currentPaperData = {
            title:   btn.getAttribute('data-paper-title'),
            author:  btn.getAttribute('data-paper-author'),
            year:    btn.getAttribute('data-publication-year'),
            journal: 'Open Journal System',
            doi:     Math.floor(Math.random() * 100000),
            url:     window.location.href
        };
        generateCitations();
        document.getElementById('citationModal').classList.add('show');
    }

    function closeCitationModal() {
        document.getElementById('citationModal').classList.remove('show');
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
        document.querySelectorAll('.citation-tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.citation-content').forEach(d => d.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById(style).classList.add('active');
    }

    function copyCitation() {
        const active = document.querySelector('.citation-content.active');
        if (!active) return;
        navigator.clipboard.writeText(active.innerText).then(() => {
            const btn = event.currentTarget;
            const orig = btn.innerHTML;
            btn.innerHTML = `<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg> Copied!`;
            setTimeout(() => { btn.innerHTML = orig; }, 2000);
        });
    }

    document.getElementById('citationModal').addEventListener('click', function(e) {
        if (e.target === this) closeCitationModal();
    });
</script>
</body>
</html>