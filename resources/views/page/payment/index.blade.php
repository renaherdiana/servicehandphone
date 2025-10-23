@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="background-color:#F3F4F6; min-height:100vh;">
    <div class="container py-5">

        {{-- 🔹 Header --}}
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold text-primary mb-0">💳 Detail & Pembayaran Servis</h4>
            <a href="{{ route('payment.index') }}" class="btn btn-outline-primary rounded-3 px-3 shadow-sm">
                ⬅ Kembali
            </a>
        </div>

        {{-- 🔹 Card --}}
        <div class="card border-0 shadow rounded-4 overflow-hidden">
            <div class="card-header text-white py-3 px-4 rounded-top-4"
                 style="background: linear-gradient(90deg, #3F51B5 0%, #5C6BC0 100%);">
                <h5 class="mb-0 fw-semibold">📋 Detail Servis</h5>
            </div>

            <div class="card-body bg-white p-4">

                {{-- 🔸 Info Utama --}}
                <div class="mb-4 pb-3 border-bottom">
                    <div class="row gy-3">
                        <div class="col-md-4">
                            <label class="fw-semibold text-secondary mb-1">No. Invoice</label>
                            <div class="p-2 px-3 bg-light rounded-3 fw-bold text-dark">
                                {{ $service->invoice }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="fw-semibold text-secondary mb-1">Pelanggan</label>
                            <div class="p-2 px-3 bg-light rounded-3">
                                {{ $service->customer->name ?? '-' }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="fw-semibold text-secondary mb-1">Teknisi</label>
                            <div class="p-2 px-3 bg-light rounded-3">
                                {{ $service->technician->name ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <p class="text-muted mt-3 mb-0 small">
                        🕓 {{ $service->created_at->setTimezone('Asia/Jakarta')->translatedFormat('l, d F Y H:i') }}
                    </p>
                </div>

                {{-- 🔸 Daftar Item --}}
                <h6 class="fw-bold mb-3 text-primary">🧾 Daftar Produk / Servis</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center shadow-sm rounded-3">
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
                                    <td class="text-start ps-3">{{ $item->name }}</td>
                                    <td class="fw-semibold text-success">
                                        Rp {{ number_format($item->pivot->subtotal ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- 🔸 Perhitungan Total --}}
                @php
                    $subtotalItem = $service->items->sum(fn($i) => $i->pivot->subtotal ?? 0);
                    $dp     = $service->down_payment ?? 0;
                    $paid   = $service->payment_amount ?? $service->paid ?? 0;
                    $other  = $service->other_cost ?? 0;
                    $totalDenganTambahan = $subtotalItem + $other;
                    $totalDibayar = $dp + $paid;
                    $sisa = max($totalDenganTambahan - $totalDibayar, 0);
                    $change = max($totalDibayar - $totalDenganTambahan, 0);
                @endphp

                <div class="bg-light p-3 rounded-3 shadow-sm mb-5">
                    <div class="row text-center text-md-start small fw-semibold">
                        <div class="col-md-3 mb-2">📦 Total Item: {{ $service->items->count() }} item</div>
                        <div class="col-md-3 mb-2">💰 Total Harga: Rp {{ number_format($totalDenganTambahan,0,',','.') }}</div>
                        <div class="col-md-3 mb-2">💵 Dibayar: Rp {{ number_format($totalDibayar,0,',','.') }}</div>
                        <div class="col-md-3">🔄 Kembalian: Rp {{ number_format($change,0,',','.') }}</div>
                    </div>
                </div>

                {{-- 🔹 Form Pembayaran --}}
                <h6 class="fw-bold text-primary mb-3">💳 Form Pembayaran</h6>
                <form action="{{ route('payment.store', $service->id) }}" method="POST">
                    @csrf
                    <div class="row gy-4">

                        {{-- Biaya Tambahan --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-primary mb-2">🔧 Biaya Tambahan</label>
                            <input type="number" name="other_cost" id="other_cost"
                                   value="{{ $other }}"
                                   {{ $other > 0 ? 'readonly style=background:#E9ECEF;cursor:not-allowed;' : '' }}
                                   placeholder="Masukkan biaya tambahan (1x input)"
                                   class="form-control input-clean">
                            <small class="text-muted">
                                {{ $other > 0 ? '✅ Sudah diisi & terkunci.' : 'Hanya bisa diinput sekali.' }}
                            </small>
                        </div>

                        {{-- Metode Pembayaran --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-primary mb-2">💳 Metode Pembayaran</label>
                            <div class="select-wrapper">
                                <select name="paymentmethod" id="paymentmethod" required class="form-select input-clean">
                                    <option value="">Pilih Metode</option>
                                    <option value="cash" {{ $service->paymentmethod == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="transfer" {{ $service->paymentmethod == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                </select>
                            </div>
                        </div>

                        {{-- Jumlah Dibayar --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-primary mb-2">💵 Tambahan Pembayaran</label>
                            <input type="number" name="paid" id="paid" value="0"
                                   placeholder="Masukkan tambahan pembayaran"
                                   class="form-control input-clean">

                            <div class="mt-3 small text-muted">
                                <div>💰 <strong>Sisa tagihan:</strong> <span id="remaining" class="fw-bold text-dark">Rp {{ number_format($sisa, 0, ',', '.') }}</span></div>
                                <div>✅ <strong>Total dibayar:</strong> <span id="totalPaidDisplay" class="fw-bold text-success">Rp {{ number_format($totalDibayar, 0, ',', '.') }}</span></div>
                                <div>💵 <strong>Kembalian:</strong> <span id="changeDisplay" class="fw-bold text-primary">Rp {{ number_format($change, 0, ',', '.') }}</span></div>
                            </div>
                        </div>
                    </div>

                    {{-- Hidden Field --}}
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

{{-- 🔸 STYLE TAMBAHAN --}}
<style>
    .input-clean {
        width: 100%;
        height: 54px;
        font-size: 1.05rem;
        padding: 0.6rem 1rem;
        border: 1px solid #DADCE0;
        border-radius: 0.6rem;
        transition: 0.2s ease-in-out;
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        background-color: #fff;
    }

    .input-clean:focus {
        border-color: #3F51B5;
        box-shadow: 0 0 0 0.2rem rgba(63, 81, 181, 0.15);
    }

    .select-wrapper {
        width: 100%;
    }

    select.input-clean {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml;utf8,<svg fill='gray' height='22' viewBox='0 0 24 24' width='22' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px;
        padding-right: 2.5rem;
    }

    label.form-label {
        color: #3F51B5;
        font-weight: 600;
    }

    .table > :not(caption) > * > * {
        vertical-align: middle;
    }
</style>

{{-- 🔸 SCRIPT --}}
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
        const other = parseFloat(otherEl.value) || 0;
        const tambahanBayar = parseFloat(paidInput.value) || 0;

        const totalTagihan = subtotal + other;
        const totalDibayar = totalSudahDibayar + tambahanBayar;
        const sisa = Math.max(totalTagihan - totalDibayar, 0);
        const kembali = Math.max(totalDibayar - totalTagihan, 0);

        remainingEl.textContent = "Rp " + sisa.toLocaleString('id-ID');
        totalPaidEl.textContent = "Rp " + totalDibayar.toLocaleString('id-ID');
        changeShow.textContent  = "Rp " + kembali.toLocaleString('id-ID');
        changeEl.value = kembali;
    }

    calc();
    [otherEl, paidInput].forEach(el => el.addEventListener('input', calc));
});
</script>
@endsection
