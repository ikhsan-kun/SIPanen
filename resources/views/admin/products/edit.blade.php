@extends('layouts.admin')
@section('title','Edit Produk')
@section('page-title','Edit Produk')
@section('page-subtitle','Perbarui informasi produk')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-2xl border border-slate-100 p-8 shadow-sm">
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm">
            <ul class="space-y-1">@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <form action="{{ route('admin.products.update',$product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')
            <div class="grid sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Produk *</label>
                    <input type="text" name="name" value="{{ old('name',$product->name) }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori *</label>
                    <select name="category" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                        @foreach($categories as $v => $l)<option value="{{ $v }}" {{ old('category',$product->category)===$v?'selected':'' }}>{{ $l }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Harga (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price',$product->price) }}" required min="0"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Stok *</label>
                    <input type="number" name="stock" value="{{ old('stock',$product->stock) }}" required min="0"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Satuan *</label>
                    <input type="text" name="unit" value="{{ old('unit',$product->unit) }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Berat</label>
                    <input type="text" name="weight" value="{{ old('weight',$product->weight) }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Material</label>
                    <input type="text" name="material" value="{{ old('material',$product->material) }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi *</label>
                    <textarea name="description" rows="3" required
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 resize-none">{{ old('description',$product->description) }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Spesifikasi</label>
                    <textarea name="specifications" rows="4"
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 resize-none">{{ old('specifications',$product->specifications) }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Produk</label>
                    @if($product->image)
                    <div class="flex items-center gap-4 mb-3 p-3 bg-slate-50 rounded-xl">
                        <img src="{{ $product->image_url }}" class="w-16 h-16 rounded-xl object-cover">
                        <p class="text-sm text-slate-600">Foto saat ini. Upload baru untuk mengganti.</p>
                    </div>
                    @endif
                    <input type="file" name="image" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                </div>
                <div class="sm:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active',$product->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded accent-green-600">
                        <span class="text-sm font-semibold text-slate-700">Produk Aktif</span>
                    </label>
                </div>
            </div>
            <div class="flex gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white font-semibold px-6 py-3 rounded-xl transition-all hover:-translate-y-0.5 shadow-md shadow-green-500/30">
                    <i class="fa-solid fa-floppy-disk"></i> Perbarui Produk
                </button>
                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 border border-slate-200 text-slate-600 font-semibold px-6 py-3 rounded-xl hover:bg-slate-50 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
