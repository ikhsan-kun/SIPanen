@extends('layouts.app')
@section('title','Masuk')

@section('content')
<div class="min-h-screen pt-16 flex items-center justify-center bg-gradient-to-br from-slate-50 to-green-50/30 px-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg" style="background:linear-gradient(135deg,#16a34a,#15803d)">
                <i class="fa-solid fa-seedling text-white text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Selamat Datang Kembali</h1>
            <p class="text-slate-500 mt-1 text-sm">Masuk ke akun SiPanen Anda</p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8">
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation flex-shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="nama@email.com"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('email') border-red-400 @enderror">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="pw-field" required
                               placeholder="Masukkan password"
                               class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                        <button type="button" onclick="togglePw()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-eye" id="pw-icon"></i>
                        </button>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded accent-green-600">
                        Ingat saya
                    </label>
                </div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white font-semibold py-3.5 rounded-xl transition-all duration-200 hover:-translate-y-0.5 shadow-md shadow-green-500/30">
                    Masuk
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-green-600 font-semibold hover:text-green-700">Daftar sekarang</a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePw() {
    const f = document.getElementById('pw-field');
    const i = document.getElementById('pw-icon');
    f.type = f.type === 'password' ? 'text' : 'password';
    i.classList.toggle('fa-eye'); i.classList.toggle('fa-eye-slash');
}
</script>
@endpush
