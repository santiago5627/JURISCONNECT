/* ========= ALERTAS PERSONALIZADAS (VERSIÓN MEJORADA) ========= */

function showCustomAlert(
    type,
    title = "",
    message = "",
    showCancel = false,
    confirmText = "Aceptar",
    cancelText = "Cancelar"
) {
    return new Promise((resolve) => {
        // Crear overlay si no existe
        let alertOverlay = document.getElementById("alertOverlay");
        if (alertOverlay) {
            alertOverlay.remove();
        }

        // Crear nuevo overlay
        alertOverlay = document.createElement("div");
        alertOverlay.id = "alertOverlay";
        alertOverlay.className = "alert-overlay";

        // Configurar iconos según el tipo
        const icons = {
            success: "✓",
            error: "✕",
            warning: "⚠",
            info: "ℹ",
        };

        // Configurar títulos por defecto
        const defaultTitles = {
            success: "¡Éxito!",
            error: "¡Error!",
            warning: "¡Atención!",
            info: "Información",
        };

        // Configurar mensajes por defecto
        const defaultMessages = {
            success: "Operación completada exitosamente",
            error: "Algo salió mal. Inténtalo de nuevo.",
            warning: "Verifica la información antes de continuar.",
            info: "Proceso en desarrollo.",
        };

        const icon = icons[type] || icons.info;
        const alertTitle = title || defaultTitles[type] || defaultTitles.info;
        const alertMessage =
            message || defaultMessages[type] || defaultMessages.info;

        // Crear botones
        const buttonsHTML = showCancel
            ? `<div class="alert-buttons">
                <button class="alert-button secondary" id="cancelAlertBtn">${cancelText}</button>
                <button class="alert-button ${type}" id="confirmAlertBtn">${confirmText}</button>
               </div>`
            : `<div class="alert-buttons">
                <button class="alert-button ${type}" id="confirmAlertBtn">${confirmText}</button>
               </div>`;

        alertOverlay.innerHTML = `
            <div class="custom-alert alert-${type}" id="customAlert" role="dialog" aria-modal="true">
                <div class="alert-icon">${icon}</div>
                <div class="alert-title">${alertTitle}</div>
                <div class="alert-message">${alertMessage}</div>
                ${buttonsHTML}
            </div>
        `;

        document.body.appendChild(alertOverlay);

        // Mostrar con animación
        setTimeout(() => alertOverlay.classList.add("show"), 10);

        const cleanup = () => {
            alertOverlay.classList.remove("show");
            setTimeout(() => {
                if (alertOverlay && alertOverlay.parentNode) {
                    alertOverlay.parentNode.removeChild(alertOverlay);
                }
            }, 350);
        };

        // Event listeners para botones
        const confirmBtn = document.getElementById("confirmAlertBtn");
        const cancelBtn = document.getElementById("cancelAlertBtn");

        if (confirmBtn) {
            confirmBtn.onclick = () => {
                cleanup();
                resolve(true);
            };
        }

        if (cancelBtn) {
            cancelBtn.onclick = () => {
                cleanup();
                resolve(false);
            };
        }

        // Cerrar con ESC
        const escHandler = (e) => {
            if (e.key === "Escape") {
                cleanup();
                resolve(false);
                document.removeEventListener("keydown", escHandler);
            }
        };
        document.addEventListener("keydown", escHandler);

        // Cerrar al hacer click fuera del modal
        alertOverlay.addEventListener("click", function (e) {
            if (e.target === alertOverlay) {
                cleanup();
                resolve(false);
            }
        });
    });
}

