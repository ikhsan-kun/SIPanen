@extends('layouts.admin')
@section('title','Tambah Produk')
@section('page-title','Tambah Produk Baru')
@section('page-subtitle','Isi form di bawah untuk menambahkan produk baru')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-2xl border border-slate-100 p-8 shadow-sm">
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm">
            <ul class="space-y-1">@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div class="grid sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Produk *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama produk"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('name') border-red-400 @enderror">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori *</label>
                    <select name="category" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $v => $l)<option value="{{ $v }}" {{ old('category')===$v?'selected':'' }}>{{ $l }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Harga (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Stok *</label>
                    <input type="number" name="stock" value="{{ old('stock',0) }}" required min="0"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Satuan *</label>
                    <input type="text" name="unit" value="{{ old('unit','pcs') }}" required placeholder="pcs, set, meter"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Berat</label>
                    <input type="text" name="weight" value="{{ old('weight') }}" placeholder="cth. 1.5 kg"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Material</label>
                    <input type="text" name="material" value="{{ old('material') }}" placeholder="cth. Baja Karbon"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi *</label>
                    <textarea name="description" rows="3" required placeholder="Deskripsi produk..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 resize-none">{{ old('description') }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Spesifikasi</label>
                    <textarea name="specifications" rows="4" placeholder="Spesifikasi teknis produk..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 resize-none">{{ old('specifications') }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Foto Produk</label>
                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-green-400 transition-colors cursor-pointer" onclick="document.getElementById('prod-img').click()">
                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-400 mb-2"></i>
                        <p class="text-sm text-slate-600">Klik untuk upload foto</p>
                        <p class="text-xs text-slate-400 mt-1">JPG, PNG, WebP, maks. 2MB</p>
                        <p id="img-name" class="text-xs text-green-600 mt-2 font-semibold hidden"></p>
                    </div>
                    <input type="file" id="prod-img" name="image" accept="image/*" class="hidden"
                           onchange="document.getElementById('img-name').textContent=this.files[0].name; document.getElementById('img-name').classList.remove('hidden')">
                </div>
                <div class="sm:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active',1) ? 'checked' : '' }} class="w-4 h-4 rounded accent-green-600">
                        <span class="text-sm font-semibold text-slate-700">Produk Aktif (tampil di katalog)</span>
                    </label>
                </div>
            </div>
            <div class="flex gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white font-semibold px-6 py-3 rounded-xl transition-all hover:-translate-y-0.5 shadow-md shadow-green-500/30">
                    <i class="fa-solid fa-check"></i> Simpan Produk
                </button>
                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 border border-slate-200 text-slate-600 font-semibold px-6 py-3 rounded-xl hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
