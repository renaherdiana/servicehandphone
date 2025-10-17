@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="background-color:#F5F5F5; min-height: 100vh;">
    <div class="container py-5">

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

            <!-- Header -->
            <div class="card-header text-white rounded-top-4"
                 style="background: linear-gradient(90deg, #3F51B5 0%, #7986CB 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Detail Teknisi</h5>
                    <a href="{{ route('technician.index') }}" class="btn btn-light btn-sm fw-semibold rounded-3">
                        <i class="mdi mdi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body p-5 bg-white">
                <div class="row g-5 align-items-center">

                    <!-- Detail Info -->
                    <div class="col-12">
                        <div class="mb-3">
                            <h4 class="fw-bold text-gray-800">{{ $technician->name }}</h4>

                            <p class="mb-3">
                                @if($technician->is_active)
                                    <span class="badge px-3 py-2 rounded-pill" 
                                          style="background-color:#E3F2FD; color:#1976D2;">Aktif</span>
                                @else
                                    <span class="badge px-3 py-2 rounded-pill" 
                                          style="background-color:#FFEBEE; color:#E53935;">Tidak Aktif</span>
                                @endif
                            </p>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex flex-column gap-2">
                            <p><strong>Nama Teknisi:</strong> {{ $technician->name }}</p>
                            <p><strong>Status:</strong> {{ $technician->is_active ? 'Aktif' : 'Non Aktif' }}</p>
                            <p><strong>Dibuat:</strong> {{ $technician->created_at->format('d M Y H:i') }}</p>
                            <p><strong>Diperbarui:</strong> {{ $technician->updated_at->format('d M Y H:i') }}</p>
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
    .badge {
        font-size: 0.95rem;
        font-weight: 600;
    }
</style>
@endsection
