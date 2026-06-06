@extends('layouts.app')
@section('title','Daftar Akun')

@section('content')
<div class="min-h-screen pt-16 flex items-center justify-center bg-gradient-to-br from-slate-50 to-green-50/30 px-4 py-10">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg" style="background:linear-gradient(135deg,#16a34a,#15803d)">
                <i class="fa-solid fa-user-plus text-white text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Buat Akun Baru</h1>
            <p class="text-slate-500 mt-1 text-sm">Daftar dan mulai berbelanja di SiPanen</p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8">
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm">
                <ul class="space-y-1">@foreach($errors->all() as $e)<li class="flex items-center gap-2"><i class="fa-solid fa-circle-exclamation flex-shrink-0"></i>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama lengkap Anda"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('name') border-red-400 @enderror">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('email') border-red-400 @enderror">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. Telepon / WhatsApp</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('phone') border-red-400 @enderror">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="pw-field" required placeholder="Minimal 8 karakter"
                               class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('password') border-red-400 @enderror">
                        <button type="button" onclick="togglePw()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-eye" id="pw-icon"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi password"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white font-semibold py-3.5 rounded-xl transition-all duration-200 hover:-translate-y-0.5 shadow-md shadow-green-500/30 mt-2">
                    Buat Akun
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-green-600 font-semibold hover:text-green-700">Masuk di sini</a>
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
