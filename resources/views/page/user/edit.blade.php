@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="background-color:#F5F5F5; min-height: 100vh;">
    <div class="container py-5">
        <div class="card shadow-sm border-0 rounded-4">

            <!-- Header -->
            <div class="card-header text-white rounded-top-4"
                 style="background: linear-gradient(90deg, #3F51B5 0%, #7986CB 100%);">
                <h5 class="mb-0 fw-bold">Edit Pengguna</h5>
            </div>

            <!-- Body -->
            <div class="card-body p-5">

                {{-- Pesan sukses/error --}}
                @if (session('success'))
                    <div class="alert alert-success rounded-3 p-3 mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 p-3 mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form enctype="multipart/form-data" method="POST" action="{{ route('pengguna.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-12">

                            {{-- Foto --}}
                            <div class="mb-4 text-center">
                                <label class="form-label fw-semibold d-block mb-3">Foto</label>

                                @if($user->foto)
                                    <div class="d-flex justify-content-center mb-3">
                                        <img src="{{ asset('storage/'.$user->foto) }}"
                                             alt="Foto Pengguna"
                                             class="user-preview shadow-sm">
                                    </div>
                                @else
                                    <p class="text-muted text-center">Belum ada foto</p>
                                @endif

                                <input type="file" name="foto" class="form-control form-control-lg rounded-3" accept="image/*">
                                <small class="text-muted d-block mt-2">Kosongkan jika tidak ingin mengganti foto</small>
                            </div>

                            {{-- Nama --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control form-control-lg rounded-3"
                                       value="{{ old('name', $user->name) }}" required>
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Alamat</label>
                                <textarea name="alamat" class="form-control form-control-lg rounded-3" rows="3"
                                          required>{{ old('alamat', $user->alamat) }}</textarea>
                            </div>

                            {{-- Nomor Telepon --}}
                          <div class="mb-3">
                              <label class="form-label fw-semibold">Nomor Telepon</label>
                              <input type="text" name="no_telp" class="form-control form-control-lg rounded-3"
                                    value="{{ old('no_telp', $user->no_telp) }}" required>
                          </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control form-control-lg rounded-3"
                                       value="{{ old('email', $user->email) }}" required>
                            </div>

                            {{-- Password (opsional) --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control form-control-lg rounded-3"
                                       placeholder="Kosongkan jika tidak ingin mengubah password">
                            </div>

                            {{-- Status --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" class="form-select form-select-lg rounded-3 status-select" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            {{-- Tombol --}}
                            <div class="mt-4 d-flex justify-content-end gap-3">
                                <a href="{{ route('pengguna.index') }}"
                                   class="btn btn-secondary fw-semibold rounded-3 shadow-sm px-4">
                                    Kembali
                                </a>
                                <button type="submit"
                                        class="btn px-4 text-white fw-semibold rounded-3 shadow-sm"
                                        style="background: linear-gradient(90deg, #3F51B5 0%, #7986CB 100%); border:none;">
                                    Update
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
    .user-preview {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #E0E0E0;
        background-color: #fff;
        transition: 0.25s ease-in-out;
    }

    .user-preview:hover {
        transform: scale(1.05);
    }

    .status-select {
        width: 100%;
        height: 60px;
        font-size: 1.1rem;
        padding: 0.75rem 1rem;
        border: 1.8px solid #D1D5DB;
        transition: 0.3s ease;
    }

    .status-select:focus {
        border-color: #3F51B5;
        box-shadow: 0 0 0 0.25rem rgba(63, 81, 181, 0.2);
    }

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

    .gap-3 { gap: 1rem !important; }
</style>
@endsection