@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="background-color:#F5F5F5; min-height: 100vh;">
    <div class="container py-5">
        <div class="card shadow-sm border-0 rounded-4">
            
            <!-- Header -->
            <div class="card-header text-white rounded-top-4"
                 style="background: linear-gradient(90deg, #3F51B5 0%, #7986CB 100%);">
                <h5 class="mb-0 fw-bold">Tambah Pengguna</h5>
            </div>

            <!-- Body -->
            <div class="card-body p-5">

                {{-- Pesan Error --}}
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 p-3 mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form enctype="multipart/form-data" method="POST" action="{{ route('pengguna.store') }}">
                    @csrf

                    <div class="row g-4">
                        <div class="col-12">

                            {{-- Foto --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Foto</label>
                                <input type="file" name="foto" class="form-control form-control-lg rounded-3" accept="image/*">
                            </div>

                            {{-- Nama --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama</label>
                                <input type="text" name="name" class="form-control form-control-lg rounded-3"
                                       placeholder="Masukkan nama lengkap" required>
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Alamat</label>
                                <textarea name="alamat" class="form-control form-control-lg rounded-3" rows="3"
                                          placeholder="Masukkan alamat pengguna" required></textarea>
                            </div>

                            {{-- Nomor Telepon --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nomor Telepon</label>
                                <input type="text" name="no_telp" class="form-control form-control-lg rounded-3"
                                       placeholder="Masukkan nomor telepon pengguna" required>
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control form-control-lg rounded-3"
                                       placeholder="Masukkan email pengguna" required>
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control form-control-lg rounded-3"
                                       placeholder="Masukkan password" required>
                            </div>

                            {{-- Status --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" 
                                        class="form-select form-select-lg rounded-3 status-select w-100" 
                                        required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="active" 
                                        {{ old('status', $user->status ?? '') == 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="inactive" 
                                        {{ old('status', $user->status ?? '') == 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>

                            {{-- Tombol --}}
                            <div class="mt-5 d-flex justify-content-end align-items-center button-group">
                                <a href="{{ route('pengguna.index') }}"
                                  class="btn btn-secondary fw-semibold rounded-3 shadow-sm px-4 py-2">
                                    Kembali
                                </a>
                                <button type="submit"
                                        class="btn text-white fw-semibold rounded-3 shadow-sm px-4 py-2"
                                        style="background: linear-gradient(90deg, #3F51B5 0%, #7986CB 100%); border:none;">
                                    Simpan
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    label.form-label {
        color: #3F51B5;
    }

    input.form-control, textarea.form-control, select.form-select {
        border: 1px solid #E0E0E0;
        transition: 0.3s;
    }

    input.form-control:focus, textarea.form-control:focus, select.form-select:focus {
        border-color: #3F51B5;
        box-shadow: 0 0 0 0.2rem rgba(63, 81, 181, 0.2);
    }

    .status-select {
        height: 52px;
        font-size: 1rem;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
    }

  .status-select {
      width: 100%;
      height: 60px;
      font-size: 1.1rem;
      padding: 0.75rem 1rem;
      border: 1.8px solid #D1D5DB;
      border-radius: 0.75rem;
      transition: 0.3s ease;
  }

  .status-select:focus {
      border-color: #3F51B5;
      box-shadow: 0 0 0 0.25rem rgba(63, 81, 181, 0.2);
  }
  .button-group {
    gap: 1.5rem; /* kasih jarak antar tombol */
}

  .btn {
      font-size: 1rem;
      transition: 0.3s ease;
  }

  .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(63, 81, 181, 0.2);
  }
</style>

@endsection
