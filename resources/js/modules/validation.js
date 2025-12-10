/**
 * Módulo de validaciones
 */

import { showCustomAlert } from "./alerts.js";
import { checkForDuplicatesAPI, checkFieldAPI } from "./api.js";

export function validateForm(formData) {
    const errors = [];
    if (!formData.get("nombre") || formData.get("nombre").trim() === "")
        errors.push("El nombre es obligatorio");
    if (!formData.get("apellido") || formData.get("apellido").trim() === "")
        errors.push("El apellido es obligatorio");
    if (!formData.get("tipoDocumento") || formData.get("tipoDocumento").trim() === "")
        errors.push("El tipo de documento es obligatorio");
    if (!formData.get("numeroDocumento") || formData.get("numeroDocumento").trim() === "")
        errors.push("El número de documento es obligatorio");
    if (!formData.get("correo") || formData.get("correo").trim() === "")
        errors.push("El correo electrónico es obligatorio");
    if (!formData.get("telefono") || formData.get("telefono").trim() === "")
        errors.push("El teléfono es obligatorio");
    if (!formData.get("especialidad") || formData.get("especialidad").trim() === "")
        errors.push("La especialidad es obligatoria");

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (formData.get("correo") && !emailRegex.test(formData.get("correo")))
        errors.push("El formato del correo electrónico no es válido");

    return errors;
}

export function validateEditForm(formData) {
    return validateForm(formData);
}

export function validateRegisterForm(formData) {
    const errors = [];
    if (!formData.get("correo") || formData.get("correo").trim() === "")
        errors.push("El correo electrónico es obligatorio");
    if (!formData.get("telefono") || formData.get("telefono").trim() === "")
        errors.push("El teléfono es obligatorio");
    if (!formData.get("especialidad") || formData.get("especialidad").trim() === "")
        errors.push("La especialidad es obligatoria");

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (formData.get("correo") && !emailRegex.test(formData.get("correo")))
        errors.push("El formato del correo electrónico no es válido");

    return errors;
}

export async function handleDuplicateError(error, status, context = "create") {
    if (status === 422) {
        const errorMessage = error.message || "";
        const errors = error.errors || {};

        if (errorMessage.includes("documento") && errorMessage.includes("ya existe")) {
            await showCustomAlert(
                "error",
                "Documento Duplicado",
                "Ya existe un abogado registrado con este número de documento. Por favor, verifica el número o usa otro."
            );
            return true;
        }
        if (errorMessage.includes("correo") && 
            (errorMessage.includes("ya existe") || errorMessage.includes("unique"))) {
            await showCustomAlert(
                "error",
                "Correo Duplicado",
                "Ya existe un abogado registrado con este correo electrónico. Usa otra dirección."
            );
            return true;
        }

        if (errors.numero_documento && 
            errors.numero_documento.some((err) => err.toLowerCase().includes("ya existe"))) {
            await showCustomAlert(
                "error",
                "Número de Documento Ya Registrado",
                "El número de documento ingresado ya está registrado."
            );
            return true;
        }
        if (errors.correo && 
            errors.correo.some((err) => err.toLowerCase().includes("ya existe"))) {
            await showCustomAlert(
                "error",
                "Correo Electrónico Ya Registrado",
                "El correo electrónico ingresado ya está registrado."
            );
            return true;
        }

        if (errorMessage.includes("ya existe") || 
            errorMessage.includes("duplicado") || 
            errorMessage.includes("unique")) {
            const actionText = context === "create" ? "crear" : "actualizar";
            await showCustomAlert(
                "error",
                "Información Duplicada",
                `No se puede ${actionText} porque existe otro registro con la misma información.`
            );
            return true;
        }

        await showCustomAlert(
            "warning",
            "Error de Validación",
            errorMessage || "Los datos ingresados no son válidos."
        );
        return true;
    }
    return false;
}

export async function checkForDuplicates(formData, currentId = null) {
    try {
        const body = {
            numero_documento: formData.get("numeroDocumento"),
            correo: formData.get("correo"),
            current_id: currentId,
        };

        const res = await checkForDuplicatesAPI(body);
        if (res.ok) {
            const result = res.data;
            if (result.duplicates && result.duplicates.length > 0) {
                const duplicateMessages = result.duplicates.map((duplicate) => {
                    if (duplicate.field === "numero_documento")
                        return `• Número de documento ${duplicate.value} ya está registrado`;
                    if (duplicate.field === "correo")
                        return `• Correo electrónico ${duplicate.value} ya está registrado`;
                    return `• ${duplicate.field}: ${duplicate.value} ya existe`;
                });
                await showCustomAlert(
                    "warning",
                    "Información Duplicada Detectada",
                    `Se encontraron los siguientes duplicados:\n\n${duplicateMessages.join("\n")}\n\nPor favor, modifica estos campos antes de continuar.`
                );
                return true;
            }
        }
    } catch (err) {
        console.log("No se pudo verificar duplicados:", err);
    }
    return false;
}

export function setupRealTimeValidation(fieldName, inputElement) {
    let timeoutId;
    inputElement.addEventListener("input", function () {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(async () => {
            const value = this.value.trim();
            if (value.length < 3) {
                inputElement.classList.remove("error", "success");
                hideFieldError(inputElement);
                return;
            }
            try {
                const res = await checkFieldAPI(fieldName, value);
                if (res.ok) {
                    const result = res.data;
                    if (result.exists) {
                        inputElement.classList.add("error");
                        inputElement.classList.remove("success");
                        showFieldError(
                            inputElement,
                            `Este ${fieldName === "numeroDocumento" || fieldName === "numero_documento"
                                ? "número de documento"
                                : "correo"
                            } ya está registrado`
                        );
                    } else {
                        inputElement.classList.add("success");
                        inputElement.classList.remove("error");
                        hideFieldError(inputElement);
                    }
                }
            } catch (err) {
                console.log("Error en validación en tiempo real:", err);
            }
        }, 800);
    });
}

export function showFieldError(inputElement, message) {
    let errorElement = inputElement.parentNode.querySelector(".field-error");
    if (!errorElement) {
        errorElement = document.createElement("div");
        errorElement.className = "field-error";
        errorElement.style.color = "#e74c3c";
        errorElement.style.fontSize = "12px";
        errorElement.style.marginTop = "4px";
        inputElement.parentNode.appendChild(errorElement);
    }
    errorElement.textContent = message;
}

export function hideFieldError(inputElement) {
    const errorElement = inputElement.parentNode.querySelector(".field-error");
    if (errorElement) errorElement.remove();
}