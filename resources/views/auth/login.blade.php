@extends('layouts.auth')
@section('title', 'Masuk — SiPanen')

@section('content')

{{-- Header --}}
<div class="mb-8">
    <h2 class="text-2xl font-extrabold text-slate-900">Selamat Datang Kembali 👋</h2>
    <p class="text-slate-500 mt-2 text-sm">Masuk ke akun SiPanen Anda untuk mulai berbelanja.</p>
</div>

{{-- Error Alert --}}
@if($errors->any())
<div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3.5 rounded-xl mb-6 text-sm">
    <i class="fa-solid fa-circle-exclamation flex-shrink-0 mt-0.5 text-red-500"></i>
    <span>{{ $errors->first() }}</span>
</div>
@endif

{{-- Login Form --}}
<form action="{{ route('login') }}" method="POST" class="space-y-5">
    @csrf

    {{-- Email --}}
    <div>
        <label for="email" class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">
            Alamat Email
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fa-solid fa-envelope text-slate-400 text-sm"></i>
            </div>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="email"
                placeholder="nama@perusahaan.com"
                class="form-input w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none @error('email') border-red-400 bg-red-50 @enderror"
            >
        </div>
    </div>

    {{-- Password --}}
    <div>
        <label for="pw-field" class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">
            Kata Sandi
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fa-solid fa-lock text-slate-400 text-sm"></i>
            </div>
            <input
                type="password"
                id="pw-field"
                name="password"
                required
                placeholder="••••••••"
                class="form-input w-full pl-11 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none"
            >
            <button
                type="button"
                onclick="togglePw()"
                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors"
                tabindex="-1"
            >
                <i class="fa-solid fa-eye text-sm" id="pw-icon"></i>
            </button>
        </div>
    </div>

    {{-- Remember --}}
    <div class="flex items-center justify-between">
        <label class="flex items-center gap-2 cursor-pointer group">
            <input
                type="checkbox"
                name="remember"
                class="w-4 h-4 rounded border-slate-300 text-green-600 focus:ring-green-500 cursor-pointer"
            >
            <span class="text-sm text-slate-600 group-hover:text-slate-800 transition-colors">Ingat saya</span>
        </label>
    </div>

    {{-- Submit --}}
    <button
        type="submit"
        id="login-btn"
        class="w-full bg-green-600 hover:bg-green-500 active:bg-green-700 text-white font-bold py-3.5 rounded-xl text-sm transition-all hover:shadow-lg hover:shadow-green-500/25 hover:-translate-y-0.5 flex items-center justify-center gap-2"
    >
        <i class="fa-solid fa-right-to-bracket"></i>
        Masuk ke Akun
    </button>
</form>

{{-- Divider --}}
<div class="flex items-center gap-3 my-6">
    <div class="flex-1 h-px bg-slate-200"></div>
    <span class="text-xs text-slate-400 font-medium">atau</span>
    <div class="flex-1 h-px bg-slate-200"></div>
</div>

{{-- Register link --}}
<div class="text-center">
    <p class="text-sm text-slate-500">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-green-600 font-bold hover:text-green-700 hover:underline transition-colors ml-1">
            Daftar Gratis
        </a>
    </p>
</div>

{{-- Trust badges --}}
<div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-center gap-5 flex-wrap">
    <span class="flex items-center gap-1.5 text-xs text-slate-400">
        <i class="fa-solid fa-lock text-green-500"></i> SSL Secured
    </span>
    <span class="flex items-center gap-1.5 text-xs text-slate-400">
        <i class="fa-solid fa-shield-halved text-green-500"></i> PCI-DSS
    </span>
    <span class="flex items-center gap-1.5 text-xs text-slate-400">
        <i class="fa-solid fa-shield-check text-green-500"></i> Data Terlindungi
    </span>
</div>

@endsection

@push('scripts')
<script>
function togglePw() {
    const f = document.getElementById('pw-field');
    const i = document.getElementById('pw-icon');
    const isPass = f.type === 'password';
    f.type = isPass ? 'text' : 'password';
    i.classList.toggle('fa-eye', !isPass);
    i.classList.toggle('fa-eye-slash', isPass);
}

// Loading state hanya aktif ketika form submit valid
const loginForm = document.querySelector('form');
const loginBtn  = document.getElementById('login-btn');
if (loginForm && loginBtn) {
    loginForm.addEventListener('submit', function(e) {
        if (this.checkValidity()) {
            loginBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
            loginBtn.disabled  = true;
        }
    });
}
</script>
@endpush
