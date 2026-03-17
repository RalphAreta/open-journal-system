<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Notifications | Journal System</title>
        <link
            href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap"
            rel="stylesheet"
        />
        <style>
            *,
            *::before,
            *::after {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            :root {
                --teal: #2d8176;
                --teal-dark: #1f5d54;
                --teal-pale: #e8f4f2;
                --gold: #c9a84c;
                --gold-deep: #a07830;
                --gold-lt: #f0d678;

                --ink: #0d1628;
                --ink-mid: #2a3545;
                --ink-soft: #5c6a7f;
                --ink-muted: #8a96a8;
                --ink-ghost: #b0aaa0;

                --bg: #f5f0e8;
                --bg-mid: #ede5d5;
                --surface: #ffffff;
                --border: #ede8e0;
                --border-lt: #f0ece6;

                --unread-bg: rgba(45, 129, 118, 0.05);
                --unread-dot: var(--teal);
                --read-dot: #e0dbd3;

                --shadow-sm:
                    0 1px 3px rgba(13, 22, 40, 0.06),
                    0 4px 12px rgba(13, 22, 40, 0.05);
                --shadow-md:
                    0 2px 8px rgba(13, 22, 40, 0.07),
                    0 12px 32px rgba(13, 22, 40, 0.07);
            }

            html,
            body {
                min-height: 100vh;
                background: linear-gradient(
                    150deg,
                    var(--bg) 0%,
                    var(--bg-mid) 60%,
                    #e8e2d8 100%
                );
                font-family: 'DM Sans', sans-serif;
                color: var(--ink);
            }

            /* Subtle hatch texture — matching login page */
            body::before {
                content: '';
                position: fixed;
                inset: 0;
                background-image: repeating-linear-gradient(
                    -50deg,
                    #8a6520 0px,
                    #8a6520 1px,
                    transparent 1px,
                    transparent 20px
                );
                opacity: 0.025;
                pointer-events: none;
                z-index: 0;
            }

            /* Decorative ring ornaments */
            body::after {
                content: '';
                position: fixed;
                width: 560px;
                height: 560px;
                top: -200px;
                right: -160px;
                border-radius: 50%;
                border: 1px solid rgba(160, 120, 48, 0.08);
                pointer-events: none;
                z-index: 0;
            }

            .page-wrap {
                position: relative;
                z-index: 1;
                max-width: 720px;
                margin: 0 auto;
                padding: 48px 24px 80px;
            }

            /* ════════════════ HEADER ════════════════ */
            .page-header {
                display: flex;
                align-items: flex-end;
                justify-content: space-between;
                gap: 16px;
                margin-bottom: 28px;
                flex-wrap: wrap;
            }

            .header-left {
            }

            .header-eyebrow {
                display: flex;
                align-items: center;
                gap: 8px;
                font-family: 'DM Mono', monospace;
                font-size: 9.5px;
                letter-spacing: 0.2em;
                text-transform: uppercase;
                color: var(--gold-deep);
                margin-bottom: 6px;
                opacity: 0.8;
            }
            .header-eyebrow::before {
                content: '';
                display: block;
                width: 16px;
                height: 1px;
                background: var(--gold);
                opacity: 0.6;
            }

            .page-title {
                font-family: 'Cormorant Garamond', serif;
                font-size: 36px;
                font-weight: 700;
                color: var(--ink);
                line-height: 1.1;
                letter-spacing: -0.01em;
            }

            .header-right {
                display: flex;
                flex-direction: column;
                align-items: flex-end;
                gap: 6px;
            }

            .role-badge {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                background: rgba(45, 129, 118, 0.08);
                border: 1px solid rgba(45, 129, 118, 0.18);
                border-radius: 100px;
                padding: 5px 13px 5px 9px;
                font-size: 12px;
                color: var(--teal-dark);
                font-weight: 500;
            }
            .role-badge-dot {
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: var(--teal);
                box-shadow: 0 0 6px rgba(45, 129, 118, 0.7);
                animation: blink 2s ease-in-out infinite;
            }
            @keyframes blink {
                0%,
                100% {
                    opacity: 1;
                }
                50% {
                    opacity: 0.3;
                }
            }

            .unread-count {
                font-family: 'DM Mono', monospace;
                font-size: 10px;
                color: var(--ink-muted);
                letter-spacing: 0.06em;
            }
            .unread-count strong {
                color: var(--gold-deep);
            }

            /* ════════════════ MARK ALL ════════════════ */
            .actions-bar {
                display: flex;
                justify-content: flex-end;
                margin-bottom: 12px;
            }
            .btn-mark-all {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-family: 'DM Mono', monospace;
                font-size: 9.5px;
                letter-spacing: 0.14em;
                text-transform: uppercase;
                color: var(--teal);
                background: rgba(45, 129, 118, 0.07);
                border: 1px solid rgba(45, 129, 118, 0.15);
                border-radius: 8px;
                padding: 6px 14px;
                cursor: pointer;
                transition:
                    background 0.18s,
                    color 0.18s,
                    border-color 0.18s;
                text-decoration: none;
            }
            .btn-mark-all:hover {
                background: rgba(45, 129, 118, 0.13);
                color: var(--teal-dark);
                border-color: rgba(45, 129, 118, 0.25);
            }

            /* ════════════════ NOTIFICATION CARD ════════════════ */
            .notif-list {
                background: var(--surface);
                border: 1px solid var(--border);
                border-radius: 18px;
                overflow: hidden;
                box-shadow: var(--shadow-md);
            }

            /* Shimmer top border — matching login page */
            .notif-list::before {
                content: '';
                display: block;
                height: 2px;
                background: linear-gradient(
                    90deg,
                    transparent,
                    var(--gold),
                    var(--gold-lt),
                    var(--gold),
                    transparent
                );
                background-size: 200% 100%;
                animation: shimmerX 3s linear infinite;
            }
            @keyframes shimmerX {
                0% {
                    background-position: -100% 0;
                }
                100% {
                    background-position: 100% 0;
                }
            }

            .notif-item {
                display: flex;
                align-items: flex-start;
                gap: 16px;
                padding: 18px 24px;
                border-bottom: 1px solid var(--border-lt);
                transition: background 0.16s;
                position: relative;
                animation: fadeUp 0.4s ease forwards;
                opacity: 0;
            }
            .notif-item:last-child {
                border-bottom: none;
            }

            .notif-item.unread {
                background: var(--unread-bg);
            }
            .notif-item:hover {
                background: #faf8f5;
            }
            .notif-item.unread:hover {
                background: rgba(45, 129, 118, 0.08);
            }

            /* Stagger animation per item */
            .notif-item:nth-child(1) {
                animation-delay: 0.05s;
            }
            .notif-item:nth-child(2) {
                animation-delay: 0.1s;
            }
            .notif-item:nth-child(3) {
                animation-delay: 0.15s;
            }
            .notif-item:nth-child(4) {
                animation-delay: 0.2s;
            }
            .notif-item:nth-child(5) {
                animation-delay: 0.25s;
            }
            .notif-item:nth-child(6) {
                animation-delay: 0.3s;
            }
            .notif-item:nth-child(7) {
                animation-delay: 0.35s;
            }
            .notif-item:nth-child(8) {
                animation-delay: 0.4s;
            }
            @keyframes fadeUp {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Left indicator column */
            .notif-indicator {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 4px;
                padding-top: 3px;
                flex-shrink: 0;
            }
            .notif-dot {
                width: 9px;
                height: 9px;
                border-radius: 50%;
                flex-shrink: 0;
            }
            .notif-dot.unread {
                background: var(--teal);
                box-shadow: 0 0 0 3px rgba(45, 129, 118, 0.15);
            }
            .notif-dot.read {
                background: var(--read-dot);
            }
            /* Vertical thread line below dot */
            .notif-thread {
                width: 1px;
                flex: 1;
                min-height: 20px;
                background: linear-gradient(
                    to bottom,
                    rgba(45, 129, 118, 0.15),
                    transparent
                );
            }
            .notif-item:last-child .notif-thread {
                display: none;
            }

            /* Icon circle */
            .notif-icon {
                width: 36px;
                height: 36px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                font-size: 15px;
                background: var(--teal-pale);
                border: 1px solid rgba(45, 129, 118, 0.12);
            }
            .notif-icon.read {
                background: #f4f0ea;
                border-color: rgba(0, 0, 0, 0.06);
                filter: saturate(0.4);
            }

            /* Content */
            .notif-body {
                flex: 1;
                min-width: 0;
            }

            .notif-title {
                font-size: 13.5px;
                font-weight: 600;
                color: var(--ink);
                line-height: 1.35;
                margin-bottom: 3px;
            }
            .notif-item.read .notif-title {
                font-weight: 500;
                color: var(--ink-mid);
            }

            .notif-message {
                font-size: 13px;
                color: var(--ink-soft);
                line-height: 1.55;
                margin-bottom: 6px;
            }

            .notif-meta {
                display: flex;
                align-items: center;
                gap: 10px;
            }
            .notif-time {
                font-family: 'DM Mono', monospace;
                font-size: 10px;
                color: var(--ink-ghost);
                letter-spacing: 0.04em;
            }
            .notif-tag {
                font-family: 'DM Mono', monospace;
                font-size: 9px;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                color: var(--teal);
                background: rgba(45, 129, 118, 0.08);
                border: 1px solid rgba(45, 129, 118, 0.14);
                border-radius: 4px;
                padding: 1px 6px;
                opacity: 0.8;
            }

            /* Mark read button */
            .notif-action {
                flex-shrink: 0;
                align-self: flex-start;
                padding-top: 2px;
            }
            .btn-read {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                font-family: 'DM Mono', monospace;
                font-size: 9px;
                font-weight: 500;
                letter-spacing: 0.14em;
                text-transform: uppercase;
                color: var(--teal);
                background: none;
                border: 1px solid rgba(45, 129, 118, 0.2);
                border-radius: 6px;
                padding: 4px 10px;
                cursor: pointer;
                transition:
                    background 0.16s,
                    color 0.16s,
                    border-color 0.16s,
                    transform 0.12s;
                white-space: nowrap;
            }
            .btn-read:hover {
                background: rgba(45, 129, 118, 0.1);
                color: var(--teal-dark);
                border-color: rgba(45, 129, 118, 0.35);
                transform: translateY(-1px);
            }
            .btn-read:active {
                transform: translateY(0);
            }

            /* ════════════════ EMPTY STATE ════════════════ */
            .empty-state {
                padding: 72px 40px;
                text-align: center;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 12px;
            }
            .empty-icon {
                width: 56px;
                height: 56px;
                background: #f4f0ea;
                border: 1px solid var(--border);
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
                margin-bottom: 8px;
            }
            .empty-title {
                font-family: 'Cormorant Garamond', serif;
                font-size: 20px;
                font-weight: 600;
                color: var(--ink-mid);
            }
            .empty-sub {
                font-size: 13px;
                color: var(--ink-ghost);
                max-width: 280px;
                line-height: 1.6;
            }
            .empty-hint {
                font-size: 12px;
                color: var(--ink-muted);
                margin-top: 4px;
                line-height: 1.6;
                max-width: 320px;
            }

            /* ════════════════ PAGINATION ════════════════ */
            .pagination-wrap {
                margin-top: 20px;
                display: flex;
                justify-content: center;
                gap: 6px;
            }
            .page-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 34px;
                height: 34px;
                border-radius: 8px;
                font-family: 'DM Mono', monospace;
                font-size: 12px;
                color: var(--ink-soft);
                background: var(--surface);
                border: 1px solid var(--border);
                cursor: pointer;
                transition:
                    background 0.15s,
                    border-color 0.15s,
                    color 0.15s;
                text-decoration: none;
            }
            .page-btn:hover {
                background: rgba(45, 129, 118, 0.07);
                border-color: rgba(45, 129, 118, 0.2);
                color: var(--teal);
            }
            .page-btn.active {
                background: var(--teal);
                border-color: var(--teal);
                color: #fff;
                font-weight: 600;
            }
            .page-btn.disabled {
                opacity: 0.35;
                pointer-events: none;
            }

            /* Corner brackets — matching login page */
            .notif-list-wrap {
                position: relative;
            }
            .corner {
                position: absolute;
                width: 28px;
                height: 28px;
                pointer-events: none;
                z-index: 2;
            }
            .corner-tl {
                top: -10px;
                left: -10px;
                border-top: 1.5px solid rgba(201, 168, 76, 0.3);
                border-left: 1.5px solid rgba(201, 168, 76, 0.3);
            }
            .corner-br {
                bottom: -10px;
                right: -10px;
                border-bottom: 1.5px solid rgba(201, 168, 76, 0.3);
                border-right: 1.5px solid rgba(201, 168, 76, 0.3);
            }

            /* Page entrance */
            .page-header {
                animation: fadeUp 0.5s ease forwards;
            }
            .actions-bar {
                animation: fadeUp 0.5s ease forwards 0.08s;
                opacity: 0;
            }
            .notif-list-wrap {
                animation: fadeUp 0.55s ease forwards 0.14s;
                opacity: 0;
            }
        </style>
    </head>
    <body>
        <div class="page-wrap">
            <!-- ═══════════ HEADER ═══════════ -->
            <div class="page-header">
                <div class="header-left">
                    <p class="header-eyebrow">Journal System</p>
                    <h1 class="page-title">Notifications</h1>
                </div>
                <div class="header-right">
                    <div class="role-badge">
                        <span class="role-badge-dot"></span>
                        Author
                    </div>
                    <span class="unread-count">
                        <strong>3</strong>
                        unread
                    </span>
                </div>
            </div>

            <!-- ═══════════ ACTIONS BAR ═══════════ -->
            <div class="actions-bar">
                <a href="#" class="btn-mark-all">
                    <svg
                        width="10"
                        height="10"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Mark all as read
                </a>
            </div>

            <!-- ═══════════ LIST ═══════════ -->
            <div class="notif-list-wrap">
                <div class="corner corner-tl"></div>
                <div class="corner corner-br"></div>

                <div class="notif-list">
                    <!-- UNREAD ITEM 1 -->
                    <div class="notif-item unread">
                        <div class="notif-indicator">
                            <span class="notif-dot unread"></span>
                            <span class="notif-thread"></span>
                        </div>
                        <div class="notif-icon">📋</div>
                        <div class="notif-body">
                            <p class="notif-title">
                                Your submission has been assigned a reviewer
                            </p>
                            <p class="notif-message">
                                "Deep Learning Approaches for Real-Time Anomaly
                                Detection" has been assigned to a reviewer. You
                                will be notified when the review is complete.
                            </p>
                            <div class="notif-meta">
                                <span class="notif-time">2 hours ago</span>
                                <span class="notif-tag">Submission</span>
                            </div>
                        </div>
                        <div class="notif-action">
                            <button class="btn-read" onclick="markRead(this)">
                                <svg
                                    width="8"
                                    height="8"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                >
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                Mark read
                            </button>
                        </div>
                    </div>

                    <!-- UNREAD ITEM 2 -->
                    <div class="notif-item unread">
                        <div class="notif-indicator">
                            <span class="notif-dot unread"></span>
                            <span class="notif-thread"></span>
                        </div>
                        <div class="notif-icon">💬</div>
                        <div class="notif-body">
                            <p class="notif-title">
                                Editor left a comment on your manuscript
                            </p>
                            <p class="notif-message">
                                The editor has added a revision note to your
                                manuscript. Please review the feedback and
                                submit your revisions within 14 days.
                            </p>
                            <div class="notif-meta">
                                <span class="notif-time">
                                    Yesterday at 4:32 PM
                                </span>
                                <span class="notif-tag">Review</span>
                            </div>
                        </div>
                        <div class="notif-action">
                            <button class="btn-read" onclick="markRead(this)">
                                <svg
                                    width="8"
                                    height="8"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                >
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                Mark read
                            </button>
                        </div>
                    </div>

                    <!-- UNREAD ITEM 3 -->
                    <div class="notif-item unread">
                        <div class="notif-indicator">
                            <span class="notif-dot unread"></span>
                            <span class="notif-thread"></span>
                        </div>
                        <div class="notif-icon">🏷️</div>
                        <div class="notif-body">
                            <p class="notif-title">
                                Submission status updated to "Under Review"
                            </p>
                            <p class="notif-message">
                                Your paper has moved to the formal review stage.
                                Track its progress from your author dashboard.
                            </p>
                            <div class="notif-meta">
                                <span class="notif-time">2 days ago</span>
                                <span class="notif-tag">Status</span>
                            </div>
                        </div>
                        <div class="notif-action">
                            <button class="btn-read" onclick="markRead(this)">
                                <svg
                                    width="8"
                                    height="8"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                >
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                Mark read
                            </button>
                        </div>
                    </div>

                    <!-- READ ITEM 1 -->
                    <div class="notif-item read">
                        <div class="notif-indicator">
                            <span class="notif-dot read"></span>
                            <span class="notif-thread"></span>
                        </div>
                        <div class="notif-icon read">✅</div>
                        <div class="notif-body">
                            <p class="notif-title">
                                Submission received successfully
                            </p>
                            <p class="notif-message">
                                Your manuscript "Deep Learning Approaches for
                                Real-Time Anomaly Detection" has been received
                                and is pending editorial review.
                            </p>
                            <div class="notif-meta">
                                <span class="notif-time">5 days ago</span>
                                <span class="notif-tag">Submission</span>
                            </div>
                        </div>
                    </div>

                    <!-- READ ITEM 2 -->
                    <div class="notif-item read">
                        <div class="notif-indicator">
                            <span class="notif-dot read"></span>
                            <span class="notif-thread"></span>
                        </div>
                        <div class="notif-icon read">👤</div>
                        <div class="notif-body">
                            <p class="notif-title">
                                Account registration confirmed
                            </p>
                            <p class="notif-message">
                                Welcome to BIRJISE. Your author account has been
                                verified and is now active. You may begin
                                submitting manuscripts.
                            </p>
                            <div class="notif-meta">
                                <span class="notif-time">Mar 12, 2025</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ═══════════ PAGINATION ═══════════ -->
            <div class="pagination-wrap">
                <a href="#" class="page-btn disabled">‹</a>
                <a href="#" class="page-btn active">1</a>
                <a href="#" class="page-btn">2</a>
                <a href="#" class="page-btn">3</a>
                <a href="#" class="page-btn">›</a>
            </div>
        </div>

        <script>
            function markRead(btn) {
                const item = btn.closest('.notif-item');
                // Animate out the unread state
                item.style.transition = 'all .3s ease';
                item.classList.remove('unread');
                item.classList.add('read');
                // Swap dot
                const dot = item.querySelector('.notif-dot');
                dot.classList.remove('unread');
                dot.classList.add('read');
                // Swap icon style
                const icon = item.querySelector('.notif-icon');
                icon.classList.add('read');
                // Remove action button
                btn.closest('.notif-action').style.opacity = '0';
                setTimeout(() => btn.closest('.notif-action').remove(), 300);
                // Update unread count
                const counter = document.querySelector('.unread-count strong');
                const current = parseInt(counter.textContent);
                if (current > 1) counter.textContent = current - 1;
                else counter.closest('.unread-count').textContent = 'All read';
            }
        </script>
    </body>
</html>
