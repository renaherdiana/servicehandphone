<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Pengguna</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #3F51B5, #7986CB);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Poppins', sans-serif;
    }

    .login-card {
      width: 400px;
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      padding: 40px 35px;
    }

    .login-header {
      text-align: center;
      margin-bottom: 25px;
    }

    .login-header img {
      width: 70px;
      margin-bottom: 10px;
    }

    .login-header h4 {
      font-weight: 700;
      color: #3F51B5;
    }

    .form-label {
      font-weight: 600;
      color: #3F51B5;
    }

    .form-control {
      height: 50px;
      border-radius: 12px;
      border: 1px solid #ddd;
      transition: all 0.3s;
    }

    .form-control:focus {
      border-color: #3F51B5;
      box-shadow: 0 0 0 0.2rem rgba(63,81,181,0.2);
    }

    .btn-login {
      background: linear-gradient(90deg, #3F51B5, #7986CB);
      border: none;
      color: #fff;
      font-weight: 600;
      border-radius: 12px;
      height: 50px;
      transition: 0.3s;
    }

    .btn-login:hover {
      opacity: 0.9;
      transform: translateY(-1px);
    }

    .alert {
      font-size: 0.9rem;
      border-radius: 10px;
    }

    .text-muted {
      font-size: 0.85rem;
    }
  </style>
</head>

<body>

  <div class="login-card">
    <div class="login-header">
      <h4>Login Pengguna</h4>
      <p class="text-muted mb-0">Masuk ke akun Anda</p>
    </div>

    {{-- Pesan Error --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0 ps-3">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Pesan Sukses --}}
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <form method="POST" action="{{ route('login.process') }}">
      @csrf

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
      </div>

      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-login">Masuk</button>
      </div>
    </form>

    <div class="text-center mt-4">
      <p class="text-muted mb-0">© {{ date('Y') }} Kelompok 5</p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
