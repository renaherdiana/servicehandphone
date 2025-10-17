@extends('layouts.app')  

@section('content') 
<div class="content-wrapper" style="background-color:#F5F5F5; min-height: 100vh;">   
    <div class="container py-5">      
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden"> 

            <!-- Header -->
            <div class="card-header text-white rounded-top-4"
                 style="background: linear-gradient(90deg, #3F51B5 0%, #7986CB 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Detail Handphone</h5>
                    <a href="{{ route('handphone.index') }}" class="btn btn-light btn-sm fw-semibold rounded-3">
                        <i class="mdi mdi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>  

            <!-- Body -->
            <div class="card-body p-5 bg-white">         
                <div class="row g-5 align-items-center">
                    
                    <!-- Foto -->
                    <div class="col-md-4 text-center">
                        @if($handphone->image)
                            <img src="{{ asset('storage/'.$handphone->image) }}" 
                                 alt="Foto {{ $handphone->model }}" 
                                 class="img-fluid rounded-4 shadow-sm"
                                 style="max-height: 300px; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center border rounded-4"
                                 style="height: 250px; background-color:#F3F4F6;">
                                <p class="text-muted mb-0">Tidak ada foto</p>
                            </div>
                        @endif
                    </div>

                    <!-- Detail Info -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <h4 class="fw-bold text-gray-800">{{ $handphone->brand }} {{ $handphone->model }}</h4>
                            <p class="text-muted mb-1">
                                <i class="mdi mdi-calendar me-1"></i> 
                                Tahun Rilis: {{ $handphone->release_year ?? '-' }}
                            </p>
                            <p class="mb-3">
                                @if($handphone->is_active === 'active')
                                    <span class="badge px-3 py-2 rounded-pill" style="background-color:#E3F2FD; color:#1976D2;">Aktif</span>
                                @else
                                    <span class="badge px-3 py-2 rounded-pill" style="background-color:#FFEBEE; color:#E53935;">Tidak Aktif</span>
                                @endif
                            </p>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex flex-column gap-2">
                            <p><strong>Brand:</strong> {{ $handphone->brand }}</p>
                            <p><strong>Model:</strong> {{ $handphone->model }}</p>
                            <p><strong>Tahun Rilis:</strong> {{ $handphone->release_year ?? '-' }}</p>
                            <p><strong>Status:</strong> 
                                {{ $handphone->is_active == 'active' ? 'Aktif' : 'Non Active' }}
                            </p>
                            <p><strong>Dibuat:</strong> {{ $handphone->created_at->format('d M Y H:i') }}</p>
                            <p><strong>Diperbarui:</strong> {{ $handphone->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>     
        </div>    
    </div> 
</div>  

<style>
    .text-gray-800 {
        color: #333;
    }
</style>
@endsection  
