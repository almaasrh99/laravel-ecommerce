@props(['product' => null, 'categories'])

@php
    $isEdit = isset($product);
@endphp

<form action="{{ $isEdit ? route('dashboard.products.update', $product->id) : route('dashboard.products.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="mb-4">
        <label class="block text-gray-700">Nama Produk</label>
        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="w-full border p-2 rounded"
            required>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700">Kategori</label>
        <select name="category_id" class="w-full border p-2 rounded" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700">Deskripsi</label>
        <textarea name="description" class="w-full border p-2 rounded"
            rows="3">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700">Harga</label>
        <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}"
            class="w-full border p-2 rounded" required>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700">Gambar</label>
        <input type="file" name="image" class="w-full border p-2 rounded">
        @if($isEdit && $product->image)
            <div class="mt-2">
                <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}"
                    class="h-24 rounded object-cover">
            </div>
        @endif
    </div>

    <div class="mt-6">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            {{ $isEdit ? 'Update' : 'Simpan' }}
        </button>
        <a href="{{ route('dashboard.products') }}" class="ml-2 text-gray-600 hover:underline">Batal</a>
    </div>
</form>