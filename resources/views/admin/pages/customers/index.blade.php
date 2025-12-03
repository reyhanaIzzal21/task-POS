@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-0">Customers</h1>
                <small class="text-muted">Customers List</small>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active">Customers</li>
                </ol>
            </nav>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                {{-- Search / filter (server-side) --}}
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('customers.index') }}" class="d-flex">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2"
                                placeholder="Search name or email..." aria-label="Search customers">
                            <button class="btn btn-primary" type="submit">Search</button>
                            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary ms-2">Reset</a>
                        </form>
                    </div>
                    <div class="col-md-6 text-md-end align-self-center">
                        <small class="text-muted">Total: <strong>{{ $user->total ?? $user->count() }}</strong></small>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:60px;">No</th>
                                <th>Nama</th>
                                <th>Poin</th>
                                <th>Registered At</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($user as $customer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{-- Avatar initial (ambil huruf pertama nama) --}}
                                            <div class="rounded-circle d-inline-flex justify-content-center align-items-center me-2"
                                                style="width:42px;height:42px;background:#e9ecef;font-weight:600;">
                                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $customer->name }}</div>
                                                <div class="text-muted small">{{ $customer->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill text-dark"
                                            style="background:#fff3cd;border:1px solid #ffe8a1;">
                                            {{ $customer->point ?? 0 }}
                                        </span>
                                    </td>
                                    <td>{{ $customer->created_at->format('d M Y') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('customers.show', $customer->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Tidak ada customer ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination (hanya jika $user adalah paginator) --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">Menampilkan {{ $user->count() }} item</div>
                    <div>
                        @if (method_exists($user, 'links'))
                            {{ $user->withQueryString()->links('pagination::bootstrap-5') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
