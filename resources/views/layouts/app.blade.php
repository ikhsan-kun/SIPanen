<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SiPanen') — CV. Ekiindo Tegal</title>
    <meta name="description" content="@yield('meta_description', 'SiPanen — Platform digital penjualan alat panen kelapa sawit terpercaya oleh CV. Ekiindo Tegal.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased" style="font-family: 'Plus Jakarta Sans', sans-serif;">

<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div id="nav-inner" class="transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform" style="background:linear-gradient(135deg,#16a34a,#15803d)">
                        <i class="fa-solid fa-seedling text-white text-base"></i>
                    </div>
                    <div>
                        <span class="text-lg font-bold nav-logo-text">SiPanen</span>
                        <p class="text-xs nav-sub-text">CV. Ekiindo Tegal</p>
                    </div>
                </a>
                <div class="hidden lg:flex items-center gap-1">
                    @foreach([['home','Beranda'],['catalog','Katalog'],['about','Tentang Kami'],['contact','Kontak']] as [$r,$l])
                    <a href="{{ route($r) }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 nav-link {{ request()->routeIs($r) ? 'nav-link-active' : '' }}">{{ $l }}</a>
                    @endforeach
                </div>
                <div class="hidden lg:flex items-center gap-3">
                    @auth
                        @if(!Auth::user()->isAdmin())
                        <a href="{{ route('cart') }}" class="relative p-2.5 rounded-xl nav-icon-btn transition-all hover:scale-105">
                            <i class="fa-solid fa-cart-shopping text-lg"></i>
                            @php $cartCount = count(session()->get('cart',[])); @endphp
                            @if($cartCount > 0)
                            <span class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-orange-500 text-white text-xs rounded-full flex items-center justify-center font-bold">{{ $cartCount }}</span>
                            @endif
                        </a>
                        @endif
                        <div class="relative" id="user-dropdown-wrap">
                            <button onclick="toggleDropdown()" class="flex items-center gap-2 px-3 py-2 rounded-xl nav-icon-btn transition-all">
                                <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white text-sm font-bold">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
                                <span class="text-sm font-semibold">{{ Str::limit(Auth::user()->name,12) }}</span>
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </button>
                            <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50">
                                @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-green-50 hover:text-green-700 transition-colors"><i class="fa-solid fa-gauge w-4"></i> Dashboard Admin</a>
                                @else
                                <a href="{{ route('orders.history') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-green-50 hover:text-green-700 transition-colors"><i class="fa-solid fa-box w-4"></i> Pesanan Saya</a>
                                @endif
                                <hr class="border-slate-100">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors"><i class="fa-solid fa-right-from-bracket w-4"></i> Keluar</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold px-4 py-2 rounded-lg nav-link transition-all">Masuk</a>
                        <a href="{{ route('register') }}" class="text-sm font-semibold px-5 py-2.5 bg-green-600 hover:bg-green-500 text-white rounded-xl transition-all shadow-md hover:shadow-green-500/30 hover:-translate-y-0.5">Daftar</a>
                    @endauth
                </div>
                <button id="mobile-toggle" onclick="toggleMobileMenu()" class="lg:hidden p-2 rounded-lg nav-icon-btn transition-colors">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-200 bg-white">
            <div class="max-w-7xl mx-auto px-4 py-4 space-y-1">
                <a href="{{ route('home') }}" class="block px-4 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs('home') ? 'bg-green-50 text-green-700' : 'text-slate-700 hover:bg-slate-50' }}">Beranda</a>
                <a href="{{ route('catalog') }}" class="block px-4 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs('catalog') ? 'bg-green-50 text-green-700' : 'text-slate-700 hover:bg-slate-50' }}">Katalog</a>
                <a href="{{ route('about') }}" class="block px-4 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs('about') ? 'bg-green-50 text-green-700' : 'text-slate-700 hover:bg-slate-50' }}">Tentang Kami</a>
                <a href="{{ route('contact') }}" class="block px-4 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs('contact') ? 'bg-green-50 text-green-700' : 'text-slate-700 hover:bg-slate-50' }}">Kontak</a>
                <hr class="border-slate-100 my-2">
                @auth
                    @if(!Auth::user()->isAdmin())
                    <a href="{{ route('cart') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        <i class="fa-solid fa-cart-shopping"></i> Keranjang
                        @if(count(session()->get('cart',[])) > 0)<span class="ml-auto w-5 h-5 bg-orange-500 text-white text-xs rounded-full flex items-center justify-center font-bold">{{ count(session()->get('cart',[])) }}</span>@endif
                    </a>
                    <a href="{{ route('orders.history') }}" class="block px-4 py-2.5 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">Pesanan Saya</a>
                    @else
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">Dashboard Admin</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="w-full text-left px-4 py-2.5 rounded-lg text-sm font-semibold text-red-600 hover:bg-red-50">Keluar</button></form>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-2.5 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">Masuk</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2.5 text-center rounded-lg text-sm font-semibold bg-green-600 text-white hover:bg-green-500">Daftar Sekarang</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

