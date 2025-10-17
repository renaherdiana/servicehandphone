@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="background-color:#F5F5F5; min-height: 100vh;">
    <div class="container py-4">

        <!-- Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold text-primary">📋 Detail Servis</h4>
            <a href="{{ route('service') }}" class="btn btn-secondary rounded-3 shadow-sm px-4">
                ⬅ Kembali
            </a>
        </div>

        <!-- Card Detail -->
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header text-white rounded-top-4"
                 style="background: linear-gradient(90deg, #3F51B5 0%, #7986CB 100%);">
                <h5 class="mb-0 fw-bold">Informasi Servis</h5>
            </div>

            <div class="card-body p-4 bg-white rounded-bottom-4">

                <!-- Informasi Servis -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold text-primary">No. Invoice:</label>
                        <div class="border rounded-3 p-2 bg-light">{{ $service->invoice }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold text-primary">Nama Pelanggan:</label>
                        <div class="border rounded-3 p-2 bg-light">
                            {{ $service->customer->name ?? '-' }}
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold text-primary">Handphone:</label>
                        <div class="border rounded-3 p-2 bg-light">
                            {{ $service->handphone->brand ?? '-' }} {{ $service->handphone->model ?? '' }}
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold text-primary">Teknisi:</label>
                        <div class="border rounded-3 p-2 bg-light">
                            {{ $service->technician->name ?? '-' }}
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold text-primary">Estimasi Biaya:</label>
                        <div class="border rounded-3 p-2 bg-light">
                            Rp {{ number_format($service->cost, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold text-primary">Status:</label>
                        <div class="border rounded-3 p-2 bg-light">
                            @switch($service->status)
                                @case('accepted') <span class="badge bg-primary">Accepted</span> @break
                                @case('process') <span class="badge bg-warning text-dark">Proses</span> @break
                                @case('finished') <span class="badge bg-success">Finished</span> @break
                                @case('taken') <span class="badge bg-info text-dark">Taken</span> @break
                                @case('cancelled') <span class="badge bg-danger">Cancelled</span> @break
                                @default <span class="badge bg-secondary">Unknown</span>
                            @endswitch
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Produk Servis -->
                <div class="mt-4">
                    <h5 class="fw-bold text-primary mb-3">🛠 Produk Servis</h5>

                    @if(isset($service->items) && $service->items->count() > 0)
                        <table class="table align-middle text-center shadow-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Item</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($service->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>Rp {{ number_format($item->pivot->subtotal ?? 0, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info text-center rounded-3">
                            Belum ada produk servis yang ditambahkan.
                        </div>
                    @endif
                </div>

                <!-- Ringkasan Total -->
                @php
                    $totalItem = $service->items->count();
                    $totalSubtotal = $service->items->sum(fn($i) => $i->pivot->subtotal);
                @endphp

                <div class="row text-center g-4 mt-4">
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 text-white" 
                             style="background: linear-gradient(135deg, #F06292, #E91E63);">
                            <h4>{{ $totalItem }}</h4>
                            <p class="mb-0 fw-semibold">TOTAL ITEM</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 text-white"
                             style="background: linear-gradient(135deg, #7E57C2, #5E35B1);">
                            <h4>Rp {{ number_format($totalSubtotal, 0, ',', '.') }}</h4>
                            <p class="mb-0 fw-semibold">TOTAL SUBTOTAL</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
    .fw-semibold { font-weight: 600; }
    .badge { font-size: 0.9rem; padding: 0.5em 0.8em; }
</style>
@endsection
