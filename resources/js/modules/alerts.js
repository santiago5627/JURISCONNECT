/**
 * Módulo de alertas personalizadas
 */

export function showCustomAlert(
    type,
    title = "",
    message = "",
    showCancel = false,
    confirmText = "Aceptar",
    cancelText = "Cancelar"
) {
    return new Promise((resolve) => {
        let alertOverlay = document.getElementById("alertOverlay");
        if (alertOverlay) {
            alertOverlay.remove();
        }

        alertOverlay = document.createElement("div");
        alertOverlay.id = "alertOverlay";
        alertOverlay.className = "alert-overlay";

        const icons = {
            success: "✓",
            error: "✕",
            warning: "⚠",
            info: "ℹ",
        };

        const defaultTitles = {
            success: "¡Éxito!",
            error: "¡Error!",
            warning: "¡Atención!",
            info: "Información",
        };

        const defaultMessages = {
            success: "Operación completada exitosamente",
            error: "Algo salió mal. Inténtalo de nuevo.",
            warning: "Verifica la información antes de continuar.",
            info: "Proceso en desarrollo.",
        };

        const icon = icons[type] || icons.info;
        const alertTitle = title || defaultTitles[type] || defaultTitles.info;
        const alertMessage = message || defaultMessages[type] || defaultMessages.info;

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
        setTimeout(() => alertOverlay.classList.add("show"), 10);

        const cleanup = () => {
            alertOverlay.classList.remove("show");
            setTimeout(() => {
                if (alertOverlay && alertOverlay.parentNode) {
                    alertOverlay.parentNode.removeChild(alertOverlay);
                }
            }, 350);
        };

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

        const escHandler = (e) => {
            if (e.key === "Escape") {
                cleanup();
                resolve(false);
                document.removeEventListener("keydown", escHandler);
            }
        };
        document.addEventListener("keydown", escHandler);

        alertOverlay.addEventListener("click", function (e) {
            if (e.target === alertOverlay) {
                cleanup();
                resolve(false);
            }
        });
    });
}

export function closeAlert() {
    const overlayEl = document.getElementById("alertOverlay");
    if (overlayEl) {
        overlayEl.classList.remove("show");
        setTimeout(() => {
            if (overlayEl && overlayEl.parentNode)
                overlayEl.parentNode.removeChild(overlayEl);
        }, 350);
    }
}

export function hideCustomAlert() {
    closeAlert();
}

// Helpers rápidos
export function alertSuccess(message, title = "¡Éxito!") {
    return showCustomAlert("success", title, message, false, "Aceptar");
}

export function alertError(message, title = "¡Error!") {
    return showCustomAlert("error", title, message, false, "Entendido");
}

export function alertWarning(message, title = "¡Atención!") {
    return showCustomAlert("warning", title, message, false, "De acuerdo");
}

export function alertInfo(message, title = "Información") {
    return showCustomAlert("info", title, message, false, "Ok");
}

export async function alertConfirm(message, title = "¿Continuar?") {
    return await showCustomAlert("info", title, message, true, "Confirmar", "Cancelar");
}

export async function alertDelete(message, title = "¿Eliminar?") {
    return await showCustomAlert("error", title, message, true, "Eliminar", "Cancelar");
}