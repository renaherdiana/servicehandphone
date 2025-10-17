@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="background-color:#F5F5F5; min-height: 100vh;">
    <div class="container py-5">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header text-white rounded-top-4"
                 style="background: linear-gradient(90deg, #3F51B5 0%, #7986CB 100%);">
                <h5 class="mb-0 fw-bold">✏️ Edit Teknisi</h5>
            </div>

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

                <form method="POST" action="{{ route('technician.update', $technician->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-12">

                            {{-- Nama Teknisi --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Teknisi</label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control form-control-lg rounded-3"
                                       placeholder="Masukkan nama teknisi"
                                       value="{{ old('name', $technician->name) }}" required>
                            </div>

                            {{-- Status --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="is_active" class="form-select form-select-lg rounded-3 status-select" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="1" {{ old('is_active', $technician->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $technician->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            {{-- Tombol --}}
                            <div class="mt-4 d-flex justify-content-end gap-3">
                                <a href="{{ route('technician.index') }}" 
                                   class="btn btn-secondary fw-semibold rounded-3 shadow-sm px-4">
                                    Kembali
                                </a>
                                <button type="submit" class="btn px-4 text-white fw-semibold rounded-3 shadow-sm"
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
    label.form-label {
        color: #3F51B5;
    }

    input.form-control, select.form-select {
        border: 1px solid #E0E0E0;
        transition: 0.3s;
    }

    input.form-control:focus, select.form-select:focus {
        border-color: #3F51B5;
        box-shadow: 0 0 0 0.2rem rgba(63, 81, 181, 0.2);
    }

    .gap-3 { gap: 1rem !important; }

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
</style>
@endsection
