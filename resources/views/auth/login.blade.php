<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Parkir Digital</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts & Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-950 text-slate-100 selection:bg-pink-500 selection:text-white">

    <div class="min-h-screen flex flex-col justify-center items-center relative overflow-hidden px-4 sm:px-6">

        <!-- Background Glowing Colorful Orbs FX -->
        <div class="absolute -top-10 -left-10 w-96 h-96 bg-indigo-600/40 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-600/40 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[30rem] h-[30rem] bg-pink-500/20 rounded-full blur-[100px] pointer-events-none"></div>

        <!-- Card Container Berwarna & Modern -->
        <div class="w-full sm:max-w-md relative z-10 bg-slate-900/90 backdrop-blur-2xl border-2 border-indigo-500/30 p-8 rounded-3xl shadow-[0_0_50px_rgba(99,102,241,0.25)] hover:border-pink-500/50 transition-all duration-500">

            <!-- HEADER & BRANDING PARKIR DIGITAL (TANPA LOGO P) -->
            <div class="text-center mb-8 pt-2">
                <h1 class="text-3xl font-black tracking-wider uppercase flex items-center justify-center gap-2">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-400 via-purple-300 to-cyan-400">PARKIR</span>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-emerald-400">DIGITAL</span>
                </h1>
                <p class="text-xs font-semibold text-indigo-200/80 mt-1">Smart Access Control & Automated Reservation</p>
            </div>

            <!-- Session Status Notification -->
            @if (session('status'))
                <div class="mb-4 text-emerald-300 text-xs font-semibold bg-emerald-950/60 border border-emerald-500/50 p-3 rounded-xl shadow-lg shadow-emerald-500/10">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- EMAIL INPUT -->
                <div>
                    <label for="email" class="block text-xs font-bold text-pink-300 uppercase tracking-wider mb-1.5">
                        Email Address
                    </label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           autocomplete="username"
                           placeholder="nama@email.com"
                           class="w-full px-4 py-3 bg-slate-950/80 border-2 border-indigo-900/60 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-pink-500 focus:ring-2 focus:ring-pink-500/20 text-sm transition-all shadow-inner">
                    @if ($errors->has('email'))
                        <p class="mt-1.5 text-xs text-rose-400 font-medium">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <!-- PASSWORD INPUT -->
                <div>
                    <label for="password" class="block text-xs font-bold text-cyan-300 uppercase tracking-wider mb-1.5">
                        Password
                    </label>
                    <input id="password"
                           type="password"
                           name="password"
                           required
                           autocomplete="current-password"
                           placeholder="••••••••"
                           class="w-full px-4 py-3 bg-slate-950/80 border-2 border-indigo-900/60 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 text-sm transition-all shadow-inner">
                    @if ($errors->has('password'))
                        <p class="mt-1.5 text-xs text-rose-400 font-medium">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                <!-- REMEMBER ME & FORGOT PASSWORD -->
                <div class="flex items-center justify-between text-xs pt-1">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me"
                               type="checkbox"
                               name="remember"
                               class="rounded bg-slate-950 border-indigo-700 text-pink-500 shadow-sm focus:ring-pink-500 focus:ring-offset-slate-900">
                        <span class="ms-2 text-slate-300 hover:text-white transition-colors">Remember Me?</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-cyan-400 hover:text-cyan-300 font-semibold transition-colors">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <!-- BUTTON LOG IN -->
                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-pink-500 via-purple-600 to-indigo-600 hover:from-pink-400 hover:via-purple-500 hover:to-indigo-500 text-black font-black text-sm tracking-wider uppercase rounded-xl shadow-lg shadow-pink-500/25 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                        <span>LOG IN</span>
                        <span class="text-base">➔</span>
                    </button>
                </div>
            </form>

            <!-- REGISTER LINK -->
            @if (Route::has('register'))
                <div class="mt-6 pt-5 border-t border-slate-800 text-center text-xs text-slate-400">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-pink-400 hover:text-pink-300 font-bold ml-1 transition-colors">
                        Daftar Akun Baru
                    </a>
                </div>
            @endif

        </div>

    </div>

</body>
</html>
