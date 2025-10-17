@extends('layouts.app')  

@section('content') 
<div class="content-wrapper" style="background-color:#F5F5F5; min-height: 100vh;">   
    <div class="container py-5">      
        <div class="card shadow-sm border-0 rounded-4"> 
            <div class="card-header text-white rounded-top-4"
                 style="background: linear-gradient(90deg, #3F51B5 0%, #7986CB 100%);">
                <h5 class="mb-0 fw-bold">Edit Handphone</h5>
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

                <form enctype="multipart/form-data" method="POST" action="{{ route('handphone.update', $handphone->id) }}">
                    @csrf
                    @method('PUT')         

                    <div class="row g-4">              
                        <div class="col-12">

                            {{-- Foto --}}
                            <div class="mb-4 text-center">
                                <label class="form-label fw-semibold d-block mb-3">Foto</label>

                                @if($handphone->image)
                                    <div class="d-flex justify-content-center mb-3">
                                        <img src="{{ asset('storage/'.$handphone->image) }}" 
                                             alt="Foto Handphone" 
                                             class="handphone-preview shadow-sm">
                                    </div>
                                @else
                                    <p class="text-muted text-center">Belum ada foto</p>
                                @endif

                                {{-- Input file full width --}}
                                <input type="file" name="image" class="form-control form-control-lg rounded-3" accept="image/*">
                                <small class="text-muted d-block mt-2">Biarkan kosong jika tidak ingin mengganti foto</small>
                            </div>

                            {{-- Brand --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Brand</label>
                                <input type="text" name="brand" class="form-control form-control-lg rounded-3" 
                                       value="{{ old('brand', $handphone->brand) }}" required>
                            </div>

                            {{-- Model --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Model</label>
                                <input type="text" name="model" class="form-control form-control-lg rounded-3" 
                                       value="{{ old('model', $handphone->model) }}" required>
                            </div>  

                            {{-- Tahun Rilis --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tahun Rilis</label>
                                <input type="number" name="release_year" class="form-control form-control-lg rounded-3"
                                       min="2000" max="2099"
                                       value="{{ old('release_year', $handphone->release_year) }}">
                            </div>  

                            {{-- Status --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="is_active" class="form-select form-select-lg rounded-3 status-select" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="active" {{ old('is_active', $handphone->is_active) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="nonactive" {{ old('is_active', $handphone->is_active) == 'nonactive' ? 'selected' : '' }}>Non Active</option>
                                </select>
                            </div>

                            {{-- Tombol --}}
                            <div class="mt-4 d-flex justify-content-end gap-3">
                                <a href="{{ route('handphone.index') }}" 
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
    /* ==== Styling Foto Handphone ==== */
    .handphone-preview {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;          /* Biar bulat */
        border: 3px solid #E0E0E0;   /* Garis halus */
        background-color: #fff;
        transition: 0.25s ease-in-out;
    }

    .handphone-preview:hover {
        transform: scale(1.05);
    }

    .status-select {
    width: 100%;               /* Biar full satu baris */
    height: 60px;              /* Lebih tinggi dari default */
    font-size: 1.1rem;         /* Teks sedikit lebih besar */
    padding: 0.75rem 1rem;     /* Ruang dalam biar lega */
    border: 1.8px solid #D1D5DB;
    transition: 0.3s ease;
    }

    .status-select:focus {
    border-color: #3F51B5;
    box-shadow: 0 0 0 0.25rem rgba(63, 81, 181, 0.2);
    }

    /* ==== Label ==== */
    label.form-label {
        color: #3F51B5;
    }

    /* ==== Input & Select ==== */
    input.form-control, select.form-select {
        border: 1px solid #E0E0E0;
        transition: 0.3s;
    }

    input.form-control:focus, select.form-select:focus {
        border-color: #3F51B5;
        box-shadow: 0 0 0 0.2rem rgba(63, 81, 181, 0.2);
    }

    /* ==== Utility ==== */
    .gap-3 { gap: 1rem !important; }
</style>
@endsection
