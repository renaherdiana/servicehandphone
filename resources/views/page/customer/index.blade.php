@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="background-color:#F5F5F5;">
  <div class="row mb-4 px-3">
    <div class="col-12 d-flex justify-content-between align-items-center">
      <h4 class="fw-bold"></h4>
      <a href="{{ route('customer.create') }}" 
        class="btn btn-primary rounded-3 shadow-sm" 
        style="background-color:#3F51B5; border:none;">
        <i class="mdi mdi-plus me-1"></i> Tambah Pelanggan Baru
      </a>
    </div>
  </div>

  <div class="card shadow-sm border-0 mx-3 rounded-4">
    <div class="card-header py-3 px-4" 
         style="background: linear-gradient(90deg, #D6E4FF 0%, #EDE7F6 100%); color:#3F51B5;">
      <h5 class="mb-0 fw-bold">👥 Daftar Pelanggan</h5>
    </div>

    <div class="card-body bg-white p-4">
     @if(session('success'))
      <div class="alert alert-success text-center fw-semibold rounded-3 py-3">
          
        {{ session('success') }}
      </div>
    @endif


      <div class="table-responsive">
        <table class="table align-middle mb-0 custom-striped">
          <thead style="background-color:#EEF2FF; color:#3F51B5;">
            <tr>
              <th>No</th>
              <th>Nama Pelanggan</th>
              <th>Status</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>

          <tbody>
            @forelse ($customers as $index => $customer)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $customer->name }}</td>
              <td>
                @if ($customer->is_active)
                  <span class="btn-status active">Active</span>
                @else
                  <span class="btn-status inactive">Inactive</span>
                @endif
              </td>
              <td class="text-center">
                <a href="{{ route('customer.show', $customer->id) }}" class="btn-action btn-detail me-1">Detail</a>
                <a href="{{ route('customer.edit', $customer->id) }}" class="btn-action btn-edit me-1">Edit</a>
                <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-action btn-delete"
                          onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">
                    Delete
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center text-muted py-4">
                Belum ada data pelanggan.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<style>
  .custom-striped tbody tr:nth-child(odd) {
    background-color: #FAFAFA;
  }

  .custom-striped tbody tr:nth-child(even) {
    background-color: #FFFFFF;
  }

  .custom-striped tbody tr:hover {
    background-color: #EEF2FF;
    transition: background-color 0.3s ease;
  }

  .btn-action {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 0.875rem;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
  }

  .btn-detail {
    background-color: #D6E4FF;
    color: #3F51B5;
  }

  .btn-edit {
    background-color: #FFF3E0;
    color: #F57C00;
  }

  .btn-delete {
    background-color: #FFEBEE;
    color: #E53935;
  }

  .btn-action:hover {
    opacity: 0.9;
    transform: translateY(-1px);
  }

  .btn-status {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
  }

  .btn-status.active {
    background-color: #E3F2FD;
    color: #1976D2;
  }

  .btn-status.inactive {
    background-color: #FFEBEE;
    color: #E53935;
  }
</style>
@endsection
