<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    
    <title>{{ config('app.name', 'Zynk') }}</title>

    <!-- Fonts & Tailwind -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ⛔️ Impede scroll causado pelas bolas */
        body {
            margin: 0;
            padding: 0;
            position: relative;
            background: linear-gradient(45deg,
                    #0072ff 0%,
                    /* azul vibrante mas confortável */
                    #00c6ff 40%,
                    /* azul claro cyan */
                    #00d084 70%,
                    /* verde água suave */
                    #0072ff 100%
                    /* azul vibrante */
                );
            background-size: 400% 400%;
            animation: gradientMove 30s ease-in-out infinite;
            overflow: hidden;
            will-change: background-position;

        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .wrapper {
            height: 100dvh; /* mais confiável no iOS */
            overflow-y: auto;
            position: relative;
            z-index: 1;
        }


        /* ⚙️ As bolas animadas */
        #bgCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }


        @keyframes morph {
            0% {
                border-radius: 40% 60% 60% 40% / 70% 30% 70% 30%;
            }

            100% {
                border-radius: 40% 60%;
            }
        }

        @keyframes spin {
            to {
                transform: rotate(1turn);
            }
        }

        /* Simplifica morph para menos estados */
        @keyframes morph {
            0% {
                border-radius: 45% 55% 55% 45% / 65% 35% 65% 35%;
            }

            100% {
                border-radius: 50% 50% 50% 50% / 50% 50% 50% 50%;
            }
        }

        @keyframes spin {
            to {
                transform: rotate(1turn);
            }
        }

        .centered-title {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            color: white;
            padding-top: 15vh;
            padding-bottom: 2rem;
        }



        .form-section {
            display: flex;
            flex-direction: column;
            align-items: center;

        }

        .flip-container {
            perspective: 1000px;
        }

        .flipper {
            width: 400px;
            height: 500px;
            transition: transform 0.8s;
            transform-style: preserve-3d;
            position: relative;
        }

        .flipper.show-login {
            transform: rotateY(180deg);
        }

        .front,
        .back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .back {
            transform: rotateY(180deg);
        }

        .flip-buttons button {
            margin: 0 0.5rem;
        }

        /* Opção de colocar o ícone dentro do input */
        input[type="password"] {
            padding-right: 2.5rem;
            /* Espaço para o ícone */
        }

        button#togglePassword {
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
        }

        select {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg fill='white' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill-rule='evenodd' d='M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 01.02-1.06z' clip-rule='evenodd' /%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.5rem center;
            background-size: 1rem;
        }
    </style>
</head>