@if(session()->hasAny(['success','error','info']))
<div id="flash-msg" class="fixed top-20 right-4 z-50 max-w-sm" style="animation:slideIn .3s ease">
    @if(session('success'))
    <div class="flex items-start gap-3 bg-green-600 text-white px-5 py-4 rounded-2xl shadow-2xl">
        <i class="fa-solid fa-circle-check mt-0.5"></i>
        <span class="text-sm font-medium">{{ session('success') }}</span>
        <button onclick="document.getElementById('flash-msg').remove()" class="ml-auto opacity-70 hover:opacity-100"><i class="fa-solid fa-xmark"></i></button>
    </div>
    @elseif(session('error'))
    <div class="flex items-start gap-3 bg-red-600 text-white px-5 py-4 rounded-2xl shadow-2xl">
        <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
        <span class="text-sm font-medium">{{ session('error') }}</span>
        <button onclick="document.getElementById('flash-msg').remove()" class="ml-auto opacity-70 hover:opacity-100"><i class="fa-solid fa-xmark"></i></button>
    </div>
    @elseif(session('info'))
    <div class="flex items-start gap-3 bg-blue-600 text-white px-5 py-4 rounded-2xl shadow-2xl">
        <i class="fa-solid fa-circle-info mt-0.5"></i>
        <span class="text-sm font-medium">{{ session('info') }}</span>
        <button onclick="document.getElementById('flash-msg').remove()" class="ml-auto opacity-70 hover:opacity-100"><i class="fa-solid fa-xmark"></i></button>
    </div>
    @endif
</div>
<script>setTimeout(()=>{const e=document.getElementById('flash-msg');if(e)e.remove();},5000);</script>
@endif

<main>@yield('content')</main>

<footer class="bg-slate-900 text-slate-300 pt-16 pb-8 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#16a34a,#15803d)"><i class="fa-solid fa-seedling text-white"></i></div>
                    <div><span class="text-xl font-bold text-white">SiPanen</span><p class="text-xs text-slate-400">CV. Ekiindo Tegal</p></div>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed max-w-sm">Platform digital terpercaya untuk penjualan alat panen kelapa sawit berkualitas tinggi. Melayani seluruh Indonesia.</p>
                <div class="flex gap-3 mt-6">
                    <a href="#" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-green-600 flex items-center justify-center transition-colors"><i class="fa-brands fa-whatsapp text-sm"></i></a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-green-600 flex items-center justify-center transition-colors"><i class="fa-brands fa-instagram text-sm"></i></a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-green-600 flex items-center justify-center transition-colors"><i class="fa-brands fa-facebook text-sm"></i></a>
                </div>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Produk</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('catalog',['category'=>'egrek']) }}" class="hover:text-green-400 transition-colors">Egrek</a></li>
                    <li><a href="{{ route('catalog',['category'=>'dodos']) }}" class="hover:text-green-400 transition-colors">Dodos</a></li>
                    <li><a href="{{ route('catalog',['category'=>'telescopic_pole']) }}" class="hover:text-green-400 transition-colors">Gagang Teleskopik</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Kontak</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2"><i class="fa-solid fa-location-dot text-green-500 mt-0.5 flex-shrink-0"></i><span>Jl. Raya Tegal, Kota Tegal, Jawa Tengah</span></li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-phone text-green-500 flex-shrink-0"></i><span>+62 812-3456-7890</span></li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-envelope text-green-500 flex-shrink-0"></i><span>info@ekiindo.com</span></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-slate-800 pt-6 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p class="text-xs text-slate-500">© {{ date('Y') }} CV. Ekiindo Tegal. Hak cipta dilindungi.</p>
            <p class="text-xs text-slate-500">Sistem Informasi Penjualan <span class="text-green-500">SiPanen</span></p>
        </div>
    </div>
</footer>

<style>
@keyframes slideIn { from { opacity:0; transform:translateX(20px); } to { opacity:1; transform:translateX(0); } }
.nav-scrolled { background:rgba(255,255,255,0.97); backdrop-filter:blur(12px); box-shadow:0 4px 24px rgba(0,0,0,.08); border-bottom:1px solid #e2e8f0; }
.nav-top .nav-link { color:rgba(255,255,255,.9); }
.nav-top .nav-link:hover { background:rgba(255,255,255,.12); color:#fff; }
.nav-top .nav-link-active { background:#16a34a; color:#fff; }
.nav-top .nav-logo-text { color:#fff; }
.nav-top .nav-sub-text { color:rgba(255,255,255,.6); }
.nav-top .nav-icon-btn { color:rgba(255,255,255,.9); }
.nav-top .nav-icon-btn:hover { background:rgba(255,255,255,.1); }
.nav-scrolled .nav-link { color:#334155; }
.nav-scrolled .nav-link:hover { background:#f1f5f9; color:#334155; }
.nav-scrolled .nav-link-active { background:#16a34a; color:#fff; }
.nav-scrolled .nav-logo-text { color:#15803d; }
.nav-scrolled .nav-sub-text { color:#94a3b8; }
.nav-scrolled .nav-icon-btn { color:#475569; }
.nav-scrolled .nav-icon-btn:hover { background:#f1f5f9; }
</style>
<script>
const navInner = document.getElementById('nav-inner');
const isHome = {{ request()->routeIs('home') ? 'true' : 'false' }};

function updateNav() {
    if (isHome) {
        if (window.scrollY > 20) {
            navInner.classList.remove('nav-top');
            navInner.classList.add('nav-scrolled');
        } else {
            navInner.classList.remove('nav-scrolled');
            navInner.classList.add('nav-top');
        }
    } else {
        navInner.classList.remove('nav-top');
        navInner.classList.add('nav-scrolled');
    }
}

if (isHome) {
    navInner.classList.add('nav-top');
} else {
    navInner.classList.add('nav-scrolled');
}

window.addEventListener('scroll', updateNav);
updateNav();

function toggleDropdown() {
    const d = document.getElementById('user-dropdown');
    d.classList.toggle('hidden');
}
document.addEventListener('click', function(e) {
    const wrap = document.getElementById('user-dropdown-wrap');
    if (wrap && !wrap.contains(e.target)) document.getElementById('user-dropdown')?.classList.add('hidden');
});
function toggleMobileMenu() {
    const m = document.getElementById('mobile-menu');
    m.classList.toggle('hidden');
}
</script>
@stack('scripts')
</body>
</html>
