<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Dashboard') — Admin SiPanen</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css','resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-slate-100 antialiased" style="font-family:'Plus Jakarta Sans',sans-serif;">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar overlay (mobile) --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-950/60 z-30 hidden transition-opacity duration-300 opacity-0" onclick="toggleSidebar()"></div>

    {{-- Sidebar --}}
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 flex flex-col bg-slate-900 text-slate-300 transition-transform duration-300 z-40 transform -translate-x-full md:relative md:translate-x-0 md:flex">
        {{-- Brand --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-800">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#16a34a,#15803d)">
                <i class="fa-solid fa-seedling text-white text-base"></i>
            </div>
            <div>
                <p class="text-white font-bold text-base leading-none">SiPanen</p>
                <p class="text-xs text-slate-400 mt-0.5">Admin Panel</p>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            @php
            $adminNav = [
                ['route'=>'admin.dashboard','icon'=>'fa-gauge','label'=>'Dashboard'],
                ['route'=>'admin.products.index','icon'=>'fa-box-open','label'=>'Produk'],
                ['route'=>'admin.orders.index','icon'=>'fa-file-invoice','label'=>'Pesanan'],
                ['route'=>'admin.customers.index','icon'=>'fa-users','label'=>'Pelanggan'],
                ['route'=>'admin.reports.index','icon'=>'fa-chart-bar','label'=>'Laporan'],
            ];
            @endphp
            @foreach($adminNav as $nav)
            <a href="{{ route($nav['route']) }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
               {{ request()->routeIs($nav['route'].'*') ? 'bg-green-600 text-white shadow-lg shadow-green-900/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid {{ $nav['icon'] }} w-4 text-center"></i>
                <span>{{ $nav['label'] }}</span>
                @if($nav['route']==='admin.orders.index')
                    @php $pendingCount = \App\Models\Order::where('payment_status','pending_confirmation')->count(); @endphp
                    @if($pendingCount > 0)
                    <span class="ml-auto w-5 h-5 bg-orange-500 text-white text-xs rounded-full flex items-center justify-center font-bold">{{ $pendingCount }}</span>
                    @endif
                @endif
            </a>
            @endforeach
        </nav>

        {{-- User Info --}}
        <div class="border-t border-slate-800 px-4 py-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-green-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-white text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500 truncate">Administrator</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-xs text-slate-400 hover:bg-slate-800 hover:text-red-400 transition-colors">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Top Bar --}}
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="md:hidden flex items-center justify-center w-10 h-10 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div>
                    <h1 class="text-lg font-bold text-slate-800">@yield('page-title','Dashboard')</h1>
                    <p class="text-xs text-slate-500 mt-0.5">@yield('page-subtitle','Selamat datang di panel admin SiPanen')</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i> Lihat Website
                </a>
                <div class="text-xs text-slate-500">{{ now()->isoFormat('dddd, D MMMM Y') }}</div>
            </div>
        </header>

        {{-- Flash --}}
        @if(session()->hasAny(['success','error','info']))
        <div class="mx-6 mt-4">
            @if(session('success'))
            <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm">
                <i class="fa-solid fa-circle-check text-green-600"></i> {{ session('success') }}
            </div>
            @elseif(session('error'))
            <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
                <i class="fa-solid fa-circle-exclamation text-red-600"></i> {{ session('error') }}
            </div>
            @elseif(session('info'))
            <div class="flex items-center gap-3 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-xl text-sm">
                <i class="fa-solid fa-circle-info text-blue-600"></i> {{ session('info') }}
            </div>
            @endif
        </div>
        @endif

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    
    if (sidebar.classList.contains('-translate-x-full')) {
        // Open
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        overlay.classList.remove('hidden');
        setTimeout(() => overlay.classList.add('opacity-100'), 20);
    } else {
        // Close
        sidebar.classList.remove('translate-x-0');
        sidebar.classList.add('-translate-x-full');
        overlay.classList.remove('opacity-100');
        setTimeout(() => overlay.classList.add('hidden'), 300);
    }
}
</script>
</body>
</html>
