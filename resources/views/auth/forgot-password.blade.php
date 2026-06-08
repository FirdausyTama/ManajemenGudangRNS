<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password | PT. Rand Nusantara Sejahtera</title>
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

    a {
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
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
      <h3 class="text-center">Lupa Password?</h3>
      <p class="text-center">Masukkan email yang terdaftar, kami akan mengirimkan link untuk mereset kata sandi Anda.</p>

      @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('status') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

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

      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-4">
          <label class="form-label" for="email">Alamat Email</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
            <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email Anda" value="{{ old('email') }}" required autofocus>
          </div>
        </div>

        <button type="submit" class="btn btn-login w-100 py-2 mb-3">
          Kirim Link Reset Password
        </button>

        <div class="text-center text-small">
          <a href="{{ route('login') }}" class="text-white"><i class="bi bi-arrow-left"></i> Kembali ke Login</a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
