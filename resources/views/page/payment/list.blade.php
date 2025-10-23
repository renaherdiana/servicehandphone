@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="background-color:#F5F5F5; min-height: 100vh;">
  <div class="container py-4">

    <!-- Header -->
    <div class="mb-4 d-flex justify-content-between align-items-center">
      <h4 class="fw-bold" style="color:#3F51B5;">💰 Daftar Pembayaran Servis</h4>
    </div>

    <!-- Card -->
    <div class="card shadow-sm border-0 rounded-4">
      <div class="card-header py-3 px-4 text-white rounded-top-4"
           style="background: linear-gradient(90deg, #3F51B5 0%, #7986CB 100%);">
        <h5 class="mb-0 fw-bold">📄 Data Pembayaran</h5>
      </div>

      <div class="card-body bg-white p-4">
        <div class="table-responsive">
          <table class="table align-middle text-center custom-striped mb-0">
            <thead style="background-color:#EEF2FF; color:#3F51B5;">
              <tr>
                <th>Invoice</th>
                <th>Nama Pelanggan</th>
                <th>Total Biaya</th>
                <th>Status Pembayaran</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($services as $service)
                @php
                  $status = $service->status_paid ?? 'unpaid';
                  $badgeClass = match($status) {
                      'paid' => 'status-paid',
                      'debt' => 'status-debt',
                      default => 'status-unpaid',
                  };
                  $statusText = match($status) {
                      'paid' => 'Paid',
                      'debt' => 'Debt',
                      default => 'Unpaid',
                  };
                @endphp

                <tr>
                  <td><strong>{{ $service->invoice }}</strong></td>
                  <td>{{ $service->customer->name ?? '-' }}</td>
                  <td>Rp {{ number_format($service->cost ?? 0, 0, ',', '.') }}</td>
                  <td><span class="status-badge {{ $badgeClass }}">{{ $statusText }}</span></td>
                  <td>
                    @if($status !== 'paid')
                      <a href="{{ route('payment.create', $service->id) }}" 
                         class="btn-action btn-pay">Bayar</a>
                    @else
                      <span class="badge-lunas">
                        <i class="mdi mdi-check-circle me-1"></i> Lunas
                      </span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-muted py-4">Belum ada data servis.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  /* 🌸 Table Style */
  .custom-striped tbody tr:nth-child(odd) { background-color: #FAFAFA; }
  .custom-striped tbody tr:nth-child(even) { background-color: #FFFFFF; }
  .custom-striped tbody tr:hover { background-color: #EEF2FF; transition: 0.3s ease; }

  /* 🌈 Status Badges */
  .status-badge {
    display:inline-block;
    padding:6px 14px;
    border-radius:8px;
    font-weight:600;
    font-size:0.9rem;
  }

  .status-paid { background-color:#E8F5E9; color:#2E7D32; }
  .status-debt { background-color:#FFF8E1; color:#F57F17; }
  .status-unpaid { background-color:#FFEBEE; color:#C62828; }

  /* 💳 Tombol Bayar */
  .btn-action {
    display:inline-block;
    padding:6px 14px;
    border-radius:8px;
    font-size:0.875rem;
    font-weight:500;
    text-decoration:none;
    transition:0.3s;
  }

  .btn-pay {
    background-color:#E3F2FD;
    color:#1976D2;
    border:none;
  }

  .btn-pay:hover {
    background-color:#BBDEFB;
    transform:translateY(-1px);
  }

  /* ✅ Badge Lunas Aesthetic */
  .badge-lunas {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #E8F5E9;
    color: #2E7D32;
    padding: 6px 14px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    box-shadow: 0 2px 4px rgba(46, 125, 50, 0.1);
    transition: all 0.3s ease;
  }

  .badge-lunas i {
    font-size: 1rem;
  }

  .badge-lunas:hover {
    background: #C8E6C9;
    transform: scale(1.03);
  }
</style>
@endsection
