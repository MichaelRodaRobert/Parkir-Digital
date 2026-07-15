<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lupa Password - Parkir Online</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            /* Background serasi dengan Welcome, Login & Register */
            background:
                linear-gradient(rgba(10, 25, 47, 0.82), rgba(10, 25, 47, 0.90)),
                url('https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }

        .forgot-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 440px;
        }

        .highlight {
            color: #4fd1ff;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff !important;
            border-radius: 12px;
            padding: 12px 16px;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15) !important;
            border-color: #4fd1ff;
            box-shadow: 0 0 10px rgba(79, 209, 255, 0.3);
        }

        .btn-custom {
            border-radius: 50px;
            padding: 12px;
            font-weight: 600;
            background-color: #0dcaf0;
            border: none;
            color: #0a192f;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background-color: #31d2f2;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 202, 240, 0.4);
        }

        a {
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center px-3">
        <div class="forgot-card">

            <!-- HEADER LOGO & TITLE -->
            <div class="text-center mb-4">
                <a href="/" class="text-white text-decoration-none d-inline-block mb-1">
                    <i class="bi bi-p-square-fill text-info fs-1"></i>
                </a>
                <h2 class="fw-bold m-0 fs-3">
                    LUPA <span class="highlight">PASSWORD</span>
                </h2>
            </div>

            <!-- DESKRIPSI PETUNJUK -->
            <div class="mb-4 text-light text-opacity-75 small text-center leading-relaxed">
                Lupa kata sandi Anda? Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan tautan reset password untuk membuat kata sandi baru.
            </div>

            <!-- SESSION STATUS NOTIFICATION -->
            @if (session('status'))
                <div class="alert alert-info py-2 px-3 small rounded-3 bg-info bg-opacity-20 text-info border-info border-opacity-25 mb-3 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- EMAIL INPUT -->
                <div class="mb-4">
                    <label for="email" class="form-label small font-weight-bold text-light opacity-90">Email Address</label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           autocomplete="username"
                           placeholder="nama@email.com"
                           class="form-control">
                    @if ($errors->has('email'))
                        <div class="text-danger small mt-1">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <!-- SUBMIT BUTTON -->
                <button type="submit" class="btn btn-custom w-100 shadow">
                    Kirim Link Reset Password <i class="bi bi-send-fill ms-1"></i>
                </button>

            </form>

            <!-- KEMBALI KE LOGIN -->
            <div class="text-center mt-4 pt-3 border-top border-white border-opacity-10 small text-light opacity-75">
                Ingat password Anda?
                <a href="{{ route('login') }}" class="text-info fw-bold ms-1">Kembali ke Login</a>
            </div>

        </div>
    </div>

</body>
</html>
