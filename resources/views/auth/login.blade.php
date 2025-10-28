<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Dunia Virtual</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Orbitron -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&family=Roboto&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: radial-gradient(circle at top, #0a0f2c, #000);
            color: #fff;
            overflow: hidden;
        }

        /* Efek portal & neon */
        .portal-effect {
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(circle, rgba(60, 60, 255, 0.15), transparent 70%);
            animation: rotatePortal 10s linear infinite;
            z-index: -1;
        }

        .neon-lines::before,
        .neon-lines::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #00ffff, transparent);
            animation: moveGlow 3s linear infinite;
        }

        .neon-lines::before {
            top: 0;
        }

        .neon-lines::after {
            bottom: 0;
        }

        @keyframes rotatePortal {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes moveGlow {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        /* Hover glow tambahan */
        .hover-glow:hover {
            border-color: #00ffff;
            box-shadow: 0 0 25px #00ffffaa;
        }

        input:focus {
            outline: none;
            border-color: #00e0ff;
            box-shadow: 0 0 8px #00e0ff;
        }

        .text-neon {
            color: #7b7bff;
            text-shadow: 0 0 10px #3d3df0;
        }
    </style>
</head>

<body class="flex justify-center items-center h-screen">

    <div class="relative login-container neon-lines bg-[rgba(20,20,40,0.8)] border-2 border-[#3d3df0] rounded-2xl p-10 w-11/12 max-w-md text-center backdrop-blur-md hover-glow transition duration-300">
        <div class="portal-effect"></div>

        <h2 class="font-[Orbitron] uppercase text-neon text-2xl mb-6">Masuk ke Dunia Virtual</h2>

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <div class="text-left">
                <label for="email" class="block text-sm text-[#a3a3ff]">Alamat Email</label>
                <input type="email" name="email" id="email"
                    class="w-full p-3 mt-2 bg-[rgba(0,0,50,0.6)] border border-[#3d3df0] rounded-lg text-white text-sm transition focus:border-[#00e0ff]"
                    placeholder="Masukkan email anda" required>
            </div>

            <div class="text-left">
                <label for="password" class="block text-sm text-[#a3a3ff]">Kata Sandi</label>
                <input type="password" name="password" id="password"
                    class="w-full p-3 mt-2 bg-[rgba(0,0,50,0.6)] border border-[#3d3df0] rounded-lg text-white text-sm transition focus:border-[#00e0ff]"
                    placeholder="Masukkan password" required>
            </div>

            <button type="submit"
                class="w-full py-3 rounded-lg font-[Orbitron] uppercase tracking-wide text-white bg-gradient-to-r from-[#3d3df0] to-[#00e0ff] hover:from-[#00e0ff] hover:to-[#3d3df0] shadow-md hover:shadow-[#00e0ff80] transition-all duration-300">
                Masuk
            </button>

            @if ($errors->any())
            <div class="text-[#ff8080] mt-3">
                {{ $errors->first() }}
            </div>
            @endif
        </form>
    </div>

</body>

</html>
