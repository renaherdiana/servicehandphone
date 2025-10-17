@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="background-color:#F5F5F5; min-height: 100vh;">
    <div class="container py-5">

        <!-- Header -->
        <div class="mb-4 text-center">
            <h3 class="fw-bold text-primary">
                <i class="mdi mdi-cash-multiple me-2"></i> Detail Pembayaran Servis
            </h3>
            <p class="text-muted mb-0">Rincian transaksi dan produk servis pelanggan</p>
        </div>

        <!-- Card utama -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header text-white rounded-top-4" 
                style="background: linear-gradient(90deg, #3F51B5, #7986CB);">
                <h5 class="mb-0 fw-semibold">
                    Invoice: {{ $service->invoice }}
                </h5>
            </div>

            <div class="card-body bg-white p-4">

                <!-- Info pelanggan -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Nama Pelanggan</p>
                        <h6 class="fw-semibold">
                            @if(is_array($service->customer))
                                {{ $service->customer['name'] ?? '-' }}
                            @elseif(is_object($service->customer))
                                {{ $service->customer->name ?? '-' }}
                            @else
                                {{ $service->customer ?? '-' }}
                            @endif
                        </h6>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Teknisi</p>
                        <h6 class="fw-semibold">{{ $service->technician }}</h6>
                    </div>

                    <div class="col-md-6 mt-3">
                        <p class="mb-1 text-muted">Tanggal Servis</p>
                        <h6 class="fw-semibold">{{ $service->created_at->format('d M Y, H:i') }}</h6>
                    </div>

                    <div class="col-md-6 mt-3">
                        <p class="mb-1 text-muted">Status</p>
                        <span class="badge 
                            @if($service->status == 'finished') bg-success 
                            @elseif($service->status == 'process') bg-warning 
                            @elseif($service->status == 'cancelled') bg-danger 
                            @else bg-secondary @endif
                            px-3 py-2 rounded-pill fw-normal">
                            {{ ucfirst($service->status) }}
                        </span>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Tabel item servis -->
                <h6 class="fw-bold mb-3 text-primary">🧾 Daftar Produk / Servis</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center rounded-3 overflow-hidden">
                        <thead class="table-light">
                            <tr class="text-primary">
                                <th>#</th>
                                <th>Nama Item</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($service->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-start">{{ $item->name }}</td>
                                <td>{{ $item->pivot->qty }}</td>
                                <td>Rp {{ number_format($item->pivot->price, 0, ',', '.') }}</td>
                                <td class="fw-semibold text-success">
                                    Rp {{ number_format($item->pivot->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Total biaya -->
                <div class="text-end mt-4">
                    <h5 class="fw-bold text-dark">
                        Total Biaya:
                        <span class="text-primary">
                            Rp {{ number_format($service->total_cost ?? $service->items->sum(fn($i) => $i->pivot->subtotal), 0, ',', '.') }}
                        </span>
                    </h5>
                    @if($service->other_cost > 0)
                    <h6 class="text-muted">
                        + Biaya Lain: Rp {{ number_format($service->other_cost, 0, ',', '.') }}
                    </h6>
                    @endif
                </div>

                <!-- Tombol bayar -->
                <div class="mt-5 text-end">
                    <a href="{{ route('payment.index') }}" class="btn btn-outline-secondary px-4 me-2 rounded-3">
                        <i class="mdi mdi-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('payment.create', $service->id) }}" 
                       class="btn btn-success px-4 rounded-3 shadow-sm fw-semibold">
                        <i class="mdi mdi-cash-multiple me-1"></i> Bayar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9ff;
    }
</style>
@endsection
