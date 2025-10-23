@extends('layouts.app')  

@section('content') 
<div class="content-wrapper" style="background-color:#F5F5F5; min-height: 100vh;">   
    <div class="container py-5">      
        <div class="card shadow-sm border-0 rounded-4"> 
            <div class="card-header text-white rounded-top-4"
                 style="background: linear-gradient(90deg, #3F51B5 0%, #7986CB 100%);">
                <h5 class="mb-0 fw-bold">Tambah Item Servis</h5>
            </div>  

            <div class="card-body p-5">    

                {{-- 🔔 NOTIFIKASI --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- 🔻 FORM TAMBAH --}}
                <form method="POST" action="{{ route('service.item.store') }}">
                    @csrf           
                    <div class="row g-4">              
                        <div class="col-12">

                            {{-- Nama Servis --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Servis</label>
                                <input type="text" 
                                       name="name" 
                                       value="{{ old('name') }}"
                                       class="form-control form-control-lg rounded-3 form-input-large @error('name') is-invalid @enderror" 
                                       placeholder="Masukkan nama servis" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Harga --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Harga</label>
                                <input type="number" 
                                       name="price" 
                                       value="{{ old('price') }}"
                                       class="form-control form-control-lg rounded-3 form-input-large @error('price') is-invalid @enderror" 
                                       placeholder="Masukkan harga servis" required>
                                @error('price')
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
                                    <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Non Active</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol --}}
                            <div class="mt-4 d-flex justify-content-end">
                                <a href="{{ route('service.item') }}" 
                                   class="btn btn-secondary fw-semibold rounded-3 shadow-sm px-4"
                                   style="margin-right: 15px;">
                                   Kembali
                                </a>
                                <button type="submit" class="btn px-4 text-white fw-semibold rounded-3 shadow-sm"
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

    .form-input-large {
        height: 50px;
        font-size: 1.1rem;
        padding: 0.75rem 1rem;
    }

    .status-select {
        height: 52px;
        font-size: 1.1rem;
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
