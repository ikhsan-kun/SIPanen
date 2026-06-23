<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SiPanen') — Solusi Alat Panen Kelapa Sawit Terbaik</title>
    <meta name="description" content="@yield('meta_description', 'SiPanen — Platform digital penjualan alat panen kelapa sawit terpercaya oleh CV. Ekiindo Tegal.')">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 1px 0 rgba(0,0,0,0.06);
            transition: box-shadow .2s;
        }
        .card-shadow {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        /* Flash animation */
        @keyframes slideInRight {
            from { opacity:0; transform:translateX(24px); }
            to   { opacity:1; transform:translateX(0); }
        }
        #flash-msg { animation: slideInRight .3s ease both; }

        /* Mobile menu */
        #mobile-menu {
            transition: max-height .3s ease, opacity .3s ease;
            max-height: 0;
            overflow: hidden;
            opacity: 0;
        }
        #mobile-menu.open {
            max-height: 400px;
            opacity: 1;
        }

        /* Pagination */
        nav[aria-label="pagination"] .page-item .page-link,
        nav[aria-label="Pagination"] span,
        nav[aria-label="Pagination"] a {
            border-radius: 8px;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-white text-gray-900 antialiased">


    {{-- Main Header --}}
    <header class="sticky-header border-b border-gray-100" id="main-header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0 group">
                    <img src="{{ asset('images/logosipanen.png') }}" alt="SiPanen Logo" class="h-10 w-auto">
                    <span class="text-xl font-bold text-primary-dark group-hover:text-primary-green transition-colors">SiPanen</span>
                </a>

                {{-- Search Bar (desktop) --}}
                <form action="{{ route('catalog') }}" method="GET" class="flex-1 max-w-sm mx-8 hidden md:block">
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input name="search" value="{{ request('search') }}"
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-green/30 focus:border-primary-green text-sm bg-gray-50 transition-all placeholder-gray-400"
                               placeholder="Cari produk..." type="text"/>
                    </div>
                </form>

                {{-- Desktop Nav --}}
                <nav class="hidden md:flex items-center space-x-1 text-sm font-semibold text-gray-600">
                    <a class="px-3 py-2 rounded-lg hover:bg-gray-50 hover:text-primary-green transition-all {{ request()->routeIs('home') ? 'text-primary-green bg-green-50' : '' }}"
                       href="{{ route('home') }}">Beranda</a>
                    <a class="px-3 py-2 rounded-lg hover:bg-gray-50 hover:text-primary-green transition-all {{ request()->routeIs('catalog') ? 'text-primary-green bg-green-50' : '' }}"
                       href="{{ route('catalog') }}">Katalog</a>
                    <a class="px-3 py-2 rounded-lg hover:bg-gray-50 hover:text-primary-green transition-all {{ request()->routeIs('about') ? 'text-primary-green bg-green-50' : '' }}"
                       href="{{ route('about') }}">Tentang Kami</a>
                    <a class="px-3 py-2 rounded-lg hover:bg-gray-50 hover:text-primary-green transition-all {{ request()->routeIs('contact') ? 'text-primary-green bg-green-50' : '' }}"
                       href="{{ route('contact') }}">Kontak</a>

                    <div class="w-px h-5 bg-gray-200 mx-2"></div>

                    @auth
                        @if(!Auth::user()->isAdmin())
                        <a href="{{ route('cart') }}" class="relative p-2.5 rounded-lg hover:bg-gray-50 hover:text-primary-green transition-all" title="Keranjang">
                            <i class="fa-solid fa-cart-shopping text-base"></i>
                            @php $cartCount = count(session()->get('cart', [])); @endphp
                            @if($cartCount > 0)
                            <span class="absolute -top-0.5 -right-0.5 bg-orange-500 text-white text-[9px] rounded-full w-4 h-4 flex items-center justify-center font-bold leading-none">{{ $cartCount }}</span>
                            @endif
                        </a>
                        @endif

                        {{-- User Dropdown --}}
                        <div class="relative" id="user-dropdown-wrap">
                            <button onclick="toggleDropdown()" id="user-btn"
                                    class="flex items-center space-x-1.5 px-3 py-2 rounded-lg hover:bg-gray-50 transition-all text-gray-700 hover:text-primary-green">
                                <div class="w-7 h-7 rounded-full bg-primary-green flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-semibold">{{ Str::limit(Auth::user()->name, 10) }}</span>
                                <i class="fa-solid fa-chevron-down text-[10px] opacity-60 transition-transform" id="dropdown-chevron"></i>
                            </button>
                            <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden z-50 py-1">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-xs font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-[11px] text-gray-500 truncate mt-0.5">{{ Auth::user()->email }}</p>
                                </div>
                                @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-gray-700 hover:bg-gray-50 hover:text-primary-green transition-colors">
                                    <i class="fa-solid fa-gauge w-4"></i> Dashboard Admin
                                </a>
                                @else
                                <a href="{{ route('orders.history') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-gray-700 hover:bg-gray-50 hover:text-primary-green transition-colors">
                                    <i class="fa-solid fa-box w-4"></i> Pesanan Saya
                                </a>
                                @endif
                                <div class="border-t border-gray-100 mt-1"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-xs text-red-600 hover:bg-red-50 transition-colors">
                                        <i class="fa-solid fa-right-from-bracket w-4"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 rounded-lg text-gray-700 hover:text-primary-green hover:bg-gray-50 transition-all font-semibold">Masuk</a>
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 bg-primary-green hover:bg-accent-green text-white rounded-lg font-semibold transition-all hover:shadow-md hover:shadow-green-500/20 hover:-translate-y-0.5">Daftar</a>
                    @endauth
                </nav>

                {{-- Mobile: Cart + Hamburger --}}
                <div class="flex items-center gap-2 md:hidden">
                    @auth
                    @if(!Auth::user()->isAdmin())
                    <a href="{{ route('cart') }}" class="relative p-2 rounded-lg text-gray-600">
                        <i class="fa-solid fa-cart-shopping text-lg"></i>
                        @php $cartCount = count(session()->get('cart', [])); @endphp
                        @if($cartCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 bg-orange-500 text-white text-[9px] rounded-full w-4 h-4 flex items-center justify-center font-bold">{{ $cartCount }}</span>
                        @endif
                    </a>
                    @endif
                    @endauth
                    <button onclick="toggleMobileMenu()" id="mobile-menu-btn"
                            class="p-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                        <i class="fa-solid fa-bars text-lg" id="mobile-menu-icon"></i>
                    </button>
                </div>

            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="md:hidden">
                <div class="border-t border-gray-100 py-3 space-y-1">
                    {{-- Mobile Search --}}
                    <form action="{{ route('catalog') }}" method="GET" class="px-2 mb-3">
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input name="search" value="{{ request('search') }}"
                                   class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-green/30"
                                   placeholder="Cari produk..." type="text"/>
                        </div>
                    </form>
                    <a href="{{ route('home') }}" class="block px-4 py-2.5 text-sm font-semibold rounded-lg {{ request()->routeIs('home') ? 'text-primary-green bg-green-50' : 'text-gray-700 hover:bg-gray-50' }}">Beranda</a>
                    <a href="{{ route('catalog') }}" class="block px-4 py-2.5 text-sm font-semibold rounded-lg {{ request()->routeIs('catalog') ? 'text-primary-green bg-green-50' : 'text-gray-700 hover:bg-gray-50' }}">Katalog</a>
                    <a href="{{ route('about') }}" class="block px-4 py-2.5 text-sm font-semibold rounded-lg {{ request()->routeIs('about') ? 'text-primary-green bg-green-50' : 'text-gray-700 hover:bg-gray-50' }}">Tentang Kami</a>
                    <a href="{{ route('contact') }}" class="block px-4 py-2.5 text-sm font-semibold rounded-lg {{ request()->routeIs('contact') ? 'text-primary-green bg-green-50' : 'text-gray-700 hover:bg-gray-50' }}">Kontak</a>
                    <div class="border-t border-gray-100 my-2"></div>
                    @auth
                        @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 rounded-lg">Dashboard Admin</a>
                        @else
                        <a href="{{ route('orders.history') }}" class="block px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 rounded-lg">Pesanan Saya</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="px-2">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-lg transition-colors">Keluar</button>
                        </form>
                    @else
                        <div class="px-2 flex gap-2">
                            <a href="{{ route('login') }}" class="flex-1 text-center py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-700">Masuk</a>
                            <a href="{{ route('register') }}" class="flex-1 text-center py-2.5 bg-primary-green text-white rounded-xl text-sm font-semibold">Daftar</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    {{-- Flash Messages --}}
    @if(session()->hasAny(['success','error','info','warning']))
    <div id="flash-msg" class="fixed top-20 right-4 z-[200] max-w-sm w-full">
        @if(session('success'))
        <div class="flex items-start gap-3 bg-white border-l-4 border-green-500 text-gray-800 px-5 py-4 rounded-xl shadow-xl shadow-green-500/10">
            <i class="fa-solid fa-circle-check mt-0.5 flex-shrink-0 text-green-500"></i>
            <span class="text-sm font-medium flex-1">{{ session('success') }}</span>
            <button onclick="document.getElementById('flash-msg').remove()" class="opacity-50 hover:opacity-100 text-gray-500 flex-shrink-0"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @elseif(session('error'))
        <div class="flex items-start gap-3 bg-white border-l-4 border-red-500 text-gray-800 px-5 py-4 rounded-xl shadow-xl shadow-red-500/10">
            <i class="fa-solid fa-circle-exclamation mt-0.5 flex-shrink-0 text-red-500"></i>
            <span class="text-sm font-medium flex-1">{{ session('error') }}</span>
            <button onclick="document.getElementById('flash-msg').remove()" class="opacity-50 hover:opacity-100 text-gray-500 flex-shrink-0"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @elseif(session('info'))
        <div class="flex items-start gap-3 bg-white border-l-4 border-blue-500 text-gray-800 px-5 py-4 rounded-xl shadow-xl">
            <i class="fa-solid fa-circle-info mt-0.5 flex-shrink-0 text-blue-500"></i>
            <span class="text-sm font-medium flex-1">{{ session('info') }}</span>
            <button onclick="document.getElementById('flash-msg').remove()" class="opacity-50 hover:opacity-100 text-gray-500 flex-shrink-0"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @elseif(session('warning'))
        <div class="flex items-start gap-3 bg-white border-l-4 border-amber-500 text-gray-800 px-5 py-4 rounded-xl shadow-xl">
            <i class="fa-solid fa-triangle-exclamation mt-0.5 flex-shrink-0 text-amber-500"></i>
            <span class="text-sm font-medium flex-1">{{ session('warning') }}</span>
            <button onclick="document.getElementById('flash-msg').remove()" class="opacity-50 hover:opacity-100 text-gray-500 flex-shrink-0"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @endif
    </div>
    <script>
        setTimeout(() => {
            const el = document.getElementById('flash-msg');
            if (el) {
                el.style.transition = 'opacity .4s, transform .4s';
                el.style.opacity = '0';
                el.style.transform = 'translateX(20px)';
                setTimeout(() => el?.remove(), 400);
            }
        }, 5000);
    </script>
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-primary-dark text-white" data-purpose="footer">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">

                {{-- Brand --}}
                <div class="md:col-span-1">
                    <div class="flex items-center mb-4">
                        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                            <img src="{{ asset('images/logosipanen.png') }}" alt="SiPanen Logo" class="h-10 w-auto brightness-200">
                            <span class="text-xl font-bold text-white group-hover:text-green-300 transition-colors">SiPanen</span>
                        </a>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed mb-5">
                        Platform digital penjualan alat panen kelapa sawit terpercaya. Produk berkualitas langsung dari CV. Ekiindo Tegal.
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="#" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors" title="Facebook">
                            <i class="fa-brands fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors" title="Instagram">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-green-600 flex items-center justify-center transition-colors" title="WhatsApp">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                        </a>
                    </div>
                </div>

                {{-- Produk --}}
                <div>
                    <h4 class="font-bold mb-4 text-sm text-white">Produk</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a class="hover:text-white transition-colors" href="{{ route('catalog', ['category' => 'egrek']) }}">Egrek Sawit</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ route('catalog', ['category' => 'dodos']) }}">Dodos Sawit</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ route('catalog', ['category' => 'telescopic_pole']) }}">Gagang Teleskopik</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ route('catalog') }}">Semua Produk</a></li>
                    </ul>
                </div>

                {{-- Perusahaan --}}
                <div>
                    <h4 class="font-bold mb-4 text-sm text-white">Perusahaan</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a class="hover:text-white transition-colors" href="{{ route('about') }}">Tentang Kami</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ route('contact') }}">Kontak</a></li>
                        @auth
                        <li><a class="hover:text-white transition-colors" href="{{ route('orders.history') }}">Pesanan Saya</a></li>
                        @else
                        <li><a class="hover:text-white transition-colors" href="{{ route('login') }}">Masuk</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ route('register') }}">Daftar</a></li>
                        @endauth
                    </ul>
                </div>

                {{-- Kontak --}}
                <div>
                    <h4 class="font-bold mb-4 text-sm text-white">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-location-dot mt-0.5 text-accent-green flex-shrink-0"></i>
                            <span>Jl. Raya Tegal No. 123, Kota Tegal, Jawa Tengah 52113</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-phone text-accent-green flex-shrink-0"></i>
                            <span>+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-accent-green flex-shrink-0"></i>
                            <span>info@ekiindo.com</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-clock text-accent-green flex-shrink-0"></i>
                            <span>Senin–Sabtu: 08.00–17.00 WIB</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Footer Bottom --}}
            <div class="border-t border-white/10 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-gray-500">
                <p>© {{ date('Y') }} CV. Ekiindo Tegal. Hak cipta dilindungi undang-undang.</p>
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-lock text-green-500"></i> SSL Secured</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-shield-halved text-green-500"></i> PCI-DSS</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // User dropdown
        function toggleDropdown() {
            const dd = document.getElementById('user-dropdown');
            const ch = document.getElementById('dropdown-chevron');
            const isHidden = dd?.classList.contains('hidden');
            dd?.classList.toggle('hidden');
            if (ch) ch.style.transform = isHidden ? 'rotate(180deg)' : '';
        }
        document.addEventListener('click', function(e) {
            const wrap = document.getElementById('user-dropdown-wrap');
            if (wrap && !wrap.contains(e.target)) {
                document.getElementById('user-dropdown')?.classList.add('hidden');
                const ch = document.getElementById('dropdown-chevron');
                if (ch) ch.style.transform = '';
            }
        });

        // Mobile menu
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('mobile-menu-icon');
            const isOpen = menu?.classList.contains('open');
            menu?.classList.toggle('open');
            if (icon) {
                icon.className = isOpen ? 'fa-solid fa-bars text-lg' : 'fa-solid fa-xmark text-lg';
            }
        }

        // Global SweetAlert2 Handlers
        window.alert = function(message) {
            Swal.fire({
                title: 'Informasi',
                text: message,
                icon: 'info',
                confirmButtonColor: '#16a34a',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-5 py-2.5 text-sm font-bold text-white'
                }
            });
        };

        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (form.hasAttribute('data-confirm')) {
                e.preventDefault();
                const message = form.getAttribute('data-confirm');
                const confirmText = form.getAttribute('data-confirm-btn') || 'Ya, Lanjutkan';
                const cancelText = form.getAttribute('data-cancel-btn') || 'Batal';
                const confirmColor = form.getAttribute('data-confirm-color') || '#16a34a';

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: confirmColor,
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: confirmText,
                    cancelButtonText: cancelText,
                    customClass: {
                        popup: 'rounded-2xl shadow-xl border border-slate-100',
                        confirmButton: 'rounded-xl px-5 py-2.5 text-sm font-bold text-white',
                        cancelButton: 'rounded-xl px-5 py-2.5 text-sm font-bold text-white'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const originalConfirm = form.getAttribute('data-confirm');
                        form.removeAttribute('data-confirm');
                        form.submit();
                        form.setAttribute('data-confirm', originalConfirm);
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
