// asistentes.js

document.addEventListener('DOMContentLoaded', function() {
    
    // Configuración de SweetAlert2 personalizada
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // ==========================================
    // ALERTA DE CREACIÓN EXITOSA
    // ==========================================
    // Detectar si hay un mensaje de éxito en la sesión (desde el backend)
    const successMessage = document.querySelector('[data-success-message]');
    if (successMessage) {
        const message = successMessage.dataset.successMessage;
        Toast.fire({
            icon: 'success',
            title: message || 'Asistente jurídico creado exitosamente'
        });
    }

    // ==========================================
    // ALERTA DE ACTUALIZACIÓN EXITOSA
    // ==========================================
    const updateMessage = document.querySelector('[data-update-message]');
    if (updateMessage) {
        const message = updateMessage.dataset.updateMessage;
        Toast.fire({
            icon: 'success',
            title: message || 'Asistente jurídico actualizado exitosamente'
        });
    }

    // ==========================================
    // CONFIRMACIÓN DE ELIMINACIÓN
    // ==========================================
    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const form = this.closest('form');
            
            Swal.fire({
                title: '¿Está seguro?',
                text: "Esta acción eliminará permanentemente el asistente jurídico",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar loading
                    Swal.fire({
                        title: 'Eliminando...',
                        text: 'Por favor espere',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit del formulario
                    form.submit();
                }
            });
        });
    });

    // ==========================================
    // ALERTA DE ELIMINACIÓN EXITOSA
    // ==========================================
    const deleteMessage = document.querySelector('[data-delete-message]');
    if (deleteMessage) {
        const message = deleteMessage.dataset.deleteMessage;
        Toast.fire({
            icon: 'success',
            title: message || 'Asistente jurídico eliminado exitosamente'
        });
    }

    // ==========================================
    // MANEJO DE ERRORES
    // ==========================================
    const errorMessage = document.querySelector('[data-error-message]');
    if (errorMessage) {
        const message = errorMessage.dataset.errorMessage;
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message || 'Ocurrió un error al procesar la solicitud',
            confirmButtonText: 'Entendido'
        });
    }

    // ==========================================
    // BOTÓN EDITAR (opcional - redirige o abre modal)
    // ==========================================
    const editButtons = document.querySelectorAll('.btn-edit');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const assistantId = this.dataset.id;
            // Aquí puedes redirigir a la página de edición o abrir un modal
            window.location.href = `/asistentes/${assistantId}/edit`;
        });
    });

    // ==========================================
    // VALIDACIÓN DE FORMULARIO (opcional)
    // ==========================================
    const assistantForm = document.querySelector('#assistantForm');
    
    if (assistantForm) {
        assistantForm.addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                } else {
                    field.classList.remove('error');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                Toast.fire({
                    icon: 'error',
                    title: 'Por favor complete todos los campos requeridos'
                });
            }
        });
    }
    

});