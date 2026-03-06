<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $paper['title'] }} - Published Paper</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Citation Modal Styles */
        .citation-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .citation-modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .citation-modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 1rem;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease-out;
            position: relative;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .citation-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .citation-tab-btn {
            padding: 0.5rem 1rem;
            border: 2px solid #c9a84c;
            background: white;
            color: #2D8176;
            border-radius: 0.5rem;
            font-weight: bold;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .citation-tab-btn:hover {
            background-color: #2D8176;
            color: white;
        }

        .citation-tab-btn.active {
            background-color: #2D8176;
            color: white;
        }

        .citation-content {
            display: none;
            padding: 1rem;
            background-color: #f9f7f2;
            border-radius: 0.5rem;
            border-left: 4px solid #c9a84c;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
            line-height: 1.6;
            word-wrap: break-word;
        }

        .citation-content.active {
            display: block;
        }

        .copy-citation-btn {
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background-color: #2D8176;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .copy-citation-btn:hover {
            background-color: #1a4d46;
            transform: translateY(-2px);
        }

        .close-citation-modal {
            position: absolute;
            right: 1.5rem;
            top: 1.5rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6a7890;
            background: none;
            border: none;
            padding: 0;
        }

        .close-citation-modal:hover {
            color: #2D8176;
        }
    </style>
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
                <div class="bg-linear-to-r from-[#2D8176] to-[#1f5d54] rounded-xl p-8 text-white">
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
                <div class="bg-white rounded-xl p-8 border border-[#e0d8cc]">
                    <p class="text-[#6a7890] mb-6">Select a citation format below and choose your preferred style.</p>
                    <button
                        onclick="openCitationModal()"
                        data-paper-title="{{ $paper['title'] }}"
                        data-paper-author="{{ $paper['author'] }}"
                        data-publication-year="{{ $paper['publishedAt']->format('Y') }}"
                        data-category="{{ $paper['category'] }}"
                        class="inline-block px-8 py-3 bg-[#2D8176] text-white rounded-lg font-bold text-sm uppercase tracking-wider hover:-translate-y-0.5 transition-all shadow-md"
                    >
                        📋 Cite Me
                    </button>
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

    <!-- CITATION MODAL -->
    <div id="citationModal" class="citation-modal">
        <div class="citation-modal-content">
            <button class="close-citation-modal" onclick="closeCitationModal()">&times;</button>
            
            <h2 class="font-libre text-2xl font-bold text-[#2D8176] mb-4">Cite This Paper</h2>
            
            <div class="citation-tabs">
                <button class="citation-tab-btn active" onclick="switchCitationStyle(this, 'apa')">APA Style</button>
                <button class="citation-tab-btn" onclick="switchCitationStyle(this, 'chicago')">Chicago Style</button>
                <button class="citation-tab-btn" onclick="switchCitationStyle(this, 'mla')">MLA Style</button>
                <button class="citation-tab-btn" onclick="switchCitationStyle(this, 'harvard')">Harvard Style</button>
            </div>

            <div id="apa" class="citation-content active"></div>
            <div id="chicago" class="citation-content"></div>
            <div id="mla" class="citation-content"></div>
            <div id="harvard" class="citation-content"></div>

            <button class="copy-citation-btn" onclick="copyCitation()">
                📋 Copy Citation
            </button>
        </div>
    </div>

    <script>
        let currentPaperData = {};

        function openCitationModal() {
            const button = event.target.closest('button');
            currentPaperData = {
                title: button.getAttribute('data-paper-title'),
                author: button.getAttribute('data-paper-author'),
                year: button.getAttribute('data-publication-year'),
                category: button.getAttribute('data-category'),
                journal: 'Journal System',
                doi: Math.floor(Math.random() * 100000),
                url: window.location.href
            };

            generateCitations();
            document.getElementById('citationModal').classList.add('show');
        }

        function closeCitationModal() {
            document.getElementById('citationModal').classList.remove('show');
        }

        function generateCitations() {
            const data = currentPaperData;

            // APA Style
            const apaCitation = `${data.author}. (${data.year}). ${data.title}. <i>${data.journal}</i>. https://doi.org/10.1234/js.${data.doi}`;
            document.getElementById('apa').innerHTML = apaCitation;

            // Chicago Style
            const chicagoCitation = `${data.author}. "${data.title}." <i>${data.journal}</i> (${data.year}). Accessed ${new Date().toLocaleDateString()} ${data.url}.`;
            document.getElementById('chicago').innerHTML = chicagoCitation;

            // MLA Style
            const mlaCitation = `${data.author}. "${data.title}." <i>${data.journal}</i>, ${data.year}, ${data.url}. DOI: 10.1234/js.${data.doi}.`;
            document.getElementById('mla').innerHTML = mlaCitation;

            // Harvard Style
            const harvardCitation = `${data.author}, ${data.year}. ${data.title}. <i>${data.journal}</i>. Available at: ${data.url} (Accessed: ${new Date().toLocaleDateString()}).`;
            document.getElementById('harvard').innerHTML = harvardCitation;
        }

        function switchCitationStyle(button, style) {
            // Remove active class from all buttons
            document.querySelectorAll('.citation-tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Remove active class from all content divs
            document.querySelectorAll('.citation-content').forEach(div => {
                div.classList.remove('active');
            });
            
            // Add active class to clicked button and corresponding content
            button.classList.add('active');
            document.getElementById(style).classList.add('active');
        }

        function copyCitation() {
            // Find the active citation content
            const activeContent = document.querySelector('.citation-content.active');
            if (activeContent) {
                const text = activeContent.innerText;
                navigator.clipboard.writeText(text).then(() => {
                    const button = event.target;
                    const originalText = button.innerText;
                    button.innerText = '✓ Copied!';
                    button.style.backgroundColor = '#2D8176';
                    setTimeout(() => {
                        button.innerText = originalText;
                        button.style.backgroundColor = '';
                    }, 2000);
                });
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('citationModal');
            if (event.target == modal) {
                modal.classList.remove('show');
            }
        }
    </script>
</body>
</html>
