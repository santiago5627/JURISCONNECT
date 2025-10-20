<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>JurisConnect SENA - Restablecer Contraseña</title>
    <link rel="stylesheet" href="{{ asset('/css/register.css') }}">

</head>
<body>
    <!-- Fondo -->
    <div class="background-image">
        <img src="{{ asset('img/Login.jpg') }}" alt="Fondo de Pantalla" class="background-image">
    </div>

    <!-- Izquierda: logo -->
    <div class="branding">
        <img src="{{ asset('img/LogoJ.png') }}" alt="JurisConnect">
    </div>

    <!-- Derecha: formulario -->
    <div class="login-box">
        <h2>Actualizar Contraseña</h2>

        <!-- Errores -->
        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- Email -->
            <label for="email">Correo Electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email', request('email')) }}" required autofocus>
            <!-- Password -->
            <label for="password">Nueva Contraseña</label>
            <div class="password-wrapper">
                <input id="password" type="password" name="password" required>
                <span class="toggle-password" onclick="togglePassword('password')">
                    <!-- Ojo cerrado -->
                    <svg xmlns="http://www.w3.org/2000/svg" id="eyeClosed-password"
                        viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17.94 17.94A10.12 10.12 0 0 1 12 20c-7 0-11-8-11-8
                                a19.44 19.44 0 0 1 4.24-5.94M9.9 4.24A9.77 9.77 0 0 1 12 4
                                c7 0 11 8 11 8a19.44 19.44 0 0 1-4.24 5.94M1 1l22 22"/>
                    </svg>
                    <!-- Ojo abierto -->
                    <svg xmlns="http://www.w3.org/2000/svg" id="eyeOpen-password"
                        viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </span>
            </div>

            <!-- Confirm Password -->
            <label for="password_confirmation">Confirmar Contraseña</label>
            <div class="password-wrapper">
                <input id="password_confirmation" type="password" name="password_confirmation" required>
                <span class="toggle-password" onclick="togglePassword('password_confirmation')">
                    <!-- Ojo cerrado -->
                    <svg xmlns="http://www.w3.org/2000/svg" id="eyeClosed-password_confirmation"
                        viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17.94 17.94A10.12 10.12 0 0 1 12 20c-7 0-11-8-11-8
                                a19.44 19.44 0 0 1 4.24-5.94M9.9 4.24A9.77 9.77 0 0 1 12 4
                                c7 0 11 8 11 8a19.44 19.44 0 0 1-4.24 5.94M1 1l22 22"/>
                    </svg>
                    <!-- Ojo abierto -->
                    <svg xmlns="http://www.w3.org/2000/svg" id="eyeOpen-password_confirmation"
                        viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </span>
            </div>
            @error('password_confirmation')
                <span class="error-message">{{ $message }}</span>
            @enderror

            <!-- Botones -->
            <div class="button-group">
                <button type="button" class="btn btn-back" onclick="window.location='{{ url('/') }}'">
                    Cancelar
                </button>
                <button class="btn" type="submit">Guardar</button>
            </div>
        </form>
        <img src="{{ asset('img/Sena.png') }}" alt="Logo SENA" class="sena-logo">
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const emailInput = document.getElementById('email');
    const form = document.querySelector('form');
    const nextButton = document.querySelector('.btn-next');
    const backButton = document.querySelector('.btn-back');
    
    // Configuración de placeholders dinámicos
    let placeholderIndex = 0;
    const placeholders = [
        'xxxxxxxxxxxx',
        'tu.email@sena.edu.co',
        'correo@ejemplo.com',
        'usuario@dominio.com'
    ];

    // Función para cambiar placeholder
    function changePlaceholder() {
        if (emailInput && !emailInput.value && document.activeElement !== emailInput) {
            placeholderIndex = (placeholderIndex + 1) % placeholders.length;
            emailInput.placeholder = placeholders[placeholderIndex];
        }
    }

    // Cambiar placeholder cada 3 segundos
    setInterval(changePlaceholder, 3000);

    // Eventos del campo email
    if (emailInput) {
        emailInput.addEventListener('focus', function() {
            this.placeholder = 'Ingresa tu correo electrónico';
            this.style.textAlign = 'left';
        });

        emailInput.addEventListener('blur', function() {
            if (!this.value) {
                this.placeholder = 'xxxxxxxxxxxx';
                this.style.textAlign = 'center';
            }
        });

        emailInput.addEventListener('input', function() {
            // Remover clase de error al escribir
            this.classList.remove('is-invalid');
            
            // Validación en tiempo real
            if (this.value && !isValidEmail(this.value)) {
                this.style.borderColor = '#ffc107';
            } else if (this.value && isValidEmail(this.value)) {
                this.style.borderColor = '#28a745';
            } else {
                this.style.borderColor = '#e9ecef';
            }
        });
    }

    // Event listener para el botón siguiente
    if (nextButton) {
        nextButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            const email = emailInput.value.trim();
            
            if (!email) {
                showValidationError('Por favor, ingresa tu correo electrónico.');
                emailInput.focus();
                return;
            }

            if (!isValidEmail(email)) {
                showValidationError('Por favor, ingresa un correo electrónico válido.');
                emailInput.focus();
                return;
            }

            // Si hay un formulario con action de Laravel, enviarlo
            if (form && form.action) {
                showLoadingState();
                form.submit();
            } else {
                // Simular envío exitoso (para pruebas)
                showSuccessMessage('Hemos enviado un enlace de restablecimiento de contraseña a tu correo electrónico.');
                // Limpiar formulario después del envío exitoso
                setTimeout(() => {
                    emailInput.value = '';
                }, 2000);
            }
        });
    }

    // Event listener para el botón volver
    if (backButton) {
        backButton.addEventListener('click', function(e) {
            e.preventDefault();
            goBack();
        });
    }

    // Función de validación de email
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Mostrar error de validación
    function showValidationError(message) {
        // Remover alertas existentes
        removeExistingAlerts();
        
        // Crear nueva alerta de error
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger';
        
        const messageP = document.createElement('p');
        messageP.textContent = message;
        alertDiv.appendChild(messageP);

        // Insertar antes del formulario
        const formContainer = document.querySelector('.form-container');
        const form = document.querySelector('form');
        formContainer.insertBefore(alertDiv, form);

        // Agregar clase de error al input
        emailInput.classList.add('is-invalid');

        // Auto-remover después de 5 segundos
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // Mostrar estado de carga
    function showLoadingState() {
        const submitBtn = document.querySelector('.btn-next');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Enviando...';
            submitBtn.style.opacity = '0.7';
        }
    }

    // Remover alertas existentes
    function removeExistingAlerts() {
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => {
            if (!alert.querySelector('p').textContent.includes('Hemos enviado')) {
                alert.remove();
            }
        });
    }

    // Animaciones de entrada
    function animateElements() {
        const leftSection = document.querySelector('.left-section');
        const formContainer = document.querySelector('.form-container');
        
        if (leftSection) {
            leftSection.style.opacity = '0';
            leftSection.style.transform = 'translateX(-50px)';
            
            setTimeout(() => {
                leftSection.style.transition = 'all 1s ease-out';
                leftSection.style.opacity = '1';
                leftSection.style.transform = 'translateX(0)';
            }, 100);
        }
        
        if (formContainer) {
            formContainer.style.opacity = '0';
            formContainer.style.transform = 'translateX(50px)';
            
            setTimeout(() => {
                formContainer.style.transition = 'all 1s ease-out';
                formContainer.style.opacity = '1';
                formContainer.style.transform = 'translateX(0)';
            }, 300);
        }
    }

    // Efectos de hover para botones
    function addButtonEffects() {
        const buttons = document.querySelectorAll('.btn');
        
        buttons.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            btn.addEventListener('mouseleave', function() {
                if (!this.disabled) {
                    this.style.transform = 'translateY(0)';
                }
            });
        });
    }

    // Auto-dismiss de alertas de éxito
    function setupAlertAutoDismiss() {
        const successAlerts = document.querySelectorAll('.alert-success');
        
        successAlerts.forEach(alert => {
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateX(-20px)';
                    
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }
            }, 5000);
        });
    }

    // Función para el botón volver
    function goBack() {
        // Intentar ir hacia atrás en el historial
        if (window.history.length > 1) {
            window.history.back();
        } else {
            // Si no hay historial, ir a la página de login
            window.location.href = '/login';
        }
    }

    // Función para mostrar mensaje de éxito
    function showSuccessMessage(message) {
        // Remover alertas existentes
        removeExistingAlerts();
        
        // Crear nueva alerta de éxito
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-success';
        
        const messageP = document.createElement('p');
        messageP.textContent = message;
        alertDiv.appendChild(messageP);

        // Insertar antes del formulario
        const formContainer = document.querySelector('.form-container');
        const form = document.querySelector('form');
        formContainer.insertBefore(alertDiv, form);

        // Auto-remover después de 5 segundos
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.style.transition = 'opacity 0.5s ease-out';
                alertDiv.style.opacity = '0';
                setTimeout(() => alertDiv.remove(), 500);
            }
        }, 5000);
    }

    // Efecto de typing para el placeholder
    function typingEffect() {
        if (emailInput && !emailInput.value && document.activeElement !== emailInput) {
            const currentPlaceholder = placeholders[placeholderIndex];
            let currentText = '';
            let charIndex = 0;
            
            const typeInterval = setInterval(() => {
                if (charIndex < currentPlaceholder.length) {
                    currentText += currentPlaceholder[charIndex];
                    emailInput.placeholder = currentText;
                    charIndex++;
                } else {
                    clearInterval(typeInterval);
                }
            }, 100);
        }
    }

    // Inicializar funciones
    animateElements();
    addButtonEffects();
    setupAlertAutoDismiss();

    // Efectos adicionales para mejor UX
    document.addEventListener('keydown', function(e) {
        // Enter en el campo email envía el formulario
        if (e.key === 'Enter' && document.activeElement === emailInput) {
            form.dispatchEvent(new Event('submit'));
        }
        
        // Escape limpia el campo
        if (e.key === 'Escape' && document.activeElement === emailInput) {
            emailInput.value = '';
            emailInput.blur();
        }
    });

    // Prevenir doble envío y configurar botones
    let formSubmitted = false;
    
    // Configurar eventos de los botones al cargar
    function setupButtonEvents() {
        if (nextButton) {
            nextButton.type = 'button'; // Prevenir envío automático del form
        }
        
        if (backButton) {
            // Si es un enlace, prevenir comportamiento por defecto
            if (backButton.tagName === 'A') {
                backButton.href = '#';
            }
            backButton.type = 'button';
        }
    }

    // Función global para el botón volver (accesible desde HTML)
    window.goBack = function() {
        if (window.history.length > 1) {
            window.history.back();
        } else {
            window.location.href = "/";
        }
    };

    function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const eyeClosed = document.getElementById(`eyeClosed-${inputId}`);
    const eyeOpen = document.getElementById(`eyeOpen-${inputId}`);

    if (input.type === "password") {
        input.type = "text";
        eyeClosed.style.display = "none";
        eyeOpen.style.display = "inline";
    } else {
        input.type = "password";
        eyeClosed.style.display = "inline";
        eyeOpen.style.display = "none";
    }
}
    window.togglePassword = togglePassword; 

    // Inicializar todo
    setupButtonEvents();

    console.log('JurisConnect - Recuperar Contraseña inicializado correctamente');
});
    </script>
</body>
</html>
