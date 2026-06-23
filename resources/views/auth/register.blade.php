@extends('layouts.auth')
@section('title', 'Daftar Akun — SiPanen')

@section('content')

{{-- Header --}}
<div class="mb-7">
    <h2 class="text-2xl font-extrabold text-slate-900">Buat Akun Baru ✨</h2>
    <p class="text-slate-500 mt-2 text-sm">Bergabung bersama 500+ mitra pekebun sawit Indonesia.</p>
</div>

{{-- Error Alert --}}
@if($errors->any())
<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3.5 rounded-xl mb-5 text-sm">
    <ul class="space-y-1">
        @foreach($errors->all() as $e)
        <li class="flex items-start gap-2"><i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5 flex-shrink-0 text-xs"></i><span>{{ $e }}</span></li>
        @endforeach
    </ul>
</div>
@endif

{{-- Register Form --}}
<form action="{{ route('register') }}" method="POST" class="space-y-4" id="register-form">
    @csrf

    {{-- Nama --}}
    <div>
        <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Nama Lengkap</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fa-solid fa-user text-slate-400 text-sm"></i>
            </div>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
                autocomplete="name"
                placeholder="Nama Lengkap Anda"
                class="form-input w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none @error('name') border-red-400 bg-red-50 @enderror"
            >
        </div>
    </div>

    {{-- Email --}}
    <div>
        <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Alamat Email</label>
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

    {{-- No. Telepon --}}
    <div>
        <label for="phone" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">No. Telepon / WhatsApp</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fa-solid fa-phone text-slate-400 text-sm"></i>
            </div>
            <input
                type="tel"
                id="phone"
                name="phone"
                value="{{ old('phone') }}"
                required
                placeholder="08xxxxxxxxxx"
                class="form-input w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none @error('phone') border-red-400 bg-red-50 @enderror"
            >
        </div>
    </div>

    {{-- Password Row --}}
    <div class="grid grid-cols-2 gap-3">
        {{-- Password --}}
        <div>
            <label for="pw-field" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Kata Sandi</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fa-solid fa-lock text-slate-400 text-sm"></i>
                </div>
                <input
                    type="password"
                    id="pw-field"
                    name="password"
                    required
                    placeholder="Min. 8 karakter"
                    class="form-input w-full pl-11 pr-10 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none"
                >
                <button type="button" onclick="togglePw()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600" tabindex="-1">
                    <i class="fa-solid fa-eye text-sm" id="pw-icon"></i>
                </button>
            </div>
        </div>
        {{-- Confirm Password --}}
        <div>
            <label for="pw-confirm" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Konfirmasi</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fa-solid fa-lock text-slate-400 text-sm"></i>
                </div>
                <input
                    type="password"
                    id="pw-confirm"
                    name="password_confirmation"
                    required
                    placeholder="Ulangi sandi"
                    class="form-input w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none"
                >
            </div>
        </div>
    </div>

    {{-- Password strength indicator --}}
    <div id="pw-strength-wrap" class="hidden">
        <div class="flex gap-1 mb-1">
            <div class="h-1 flex-1 rounded-full bg-slate-200 overflow-hidden"><div id="bar-1" class="h-full w-0 transition-all duration-300 rounded-full"></div></div>
            <div class="h-1 flex-1 rounded-full bg-slate-200 overflow-hidden"><div id="bar-2" class="h-full w-0 transition-all duration-300 rounded-full"></div></div>
            <div class="h-1 flex-1 rounded-full bg-slate-200 overflow-hidden"><div id="bar-3" class="h-full w-0 transition-all duration-300 rounded-full"></div></div>
            <div class="h-1 flex-1 rounded-full bg-slate-200 overflow-hidden"><div id="bar-4" class="h-full w-0 transition-all duration-300 rounded-full"></div></div>
        </div>
        <p id="pw-strength-text" class="text-[11px] text-slate-400"></p>
    </div>

    {{-- Submit --}}
    <button
        type="submit"
        id="register-btn"
        class="w-full bg-green-600 hover:bg-green-500 active:bg-green-700 text-white font-bold py-3.5 rounded-xl text-sm transition-all hover:shadow-lg hover:shadow-green-500/25 hover:-translate-y-0.5 flex items-center justify-center gap-2 mt-1"
    >
        <i class="fa-solid fa-user-plus"></i>
        Daftar Sekarang
    </button>
</form>

{{-- Divider --}}
<div class="flex items-center gap-3 my-5">
    <div class="flex-1 h-px bg-slate-200"></div>
    <span class="text-xs text-slate-400 font-medium">atau</span>
    <div class="flex-1 h-px bg-slate-200"></div>
</div>

{{-- Login link --}}
<div class="text-center">
    <p class="text-sm text-slate-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-green-600 font-bold hover:text-green-700 hover:underline transition-colors ml-1">
            Masuk di sini
        </a>
    </p>
</div>

{{-- Trust badges --}}
<div class="mt-6 pt-5 border-t border-slate-100 flex items-center justify-center gap-5 flex-wrap">
    <span class="flex items-center gap-1.5 text-xs text-slate-400">
        <i class="fa-solid fa-lock text-green-500"></i> SSL Secured
    </span>
    <span class="flex items-center gap-1.5 text-xs text-slate-400">
        <i class="fa-solid fa-shield-halved text-green-500"></i> Data Aman
    </span>
    <span class="flex items-center gap-1.5 text-xs text-slate-400">
        <i class="fa-solid fa-user-shield text-green-500"></i> Privasi Terjaga
    </span>
</div>

@endsection

@push('scripts')
<script>
// Toggle password visibility
function togglePw() {
    const f = document.getElementById('pw-field');
    const i = document.getElementById('pw-icon');
    const isPass = f.type === 'password';
    f.type = isPass ? 'text' : 'password';
    i.classList.toggle('fa-eye', !isPass);
    i.classList.toggle('fa-eye-slash', isPass);
}

// Password strength meter
const pwField = document.getElementById('pw-field');
const strengthWrap = document.getElementById('pw-strength-wrap');
const strengthText = document.getElementById('pw-strength-text');
const bars = [1,2,3,4].map(n => document.getElementById('bar-' + n));

const levels = [
    { min: 0,  label: '',           color: '' },
    { min: 1,  label: 'Sangat Lemah', color: '#ef4444' },
    { min: 4,  label: 'Lemah',      color: '#f97316' },
    { min: 6,  label: 'Cukup Kuat', color: '#eab308' },
    { min: 8,  label: 'Kuat 💪',    color: '#22c55e' },
];

pwField.addEventListener('input', function() {
    const val = this.value;
    if (!val) { strengthWrap.classList.add('hidden'); return; }
    strengthWrap.classList.remove('hidden');

    let score = 0;
    if (val.length >= 8)  score++;
    if (val.length >= 12) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const level = Math.min(4, Math.ceil(score * 4 / 5));
    const lv = levels[level] || levels[1];

    bars.forEach((b, idx) => {
        b.style.width = idx < level ? '100%' : '0%';
        b.style.backgroundColor = idx < level ? lv.color : '';
    });
    strengthText.textContent = lv.label;
    strengthText.style.color = lv.color;
});

// Submit loading state
document.getElementById('register-btn').addEventListener('click', function() {
    const form = document.getElementById('register-form');
    if (form.checkValidity()) {
        this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
        this.disabled = true;
    }
});
</script>
@endpush
