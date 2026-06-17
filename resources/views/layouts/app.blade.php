<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SiPanen') — Solusi Alat Panen Kelapa Sawit Terbaik</title>
    <meta name="description" content="@yield('meta_description', 'SiPanen — Platform digital penjualan alat panen kelapa sawit terpercaya oleh CV. Ekiindo Tegal.')">
    
    <!-- FontAwesome & Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .card-shadow {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        @keyframes slideIn { 
            from { opacity:0; transform:translateX(20px); } 
            to { opacity:1; transform:translateX(0); } 
        }
    </style>
    @stack('styles')
</head>
<body class="bg-white text-gray-900 antialiased font-sans">

    {{-- Top Announcement Bar --}}
    <div class="bg-primary-dark text-white text-center py-2 text-xs font-medium" data-purpose="announcement">
        Modern is premium e-commerce marketplace website
    </div>

    {{-- Main Header --}}
    <header class="sticky-header border-b border-gray-100" data-purpose="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center space-x-2 flex-shrink-0" data-purpose="logo">
                <img alt="SiPanen Logo" class="h-8 w-auto" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAeCDJmAzJIpbqolbDZmub5taHkKMzKt_wek4FQjknuhSIS00SmRxq9YHj9uroaXxPEUsVLdRWlPInxxeSD5I9HH_oXImwZhlwIAx8Z7MAk425OCKOLY0kaPp4L1P4LtweWqFF40bAion4WHdvCwZHJqxDLukjrbn-wFDz5mWMqkcCw2R12CZLhMRNrjtbZqtm5AtvCyTIMLVqgDDy2Dbm_cxmg-sVxdTBpkfrxrSQI3FjskyF4BIbop1yxC_CzrXz-eN8leGzXWUc"/>
                <span class="text-2xl font-bold text-primary-dark">SiPanen</span>
            </a>

            {{-- Search Bar --}}
            <form action="{{ route('catalog') }}" method="GET" class="flex-1 max-w-md mx-8 hidden sm:block">
                <div class="relative">
                    <input name="search" value="{{ request('search') }}" class="w-full pl-4 pr-12 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-primary-green focus:border-primary-green text-sm" placeholder="Search" type="text"/>
                    <button type="submit" class="absolute right-0 top-0 h-full px-4 bg-primary-dark text-white rounded-r-md hover:bg-primary-green transition">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Navigation Links --}}
            <nav class="flex items-center space-x-6 text-sm font-semibold text-gray-700">
                <a class="hover:text-primary-green transition-colors {{ request()->routeIs('catalog') ? 'text-primary-green' : '' }}" href="{{ route('catalog') }}">Katalog</a>
                <a class="hover:text-primary-green transition-colors {{ request()->routeIs('about') ? 'text-primary-green' : '' }}" href="{{ route('about') }}">Tentang Kami</a>
                <a class="hover:text-primary-green transition-colors {{ request()->routeIs('contact') ? 'text-primary-green' : '' }}" href="{{ route('contact') }}">Kontak</a>
                
                @auth
                    @if(!Auth::user()->isAdmin())
                        <div class="h-4 w-px bg-gray-300"></div>
                        <a href="{{ route('cart') }}" class="relative hover:text-primary-green transition-colors" title="Keranjang">
                            <i class="fa-solid fa-cart-shopping text-base"></i>
                            @php $cartCount = count(session()->get('cart', [])); @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-2.5 -right-2.5 bg-orange-500 text-white text-[9px] rounded-full w-4 h-4 flex items-center justify-center font-bold">{{ $cartCount }}</span>
                            @endif
                        </a>
                    @endif
                    <div class="h-4 w-px bg-gray-300"></div>
                    <div class="relative" id="user-dropdown-wrap">
                        <button onclick="toggleDropdown()" class="flex items-center space-x-1 hover:text-primary-green transition-colors">
                            <span class="text-sm font-semibold">{{ Str::limit(Auth::user()->name, 12) }}</span>
                            <i class="fa-solid fa-chevron-down text-[10px] opacity-75"></i>
                        </button>
                        <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden z-50">
                            <div class="px-4 py-2 border-b border-gray-100 bg-gray-50/50">
                                <p class="text-xs font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 hover:text-primary-green transition"><i class="fa-solid fa-gauge mr-2"></i> Dashboard Admin</a>
                            @else
                                <a href="{{ route('orders.history') }}" class="block px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 hover:text-primary-green transition"><i class="fa-solid fa-box mr-2"></i> Pesanan Saya</a>
                            @endif
                            <hr class="border-gray-100">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition"><i class="fa-solid fa-right-from-bracket mr-2"></i> Keluar</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="h-4 w-px bg-gray-300"></div>
                    <a class="hover:text-primary-green transition-colors" href="{{ route('login') }}">Masuk</a>
                    <a class="hover:text-primary-green transition-colors" href="{{ route('register') }}">Daftar</a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- Flash Messages --}}
    @if(session()->hasAny(['success','error','info']))
    <div id="flash-msg" class="fixed top-20 right-4 z-50 max-w-sm w-full" style="animation:slideIn .3s ease">
        @if(session('success'))
        <div class="flex items-start gap-3 bg-primary-green text-white px-5 py-4 rounded-xl shadow-lg">
            <i class="fa-solid fa-circle-check mt-0.5 flex-shrink-0"></i>
            <span class="text-sm font-medium flex-1">{{ session('success') }}</span>
            <button onclick="document.getElementById('flash-msg').remove()" class="opacity-70 hover:opacity-100 flex-shrink-0"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @elseif(session('error'))
        <div class="flex items-start gap-3 bg-red-600 text-white px-5 py-4 rounded-xl shadow-lg">
            <i class="fa-solid fa-circle-exclamation mt-0.5 flex-shrink-0"></i>
            <span class="text-sm font-medium flex-1">{{ session('error') }}</span>
            <button onclick="document.getElementById('flash-msg').remove()" class="opacity-70 hover:opacity-100 flex-shrink-0"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @elseif(session('info'))
        <div class="flex items-start gap-3 bg-blue-600 text-white px-5 py-4 rounded-xl shadow-lg">
            <i class="fa-solid fa-circle-info mt-0.5 flex-shrink-0"></i>
            <span class="text-sm font-medium flex-1">{{ session('info') }}</span>
            <button onclick="document.getElementById('flash-msg').remove()" class="opacity-70 hover:opacity-100 flex-shrink-0"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @endif
    </div>
    <script>
        setTimeout(() => {
            const e = document.getElementById('flash-msg');
            if(e) {
                e.style.transition = 'opacity .4s';
                e.style.opacity = '0';
                setTimeout(() => e.remove(), 400);
            }
        }, 5000);
    </script>
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Main Footer --}}
    <footer class="bg-primary-dark text-white pt-20 pb-10" data-purpose="footer">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                
                {{-- Brand Section --}}
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center space-x-2 mb-6" data-purpose="logo">
                        <img alt="SiPanen Logo" class="h-8 w-auto brightness-200" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAeCDJmAzJIpbqolbDZmub5taHkKMzKt_wek4FQjknuhSIS00SmRxq9YHj9uroaXxPEUsVLdRWlPInxxeSD5I9HH_oXImwZhlwIAx8Z7MAk425OCKOLY0kaPp4L1P4LtweWqFF40bAion4WHdvCwZHJqxDLukjrbn-wFDz5mWMqkcCw2R12CZLhMRNrjtbZqtm5AtvCyTIMLVqgDDy2Dbm_cxmg-sVxdTBpkfrxrSQI3FjskyF4BIbop1yxC_CzrXz-eN8leGzXWUc"/>
                        <span class="text-2xl font-bold">SiPanen</span>
                    </div>
                    <p class="text-sm text-gray-300 leading-relaxed">
                        SiPanen, and premium e-commerce marketplace website home careen hon our palm oil harvesting tools.
                    </p>
                </div>

                {{-- Produk Links --}}
                <div>
                    <h4 class="font-bold mb-6 text-sm uppercase tracking-wider text-green-300">Produk</h4>
                    <ul class="space-y-4 text-sm text-gray-300">
                        <li><a class="hover:text-white transition-colors" href="{{ route('catalog') }}">Produk</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ route('contact') }}">Kontak</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ route('about') }}">Tentang Kami</a></li>
                        <li><a class="hover:text-white transition-colors" href="#">Menuar Kamoan</a></li>
                    </ul>
                </div>

                {{-- Kontak Links --}}
                <div>
                    <h4 class="font-bold mb-6 text-sm uppercase tracking-wider text-green-300">Kontak</h4>
                    <ul class="space-y-4 text-sm text-gray-300">
                        <li><a class="hover:text-white transition-colors" href="{{ route('contact') }}">Kontak</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ route('about') }}">Tentang Kami</a></li>
                        <li><a class="hover:text-white transition-colors" href="#">Dnnaon-Soarja</a></li>
                    </ul>
                </div>

                {{-- Social Media --}}
                <div>
                    <h4 class="font-bold mb-6 text-sm uppercase tracking-wider text-green-300">Social / Media</h4>
                    <ul class="space-y-4 text-sm text-gray-300">
                        <li class="flex items-center space-x-2">
                            <svg class="h-5 w-5" fill="currentColor" viewbox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"></path></svg>
                            <span>SiPanen</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="h-5 w-5" fill="currentColor" viewbox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path></svg>
                            <span>SiPanen</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            {{-- Footer Bottom --}}
            <div class="border-t border-gray-700 pt-8 flex justify-between items-center text-xs text-gray-400">
                <p>Copyright © {{ date('Y') }} SiPanen Ilonscasem</p>
                <p>palm oil harvesting com</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleDropdown() {
            document.getElementById('user-dropdown')?.classList.toggle('hidden');
        }
        document.addEventListener('click', function(e) {
            const wrap = document.getElementById('user-dropdown-wrap');
            if (wrap && !wrap.contains(e.target)) {
                document.getElementById('user-dropdown')?.classList.add('hidden');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
