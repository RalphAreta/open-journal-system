<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Email Verification</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                background: #f7f3ec;
                font-family: 'DM Sans', Arial, sans-serif;
                color: #1a202c;
            }
            .wrapper {
                max-width: 520px;
                margin: 40px auto;
                background: #ffffff;
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 4px 24px rgba(160, 120, 48, 0.1);
                border: 1px solid rgba(201, 168, 76, 0.18);
            }
            .header {
                background: linear-gradient(135deg, #124841 0%, #1c544c 100%);
                padding: 32px 40px 24px;
                text-align: center;
            }
            .header .brand {
                font-size: 11px;
                letter-spacing: 0.2em;
                text-transform: uppercase;
                color: #c9a84c;
                font-weight: 600;
                margin-bottom: 8px;
            }
            .header h1 {
                margin: 0;
                font-size: 22px;
                font-weight: 700;
                color: #ffffff;
                font-family: Georgia, serif;
            }
            .body {
                padding: 36px 40px;
                text-align: center;
            }
            .body p.intro {
                font-size: 14px;
                color: #6a7890;
                margin: 0 0 24px;
                line-height: 1.6;
            }
            .otp-box {
                display: inline-block;
                background: #fdfcf8;
                border: 1.5px dashed rgba(201, 168, 76, 0.5);
                border-radius: 12px;
                padding: 20px 48px;
                margin-bottom: 24px;
            }
            .otp-label {
                font-size: 11px;
                letter-spacing: 0.15em;
                text-transform: uppercase;
                color: #a07830;
                font-weight: 600;
                margin-bottom: 8px;
            }
            .otp-code {
                font-size: 40px;
                font-weight: 700;
                letter-spacing: 12px;
                color: #0d1628;
                font-family: 'Courier New', monospace;
                line-height: 1;
            }
            .expiry {
                font-size: 13px;
                color: #a0aab8;
                margin: 0 0 28px;
            }
            .expiry strong {
                color: #c9a84c;
            }
            .divider {
                height: 1px;
                background: #ede8de;
                margin: 0 0 24px;
            }
            .warning {
                font-size: 12px;
                color: #b0bac8;
                line-height: 1.6;
            }
            .footer {
                background: #f7f3ec;
                padding: 20px 40px;
                text-align: center;
                font-size: 11px;
                color: #b0bac8;
                border-top: 1px solid #ede8de;
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            {{-- Header --}}
            <div class="header">
                <div class="brand">Journal System</div>
                <h1>Verify your email</h1>
            </div>

            {{-- Body --}}
            <div class="body">
                <p class="intro">
                    Use the code below to complete your registration.
                    <br />
                    Do not share this code with anyone.
                </p>

                <div class="otp-box">
                    <div class="otp-label">Your verification code</div>
                    <div class="otp-code">{{ $token }}</div>
                </div>

                <p class="expiry">
                    This code expires in
                    <strong>10 minutes</strong>
                    .
                </p>

                <div class="divider"></div>

                <p class="warning">
                    If you did not attempt to register on Journal System,
                    <br />
                    you can safely ignore this email.
                </p>
            </div>

            {{-- Footer --}}
            <div class="footer">
                &copy; {{ date('Y') }} Journal System &mdash; All rights
                reserved.
            </div>
        </div>
    </body>
</html>
