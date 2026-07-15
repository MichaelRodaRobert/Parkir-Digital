<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Parkir Online</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *{
            font-family:'Poppins',sans-serif;
        }

        body{
            margin:0;
            min-height:100vh;
            background:
            linear-gradient(rgba(10,25,47,.82),rgba(10,25,47,.90)),
            url('https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=1600&q=80');
            background-size:cover;
            background-position:center;
            color:white;
        }

        .navbar{
            background:rgba(255,255,255,.08);
            backdrop-filter:blur(15px);
        }

        .hero{
            min-height:calc(100vh - 120px);
            display:flex;
            align-items:center;
            padding:40px 0;
        }

        .glass{
            background:rgba(255,255,255,.12);
            backdrop-filter:blur(20px);
            border-radius:20px;
            padding:40px;
            border:1px solid rgba(255,255,255,.15);
            box-shadow:0 10px 30px rgba(0,0,0,.25);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h1{
            font-size:48px;
            font-weight:700;
            line-height:1.2;
        }

        .highlight{
            color:#4fd1ff;
        }

        .btn-custom{
            border-radius:50px;
            padding:12px 35px;
            font-weight:600;
        }

        .feature-card{
            background:rgba(255,255,255,.10);
            border-radius:18px;
            padding:20px 25px;
            transition:.3s;
            border:1px solid rgba(255,255,255,.12);
            backdrop-filter:blur(12px);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .feature-card:hover{
            transform:translateX(8px);
            background:rgba(255,255,255,.18);
            border-color: rgba(79, 209, 255, 0.4);
        }

        .feature-icon{
            width: 55px;
            height: 55px;
            background: rgba(79, 209, 255, 0.15);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-card i{
            font-size:28px;
            color:#58d3ff;
        }

        footer{
            background:rgba(0,0,0,.4);
            padding:15px;
            text-align:center;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        @media(max-width:991px){
            .hero{
                min-height:auto;
            }

            h1{
                font-size:36px;
            }

            .glass{
                padding:25px;
            }
        }
    </style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">

        <a class="navbar-brand fw-bold fs-3" href="#">
            <i class="bi bi-p-square-fill text-info"></i>
            Parkir Online
        </a>

        <div class="ms-auto">

            @if (Route::has('login'))

                @auth

                    <a href="{{ url('/dashboard') }}" class="btn btn-info rounded-pill px-4">
                        Dashboard
                    </a>

                @else

                    <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill px-4">
                        Login
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-info rounded-pill px-4 ms-2">
                            Register
                        </a>
                    @endif

                @endauth

            @endif

        </div>

    </div>
</nav>

<section class="hero">

    <div class="container">

        <div class="row g-4 align-items-stretch">

            <!-- Kiri: Deskripsi Sistem -->
            <div class="col-lg-6">

                <div class="glass">

                    <h1>
                        Sistem
                        <span class="highlight">
                            Parkir Online
                        </span>
                    </h1>

                    <p class="mt-3 fs-5 text-light opacity-90">
                        Kelola kendaraan dengan lebih cepat, aman, dan efisien.
                        Monitoring kendaraan secara real-time, reservasi online.
                    </p>

                    <div class="mt-4">

                        @if(Route::has('login'))

                            @auth

                                <a href="{{ url('/dashboard') }}" class="btn btn-info btn-lg btn-custom shadow">
                                    Dashboard System
                                </a>

                            @else

                                <a href="{{ route('login') }}" class="btn btn-info btn-lg btn-custom shadow">
                                    Masuk Sekarang
                                </a>

                            @endif

                        @endif

                    </div>

                </div>

            </div>

            <!-- Kanan: 3 Card Fitur (Monitoring, Booking, Laporan) -->
            <div class="col-lg-6">

                <div class="d-flex flex-column gap-3 h-100 justify-content-center">

                    <!-- Card 1: Monitoring Kendaraan -->
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-car-front-fill"></i>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold">Monitoring Kendaraan</h5>
                            <p class="mb-0 text-light text-opacity-75 small">
                                Memantau status dan ketersediaan slot kendaraan masuk dan keluar secara real-time.
                            </p>
                        </div>
                    </div>

                    <!-- Card 2: Booking Online -->
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold">Booking Online</h5>
                            <p class="mb-0 text-light text-opacity-75 small">
                                Pesan slot tempat parkir lebih awal dengan mudah sebelum tiba di lokasi.
                            </p>
                        </div>
                    </div>



                </div>

            </div>

        </div>

    </div>

</section>

<footer>
    <small class="text-light text-opacity-75">
        © {{ date('Y') }} Parkir Online | System Smart Access
    </small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
