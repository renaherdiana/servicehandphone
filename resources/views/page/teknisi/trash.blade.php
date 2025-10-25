@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="background-color:#F5F5F5; min-height: 100vh;">
  <div class="container py-4">

    {{-- 🔹 Header --}}
    <div class="mb-4 d-flex justify-content-between align-items-center">
      <h4 class="fw-bold text-primary mb-0">🗑️ Trash Teknisi</h4>
      <a href="{{ route('technician.index') }}" class="btn btn-secondary rounded-3 shadow-sm">
        <i class="mdi mdi-arrow-left me-1"></i> Kembali
      </a>
    </div>

    {{-- 🔹 Card Utama --}}
    <div class="card shadow-sm border-0 rounded-4">
      <div class="card-header py-3 px-4" 
           style="background: linear-gradient(90deg, #D6E4FF 0%, #EDE7F6 100%); color:#3F51B5;">
        <h5 class="mb-0 fw-bold">🧑‍🔧 Data Teknisi yang Dihapus</h5>
      </div>

      <div class="card-body bg-white p-4">
        @if(session('success'))
          <div class="alert alert-success text-center fw-semibold rounded-3 py-3">
            {{ session('success') }}
          </div>
        @endif

        {{-- 🔹 Tabel Trash --}}
        <div class="table-responsive">
          <table class="table align-middle mb-0 custom-striped">
            <thead style="background-color:#EEF2FF; color:#3F51B5;">
              <tr>
                <th>No</th>
                <th>Nama Teknisi</th>
                <th>Dihapus Pada</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>

            <tbody>
              @forelse ($technicians as $index => $technician)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $technician->name }}</td>
                <td>{{ \Carbon\Carbon::parse($technician->deleted_at)->translatedFormat('d F Y, H:i') }}</td>
                <td class="text-center">
                  {{-- 🔄 Tombol Restore --}}
                  <form action="{{ route('technician.restore', $technician->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-action btn-restore me-1"
                            onclick="return confirm('Yakin ingin mengembalikan data ini?')">
                      Restore
                    </button>
                  </form>

                  {{-- ❌ Tombol Hapus Permanen --}}
                  <form action="{{ route('technician.forceDelete', $technician->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete"
                            onclick="return confirm('Hapus permanen data ini?')">
                      Hapus Permanen
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="text-center text-muted py-4">
                  Tidak ada data di trash.
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
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
  .btn-restore { background-color:#E8F5E9; color:#388E3C; }
  .btn-delete { background-color:#FFEBEE; color:#E53935; }
  .btn-action:hover { opacity:0.9; transform:translateY(-1px); }
</style>
@endsection
