@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="background-color:#F5F5F5; min-height: 100vh;">
  
  {{-- Header --}}
  <div class="row mb-4 px-3">
    <div class="col-12">
      <h4 class="fw-bold">Welcome to <span class="text-primary">ServisHP.id</span></h4>
      <p class="text-muted mb-0">Siap membantu memperbaiki perangkat Anda!</p>
    </div>
  </div>

  {{-- Statistik --}}
  <div class="row g-3 px-3">
    @php
      $stats = [
        ['title'=>'Jumlah Servis','value'=>$jumlahServis ?? 0,'color'=>'#FFB74D'],
        ['title'=>'Menunggu Diterima','value'=>$menunggu ?? 0,'color'=>'#7E57C2'],
        ['title'=>'Sedang Diproses','value'=>$diproses ?? 0,'color'=>'#EC407A'],
        ['title'=>'Selesai','value'=>$selesai ?? 0,'color'=>'#26A69A'],
      ];
    @endphp

    @foreach($stats as $s)
    <div class="col-md-3 col-12">
      <div class="card shadow-sm border-0 rounded-4" style="background:{{ $s['color'] }}; color:white; height:120px;">
        <div class="card-body text-center d-flex flex-column justify-content-center">
          <h6 class="fw-bold mb-1">{{ $s['title'] }}</h6>
          <h3 class="fw-bolder mb-0">{{ number_format($s['value'], 0, ',', '.') }}</h3>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  {{-- Riwayat Servis --}}
  <div class="row mt-4 px-3">
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4" style="overflow:hidden;">
        <div class="card-header py-3 px-4" 
             style="background: linear-gradient(90deg, #D6E4FF 0%, #EDE7F6 100%); color:#3F51B5;">
          <h5 class="mb-0 fw-bold">📋 Riwayat Servis 
            <span class="fw-normal" style="opacity:0.9;">| Purchase History</span>
          </h5>
        </div>

        <div class="card-body p-4 bg-white">
          <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
              <thead style="background-color:#EEF2FF; color:#3F51B5;">
                <tr>
                  <th>No</th>
                  <th>Customer</th>
                  <th>Handphone</th>
                  <th>Status Servis</th>
                  <th>Biaya</th>
                </tr>
              </thead>
              <tbody>
                @forelse($riwayat as $i => $s)
                  <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $s->customer->name ?? $s->customer_name ?? '-' }}</td>
                    <td>{{ $s->handphone->brand ?? '-' }} {{ $s->handphone->model ?? '' }}</td>
                    <td>
                      @php
                        $statusClass = match($s->status) {
                          'accepted' => 'diterima',
                          'process' => 'proses',
                          'finished' => 'selesai',
                          'taken' => 'diambil',
                          'cancelled' => 'batal',
                          default => '',
                        };
                      @endphp
                      <span class="btn-status {{ $statusClass }}">
                        {{ ucfirst($s->status) }}
                      </span>
                    </td>

                    {{-- 💰 Langsung ambil dari kolom total_cost --}}
                    <td>Rp{{ number_format($s->total_cost ?? 0, 0, ',', '.') }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                      Belum ada riwayat servis.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <a href="{{ route('service') }}" class="text-primary fw-bold d-block mt-3 text-end">
            Lihat semua riwayat servis →
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Style --}}
<style>
  .btn-status {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.2s ease;
  }
  .btn-status.selesai {
    background-color: #E3F2FD;
    color: #1976D2;
  }
  .btn-status.proses {
    background-color: #FFF8E1;
    color: #F57C00;
  }
  .btn-status.diterima {
    background-color: #F3E5F5;
    color: #7B1FA2;
  }
  .btn-status.diambil {
    background-color: #E8F5E9;
    color: #2E7D32;
  }
  .btn-status.batal {
    background-color: #FFEBEE;
    color: #C62828;
  }
  .table-striped tbody tr:nth-of-type(odd) {
    background-color: #FAFAFA !important;
  }
  .table-striped tbody tr:nth-of-type(even) {
    background-color: #FFFFFF !important;
  }
  .table-striped tbody tr:hover {
    background-color: #F0F4FF !important;
    transition: 0.3s;
  }
</style>
@endsection
