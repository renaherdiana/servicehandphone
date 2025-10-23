@extends('layouts.app')  

@section('content') 
<div class="content-wrapper" style="background-color:#F5F5F5; min-height: 100vh;">   
    <div class="container py-5">      
        <div class="card shadow-sm border-0 rounded-4"> 
            <div class="card-header text-white rounded-top-4"
                 style="background: linear-gradient(90deg, #3F51B5 0%, #7986CB 100%);">
                <h5 class="mb-0 fw-bold">Tambah Handphone</h5>
            </div>  

            <div class="card-body p-5">    

                {{-- 🔔 ALERT / PESAN NOTIFIKASI --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- 🔻 FORM TAMBAH --}}
                <form enctype="multipart/form-data" method="POST" action="{{ route('handphone.store') }}">
                    @csrf           
                    <div class="row g-4">              
                        <div class="col-12">

                            {{-- Foto --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Foto</label>
                                <input type="file" name="image" class="form-control form-control-lg rounded-3" accept="image/*">
                            </div>
                            
                            {{-- Brand --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Brand</label>
                                <input type="text" 
                                       name="brand" 
                                       value="{{ old('brand') }}"
                                       class="form-control form-control-lg rounded-3 @error('brand') is-invalid @enderror" 
                                       placeholder="Masukkan brand handphone" required>
                                @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Model --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Model</label>
                                <input type="text" 
                                       name="model" 
                                       value="{{ old('model') }}"
                                       class="form-control form-control-lg rounded-3 @error('model') is-invalid @enderror" 
                                       placeholder="Masukkan model handphone" required>
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>  

                            {{-- Tahun Rilis --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tahun Rilis</label>
                                <input type="number" 
                                       name="release_year" 
                                       value="{{ old('release_year') }}"
                                       class="form-control form-control-lg rounded-3 @error('release_year') is-invalid @enderror" 
                                       placeholder="Masukkan tahun rilis" 
                                       min="2000" max="2099" required>
                                @error('release_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>  

                            {{-- Status --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="is_active" 
                                        class="form-select status-select rounded-3 @error('is_active') is-invalid @enderror" 
                                        required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="active" {{ old('is_active') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="nonactive" {{ old('is_active') == 'nonactive' ? 'selected' : '' }}>Non Active</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol --}}
                            <div class="mt-4 d-flex justify-content-end">
                                <a href="{{ route('handphone.index') }}" 
                                   class="btn btn-secondary fw-semibold rounded-3 shadow-sm px-4"
                                   style="margin-right: 20px;">
                                    Kembali
                                </a>
                                <button type="submit" 
                                        class="btn px-4 text-white fw-semibold rounded-3 shadow-sm"
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

    input.form-control, select.form-select {
        border: 1px solid #E0E0E0;
        transition: 0.3s;
    }

    input.form-control:focus, select.form-select:focus {
        border-color: #3F51B5;
        box-shadow: 0 0 0 0.2rem rgba(63, 81, 181, 0.2);
    }

    .status-select {
        height: 52px;
        font-size: 1rem;
        padding: 0.75rem 1rem;
        width: 100%;
        max-width: 100%;
        border-radius: 0.5rem;
    }

    .alert {
        font-size: 0.95rem;
    }
</style>
@endsection
