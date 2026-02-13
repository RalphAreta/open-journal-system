<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'IRJIEST') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */@layer theme{:root,:host{--font-sans:'Instrument Sans',ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";--font-serif:ui-serif,Georgia,Cambria,"Times New Roman",Times,serif;--font-mono:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;--color-black:#000;--color-white:#fff}}@layer base{*,:after,:before,::backdrop{box-sizing:border-box;border:0 solid;margin:0;padding:0}}html,body{height:100%;width:100%;margin:0;padding:0}</style>
            </style>
        @endif

        <style>
            body {
                background-image: url('{{ asset('images/homepage-webslider-1.jpg') }}');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            }
            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                z-index: 1;
            }
            .content {
                text-align: center;
                color: white;
                max-width: 600px;
                position: relative;
                z-index: 2;
            }
            .content h1 {
                font-size: 48px;
                font-weight: 600;
                margin-bottom: 20px;
                letter-spacing: 2px;
            }
            .content p {
                font-size: 18px;
                line-height: 1.6;
                margin-bottom: 40px;
                font-weight: 400;
            }
            .btn {
                display: inline-block;
                padding: 14px 40px;
                background-color: #f53003;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                font-weight: 600;
                font-size: 16px;
                transition: all 0.3s ease;
                border: 2px solid #f53003;
            }
            .btn:hover {
                background-color: transparent;
                border-color: white;
                color: white;
                transform: translateY(-2px);
            }
            .nav-links {
                position: absolute;
                top: 20px;
                right: 20px;
                display: flex;
                gap: 15px;
                z-index: 3;
            }
            .nav-links a {
                color: white;
                text-decoration: none;
                padding: 8px 16px;
                border: 1px solid rgba(255, 255, 255, 0.5);
                border-radius: 4px;
                font-size: 14px;
                transition: all 0.3s ease;
            }
            .nav-links a:hover {
                background-color: rgba(255, 255, 255, 0.1);
                border-color: white;
            }
        </style>
    </head>
    <body>
        <div class="overlay">
            <div class="nav-links">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                @endif
            </div>

            <div class="content">
                <h1>IRJIEST</h1>
                <p>
                    International Research and Journalistic International Educational Science and Technology Platform.
                    <br>
                    A comprehensive platform for researchers, editors, and reviewers to collaborate on academic submissions, reviews, and publications.
                </p>
                <a href="{{ route('login') }}" class="btn">Get Started</a>
            </div>
        </div>
    </body>
</html>