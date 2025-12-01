@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title fw-semibold">Daftar Produk</h5>
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="ti ti-plus"></i> Tambah Produk
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Gambar</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Nama Produk</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Harga</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Stok</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Aksi</h6>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                    <tr>
                        <td class="border-bottom-0">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" width="50" class="rounded" alt="{{ $product->name }}">
                            @else
                                <span class="badge bg-secondary">No Image</span>
                            @endif
                        </td>
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-1">{{ $product->product_name }}</h6>
                            <span class="fw-normal text-muted">{{ Str::limit($product->description, 30) }}</span>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-normal">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </td>
                        <td class="border-bottom-0">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} rounded-3 fw-semibold">
                                    {{ $product->stock }} Pcs
                                </span>
                            </div>
                        </td>
                        <td class="border-bottom-0">
                            <form onsubmit="return confirm('Apakah Anda yakin menghapus data ini?');" action="{{ route('products.destroy', $product->id) }}" method="POST">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Data Produk Belum Tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
