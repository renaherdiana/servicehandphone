<nav class="sidebar sidebar-offcanvas" id="sidebar" 
     style="background: linear-gradient(180deg, #D6E4FF 0%, #EDE7F6 100%); color: #333; min-height: 100vh; font-family: 'Poppins', sans-serif;">
  
  <!-- Logo -->
  <div class="text-center py-4 border-bottom">
    <h4 class="fw-bold mb-0" style="color:#3F51B5;">ServisHP.id</h4>
  </div>

  <!-- Profile -->
  <div class="text-center mt-4 mb-3">
      @if($activeUser && $activeUser->foto)
          <img src="{{ asset('storage/' . $activeUser->foto) }}" 
              class="rounded-circle mb-2 shadow-sm border"
              width="70" height="70" alt="profile" style="object-fit:cover;">
      @else
          <img src="{{ asset('assets/images/faces/face1.jpg') }}" 
              class="rounded-circle mb-2 shadow-sm border"
              width="70" height="70" alt="profile" style="object-fit:cover;">
      @endif

      <h6 class="fw-semibold mb-0" style="color:#3F51B5;">
          {{ $activeUser->name ?? 'Tidak Ada User Aktif' }}
      </h6>
  </div>

  <ul class="nav flex-column px-3">

    <!-- Navigation Section -->
    <li class="nav-item text-uppercase fw-bold small mb-2 mt-3" style="color:#3F51B5;">Navigation</li>
    <li class="nav-item mb-2">
      <a class="nav-link d-flex align-items-center rounded-3 py-2 px-2 {{ Request::is('dashboard') ? 'active' : '' }}" 
         href="{{ url('/dashboard') }}" style="color:#333; transition: all 0.3s;">
        <i class="mdi mdi-home-outline me-2" style="color:#3F51B5;"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <!-- Main Data Section -->
    <li class="nav-item text-uppercase fw-bold small mb-2 mt-3" style="color:#3F51B5;">Main Data</li>
    <li class="nav-item mb-1">
      <a class="nav-link d-flex align-items-center rounded-3 py-2 px-2 {{ Request::is('pengguna') ? 'active' : '' }}" 
         href="{{ url('/pengguna') }}" style="color:#333; transition: all 0.3s;">
        <i class="mdi mdi-account-outline me-2" style="color:#3F51B5;"></i>
        <span>User</span>
      </a>
    </li>
    <li class="nav-item mb-1">
      <a class="nav-link d-flex align-items-center rounded-3 py-2 px-2 {{ Request::is('handphone') ? 'active' : '' }}" 
         href="{{ url('/handphone') }}" style="color:#333; transition: all 0.3s;">
        <i class="mdi mdi-cellphone-android me-2" style="color:#3F51B5;"></i>
        <span>Handphone</span>
      </a>
    </li>

    <!-- Services Section -->
    <li class="nav-item text-uppercase fw-bold small mb-2 mt-3" style="color:#3F51B5;">Services</li>
    <li class="nav-item mb-1">
      <a class="nav-link d-flex align-items-center rounded-3 py-2 px-2 {{ Request::is('service') ? 'active' : '' }}" 
         href="{{ url('/service') }}" style="color:#333; transition: all 0.3s;">
        <i class="mdi mdi-format-list-bulleted me-2" style="color:#3F51B5;"></i>
        <span>Services</span>
      </a>
    </li>
    <li class="nav-item mb-1">
      <a class="nav-link d-flex align-items-center rounded-3 py-2 px-2 {{ Request::is('service-item') ? 'active' : '' }}" 
         href="{{ url('/service-item') }}" style="color:#333; transition: all 0.3s;">
        <i class="mdi mdi-wrench-outline me-2" style="color:#3F51B5;"></i>
        <span>Services Item</span>
      </a>
    </li>

    {{-- 👥 Customer --}}
    <li class="nav-item mb-1">
      <a class="nav-link d-flex align-items-center rounded-3 py-2 px-2 {{ Request::is('customer') ? 'active' : '' }}" 
         href="{{ url('/customer') }}" style="color:#333; transition: all 0.3s;">
        <i class="mdi mdi-account-multiple-outline me-2" style="color:#3F51B5;"></i>
        <span>Customer</span>
      </a>
    </li>

    {{-- 🧑‍🔧 Teknisi --}}
    <li class="nav-item mb-1">
      <a class="nav-link d-flex align-items-center rounded-3 py-2 px-2 {{ Request::is('teknisi') ? 'active' : '' }}" 
        href="{{ url('/teknisi') }}" style="color:#333; transition: all 0.3s;">
        <i class="mdi mdi-account-hard-hat me-2" style="color:#3F51B5;"></i>
        <span>Teknisi</span>
      </a>
    </li>


    <!-- Pembayaran Section -->
    <li class="nav-item text-uppercase fw-bold small mb-2 mt-3" style="color:#3F51B5;">Transaksi</li>
    <li class="nav-item mb-3">
      <a class="nav-link d-flex align-items-center rounded-3 py-2 px-2 {{ Request::is('pembayaran*') ? 'active' : '' }}" 
         href="{{ route('payment.index') }}" 
         style="color:#333; transition: all 0.3s;">
        <i class="mdi mdi-cash-multiple me-2" style="color:#3F51B5;"></i>
        <span>Pembayaran</span>
      </a>
    </li>

    <!-- Pengaturan Section -->
    <li class="nav-item text-uppercase fw-bold small mb-2 mt-3" style="color:#3F51B5;">Pengaturan</li>
    <li class="nav-item mb-1">
    </li>
    <li class="nav-item">
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0 p-0">
          @csrf
          <button type="submit" 
                  class="nav-link d-flex align-items-center rounded-3 py-2 px-2 w-100 border-0 bg-transparent text-start"
                  style="color:#E53935; transition: all 0.3s;">
              <i class="mdi mdi-logout me-2"></i>
              <span>Logout</span>
          </button>
      </form>
    </li>

  </ul>
</nav>

<style>
  .nav-link:hover {
    background-color: rgba(63, 81, 181, 0.08);
    transform: translateX(3px);
  }

  .nav-link.active {
    background-color: rgba(63, 81, 181, 0.15);
    font-weight: 600;
    border-left: 4px solid #3F51B5;
    color: #3F51B5 !important;
  }

  .nav-item .mdi {
    font-size: 18px;
  }
</style>