<body>
    <canvas id="bgCanvas"></canvas>

    <!-- Título centralizado no meio da tela -->
    <div class="wrapper">
        <div class="language absolute top-1 left-5">
            <div class="relative inline-block text-left mt-6">
                <form id="langForm" action="" method="get">
                    <select name="lang" id="langSelect"
                        class="bg-transparent text-white text-sm font-medium appearance-none pr-8 pl-2 py-1 border border-white/30 rounded-md backdrop-blur-md focus:outline-none focus:ring-2 focus:ring-white/50">
                        <option value="pt-br" class="text-black" selected
                            {{ app()->getLocale() == 'pt-br' ? 'selected' : '' }}>Português</option>
                        <option value="en" class="text-black" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>
                            English</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="centered-title">
            <img src="{{ asset('/logo/logo_incio.png') }}" alt="Logo" class="w-[200px] mb-6">
            <h1 class="text-4xl font-bold">{{ __('texts.ola') }} </h1>
            <p class="text-lg opacity-80 mt-4">{{ __('texts.text') }}</p>
        </div>

        <!-- Formulário e botões abaixo do título -->
        <div class="form-section">
            <div class="flip-buttons mb-6">
                <button onclick="showForm('register')"
                    class="px-6 py-2 text-white border-2 border-white rounded-full hover:bg-white hover:text-blue-600 transition">{{ __('texts.register') }}</button>
                <button onclick="showForm('login')"
                    class="px-6 py-2 text-white border-2 border-white rounded-full hover:bg-white hover:text-blue-600 transition">Login</button>
            </div>

            <div class="flip-container">
                <div id="card" class="flipper mb-10">
                    <!-- Registro (Front) -->
                    <div class="front flex flex-col justify-center items-center space-y-4">
                        <h2 class="text-2xl font-bold text-blue-600">{{ __('texts.register') }}</h2>

                        <form method="POST" action="{{ route('register') }}" class="w-full">
                            @csrf

                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('texts.nome')" />
                                <x-text-input id="name" class="block w-full px-4 py-2 border rounded"
                                    type="text" name="name" :value="old('name')" required autofocus
                                    autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Username -->
                            <div class="mt-4">
                                <x-input-label for="username" :value="__('texts.username')" />
                                <x-text-input id="username" class="block w-full px-4 py-2 border rounded"
                                    type="text" name="username" :value="old('username')" required autofocus
                                    autocomplete="username" />
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            </div>

                            <!-- Email Address -->
                            <div class="mt-4">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block w-full px-4 py-2 border rounded"
                                    type="email" name="email" :value="old('email')" required autocomplete="email" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-input-label for="password" :value="__('texts.senha')" />

                                <div class="relative">
                                    <x-text-input id="password_register" class="block w-full px-4 py-2 border rounded"
                                        type="password" name="password" required autocomplete="new-password" />

                                    <!-- Botão de Mostrar/Ocultar -->
                                    <button type="button" id="togglePassword"
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-red-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                            viewBox="0 0 24 24" fill="none">
                                            <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12" stroke="#000000"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M1 12C1 12 5 20 12 20C19 20 23 12 23 12" stroke="#000000"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <circle cx="12" cy="12" r="3" stroke="#000000"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button class="ms-4">
                                    {{ __('texts.register') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>


                    <!-- Login -->
                    <!-- Session Status -->
                    <!-- Login Blade inside the .back panel -->
                    <div class="back flex flex-col justify-center items-center space-y-4">
                        <h2 class="text-2xl font-bold text-blue-600">Login</h2>

                        <form method="POST" action="{{ route('login') }}" class="w-full">
                            @csrf

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block w-full px-4 py-2 border rounded"
                                    type="email" name="email" :value="old('email')" required autofocus
                                    autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                              <x-input-label for="password" :value="__('texts.senha')" />
                              <div class="relative">
                                <x-text-input id="password" class="block w-full px-4 py-2 border rounded"
                                    type="password" name="password" required autocomplete="current-password" />

                                <button type="button" id="togglePassword2"
                                      class="absolute right-4 top-1/2 transform -translate-y-1/2 text-red-800">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                          viewBox="0 0 24 24" fill="none">
                                          <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12" stroke="#000000"
                                              stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                          <path d="M1 12C1 12 5 20 12 20C19 20 23 12 23 12" stroke="#000000"
                                              stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                          <circle cx="12" cy="12" r="3" stroke="#000000"
                                              stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                      </svg>
                                  </button>
                              </div>
                              <x-input-error :messages="$errors->get('password')" class="mt-2" />

                            </div>

                            <div class="block mt-4">
                                <label for="remember_me" class="inline-flex items-center">
                                    <input id="remember_me" type="checkbox"
                                        class="rounded p-2 border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                        name="remember">
                                    <span class="ms-2 text-sm text-gray-600">{{ __('texts.lembrar') }}</span>
                                </label>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                @if (Route::has('password.request'))
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                        href="{{ route('password.request') }}">
                                        {{ __('texts.esquecerSenha') }}
                                    </a>
                                @endif

                                <x-primary-button class="ms-3 text-blue-600">
                                    {{ __('texts.logar') }}
                                </x-primary-button>
                            </div>
                        </form>

                    </div>

                </div>

                <script>
                    const canvas = document.getElementById('bgCanvas');
                    const ctx = canvas.getContext('2d');

                    let width, height;

                    function resizeCanvas() {
                        width = canvas.width = window.innerWidth;
                        height = canvas.height = window.innerHeight;
                    }
                    window.addEventListener('resize', resizeCanvas);
                    resizeCanvas();

                    class Bubble {
                        constructor() {
                            this.reset();
                            this.time = Math.random() * 1000;
                        }

                        reset() {
                            this.r = 400;
                            this.speedX = (Math.random() - 0.5) * 2;
                            this.speedY = (Math.random() - 0.5) * 2;
                            this.opacity = 0.06 + Math.random() * 0.07;
                        }

                        update() {
                            // Velocidade oscila um pouco para movimento orgânico
                            this.speedX += (Math.random() - 0.5) * 0.05;
                            this.speedY += (Math.random() - 0.5) * 0.05;

                            // Limita velocidade
                            this.speedX = Math.max(Math.min(this.speedX, 1.5), -1.5);
                            this.speedY = Math.max(Math.min(this.speedY, 1.5), -1.5);

                            this.x += this.speedX;
                            this.y += this.speedY;

                            this.time += 0.02;

                            // Loop bordas
                            if (this.x - this.r > width) this.x = -this.r;
                            if (this.x + this.r < 0) this.x = width + this.r;
                            if (this.y - this.r > height) this.y = -this.r;
                            if (this.y + this.r < 0) this.y = height + this.r;
                        }

                        draw(ctx) {
                            ctx.save();
                            ctx.translate(this.x, this.y);

                            const points = 32;
                            const angleStep = (Math.PI * 2) / points;
                            const radius = this.r;
                            const deform = 12;

                            const circlePoints = [];

                            for (let i = 0; i < points; i++) {
                                const angle = i * angleStep;
                                const offset = Math.sin(this.time * 1.3 + i) * deform;
                                const r = radius + offset;
                                const x = Math.cos(angle) * r;
                                const y = Math.sin(angle) * r;
                                circlePoints.push({
                                    x,
                                    y
                                });
                            }

                            ctx.beginPath();

                            for (let i = 0; i < points; i++) {
                                const p1 = circlePoints[i];
                                const p2 = circlePoints[(i + 1) % points];
                                const cx = (p1.x + p2.x) / 2;
                                const cy = (p1.y + p2.y) / 2;

                                if (i === 0) {
                                    ctx.moveTo(cx, cy);
                                }

                                ctx.quadraticCurveTo(p1.x, p1.y, cx, cy);
                            }

                            ctx.closePath();

                            ctx.globalAlpha = this.opacity;
                            ctx.fillStyle = '#ffffff';
                            ctx.fill();

                            ctx.restore();
                        }
                    }

                    // Função para calcular distância
                    function distance(x1, y1, x2, y2) {
                        return Math.sqrt((x1 - x2) ** 2 + (y1 - y2) ** 2);
                    }

                    const minDistance = 500;
                    const bubbles = [];

                    function createBubble() {
                        let x, y;
                        let tries = 0;
                        const maxTries = 100;
                        do {
                            x = Math.random() * width;
                            y = Math.random() * height;
                            tries++;
                        } while (
                            bubbles.some(b => distance(x, y, b.x, b.y) < minDistance) &&
                            tries < maxTries
                        );

                        const b = new Bubble();
                        b.x = x;
                        b.y = y;
                        return b;
                    }

                    // Criar as bolhas
                    for (let i = 0; i < 2; i++) {
                        bubbles.push(createBubble());
                    }

                    function animate() {
                        ctx.clearRect(0, 0, width, height);
                        bubbles.forEach(bubble => {
                            bubble.update();
                            bubble.draw(ctx);
                        });
                        requestAnimationFrame(animate);
                    }

                    animate();
                </script>

                <script>
                    function showForm(type) {
                        const card = document.getElementById('card');
                        if (type === 'login') {
                            card.classList.add('show-login');
                        } else {
                            card.classList.remove('show-login');
                        }
                    }

                    document.getElementById('togglePassword').addEventListener('click', function() {
                        const passwordField = document.getElementById('password_register');
                        const type = passwordField.type === 'password' ? 'text' : 'password';
                        passwordField.type = type;
                        this.innerHTML = type === 'password' ?
                            '<svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none"> <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M1 12C1 12 5 20 12 20C19 20 23 12 23 12" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <circle cx="12" cy="12" r="3" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </svg>' :
                            '<svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none"> <path d="M2 2L22 22" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M6.71277 6.7226C3.66479 8.79527 2 12 2 12C2 12 5.63636 19 12 19C14.0503 19 15.8174 18.2734 17.2711 17.2884M11 5.05822C11.3254 5.02013 11.6588 5 12 5C18.3636 5 22 12 22 12C22 12 21.3082 13.3317 20 14.8335" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M14 14.2362C13.4692 14.7112 12.7684 15.0001 12 15.0001C10.3431 15.0001 9 13.657 9 12.0001C9 11.1764 9.33193 10.4303 9.86932 9.88818" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </svg>'; // Alterna o ícone
                    });

                    document.getElementById('togglePassword2').addEventListener('click', function() {
                        const passwordField2 = document.getElementById('password');
                        const type = passwordField2.type === 'password' ? 'text' : 'password';
                        passwordField2.type = type;
                        this.innerHTML = type === 'password' ?
                            '<svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none"> <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M1 12C1 12 5 20 12 20C19 20 23 12 23 12" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <circle cx="12" cy="12" r="3" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </svg>' :
                            '<svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none"> <path d="M2 2L22 22" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M6.71277 6.7226C3.66479 8.79527 2 12 2 12C2 12 5.63636 19 12 19C14.0503 19 15.8174 18.2734 17.2711 17.2884M11 5.05822C11.3254 5.02013 11.6588 5 12 5C18.3636 5 22 12 22 12C22 12 21.3082 13.3317 20 14.8335" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M14 14.2362C13.4692 14.7112 12.7684 15.0001 12 15.0001C10.3431 15.0001 9 13.657 9 12.0001C9 11.1764 9.33193 10.4303 9.86932 9.88818" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </svg>'; // Alterna o ícone
                    });

                    document.getElementById('langSelect').addEventListener('change', function() {
                        const lang = this.value;
                        window.location.href = "{{ url('lang') }}/" + lang;
                    });
                </script>
            </div>

</body>

</html>
