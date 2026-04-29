<!DOCTYPE html>
<html>
    <body
        style="
            font-family: sans-serif;
            background: #f4f2ee;
            padding: 30px;
            margin: 0;
        "
    >
        <div
            style="
                max-width: 520px;
                margin: auto;
                background: #ffffff;
                border: 1px solid #e0dbd3;
                border-radius: 16px;
                overflow: hidden;
            "
        >
            {{-- Header --}}
            <div
                style="
                    background: #1a5c52;
                    padding: 20px 28px;
                    display: flex;
                    align-items: center;
                    gap: 12px;
                "
            >
                <div
                    style="
                        width: 36px;
                        height: 36px;
                        border-radius: 50%;
                        background: rgba(255, 255, 255, 0.15);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        flex-shrink: 0;
                    "
                >
                    <svg
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="white"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                </div>
                <div>
                    <p
                        style="
                            color: rgba(255, 255, 255, 0.6);
                            font-size: 11px;
                            margin: 0 0 2px;
                            text-transform: uppercase;
                            letter-spacing: 0.08em;
                            font-weight: 600;
                        "
                    >
                        System Notification
                    </p>
                    <p
                        style="
                            color: #ffffff;
                            font-size: 14px;
                            font-weight: 600;
                            margin: 0;
                        "
                    >
                        New activity on your account
                    </p>
                </div>
            </div>

            {{-- Body --}}
            <div style="padding: 28px 28px 24px">
                {{-- Greeting + Role --}}
                <div
                    style="
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        margin-bottom: 20px;
                    "
                >
                    <div
                        style="
                            width: 32px;
                            height: 32px;
                            border-radius: 50%;
                            background: #e1f5ee;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 12px;
                            font-weight: 600;
                            color: #0f6e56;
                            flex-shrink: 0;
                        "
                    >
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div>
                        <p style="margin: 0; font-size: 13px; color: #6a7890">
                            Hello,
                            <strong style="color: #0d1628">
                                {{ $user->name }}
                            </strong>
                        </p>
                        @if ($notification->role)
                            <span
                                style="
                                    display: inline-block;
                                    background: #e1f5ee;
                                    color: #0f6e56;
                                    font-size: 11px;
                                    font-weight: 600;
                                    padding: 2px 9px;
                                    border-radius: 20px;
                                    margin-top: 3px;
                                "
                            >
                                {{ ucfirst($notification->role) }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Notification Title + Message --}}
                <div
                    style="
                        border-left: 2px solid #1a5c52;
                        padding-left: 16px;
                        margin-bottom: 24px;
                    "
                >
                    <h3
                        style="
                            color: #0d1628;
                            margin: 0 0 8px;
                            font-size: 16px;
                            font-weight: 600;
                        "
                    >
                        {{ $notification->title }}
                    </h3>
                    <p
                        style="
                            color: #6a7890;
                            font-size: 13px;
                            margin: 0;
                            line-height: 1.7;
                        "
                    >
                        {{ $notification->message }}
                    </p>
                </div>

                {{-- Actor Card --}}
                @if ($actor)
                    <div
                        style="
                            background: #f9f7f4;
                            border: 1px solid #e8e2da;
                            border-radius: 12px;
                            padding: 16px 18px;
                        "
                    >
                        <p
                            style="
                                font-size: 11px;
                                font-weight: 700;
                                text-transform: uppercase;
                                letter-spacing: 0.08em;
                                color: #9a9488;
                                margin: 0 0 12px;
                            "
                        >
                            Action performed by
                        </p>

                        <div
                            style="
                                display: flex;
                                align-items: center;
                                gap: 12px;
                                margin-bottom: 12px;
                            "
                        >
                            <div
                                style="
                                    width: 38px;
                                    height: 38px;
                                    border-radius: 50%;
                                    background: #e1f5ee;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-size: 13px;
                                    font-weight: 600;
                                    color: #0f6e56;
                                    flex-shrink: 0;
                                "
                            >
                                {{ strtoupper(substr($actor->name, 0, 2)) }}
                            </div>
                            <div>
                                <p
                                    style="
                                        color: #0d1628;
                                        font-size: 14px;
                                        font-weight: 600;
                                        margin: 0 0 2px;
                                    "
                                >
                                    {{ $actor->name }}
                                </p>
                                <p
                                    style="
                                        color: #6a7890;
                                        font-size: 12px;
                                        margin: 0;
                                    "
                                >
                                    {{ ucfirst($notification->type ?? 'Staff') }}
                                </p>
                            </div>
                        </div>

                        <div
                            style="
                                border-top: 1px solid #e8e2da;
                                padding-top: 12px;
                                display: flex;
                                align-items: center;
                                gap: 8px;
                            "
                        >
                            <svg
                                width="14"
                                height="14"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#1a5c52"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <rect
                                    width="20"
                                    height="16"
                                    x="2"
                                    y="4"
                                    rx="2"
                                />
                                <path
                                    d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"
                                />
                            </svg>
                            <a
                                href="mailto:{{ $actor->email }}"
                                style="
                                    color: #1a5c52;
                                    font-size: 12px;
                                    text-decoration: none;
                                    font-weight: 600;
                                "
                            >
                                {{ $actor->email }}
                            </a>
                        </div>

                        <p
                            style="
                                color: #b0aaa0;
                                font-size: 11px;
                                margin: 8px 0 0;
                                line-height: 1.6;
                            "
                        >
                            For questions, reply to this email or contact them
                            directly.
                        </p>
                    </div>
                @endif
            </div>

            {{-- Footer --}}
            <div
                style="
                    padding: 14px 28px;
                    background: #f9f7f4;
                    border-top: 1px solid #e8e2da;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                "
            >
                <p style="color: #b0aaa0; font-size: 11px; margin: 0">
                    {{ $notification->created_at->format('M d, Y h:i A') }}
                </p>
                <p style="color: #b0aaa0; font-size: 11px; margin: 0">
                    Automated notification
                </p>
            </div>
        </div>
    </body>
</html>
