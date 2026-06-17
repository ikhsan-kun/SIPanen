@extends('layouts.app')
@section('title','Daftar Akun — SiPanen')

@section('content')
<div class="min-h-[calc(100vh-104px)] flex items-center justify-center bg-gray-50 px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-4xl w-full bg-white rounded-xl card-shadow overflow-hidden border border-gray-100 flex flex-col md:flex-row">

        {{-- Left: Visual panel --}}
        <div class="md:w-5/12 bg-primary-dark p-10 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="absolute -right-8 -bottom-8 w-60 h-60 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute right-1/3 top-8 w-28 h-28 bg-primary-green/20 rounded-full blur-xl pointer-events-none"></div>

            <div class="relative z-10 flex items-center space-x-2">
                <img alt="SiPanen Logo" class="h-6 w-auto brightness-200" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAeCDJmAzJIpbqolbDZmub5taHkKMzKt_wek4FQjknuhSIS00SmRxq9YHj9uroaXxPEUsVLdRWlPInxxeSD5I9HH_oXImwZhlwIAx8Z7MAk425OCKOLY0kaPp4L1P4LtweWqFF40bAion4WHdvCwZHJqxDLukjrbn-wFDz5mWMqkcCw2R12CZLhMRNrjtbZqtm5AtvCyTIMLVqgDDy2Dbm_cxmg-sVxdTBpkfrxrSQI3FjskyF4BIbop1yxC_CzrXz-eN8leGzXWUc"/>
                <span class="font-bold text-lg tracking-tight block">SiPanen</span>
            </div>

            <div class="relative z-10 my-8">
                <h2 class="text-2xl font-extrabold leading-tight mb-4 text-green-100">
                    Mulai Langkah Sukses Anda
                </h2>
                <p class="text-gray-300 leading-relaxed text-xs">
                    Bergabunglah bersama ribuan petani kelapa sawit dan perusahaan perkebunan di seluruh Indonesia. Dapatkan akses ke produk alat panen dengan harga terbaik.
                </p>
                <div class="mt-6 space-y-3">
                    @foreach(['Akses Ribuan Produk Premium','Pemesanan & Pembayaran Online','Pelacakan Resi Real-Time'] as $f)
                    <div class="flex items-center space-x-2 text-xs text-green-200">
                        <i class="fa-solid fa-circle-check text-accent-green flex-shrink-0"></i> 
                        <span>{{ $f }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="relative z-10 border-t border-white/10 pt-4 flex items-center justify-between text-[10px] text-gray-400">
                <span>© {{ date('Y') }} CV. Ekiindo Tegal</span>
                <span>v1.0</span>
            </div>
        </div>

        {{-- Right: Form panel --}}
        <div class="md:w-7/12 p-8 sm:p-12 flex flex-col justify-center">
            <div class="mb-6">
                <h1 class="text-xl font-bold text-gray-900">Buat Akun Baru</h1>
                <p class="text-gray-500 mt-1 text-xs">Daftarkan akun untuk mulai bertransaksi di SiPanen.</p>
            </div>

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-xs">
                <ul class="space-y-1">
                    @foreach($errors->all() as $e)
                    <li class="flex items-center space-x-2"><i class="fa-solid fa-circle-exclamation flex-shrink-0"></i> <span>{{ $e }}</span></li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1.5">Nama Lengkap</label>
                    <div class="relative">
                        <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               placeholder="Nama Lengkap Anda"
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-primary-green focus:border-primary-green bg-white transition @error('name') border-red-400 bg-red-50 @enderror">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1.5">Alamat Email</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               placeholder="nama@perusahaan.com"
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-primary-green focus:border-primary-green bg-white transition @error('email') border-red-400 bg-red-50 @enderror">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1.5">No. Telepon / WhatsApp</label>
                    <div class="relative">
                        <i class="fa-solid fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required
                               placeholder="08xxxxxxxxxx"
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-primary-green focus:border-primary-green bg-white transition @error('phone') border-red-400 bg-red-50 @enderror">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="password" name="password" id="pw-field" required
                               placeholder="Minimal 8 karakter"
                               class="w-full pl-10 pr-12 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-primary-green focus:border-primary-green bg-white transition">
                        <button type="button" onclick="togglePw()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fa-solid fa-eye" id="pw-icon"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1.5">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="password" name="password_confirmation" required
                               placeholder="Ulangi Kata Sandi"
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-primary-green focus:border-primary-green bg-white transition">
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-primary-green hover:bg-accent-green text-white font-bold py-2.5 rounded-md transition duration-150 shadow-sm text-sm mt-2">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-center text-xs text-gray-500 mt-6">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="text-primary-green font-bold hover:underline transition-colors">Masuk di sini</a>
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
