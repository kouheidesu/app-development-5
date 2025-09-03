@php
$siteName = 'Aurora Studio';
$tagline = 'Minimal, smart, and a little bit magical.';
$navLinks = [
['label' => 'Work', 'href' => '#work'],
['label' => 'About', 'href' => '#about'],
['label' => 'Contact', 'href' => '#contact'],
];

// Very simple flash message demo (no storage).
$flash = null;
if (request()->isMethod('post')) {
$email = trim(request('email', ''));
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
$flash = "Thanks! We\'ll keep you posted: {$email}";
} else {
$flash = 'Please enter a valid email address.';
}
}
@endphp

<!DOCTYPE html>
<html lang="ja" class="scroll-smooth">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $siteName }} — {{ $tagline }}</title>
    <meta name="description" content="{{ $siteName }} | {{ $tagline }}" />
    <meta name="theme-color" content="#0ea5e9" />

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind (configure first, then load) -->
    <script>
        window.__theme = localStorage.getItem('theme') || 'system';
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const reallyDark = (window.__theme === 'dark') || (window.__theme === 'system' && prefersDark);
        if (reallyDark) document.documentElement.classList.add('dark');

        // Tailwind config for CDN build
        window.tailwind = {
            config: {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif']
                        },
                        colors: {
                            brand: {
                                50: '#ecfeff',
                                100: '#cffafe',
                                200: '#a5f3fc',
                                300: '#67e8f9',
                                400: '#22d3ee',
                                500: '#06b6d4',
                                600: '#0891b2',
                                700: '#0e7490',
                                800: '#155e75',
                                900: '#164e63',
                                950: '#083344'
                            }
                        },
                        boxShadow: {
                            glow: '0 10px 30px rgba(14,116,144,.25)'
                        }
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- A pinch of custom CSS for subtle texture -->
    <style>
        :root {
            color-scheme: light dark;
        }

        .noise {
            position: fixed;
            inset: 0;
            pointer-events: none;
            opacity: .04;
            mix-blend-mode: overlay;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'120\' height=\'120\'><filter id=\'n\'><feTurbulence type=\'fractalNoise\' baseFrequency=\'.8\' numOctaves=\'4\'/></filter><rect width=\'100%\' height=\'100%\' filter=\'url(%23n)\'/></svg>');
        }

        .gradient-blob {
            position: absolute;
            inset: auto auto -20% -10%;
            width: 60vw;
            height: 60vw;
            filter: blur(60px);
            background: radial-gradient(40% 40% at 30% 30%, rgba(34, 211, 238, .35), transparent 70%),
                radial-gradient(40% 40% at 70% 60%, rgba(14, 116, 144, .35), transparent 70%),
                radial-gradient(30% 30% at 50% 80%, rgba(6, 182, 212, .45), transparent 70%);
            transform: rotate(-8deg);
        }
    </style>

    <!-- React & Babel (JSX in one file) -->
    <script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
</head>

