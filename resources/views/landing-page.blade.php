<!DOCTYPE html>
<html lang="en" class="h-full antialiased" x-data="cubeLinkPage(@js($featuredSlides))" :class="mode === 'dark' ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landingPage->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --cubelink-bg: {{ $landingPage->background_color }};
            --cubelink-fg: {{ $landingPage->text_color }};
            --cubelink-card: color-mix(in srgb, var(--cubelink-bg) 82%, #ffffff 18%);
            --cubelink-border: color-mix(in srgb, var(--cubelink-fg) 18%, transparent);
            --cubelink-accent: color-mix(in srgb, var(--cubelink-fg) 40%, #00b4d8 60%);
        }

        .dark {
            --cubelink-bg: #0b1220;
            --cubelink-fg: #ecfeff;
            --cubelink-card: #111a2d;
            --cubelink-border: rgba(236, 254, 255, 0.16);
            --cubelink-accent: #22d3ee;
        }
    </style>
</head>
<body class="bg-(--cubelink-bg) selection:bg-(--cubelink-accent) min-h-full text-(--cubelink-fg) selection:text-slate-900">
    <div class="relative overflow-hidden">
        <div class="-z-10 absolute inset-0 pointer-events-none">
            <div class="top-0 -left-24 absolute bg-cyan-300/30 blur-3xl rounded-full w-72 h-72"></div>
            <div class="top-36 -right-20 absolute bg-emerald-300/20 blur-3xl rounded-full w-80 h-80"></div>
            <div class="bottom-0 left-1/2 absolute bg-sky-400/20 blur-3xl rounded-full w-64 h-64 -translate-x-1/2"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgba(255,255,255,.08)_1px,transparent_0)] bg-size-[26px_26px]"></div>
        </div>

        <main class="mx-auto px-4 sm:px-6 py-10 max-w-3xl">
            <div class="flex justify-between items-center bg-(--cubelink-card)/80 backdrop-blur-sm mb-7 px-4 py-3 border border-(--cubelink-border) rounded-2xl">
                <p class="opacity-80 font-display text-sm uppercase tracking-[0.16em]">CubeLink</p>
                <button
                    type="button"
                    class="px-3 py-1.5 border border-(--cubelink-border) rounded-xl font-semibold text-xs tracking-wide hover:scale-[1.02] transition"
                    @click="toggleMode()"
                >
                    <span x-text="mode === 'dark' ? 'Switch Light' : 'Switch Dark'"></span>
                </button>
            </div>

            <section class="bg-(--cubelink-card)/85 shadow-2xl shadow-cyan-900/10 backdrop-blur-sm p-6 sm:p-8 border border-(--cubelink-border) rounded-3xl">
                <div class="flex items-start sm:items-center gap-4 mb-7">
                    @if ($landingPage->profile_picture)
                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($landingPage->profile_picture) }}"
                            alt="{{ $landingPage->title }}"
                            class="rounded-2xl ring-(--cubelink-border) ring-2 w-16 h-16 object-cover"
                            onerror="this.style.display='none'"
                        >
                    @endif
                    <div>
                        <h1 class="font-display font-bold text-3xl sm:text-4xl leading-tight">{{ $landingPage->title }}</h1>
                        <p class="opacity-80 mt-1 text-sm sm:text-base">{{ $landingPage->description }}</p>
                    </div>
                </div>

                <section class="mb-7" aria-label="Featured">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="opacity-70 font-display text-xs uppercase tracking-[0.2em]">Featured</h2>
                        <div class="flex gap-2" x-show="slides.length > 1">
                            <button type="button" @click="prev()" class="px-2.5 py-1 border border-(--cubelink-border) rounded-lg text-xs">Prev</button>
                            <button type="button" @click="next()" class="px-2.5 py-1 border border-(--cubelink-border) rounded-lg text-xs">Next</button>
                        </div>
                    </div>

                    <div class="relative bg-linear-to-br from-slate-900/70 via-cyan-950/40 to-slate-800/70 p-5 border border-(--cubelink-border) rounded-2xl overflow-hidden text-cyan-50">
                        <template x-if="slides.length === 0">
                            <p class="opacity-80 text-sm">Add active links to show featured items.</p>
                        </template>

                        <template x-for="(slide, index) in slides" :key="slide.id">
                            <a
                                x-show="current === index"
                                x-transition.opacity.duration.250ms
                                class="block"
                                :href="slide.href"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <p class="mb-2 text-cyan-200/80 text-xs uppercase tracking-[0.18em]">Spotlight Link</p>
                                <h3 class="font-display font-bold text-2xl" x-text="slide.title"></h3>
                                <p class="mt-1 text-cyan-100/80 text-sm" x-text="slide.subtitle"></p>
                                <p class="mt-4 font-semibold text-sm">Tap to open</p>
                            </a>
                        </template>
                    </div>
                </section>

                <section aria-label="Links" class="gap-3 grid">
                    @foreach ($landingPage->links as $link)
                        <a
                            href="{{ route('links.redirect', ['linkId' => $link->id]) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="group flex justify-between items-center bg-white/5 hover:bg-white/10 px-4 py-3 border border-(--cubelink-border) rounded-2xl transition hover:-translate-y-0.5 duration-200"
                        >
                            <span class="font-semibold">{{ $link->label }}</span>
                            <span class="opacity-70 text-xs transition group-hover:translate-x-1">Open</span>
                        </a>
                    @endforeach
                </section>
            </section>
        </main>
    </div>

    @if ($landingPage->custom_css)
        <style>{!! $landingPage->custom_css !!}</style>
    @endif

    <script>
        function cubeLinkPage(slides) {
            return {
                slides,
                current: 0,
                mode: 'light',
                timer: null,
                init() {
                    this.mode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';

                    if (this.slides.length > 1) {
                        this.timer = setInterval(() => this.next(), 4200);
                    }
                },
                next() {
                    if (!this.slides.length) {
                        return;
                    }

                    this.current = (this.current + 1) % this.slides.length;
                },
                prev() {
                    if (!this.slides.length) {
                        return;
                    }

                    this.current = (this.current - 1 + this.slides.length) % this.slides.length;
                },
                toggleMode() {
                    this.mode = this.mode === 'dark' ? 'light' : 'dark';
                },
            };
        }
    </script>
</body>
</html>
