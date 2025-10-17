@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="background-color:#F5F5F5; min-height: 100vh;">
    <div class="container py-4">

        <!-- Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">➕ Tambah Servis Baru</h4>
        </div>

        <!-- Form Card -->
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header text-white rounded-top-4"
                 style="background: linear-gradient(90deg, #3F51B5 0%, #7986CB 100%);">
                <h5 class="mb-0 fw-bold">Formulir Servis</h5>
            </div>

            <div class="card-body p-4 bg-white">
                <form action="{{ route('service.store') }}" method="POST">
                    @csrf

                    <!-- Input Utama -->
                    <div class="mb-3">
                        <label for="invoice" class="form-label fw-semibold">No. Invoice</label>
                        <input type="text" class="form-control" id="invoice" name="invoice" placeholder="INV-2025-001" required>
                    </div>

                    <!-- Nama Pelanggan -->
                    <div class="mb-3">
                        <label for="customer_id" class="form-label fw-semibold text-primary">Nama Pelanggan</label>
                        <select 
                            name="customer_id" 
                            id="customer_id" 
                            class="form-select rounded-3 shadow-sm border-0"
                            required
                            style="width: 100%; max-width: 1500px; height: 55px; font-size: 1rem; padding: 0.75rem 1rem; border-radius: 0.5rem; background-color: #fff;">
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pilih Handphone -->
                    <div class="mb-3">
                        <label for="handphone_id" class="form-label fw-semibold text-primary">Handphone</label>
                        <select 
                            name="handphone_id" 
                            id="handphone_id" 
                            class="form-select rounded-3 shadow-sm border-0"
                            required
                            style="width: 100%; max-width: 1500px; height: 55px; font-size: 1rem; padding: 0.75rem 1rem; border-radius: 0.5rem; background-color: #fff;">
                            <option value="">-- Pilih Handphone --</option>
                            @foreach($handphones as $hp)
                                <option value="{{ $hp->id }}">
                                    {{ $hp->brand }} {{ $hp->model }} ({{ $hp->release_year ?? 'Tahun tidak diketahui' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pilih Teknisi -->
                    <div class="mb-3">
                        <label for="technician_id" class="form-label fw-semibold text-primary">Teknisi</label>
                        <select 
                            name="technician_id" 
                            id="technician_id" 
                            class="form-select rounded-3 shadow-sm border-0"
                            required
                            style="width: 100%; max-width: 1500px; height: 55px; font-size: 1rem; padding: 0.75rem 1rem; border-radius: 0.5rem; background-color: #fff;">
                            <option value="">-- Pilih Teknisi --</option>
                            @foreach($technicians as $technician)
                                <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pembayaran -->
                    <div class="mb-3">
                        <label for="payment_amount" class="form-label fw-semibold">DP / Pembayaran Awal</label>
                        <input type="number" class="form-control" id="payment_amount" name="payment_amount" min="0" value="0">
                    </div>

                    <div class="mb-4">
                        <label for="payment_method" class="form-label fw-semibold">Metode Pembayaran</label>
                        <select class="form-select" id="payment_method" name="payment_method"
                                style="width: 100%; max-width: 1500px; height: 50px; font-size: 1rem;">
                            <option value="">-- Pilih Metode --</option>
                            <option value="cash">Cash</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>

                    <!-- Produk Servis Dinamis -->
                    <div class="mt-5">
                        <label class="form-label fw-semibold text-primary">Produk Servis</label>
                        <table class="table align-middle text-center" id="productTable">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Action</th>
                                    <th>Product</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                        <div class="text-center">
                            <button type="button" id="addProductBtn" class="btn btn-outline-primary rounded-3 mt-2">
                                + Tambah Item Servis
                            </button>
                        </div>
                    </div>

                    <!-- Total Ringkasan -->
                    <div class="row text-center g-4 mt-4">
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 text-white" style="background: linear-gradient(135deg, #F06292, #E91E63);">
                                <h4 id="totalProduct">0</h4>
                                <p class="mb-0 fw-semibold">TOTAL PRODUK</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 text-white" style="background: linear-gradient(135deg, #7E57C2, #5E35B1);">
                                <h4 id="totalSubtotal">0</h4>
                                <p class="mb-0 fw-semibold">TOTAL SUBTOTAL</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="mt-5 d-flex justify-content-end align-items-center" style="gap: 20px;">
                        <a href="{{ route('service') }}" 
                           class="btn btn-secondary fw-semibold rounded-3 shadow-sm px-4 py-2"
                           style="margin-right: 15px;">
                            Kembali
                        </a>
                        <button type="submit" 
                                class="btn px-4 py-2 text-white fw-semibold rounded-3 shadow-sm" 
                                style="background: linear-gradient(90deg, #3F51B5 0%, #7986CB 100%); border:none;">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.form-label { color:#3F51B5; }
.form-control:focus, .form-select:focus { border-color:#3F51B5; box-shadow:0 0 0 0.2rem rgba(63,81,181,.25); }
.status-select { height:50px; font-size:1rem; padding:0.75rem 1rem; border-radius:0.5rem; }
.product-select { height:50px!important; font-size:1rem; padding:0.6rem 1rem; border-radius:0.6rem; min-width:230px; }
#productTable td { vertical-align: middle; }
.removeRow { background:white!important; color:#e53935!important; border:1px solid #e53935!important; border-radius:10px; font-size:1rem; transition:.3s; }
.removeRow:hover { background:#e53935!important; color:white!important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const table = document.querySelector('#productTable tbody');
    const addBtn = document.getElementById('addProductBtn');
    const allItems = @json($serviceItems);

    // 🧩 Tambah baris pertama otomatis
    addRow();

    // Fungsi update total dan urutan
    function updateTotals() {
        let totalProduct = table.rows.length;
        let totalSubtotal = 0;

        Array.from(table.rows).forEach((row, i) => {
            row.cells[0].textContent = i + 1;
            const subtotal = parseFloat(row.querySelector('.subtotal').value) || 0;
            totalSubtotal += subtotal;
        });

        document.getElementById('totalProduct').textContent = totalProduct;
        document.getElementById('totalSubtotal').textContent = totalSubtotal.toLocaleString('id-ID');
    }

    // Tambah baris baru
    addBtn.addEventListener('click', () => addRow());

    function addRow() {
        const rowCount = table.rows.length;
        let options = '<option value="">Pilih produk...</option>';
        allItems.forEach(item => {
            options += `<option value="${item.id}" data-price="${item.price}">${item.name}</option>`;
        });

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${rowCount + 1}</td>
            <td><button type="button" class="btn removeRow">🗑️</button></td>
            <td>
                <select name="products[${rowCount}][id]" class="form-select product-select" required>
                    ${options}
                </select>
            </td>
            <td>
                <input type="text" name="products[${rowCount}][subtotal]" class="form-control subtotal" readonly value="0">
            </td>
        `;
        table.appendChild(newRow);
        updateTotals();
    }

    // Update subtotal saat pilih produk
    table.addEventListener('change', e => {
        if (e.target.classList.contains('product-select')) {
            const row = e.target.closest('tr');
            const price = e.target.selectedOptions[0].dataset.price || 0;
            row.querySelector('.subtotal').value = price;
            updateTotals();
        }
    });

    // Hapus baris
    table.addEventListener('click', e => {
        if (e.target.classList.contains('removeRow')) {
            const rows = Array.from(table.rows);
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                updateTotals();
            } else {
                alert("Minimal harus ada satu produk servis!");
            }
        }
    });
});
</script>
@endsection
