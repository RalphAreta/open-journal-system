<!DOCTYPE html>
<html>
    <body style="font-family: sans-serif; background: #f5f0e8; padding: 40px">
        <div
            style="
                max-width: 400px;
                margin: 0 auto;
                background: white;
                border-radius: 16px;
                padding: 40px;
                text-align: center;
            "
        >
            <h2 style="color: #0d1628">Journal System</h2>
            <p style="color: #8a96a8">Your verification code is:</p>
            <div
                style="
                    font-size: 42px;
                    font-weight: bold;
                    letter-spacing: 12px;
                    color: #a07830;
                    margin: 20px 0;
                "
            >
                {{ $otp }}
            </div>
            <p style="color: #8a96a8; font-size: 13px">
                This code expires in 10 minutes.
            </p>
        </div>
    </body>
</html>
