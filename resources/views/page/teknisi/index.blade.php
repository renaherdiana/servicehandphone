@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="background-color:#F5F5F5;">
  <div class="row mb-4 px-3">
    <div class="col-12 d-flex justify-content-between align-items-center">
      <h4 class="fw-bold" style="color:#3F51B5;">👨‍🔧 Daftar Teknisi</h4>
      <div>
        <a href="{{ route('technician.create') }}" class="btn btn-primary rounded-3 shadow-sm" style="background-color:#3F51B5; border:none;">
          <i class="mdi mdi-plus me-1"></i> Tambah Teknisi
        </a>
        <a href="{{ route('technician.trash') }}" class="btn btn-outline-danger rounded-3 shadow-sm ms-2">
          <i class="mdi mdi-delete-outline me-1"></i> Lihat Sampah
        </a>
      </div>
    </div>
  </div>

  <div class="card shadow-sm border-0 mx-3 rounded-4">
    <div class="card-header py-3 px-4" style="background: linear-gradient(90deg, #D6E4FF 0%, #EDE7F6 100%); color:#3F51B5;">
      <h5 class="mb-0 fw-bold">📋 Data Teknisi Aktif</h5>
    </div>

    <div class="card-body bg-white p-4">
      @if(session('success'))
        <div class="alert alert-success text-center fw-semibold rounded-3 py-3">
          {{ session('success') }}
        </div>
      @endif

      {{-- 🔍 Pencarian --}}
      <form method="GET" action="{{ route('technician.index') }}" class="mb-4">
        <div class="input-group" style="max-width: 350px;">
          <input type="text" name="search" class="form-control rounded-start-3"
                 placeholder="Cari nama teknisi..." value="{{ request('search') }}">
          <button class="btn btn-primary rounded-end-3" type="submit"
                  style="background-color:#3F51B5; border:none;">
            <i class="mdi mdi-magnify"></i> Cari
          </button>
        </div>
      </form>

      {{-- 📋 Tabel --}}
      <div class="table-responsive">
        <table class="table align-middle mb-0 custom-striped">
          <thead style="background-color:#EEF2FF; color:#3F51B5;">
            <tr>
              <th>No</th>
              <th>Nama Teknisi</th>
              <th>Status</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>

          <tbody>
            @forelse ($technicians as $index => $technician)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $technician->name }}</td>
              <td>
                <span class="btn-status {{ $technician->is_active ? 'active' : 'inactive' }}">
                  {{ $technician->is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="text-center">
                {{-- 🔹 Tombol Detail --}}
                <a href="{{ route('technician.show', $technician->id) }}" class="btn-action btn-detail me-1">Detail</a>

                {{-- 🔹 Tombol Edit --}}
                <a href="{{ route('technician.edit', $technician->id) }}" class="btn-action btn-edit me-1">Edit</a>

                {{-- 🔹 Tombol Hapus --}}
                <form action="{{ route('technician.destroy', $technician->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-action btn-delete"
                          onclick="return confirm('Yakin ingin menghapus teknisi ini?')">Hapus</button>
                </form>
              </td>
            </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center text-muted py-4">Belum ada data teknisi.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- 🎨 STYLE --}}
<style>
  .custom-striped tbody tr:nth-child(odd) { background-color: #FAFAFA; }
  .custom-striped tbody tr:nth-child(even) { background-color: #FFFFFF; }
  .custom-striped tbody tr:hover { background-color: #EEF2FF; transition: 0.3s ease; }

  .btn-action {
    display:inline-block; padding:6px 14px; border-radius:8px;
    font-size:0.875rem; text-decoration:none; font-weight:500;
    transition:all 0.3s ease;
  }

  .btn-detail { background-color:#D6E4FF; color:#3F51B5; }
  .btn-edit { background-color:#FFF3E0; color:#F57C00; }
  .btn-delete { background-color:#FFEBEE; color:#E53935; }

  .btn-action:hover { opacity:0.9; transform:translateY(-1px); }

  .btn-status {
    display:inline-block; padding:6px 14px; border-radius:8px;
    font-size:0.85rem; font-weight:500;
  }
  .btn-status.active { background-color:#E3F2FD; color:#1976D2; }
  .btn-status.inactive { background-color:#FFEBEE; color:#E53935; }
</style>
@endsection
