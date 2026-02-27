<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $paper['title'] }} - Published Paper</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f9f7f2]">
    <!-- Header Navigation -->
    <header class="bg-white border-b border-[#e0d8cc] sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="font-libre text-2xl font-bold text-[#2D8176]">
                📚 Journals
            </a>
            <div class="flex items-center gap-4">
                <a href="/" class="text-[#6a7890] hover:text-[#2D8176] transition-colors text-sm font-medium">← Back to Home</a>
            </div>
        </div>
    </header>

    <!-- Paper Content -->
    <main class="max-w-4xl mx-auto px-6 py-16">
        <!-- Paper Title & Metadata -->
        <article>
            <header class="mb-12">
                <!-- Category Badge -->
                <div class="mb-4 inline-block">
                    <span class="bg-[#2D8176]/10 text-[#2D8176] px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                        {{ $paper['category'] }}
                    </span>
                </div>

                <!-- Title -->
                <h1 class="font-libre text-4xl md:text-5xl font-bold text-[#1a1a1a] mb-6 leading-tight">
                    {{ $paper['title'] }}
                </h1>

                <!-- Author & Publication Date -->
                <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-8 border-b border-[#e0d8cc] pb-8">
                    <div>
                        <p class="text-xs text-[#6a7890] uppercase tracking-wider mb-1">Author</p>
                        <p class="text-lg text-[#2D8176] font-bold">{{ $paper['author'] }}</p>
                    </div>
                    <div class="hidden md:block w-px h-12 bg-[#e0d8cc]"></div>
                    <div>
                        <p class="text-xs text-[#6a7890] uppercase tracking-wider mb-1">Published</p>
                        <p class="text-lg text-[#2D8176] font-bold">{{ $paper['publishedAt']->format('M d, Y') }}</p>
                    </div>
                </div>
            </header>

            <!-- Stats Row -->
            <div class="grid grid-cols-3 gap-4 md:gap-6 mb-12 p-6 bg-white rounded-xl border border-[#e0d8cc]">
                <div>
                    <div class="text-2xl md:text-3xl font-bold text-[#2D8176]">{{ $paper['citations'] }}</div>
                    <p class="text-xs text-[#6a7890] uppercase tracking-wider mt-1">Citations</p>
                </div>
                <div class="border-l border-r border-[#e0d8cc]">
                    <div class="text-2xl md:text-3xl font-bold text-[#2D8176]">{{ $paper['downloads'] }}</div>
                    <p class="text-xs text-[#6a7890] uppercase tracking-wider mt-1">Downloads</p>
                </div>
                <div>
                    <div class="text-2xl md:text-3xl font-bold text-[#2D8176]">{{ $paper['reviews'] }}</div>
                    <p class="text-xs text-[#6a7890] uppercase tracking-wider mt-1">Peer Reviews</p>
                </div>
            </div>

            <!-- Abstract Section -->
            <section class="mb-12">
                <h2 class="font-libre text-2xl font-bold text-[#2D8176] mb-4">Abstract</h2>
                <div class="bg-white rounded-xl p-8 border border-[#e0d8cc] text-[#4a5568] leading-relaxed">
                    {{ $paper['abstract'] }}
                </div>
            </section>

            <!-- Keywords Section -->
            @if($paper['keywords'])
            <section class="mb-12">
                <h2 class="font-libre text-2xl font-bold text-[#2D8176] mb-4">Keywords</h2>
                <div class="flex flex-wrap gap-3">
                    @foreach(array_filter(array_map('trim', explode(',', $paper['keywords']))) as $keyword)
                    <span class="bg-[#f0efe8] text-[#2D8176] px-4 py-2 rounded-lg text-sm font-medium border border-[#e0d8cc]">
                        {{ $keyword }}
                    </span>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Download Section -->
            <section class="mb-12">
                <h2 class="font-libre text-2xl font-bold text-[#2D8176] mb-4">Access Paper</h2>
                <div class="bg-gradient-to-r from-[#2D8176] to-[#1f5d54] rounded-xl p-8 text-white">
                    <p class="mb-6 text-lg">
                        Download the full paper to read the complete research.
                    </p>
                    <a href="{{ route('papers.download', ['submission' => $paper['id']]) }}"
                       class="inline-block bg-white text-[#2D8176] px-8 py-3 rounded-lg font-bold hover:bg-[#f9f7f2] transition-colors">
                        📥 Download PDF
                    </a>
                </div>
            </section>

            <!-- Citation Information -->
            <section class="mb-12">
                <h2 class="font-libre text-2xl font-bold text-[#2D8176] mb-4">Citation</h2>
                <div class="bg-white rounded-xl p-6 border border-[#e0d8cc] font-mono text-sm text-[#4a5568] overflow-x-auto">
                    <p class="whitespace-pre-wrap">{{ $paper['author'] }} ({{ $paper['publishedAt']->year }}). {{ $paper['title'] }}. <em>Published Paper</em>.</p>
                </div>
            </section>

            <!-- Related Papers -->
            <section>
                <h2 class="font-libre text-2xl font-bold text-[#2D8176] mb-6">Related Research</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    @for($i = 0; $i < 2; $i++)
                    <div class="bg-white rounded-xl p-6 border border-[#e0d8cc] hover:border-[#2D8176] transition-colors">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#c9a84c]">Similar Research</span>
                        <h3 class="text-lg font-bold text-[#2D8176] mt-3 mb-3 line-clamp-2">
                            {{ ['Advanced Neural Network Optimization', 'Quantum Computing Applications'][$i] }}
                        </h3>
                        <p class="text-sm text-[#6a7890] mb-4">
                            {{ ['Exploring state-of-the-art techniques for neural network efficiency...', 'Contemporary approaches to quantum computational advantage...'][$i] }}
                        </p>
                        <div class="flex items-center gap-2 text-xs text-[#a7b1c7]">
                            <span>{{ rand(20, 100) }} citations</span>
                            <span>•</span>
                            <span>{{ rand(500, 3000) }} downloads</span>
                        </div>
                    </div>
                    @endfor
                </div>
            </section>
        </article>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-[#e0d8cc] mt-20 py-12">
        <div class="max-w-5xl mx-auto px-6 text-center text-sm text-[#6a7890]">
            <p>&copy; {{ now()->year }} Open Journal System. All rights reserved.</p>
            <div class="mt-4 flex justify-center gap-6">
                <a href="/" class="hover:text-[#2D8176] transition-colors">Home</a>
                <a href="/" class="hover:text-[#2D8176] transition-colors">Browse Papers</a>
                <a href="/" class="hover:text-[#2D8176] transition-colors">Submit Research</a>
            </div>
        </div>
    </footer>
</body>
</html>
