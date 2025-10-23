@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="background-color:#F5F5F5; min-height: 100vh;">
  <div class="container py-5">

    <!-- Header -->
    <div class="row mb-4">
      <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="fw-bold text-primary">📱 Daftar Servis</h4>
        <a href="{{ route('service.create') }}" class="btn btn-primary rounded-3 shadow-sm"
           style="background-color:#3F51B5; border:none;">
          <i class="mdi mdi-plus me-1"></i> Tambah Servis Baru
        </a>
      </div>
    </div>

    <!-- Card -->
    <div class="card shadow-sm border-0 rounded-4">
      <div class="card-header py-3 px-4 text-white rounded-top-4"
           style="background: linear-gradient(90deg, #3F51B5 0%, #7986CB 100%);">
        <h5 class="mb-0 fw-bold">📄 Daftar Riwayat Servis</h5>
      </div>

      <div class="card-body bg-white p-4">
        <div class="table-responsive">
          <table class="table align-middle mb-0 custom-striped">
            <thead style="background-color:#EEF2FF; color:#3F51B5;">
              <tr>
                <th>No. Invoice</th>
                <th>Pelanggan</th>
                <th>Handphone</th>
                <th>Teknisi</th>
                <th>Estimasi Biaya</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($services as $s)
              <tr>
                <td>{{ $s->invoice }}</td>

                {{-- 🔹 Nama pelanggan --}}
                <td>{{ optional($s->customer)->name ?? '-' }}</td>

                {{-- 🔹 Handphone --}}
                <td>
                  {{ $s->handphone 
                      ? $s->handphone->brand . ' ' . $s->handphone->model . 
                        ' (' . ($s->handphone->release_year ?? '-') . ')' 
                      : '-' }}
                </td>

                {{-- 🔹 Teknisi --}}
                <td>{{ optional($s->technician)->name ?? '-' }}</td>

                {{-- 🔹 Estimasi Biaya --}}
                <td>Rp {{ number_format($s->cost ?? 0, 0, ',', '.') }}</td>

                {{-- 🔹 Status Servis --}}
                <td>
                  @switch($s->status)
                      @case('accepted')
                          <span class="btn-status accepted">Accepted</span>
                          @break
                      @case('process')
                          <span class="btn-status process">Process</span>
                          @break
                      @case('finished')
                          <span class="btn-status finished">Finished</span>
                          @break
                      @case('taken')
                          <span class="btn-status taken">Taken</span>
                          @break
                      @case('cancelled')
                          <span class="btn-status cancelled">Cancelled</span>
                          @break
                      @default
                          <span class="btn-status unknown">Unknown</span>
                  @endswitch
                </td>

                {{-- 🔹 Aksi --}}
                <td class="text-center">
                  <a href="{{ route('service.show', $s->id) }}" class="btn-action btn-detail me-1">Detail</a>
                  <a href="{{ route('service.edit', $s->id) }}" class="btn-action btn-edit me-1">Edit</a>
                  
                  <form action="{{ route('service.destroy', $s->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete border-0"
                            onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center text-muted py-4">Belum ada data servis.</td>
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
  /* Table aesthetic */
  .custom-striped tbody tr:nth-child(odd) { background-color: #FAFAFA; }
  .custom-striped tbody tr:nth-child(even) { background-color: #FFFFFF; }
  .custom-striped tbody tr:hover { background-color: #EEF2FF; transition: 0.3s ease; }

  /* Tombol aksi */
  .btn-action {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
  }
  .btn-action:hover {
    transform: scale(1.05);
    opacity: 0.95;
  }
  .btn-detail { background-color: #E3F2FD; color: #1976D2; }
  .btn-edit { background-color: #FFF3E0; color: #F57C00; }
  .btn-delete { background-color: #FFEBEE; color: #E53935; }

  /* Status badge */
  .btn-status {
    display: inline-flex;
    align-items: center;
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 600;
    letter-spacing: .3px;
  }
  .btn-status.accepted  { background-color: #E3F2FD; color: #1565C0; }
  .btn-status.process   { background-color: #FFF3E0; color: #F57C00; }
  .btn-status.finished  { background-color: #E8F5E9; color: #388E3C; }
  .btn-status.taken     { background-color: #E1F5FE; color: #0288D1; }
  .btn-status.cancelled { background-color: #FFEBEE; color: #D32F2F; }
  .btn-status.unknown   { background-color: #F3E5F5; color: #7B1FA2; }
</style>
@endsection
