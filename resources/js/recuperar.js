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

    // Inicializar todo
    setupButtonEvents();

    console.log('JurisConnect - Recuperar Contraseña inicializado correctamente');
});