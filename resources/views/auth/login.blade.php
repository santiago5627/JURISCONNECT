<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>JurisConnect SENA - Login</title>
        <link rel="stylesheet" href="{{ asset('/css/login.css') }}">
    </head>

    <body>
        <!-- Ondas del fondo -->
        <div class="wave1"></div>
        <div class="wave2"></div>
        <div class="wave3"></div>

        <div class="login-container">
            
            <!-- Logo institucional arriba -->
            <div class="logo-arriba">
                <img src="{{ asset('img/LogoSena_Verde.png') }}" alt="Logo SENA" width="80">
            </div>    
            
            <!-- Título -->
            <h2>JURISCONNECT SENA</h2>

            <!-- Session Status -->
            @if (session('status'))
                <div class="session-status">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Formulario -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <label for="email">{{ __('Correo Electrico') }}</label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    autocomplete="username"
                    class="{{ $errors->get('email') ? 'error-input' : '' }}"
                >
                @if ($errors->get('email'))
                    <div class="error-message">
                        @foreach ($errors->get('email') as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <!-- Password -->
                <label for="password">{{ __('Contraseña') }}</label>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password"
                    class="{{ $errors->get('password') ? 'error-input' : '' }}"
                >
                @if ($errors->get('password'))
                    <div class="error-message">
                        @foreach ($errors->get('password') as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <!-- Remember Me -->
                <div class="remember-container">
                    <input 
                        id="remember_me" 
                        type="checkbox" 
                        name="remember"
                    >
                    <label for="remember_me">{{ __('Recuerdame') }}</label>
                </div>

                <button type="submit">{{ __('Iniciar Sesión') }}</button>

                <div class="forgot-link">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('¿Haz olvidado tu contraseña?') }}
                        </a>
                    @endif
                </div>
            </form>

            <!-- Logo del SENA abajo -->
            <div class="logo_container">
                <img src="{{ asset('img/LogoInsti.png') }}" alt="Logo Institucional" width="85">
            </div>
        </div>

    </body>
    </html>