@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Edit Produk</h5>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror" value="{{ old('product_name', $product->product_name) }}">
                @error('product_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock) }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Produk (Biarkan kosong jika tidak diubah)</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                @if($product->image)
                    <div class="mt-2">
                        <small>Gambar saat ini:</small><br>
                        <img src="{{ asset('storage/' . $product->image) }}" width="100" class="rounded border">
                    </div>
                @endif
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Produk</button>
            <a href="{{ route('products.index') }}" class="btn btn-light">Kembali</a>
        </form>
    </div>
</div>
@endsection
