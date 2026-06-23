<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SiPanen') — Solusi Alat Panen Kelapa Sawit</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        .auth-hero {
            background: url('/images/hero-sipanen.png') center center / cover no-repeat;
            position: relative;
        }
        .auth-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg,
                rgba(0, 40, 15, 0.82) 0%,
                rgba(15, 70, 30, 0.70) 50%,
                rgba(0, 30, 10, 0.85) 100%);
        }

        /* Input animation */
        .form-input {
            transition: border-color .2s, box-shadow .2s, background-color .2s;
        }
        .form-input:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22,163,74,.12);
            background-color: #fff;
        }

        /* Floating label feel */
        @keyframes fadeUp {
            from { opacity:0; transform: translateY(16px); }
            to   { opacity:1; transform: translateY(0); }
        }
        .form-card { animation: fadeUp .45s ease both; }

        /* Scrollbar thin */
        .form-side::-webkit-scrollbar { width: 4px; }
        .form-side::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }
    </style>
    @stack('styles')
</head>
<body class="bg-white antialiased">

<div class="min-h-screen flex">

    {{-- LEFT: Form Side --}}
    <div class="form-side w-full lg:w-[45%] xl:w-[40%] flex flex-col overflow-y-auto">

        {{-- Top bar --}}
        <div class="px-8 pt-8 pb-4 flex items-center justify-between flex-shrink-0">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <img src="{{ asset('images/logosipanen.png') }}" alt="SiPanen" class="h-9 w-auto">
            </a>
            <a href="{{ route('home') }}"
               class="hidden sm:inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-green-700 font-semibold transition-colors">
                <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Beranda
            </a>
        </div>

        {{-- Form Content --}}
        <div class="flex-1 flex items-center justify-center px-8 sm:px-12 py-8">
            <div class="w-full max-w-md form-card">
                @yield('content')
            </div>
        </div>

        {{-- Bottom --}}
        <div class="px-8 pb-8 pt-4 text-center text-xs text-slate-400 flex-shrink-0">
            © {{ date('Y') }} CV. Ekiindo Tegal · Hak cipta dilindungi
        </div>
    </div>

    {{-- RIGHT: Hero Image Side --}}
    <div class="auth-hero hidden lg:flex lg:w-[55%] xl:w-[60%] relative flex-col items-center justify-center p-12">
        {{-- Content overlay --}}
        <div class="relative z-10 max-w-lg text-center">

            {{-- Icon badge --}}
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 text-green-200 text-xs font-bold px-4 py-2 rounded-full mb-8 tracking-widest uppercase">
                <i class="fa-solid fa-seedling text-green-300"></i>
                CV. Ekiindo Tegal
            </div>

            <h1 class="text-4xl xl:text-5xl font-extrabold text-white leading-tight mb-5">
                Alat Panen Sawit<br/>
                <span class="text-green-300">Kualitas Premium</span>
            </h1>
            <p class="text-gray-300 leading-relaxed text-sm xl:text-base max-w-sm mx-auto mb-10">
                Egrek, Dodos, dan Gagang Teleskopik presisi tinggi. Dipercaya lebih dari 500 mitra perkebunan di seluruh Indonesia sejak 2014.
            </p>

            {{-- Feature pills --}}
            <div class="flex flex-wrap justify-center gap-3">
                @foreach(['Baja Premium SNI', 'Pengiriman Seluruh Indonesia', 'Pembayaran via Midtrans', 'Garansi Produk'] as $f)
                <span class="inline-flex items-center gap-1.5 bg-white/10 backdrop-blur-sm border border-white/15 text-green-100 text-xs font-medium px-3.5 py-1.5 rounded-full">
                    <i class="fa-solid fa-check text-green-300 text-[9px]"></i> {{ $f }}
                </span>
                @endforeach
            </div>

            {{-- Stats --}}
            <div class="mt-12 grid grid-cols-3 gap-4">
                @foreach([['500+', 'Mitra Pekebun'], ['10+', 'Tahun Pengalaman'], ['3', 'Lini Produk']] as $s)
                <div class="bg-white/8 backdrop-blur-sm border border-white/15 rounded-2xl p-4">
                    <div class="text-2xl font-extrabold text-white">{{ $s[0] }}</div>
                    <div class="text-xs text-gray-300 mt-0.5">{{ $s[1] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Bottom attribution --}}
        <div class="absolute bottom-6 left-0 right-0 text-center z-10">
            <span class="text-xs text-white/30">Foto: Kebun sawit CV. Ekiindo Tegal</span>
        </div>
    </div>

</div>

@stack('scripts')
</body>
</html>
