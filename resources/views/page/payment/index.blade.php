@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="background-color:#F3F4F6; min-height:100vh;">
    <div class="container py-5">

        <!-- Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold text-primary mb-0">💳 Detail & Pembayaran Servis</h4>
            <a href="{{ route('payment.index') }}" class="btn btn-outline-primary rounded-3 px-3 shadow-sm">
                ⬅ Kembali
            </a>
        </div>

        <!-- CARD -->
        <div class="card border-0 shadow rounded-4 overflow-hidden">
            <div class="card-header text-white rounded-top-4 py-3 px-4"
                 style="background: linear-gradient(90deg, #3F51B5 0%, #5C6BC0 100%);">
                <h5 class="mb-0 fw-semibold">📋 Detail Servis</h5>
            </div>

            <div class="card-body bg-white p-4">

                <!-- Detail Servis -->
                <div class="mb-4 border-bottom pb-3">
                    <div class="row gy-3">
                        <div class="col-md-4">
                            <p class="mb-1 fw-semibold text-secondary">No. Invoice</p>
                            <div class="p-2 px-3 bg-light rounded-3 fw-bold text-dark">
                                {{ $service->invoice }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <p class="mb-1 fw-semibold text-secondary">Pelanggan</p>
                            <div class="p-2 px-3 bg-light rounded-3">
                                {{ $service->customer->name ?? '-' }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <p class="mb-1 fw-semibold text-secondary">Teknisi</p>
                            <div class="p-2 px-3 bg-light rounded-3">
                                {{ $service->technician->name ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <p class="text-muted mt-3 mb-0">
                        🕓 {{ $service->created_at->setTimezone('Asia/Jakarta')->translatedFormat('l, d F Y H:i') }}
                    </p>
                </div>

                <!-- Daftar Item / Servis -->
                <h6 class="fw-bold mb-3 text-primary">🧾 Daftar Produk / Servis</h6>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center shadow-sm rounded-3 overflow-hidden w-100">
                        <thead class="table-primary">
                            <tr>
                                <th style="width:5%">#</th>
                                <th style="width:65%">Nama Item</th>
                                <th style="width:30%">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($service->items as $i => $item)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td class="text-start text-wrap ps-3">{{ $item->name }}</td>
                                    <td class="fw-semibold text-success">
                                        Rp {{ number_format($item->pivot->subtotal ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Perhitungan Total -->
                @php
                    // ✅ Hitung total langsung dari subtotal item
                    $subtotalItem = $service->items->sum(fn($i) => $i->pivot->subtotal ?? 0);

                    $dp     = $service->down_payment ?? 0;
                    $paid   = $service->payment_amount ?? $service->paid ?? 0;
                    $other  = $service->other_cost ?? 0;

                    $totalDenganTambahan = $subtotalItem + $other;
                    $totalDibayar = $dp + $paid;

                    $sisa = max($totalDenganTambahan - $totalDibayar, 0);
                    $change = max($totalDibayar - $totalDenganTambahan, 0);
                @endphp

                <div class="total-wrapper mt-4">
                    <div class="total-box bg-light shadow-sm rounded-3 p-3 w-100">
                        <div class="row text-center text-md-start">
                            <div class="col-12 col-md-3 mb-2 mb-md-0">
                                <strong>Total Items:</strong> {{ $service->items->count() }} item
                            </div>
                            <div class="col-12 col-md-3 mb-2 mb-md-0">
                                <strong>Total Harga:</strong> Rp {{ number_format($totalDenganTambahan,0,',','.') }}
                            </div>
                            <div class="col-12 col-md-3 mb-2 mb-md-0">
                                <strong>Dibayar:</strong> Rp {{ number_format($totalDibayar,0,',','.') }}
                            </div>
                            <div class="col-12 col-md-3">
                                <strong>Kembalian:</strong> Rp {{ number_format($change,0,',','.') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FORM PEMBAYARAN -->
                <form action="{{ route('payment.store', $service->id) }}" method="POST" class="mt-5">
                    @csrf
                    <div class="row gy-4">

                        <!-- Biaya Tambahan (hanya sekali input) -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-primary mb-2">🔧 Biaya Tambahan</label>
                            <input type="number" name="other_cost" id="other_cost"
                                   value="{{ $other }}"
                                   {{ $other > 0 ? 'readonly style=background:#E9ECEF;cursor:not-allowed;' : '' }}
                                   placeholder="Masukkan biaya tambahan (1x input)"
                                   class="form-control border-0 bg-transparent fw-semibold">
                            @if($other > 0)
                                <small class="text-muted">✅ Sudah diisi & terkunci.</small>
                            @else
                                <small class="text-muted">Hanya bisa diinput sekali.</small>
                            @endif
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-primary mb-2">💳 Metode Pembayaran</label>
                            <select name="paymentmethod" id="paymentmethod" required
                                    class="form-control border-0 bg-transparent fw-semibold">
                                <option value="">Pilih Metode</option>
                                <option value="cash" {{ $service->paymentmethod == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="transfer" {{ $service->paymentmethod == 'transfer' ? 'selected' : '' }}>Transfer</option>
                            </select>
                        </div>

                        <!-- Jumlah Dibayar -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-primary mb-2">💵 Jumlah Dibayar</label>
                            <input type="number" name="paid" id="paid" value="0"
                                   placeholder="Masukkan tambahan pembayaran"
                                   class="form-control border-0 bg-transparent fw-semibold">

                            <div class="mt-2 small">
                                <p class="mb-1 text-muted">💰 Sisa tagihan: <span id="remaining" class="fw-bold text-dark">Rp {{ number_format($sisa, 0, ',', '.') }}</span></p>
                                <p class="mb-1 text-success">✅ Total dibayar: <span id="totalPaidDisplay" class="fw-bold">Rp {{ number_format($totalDibayar, 0, ',', '.') }}</span></p>
                                <p class="mb-0 text-primary">💵 Kembalian: <span id="changeDisplay" class="fw-bold">Rp {{ number_format($change, 0, ',', '.') }}</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden field -->
                    <input type="hidden" name="subtotal_item" id="subtotal_item" value="{{ $subtotalItem }}">
                    <input type="hidden" name="change" id="change" value="{{ $change }}">
                    <input type="hidden" name="down_payment" value="{{ $dp }}">

                    <div class="text-end mt-5">
                        <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold rounded-4 shadow-sm">
                            💾 Simpan Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const subtotalEl  = document.getElementById('subtotal_item');
    const otherEl     = document.getElementById('other_cost');
    const paidInput   = document.getElementById('paid');
    const changeEl    = document.getElementById('change');
    const remainingEl = document.getElementById('remaining');
    const totalPaidEl = document.getElementById('totalPaidDisplay');
    const changeShow  = document.getElementById('changeDisplay');

    const dpInput = document.querySelector('input[name="down_payment"]');
    const dp = dpInput ? parseFloat(dpInput.value) || 0 : 0;
    const existingPaid = {{ $service->payment_amount ?? $service->paid ?? 0 }};
    let totalSudahDibayar = dp + existingPaid;

    function calc() {
        const subtotal = parseFloat(subtotalEl.value) || 0;
        const other = parseFloat(otherEl.value) || 0; // 🧮 nilai langsung dari input
        const tambahanBayar = parseFloat(paidInput.value) || 0;

        // Hitung total tagihan dan pembayaran
        const totalTagihan = subtotal + other;
        const totalDibayar = totalSudahDibayar + tambahanBayar;
        const sisa = Math.max(totalTagihan - totalDibayar, 0);
        const kembali = Math.max(totalDibayar - totalTagihan, 0);

        // Update tampilan secara real-time
        remainingEl.textContent = "Rp " + sisa.toLocaleString('id-ID');
        totalPaidEl.textContent = "Rp " + totalDibayar.toLocaleString('id-ID');
        changeShow.textContent  = "Rp " + kembali.toLocaleString('id-ID');
        changeEl.value = kembali;
    }

    // Jalankan saat halaman dimuat dan saat input berubah
    calc();
    [otherEl, paidInput].forEach(el => el.addEventListener('input', calc));
});
</script>

@endsection