document.addEventListener("DOMContentLoaded", function () {
    // ==========================================
    // CONFIGURACIÓN DE SWEETALERT2 (TOAST)
    // Se usará para notificaciones de eliminación no críticas.
    // ==========================================
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    // ==========================================
    // ALERTA DE CREACIÓN EXITOSA (Modal Unificado)
    // ==========================================
    const successMessage = document.querySelector("[data-success-message]");
    if (successMessage) {
        const message = successMessage.dataset.successMessage;
        Swal.fire({
            icon: "success",
            title: "¡Accion Exitosa!", // Título unificado para creación
            text: message,
            confirmButtonText: "OK",
            confirmButtonColor: "#28a745", // Botón verde
        });
    }

    // ==========================================
    // ALERTA DE ACTUALIZACIÓN EXITOSA (Modal Unificado)
    // ==========================================
    const updateMessage = document.querySelector("[data-update-message]");
    if (updateMessage) {
        const message = updateMessage.dataset.updateMessage;
        Swal.fire({
            icon: "success",
            title: "¡Actualización Exitosa!", // Título para actualización
            text: message,
            confirmButtonText: "OK", // Botón "OK"
            confirmButtonColor: "#28a745", // Botón verde
        });
    }

    // ==========================================
    // ALERTA DE ELIMINACIÓN EXITOSA (Toast)
    // ==========================================
    const deleteMessage = document.querySelector("[data-delete-message]");
    if (deleteMessage) {
        const message = deleteMessage.dataset.deleteMessage;
        Toast.fire({
            icon: "info", // Para indicar que la acción peligrosa terminó
            title: message,
            background: "#fff3cd",
            color: "#856404",
        });
    }

    // ==========================================
    // ALERTA DE ERROR (Modal)
    // ==========================================
    const errorMessage = document.querySelector("[data-error-message]");
    if (errorMessage) {
        const message = errorMessage.dataset.errorMessage;
        Swal.fire({
            icon: "error",
            title: "Error Inesperado",
            text: message,
            confirmButtonText: "Entendido",
            confirmButtonColor: "#dc3545", // Botón rojo
        });
    }

    // ==========================================
    // BOTÓN EDITAR (Se mantiene)
    // ==========================================
    const editButtons = document.querySelectorAll(".btn-edit-asistente");
    editButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const assistantId = this.dataset.id;
            Swal.fire({
                title: "Cargando...",
                text: "Preparando formulario de edición",
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
            window.location.href = `/asistentes/${assistantId}/edit`;
        });
    });

    // ==========================================
    // VALIDACIÓN DE FORMULARIO
    // ==========================================
    const assistantForm = document.querySelector("#assistantForm");
    if (assistantForm) {
        assistantForm.addEventListener("submit", function (e) {
            const requiredFields = this.querySelectorAll("[required]");
            let isValid = true;
            let emptyFields = [];
            requiredFields.forEach((field) => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add("error");
                    const label = document.querySelector(
                        `label[for="${field.id}"]`
                    );
                    if (label) {
                        emptyFields.push(
                            label.textContent.replace("*", "").trim()
                        );
                    }
                } else {
                    field.classList.remove("error");
                }
            });

            if (!isValid) {
                e.preventDefault();
                Swal.fire({
                    icon: "warning",
                    title: "🛑 ¡Atención! Campos Requeridos",
                    html: `<p>Debe completar los siguientes campos obligatorios para continuar:</p>
                        <ul style="text-align: left; margin: 10px auto; display: inline-block;">
                        ${emptyFields
                            .map((field) => `<li>**${field}**</li>`)
                            .join("")}
                        </ul>`,
                    confirmButtonText: "Corregir",
                    confirmButtonColor: "#ffc107",
                });
            }
        });

        const allInputs = assistantForm.querySelectorAll(
            "input, select, textarea"
        );
        allInputs.forEach((input) => {
            input.addEventListener("input", function () {
                this.classList.remove("error");
            });
        });
    }

    // ==========================================
    // HOVER EFFECTS
    // ==========================================
    const actionButtons = document.querySelectorAll(".btn-edit, .btn-delete");
    actionButtons.forEach((button) => {
        button.addEventListener("mouseenter", function () {
            this.style.transform = "scale(1.05)";
            this.style.transition = "transform 0.2s ease";
        });
        button.addEventListener("mouseleave", function () {
            this.style.transform = "scale(1)";
        });
    });

    // Delegación: eliminar abogado con confirmación
    document.addEventListener("submit", async function (e) {
        if (e.target.classList.contains("delete-asistente-form")) {
            e.preventDefault();

            const form = e.target;

            // Nombre real del asistente
            const assistantName = form.dataset.name || "";

            const confirmed = await showCustomAlert(
                "warning",
                "Confirmar Eliminación",
                `¿Estás seguro de eliminar al asistente ${assistantName}? Esta acción no se puede deshacer.`,
                true,
                "Eliminar",
                "Cancelar"
            );

            if (confirmed) form.submit();
        }
    });

    

});