<body class="bg-white text-slate-900 dark:bg-slate-950 dark:text-slate-100 antialiased">
    <div class="noise"></div>

    <!-- Header / Nav -->
    <header class="relative">
        <div class="gradient-blob"></div>
        <nav class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
            <a href="#" class="group inline-flex items-center gap-3">
                <span class="h-9 w-9 grid place-items-center rounded-2xl bg-gradient-to-br from-brand-400 via-sky-400 to-brand-600 shadow-glow transition-transform group-hover:scale-105">
                    <!-- Spark icon -->
                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5 text-white">
                        <path d="M12 2l2.2 5.7L20 10l-5.8 2.3L12 18l-2.2-5.7L4 10l5.8-2.3L12 2z" fill="currentColor" />
                    </svg>
                </span>
                <span class="text-lg font-extrabold tracking-tight">{{ $siteName }}</span>
            </a>

            <div class="hidden md:flex items-center gap-6">
                @foreach ($navLinks as $link)
                <a href="{{ $link['href'] }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white transition">{{ $link['label'] }}</a>
                @endforeach
                <button id="themeToggle" class="relative rounded-xl px-3 py-2 text-sm font-semibold bg-slate-900 text-white dark:bg-white dark:text-slate-900 shadow hover:shadow-glow transition">
                    <span class="inline-flex items-center gap-2">
                        <svg id="sun" class="h-4 w-4 hidden dark:inline" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="4" />
                            <path d="M12 2v2m0 16v2M4 12H2m20 0h-2M5 5l1.5 1.5M17.5 17.5 19 19M5 19l1.5-1.5M17.5 6.5 19 5" />
                        </svg>
                        <svg id="moon" class="h-4 w-4 dark:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
                        </svg>
                        <span class="hidden sm:inline">Theme</span>
                    </span>
                </button>
            </div>
        </nav>
    </header>

    <!-- Hero -->
    <section class="relative isolate">
        <div class="max-w-4xl mx-auto px-6 py-16 md:py-24 text-center">
            <div class="inline-flex items-center gap-2 rounded-full border border-slate-200/70 dark:border-slate-800 bg-white/60 dark:bg-slate-900/60 backdrop-blur px-3 py-1 text-xs text-slate-600 dark:text-slate-300">
                <span class="h-2 w-2 rounded-full bg-emerald-400"></span> Now shipping ideas
            </div>
            <h1 class="mt-6 text-4xl md:text-6xl font-extrabold leading-tight tracking-tight">
                Design that feels <span class="bg-gradient-to-tr from-brand-400 to-sky-600 bg-clip-text text-transparent">effortless</span>
            </h1>
            <p class="mt-4 text-base md:text-lg text-slate-600 dark:text-slate-300">
                {{ $tagline }} Build interactive cards, filter with tags, and enjoy smooth micro‑interactions—all in a single Blade file.
            </p>
            <div class="mt-8 flex items-center justify-center gap-3">
                <a href="#work" class="rounded-xl px-5 py-3 text-sm font-semibold bg-slate-900 text-white dark:bg-white dark:text-slate-900 shadow hover:shadow-glow transition">See Work</a>
                <a href="#contact" class="rounded-xl px-5 py-3 text-sm font-semibold border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900/40 transition">Contact</a>
            </div>
        </div>
    </section>

    <!-- React mount point -->
    <main id="work" class="max-w-7xl mx-auto px-6 pb-24">
        <div id="app" class="mt-4"></div>
    </main>

    <!-- About -->
    <section id="about" class="max-w-5xl mx-auto px-6 pb-24">
        <div class="grid md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <h2 class="text-xl font-bold">About</h2>
            </div>
            <div class="md:col-span-2 text-slate-600 dark:text-slate-300 leading-relaxed">
                <p>
                    Aurora Studio is a fictional creative lab. This page demonstrates how to blend <strong>Blade + PHP</strong>, <strong>Tailwind CSS</strong>, and <strong>React</strong> in a single file for quick prototypes.
                    The grid below is rendered by React with a tag filter, search, and lightweight state persistence.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact (simple PHP form demo) -->
    <section id="contact" class="max-w-5xl mx-auto px-6 pb-24">
        <div class="grid md:grid-cols-3 gap-6 items-start">
            <div>
                <h2 class="text-xl font-bold">Stay in the loop</h2>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Subscribe for occasional updates. (Demo only)</p>
            </div>
            <div class="md:col-span-2">
                @if($flash)
                <div class="mb-4 rounded-xl border border-emerald-300/40 bg-emerald-50/50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-200 px-4 py-3">{{ $flash }}</div>
                @endif
                <form method="post" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <input required name="email" type="email" placeholder="you@example.com" class="w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/60 px-4 py-3 outline-none focus:ring-2 focus:ring-brand-400/60" />
                    <button class="rounded-xl px-5 py-3 text-sm font-semibold bg-gradient-to-br from-brand-400 to-sky-600 text-white shadow hover:shadow-glow transition">Subscribe</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-6 py-10 text-sm text-slate-500 dark:text-slate-400 flex items-center justify-between">
            <p>&copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.</p>
            <a href="#" class="hover:text-slate-900 dark:hover:text-white">Back to top ↑</a>
        </div>
    </footer>

    <!-- Server-provided seed data for React -->
    @php
    $projects = [
    [
    'title' => 'Shiro—Calm Finance Dashboard',
    'tag' => 'Web',
    'desc' => 'A minimalist personal finance dashboard with soft glass UI and keyboard shortcuts.',
    'link' => '#',
    ],
    [
    'title' => 'Gekkou—Night Photography Edit Pack',
    'tag' => 'App',
    'desc' => 'Preset toolkit that turns city lights into dreamy bokeh in one click.',
    'link' => '#',
    ],
    [
    'title' => 'Kumo—AI Writing Companion',
    'tag' => 'AI',
    'desc' => 'Context-aware drafts and tone suggestions with offline-first sync.',
    'link' => '#',
    ],
    [
    'title' => 'Mizu—Wellness Micro‑habits',
    'tag' => 'App',
    'desc' => 'Tiny daily rituals with delightful motion and haptic feedback.',
    'link' => '#',
    ],
    [
    'title' => 'Sora—3D Web Playground',
    'tag' => 'Web',
    'desc' => 'Interactive scenes powered by WebGL; zero-install demo environments.',
    'link' => '#',
    ],
    [
    'title' => 'Hikari—Research Reader',
    'tag' => 'AI',
    'desc' => 'Summarize papers, create highlights, and quiz yourself instantly.',
    'link' => '#',
    ],
    ];
    @endphp
    <script id="seed" type="application/json">
        {
            !!json_encode($projects, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!
        }
    </script>

    <!-- App Script (JSX compiled by Babel in the browser) -->
    <script type="text/babel" data-presets="react">
        const { useEffect, useMemo, useState } = React;

      function clsx(...xs){ return xs.filter(Boolean).join(' '); }

      function Tag({label, active, onClick}){
        return (
          <button onClick={onClick}
            className={clsx(
              'px-3 py-1 rounded-full text-xs font-semibold border transition shadow-sm',
              active ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900 border-transparent' : 'border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900/40'
            )}
          >{label}</button>
        );
      }

      function Card({item}){
        return (
          <a href={item.link} className="group flex flex-col gap-3 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/70 dark:bg-slate-900/50 backdrop-blur p-5 hover:shadow-glow transition">
            <div className="flex items-center justify-between">
              <span className="text-xs font-bold tracking-wide text-slate-500 dark:text-slate-400">{item.tag}</span>
              <span className="inline-flex items-center gap-1 text-xs text-slate-500 group-hover:text-slate-900 dark:group-hover:text-white">
                View
                <svg className="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M7 17L17 7"/><path d="M7 7h10v10"/></svg>
              </span>
            </div>
            <h3 className="text-lg font-bold leading-snug text-slate-900 dark:text-white">{item.title}</h3>
            <p className="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">{item.desc}</p>
          </a>
        );
      }

      function useLocalState(key, initial){
        const [state, setState] = useState(() => {
          try { const v = localStorage.getItem(key); return v ? JSON.parse(v) : initial; } catch { return initial; }
        });
        useEffect(() => { try { localStorage.setItem(key, JSON.stringify(state)); } catch {} }, [key, state]);
        return [state, setState];
      }

      function ShowcaseApp(){
        const seed = JSON.parse(document.getElementById('seed').textContent);
        const [query, setQuery] = useLocalState('aurora.query', '');
        const [tag, setTag] = useLocalState('aurora.tag', 'All');

        const tags = ['All', 'Web', 'App', 'AI'];

        const items = useMemo(() => seed.filter(p => {
          const okTag = tag === 'All' || p.tag === tag;
          const q = query.trim().toLowerCase();
          const okQ  = !q || p.title.toLowerCase().includes(q) || p.desc.toLowerCase().includes(q);
          return okTag && okQ;
        }), [seed, tag, query]);

        return (
          <div className="relative">
            <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
              <h2 className="text-2xl font-extrabold">Featured Work</h2>
              <div className="flex items-center gap-2">
                <div className="flex gap-2 bg-white/70 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-xl p-1">
                  {tags.map(t => (
                    <Tag key={t} label={t} active={t===tag} onClick={() => setTag(t)} />
                  ))}
                </div>
                <div className="relative">
                  <input value={query} onChange={e=>setQuery(e.target.value)} placeholder="Search…" className="w-52 sm:w-64 rounded-xl border border-slate-200 dark:border-slate-800 bg-white/70 dark:bg-slate-900/50 px-4 py-2.5 pl-9 text-sm outline-none focus:ring-2 focus:ring-brand-400/60"/>
                  <svg className="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/></svg>
                </div>
              </div>
            </div>

            <div className="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
              {items.map((item, i) => <Card key={i} item={item} />)}
              {items.length === 0 && (
                <div className="col-span-full rounded-2xl border border-dashed border-slate-300 dark:border-slate-700 p-10 text-center text-slate-500 dark:text-slate-400">No results. Try another tag or search.</div>
              )}
            </div>
          </div>
        );
      }

      const root = ReactDOM.createRoot(document.getElementById('app'));
      root.render(<ShowcaseApp/>);
    </script>

    <!-- Theme toggle script -->
    <script>
        document.getElementById('themeToggle')?.addEventListener('click', () => {
            const el = document.documentElement;
            const nowDark = !el.classList.contains('dark');
            el.classList.toggle('dark', nowDark);
            localStorage.setItem('theme', nowDark ? 'dark' : 'light');
        });
    </script>
</body>

</html>
