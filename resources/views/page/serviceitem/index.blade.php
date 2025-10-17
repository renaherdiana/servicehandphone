@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="background-color:#F5F5F5;">
  <div class="row mb-4 px-3">
    <div class="col-12 d-flex justify-content-between align-items-center">
      <h4 class="fw-bold">🛠️ Daftar Item Servis</h4>
      <a href="{{ route('service.item.create') }}" class="btn btn-primary rounded-3 shadow-sm" 
         style="background-color:#3F51B5; border:none;">
        <i class="mdi mdi-plus me-1"></i>  Tambah Item Baru
      </a>
    </div>
  </div>

  <div class="card shadow-sm border-0 mx-3 rounded-4">
    <div class="card-header py-3 px-4" 
         style="background: linear-gradient(90deg, #D6E4FF 0%, #EDE7F6 100%); color:#3F51B5;">
      <h5 class="mb-0 fw-bold">📄 Data Item Servis</h5>
    </div>
    <div class="card-body bg-white p-4">
      <div class="table-responsive">
        <table class="table align-middle mb-0 custom-striped">
          <thead style="background-color:#EEF2FF; color:#3F51B5;">
            <tr>
              <th>No</th>
              <th>Nama Servis</th>
              <th>Harga</th>
              <th>Status</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($serviceItems as $index => $item)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->name }}</td>
                <td>Rp {{ number_format($item->price,0,',','.') }}</td>
                <td>
                  <span class="btn-status {{ $item->is_active ? 'active' : 'cancelled' }}">
                    {{ $item->is_active ? 'Active' : 'Non Active' }}
                  </span>
                </td>
                <td class="text-center">
                  <a href="{{ route('service.item.edit', $item->id) }}" class="btn-action btn-edit me-1">Edit</a>
                  <form action="{{ route('service.item.destroy', $item->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Yakin ingin menghapus?')" 
                            class="btn-action btn-delete border-0">Delete</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">Belum ada data item servis.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<style>
  .custom-striped tbody tr:nth-child(odd) { background-color: #FAFAFA; }
  .custom-striped tbody tr:nth-child(even) { background-color: #FFFFFF; }
  .custom-striped tbody tr:hover { background-color: #EEF2FF; transition: 0.3s ease; }

  .btn-action {
    display: inline-block; padding: 6px 14px; border-radius: 8px;
    font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: 0.3s;
  }
  .btn-edit { background-color: #FFF3E0; color: #F57C00; }
  .btn-delete { background-color: #FFEBEE; color: #E53935; }
  .btn-action:hover { opacity: 0.9; transform: translateY(-1px); }

  .btn-status {
    display: inline-block; padding: 6px 14px; border-radius: 8px; font-size: 0.85rem; font-weight: 500;
  }
  .btn-status.active { background-color: #E3F2FD; color: #1976D2; }
  .btn-status.cancelled { background-color: #FFEBEE; color: #E53935; }
</style>
@endsection
