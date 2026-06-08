<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password | PT. Rand Nusantara Sejahtera</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico?v=2') }}">

  <style>
    body {
      margin: 0;
      height: 100vh;
      font-family: 'Poppins', sans-serif;
      display: flex;
    }

    .left-side {
      flex: 1;
      background-color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .left-side img {
      max-width: 70%;
      height: auto;
    }

    .right-side {
      flex: 1;
      background-color: #0d3b91;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-box {
      width: 100%;
      max-width: 380px;
      background: transparent;
    }

    .login-box h3 {
      font-weight: 700;
      margin-bottom: 5px;
    }

    .login-box p {
      font-size: 13px;
      color: #dcdcdc;
      margin-bottom: 30px;
    }

    .input-group-text {
      background-color: #fff;
    }

    .form-control {
      border-radius: 8px;
      padding: 10px;
    }

    .btn-login {
      background-color: #f7b733;
      border: none;
      color: #fff;
      font-weight: 600;
      border-radius: 8px;
      transition: all 0.2s;
    }

    .btn-login:hover {
      background-color: #e0a020;
    }

    .text-small {
      font-size: 0.9rem;
    }

    .toggle-password {
      cursor: pointer;
      background-color: #fff;
      border-left: none;
    }

    .input-group .form-control {
      border-right: none;
    }

    .input-group .toggle-password:hover {
      background-color: #f8f9fa;
    }

    @media (max-width: 768px) {
      body {
        flex-direction: column;
        background-color: #0d3b91;
      }
      .left-side {
        display: none;
      }
      .right-side {
        width: 100%;
        min-height: 100vh;
        padding: 20px;
      }
    }
  </style>
</head>

<body>
  <div class="left-side">
    <img src="{{ asset('assets/images/logo-rns-bg.png') }}" alt="Logo RNS">
  </div>

  <div class="right-side">
    <div class="login-box">
      <h3 class="text-center">Buat Password Baru</h3>
      <p class="text-center">Silakan buat kata sandi baru untuk akun Anda.</p>

      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        
        <div class="mb-3">
          <label class="form-label" for="email">Alamat Email</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
            <input type="email" name="email" id="email" class="form-control" value="{{ $email ?? old('email') }}" readonly required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="password">Password Baru</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password Baru" required autofocus>
            <span class="input-group-text toggle-password" onclick="togglePassword('password', this)">
              <i class="bi bi-eye-slash"></i>
            </span>
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi Password Baru" required>
            <span class="input-group-text toggle-password" onclick="togglePassword('password_confirmation', this)">
              <i class="bi bi-eye-slash"></i>
            </span>
          </div>
        </div>

        <button type="submit" class="btn btn-login w-100 py-2">
          Simpan Password Baru
        </button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function togglePassword(inputId, iconElement) {
      const input = document.getElementById(inputId);
      const icon = iconElement.querySelector('i');
      
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      } else {
        input.type = 'password';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      }
    }
  </script>
</body>
</html>
