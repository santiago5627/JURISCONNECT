/**
 * MAIN.JS - Punto de entrada
 * Importa todos los módulos y orquesta la inicialización
 */

import * as Alerts from "./modules/alerts.js";
import * as API from "./modules/api.js";
import * as Validation from "./modules/validation.js";
import * as UI from "./modules/ui.js";
import * as Pagination from "./modules/pagination.js";

/**
 * SETUP DE EVENT LISTENERS GLOBALES
 */
function setupGlobalListeners() {
    // ===== SIDEBAR =====
    const hamburgerBtn = document.getElementById("hamburgerBtn");
    const overlay = document.getElementById("overlay");
    if (hamburgerBtn) hamburgerBtn.addEventListener("click", UI.toggleSidebar);
    if (overlay) overlay.addEventListener("click", UI.closeSidebar);

    // ===== CREAR ABOGADO: MODAL =====
    const createBtn = document.getElementById("createBtn");
    const closeModal = document.getElementById("closeModal");
    const cancelBtn = document.getElementById("cancelBtn");
    if (createBtn) createBtn.addEventListener("click", UI.openModal);
    if (closeModal) closeModal.addEventListener("click", UI.closeModalFunction);
    if (cancelBtn) cancelBtn.addEventListener("click", UI.closeModalFunction);

    // ===== EDITAR ABOGADO: MODAL =====
    const closeEditModalBtn = document.getElementById("closeEditModal");
    const cancelEditBtn = document.getElementById("cancelEditBtn");
    if (closeEditModalBtn) closeEditModalBtn.addEventListener("click", UI.closeEditModal);
    if (cancelEditBtn) cancelEditBtn.addEventListener("click", UI.closeEditModal);

    // ===== ASSISTANT: MODAL =====
    const btnOpenAsistente = document.getElementById("btnOpenAsistente");
    const btnCloseAsistente = document.getElementById("closeAsistente");
    const btnCancelAsistente = document.getElementById("cancelAsistente");
    if (btnOpenAsistente) btnOpenAsistente.addEventListener("click", UI.openAssistantModal);
    if (btnCloseAsistente) btnCloseAsistente.addEventListener("click", UI.closeAssistantModal);
    if (btnCancelAsistente) btnCancelAsistente.addEventListener("click", UI.closeAssistantModal);

    // ===== CERRAR TODO CON ESC =====
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            UI.closeSidebar();
            UI.closeModalFunction();
            UI.closeEditModal();
            UI.closeAssistantModal();
            Alerts.hideCustomAlert();
        }
    });

    // ===== BÚSQUEDA EN TIEMPO REAL =====
    Pagination.setupSearchInput();

    // ===== PAGINACIÓN AJAX =====
    Pagination.handleAjaxPagination();

    // ===== SETUP ADICIONAL UI =====
    UI.setupNameCapitalization();
    UI.setupCardToggles();
    UI.setupSectionNavigation();
    UI.setupImageUpload();

    console.log("✓ Event listeners globales inicializados");
}

/**
 * DELEGACIÓN DE EVENTOS: ELIMINAR ABOGADO
 */
function setupDeleteLawyerForm() {
    document.addEventListener("submit", async function (e) {
        if (e.target.classList.contains("delete-lawyer-form")) {
            e.preventDefault();
            const form = e.target;
            const lawyerName = form.dataset.name || "";
            const confirmed = await Alerts.alertDelete(
                `¿Estás seguro de eliminar al abogado ${lawyerName}? Esta acción no se puede deshacer.`,
                "Confirmar Eliminación"
            );
            if (confirmed) form.submit();
        }
    });
}

/**
 * DELEGACIÓN DE EVENTOS: ELIMINAR PROCESO
 */
function setupDeleteProcesoForm() {
    document.addEventListener("submit", async function (e) {
        if (e.target.classList.contains("delete-proceso-form")) {
            e.preventDefault();
            const confirmed = await Alerts.alertDelete(
                "¿Seguro que deseas eliminar este proceso?",
                "Confirmar Eliminación"
            );
            if (confirmed) e.target.submit();
        }
    });
}

/**
 * DELEGACIÓN DE EVENTOS: EDITAR ABOGADO
 */
function setupEditLawyerButton() {
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("btn-edit")) {
            const row = e.target.closest("tr");
            if (!row) return;

            const lawyerData = {
                id: row.dataset.id,
                nombre: row.children[0].textContent,
                apellido: row.children[1].textContent,
                tipo_documento: row.children[2].textContent,
                numero_documento: row.children[3].textContent,
                correo: row.children[4].textContent,
                telefono: row.children[5].textContent,
                especialidad: row.children[6].textContent,
            };
            UI.openEditModal(lawyerData);
        }
    });
}

/**
 * CREAR ABOGADO: ENVÍO DE FORMULARIO
 */
function setupCreateLawyerForm() {
    const createForm = document.getElementById("createLawyerModal")?.querySelector("form");
    if (!createForm) return;

    createForm.addEventListener("submit", async function (e) {
        e.preventDefault();
        const form = e.target;
        const data = new FormData(form);

        const validationErrors = Validation.validateForm(data);
        if (validationErrors.length > 0) {
            await Alerts.showCustomAlert(
                "warning",
                "Campos Incompletos",
                "Por favor, completa todos los campos obligatorios:\n\n" +
                validationErrors.join("\n")
            );
            return;
        }

        const hasDuplicates = await Validation.checkForDuplicates(data);
        if (hasDuplicates) return;

        try {
            const csrf = API.getCsrfToken();
            const response = await fetch("/lawyers", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": csrf },
                body: data,
            });

            if (response.ok) {
                await Alerts.alertSuccess(
                    `El abogado ${data.get("nombre")} ${data.get("apellido")} ha sido registrado exitosamente.`,
                    "¡Excelente!"
                );
                form.reset();
                UI.closeModalFunction();
                location.reload();
            } else {
                const error = await response.json();
                const handled = await Validation.handleDuplicateError(error, response.status, "create");
                if (!handled) {
                    await Alerts.alertError(
                        "Error al guardar: " + (error.message || "Verifica los campos."),
                        "Error al Crear"
                    );
                }
            }
        } catch (err) {
            console.error(err);
            await Alerts.alertError(
                "No se pudo crear el abogado. Verifica tu conexión e inténtalo de nuevo.",
                "Error de Conexión"
            );
        }
    });
}

/**
 * EDITAR ABOGADO: ENVÍO DE FORMULARIO
 */
function setupEditLawyerForm() {
    const form = document.getElementById("editLawyerForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        // Asegurar action válido
        if (!form.action || form.action === "#" || form.action.endsWith("/dashboard")) {
            await Alerts.alertError("Formulario sin destino. Abre el modal de edición correctamente.", "Error");
            return;
        }

        const data = new FormData(form);

        // Añadir override method si no existe
        if (!data.get("_method")) {
            data.append("_method", "PUT");
        }

        const validationErrors = Validation.validateEditForm(data);
        if (validationErrors.length > 0) {
            await Alerts.showCustomAlert("warning", "Campos Incompletos", validationErrors.join("\n"));
            return;
        }

        const lawyerId = form.action.split("/").pop();
        const hasDuplicates = await Validation.checkForDuplicates(data, lawyerId);
        if (hasDuplicates) return;

        try {
            const csrf = API.getCsrfToken();
            const response = await fetch(form.action, {
                method: "POST", // Laravel recibirá PUT gracias al campo _method
                headers: { "X-CSRF-TOKEN": csrf, Accept: "application/json" },
                body: data,
            });

            if (response.ok) {
                const updatedLawyer = {
                    nombre: data.get("nombre"),
                    apellido: data.get("apellido"),
                    tipo_documento: data.get("tipoDocumento"),
                    numero_documento: data.get("numeroDocumento"),
                    correo: data.get("correo"),
                    telefono: data.get("telefono"),
                    especialidad: data.get("especialidad"),
                };

                UI.updateRowInTable(lawyerId, updatedLawyer);
                await Alerts.alertSuccess(
                    `El abogado ${updatedLawyer.nombre} ${updatedLawyer.apellido} ha sido actualizado exitosamente.`,
                    "¡Perfecto!"
                );
                UI.closeEditModal();
            } else {
                const error = await response.json();
                const handled = await Validation.handleDuplicateError(error, response.status, "edit");
                if (!handled) {
                    await Alerts.alertError("Error al actualizar: " + (error.message || "Verifica que todos los campos estén correctos."), "Error de Actualización");
                }
            }
        } catch (err) {
            console.error(err);
            await Alerts.alertError("Ocurrió un error inesperado. Inténtalo de nuevo.", "Error Inesperado");
        }
    });
}

/**
 * VALIDACIÓN EN TIEMPO REAL
 */
function setupRealTimeValidation() {
    const createNumeroDocumento = document.getElementById("numeroDocumento");
    const createCorreo = document.getElementById("correo");
    if (createNumeroDocumento)
        Validation.setupRealTimeValidation("numeroDocumento", createNumeroDocumento);
    if (createCorreo)
        Validation.setupRealTimeValidation("correo", createCorreo);

    const editNumeroDocumento = document.getElementById("editNumeroDocumento");
    const editCorreo = document.getElementById("editCorreo");
    if (editNumeroDocumento)
        Validation.setupRealTimeValidation("numeroDocumento", editNumeroDocumento);
    if (editCorreo)
        Validation.setupRealTimeValidation("correo", editCorreo);
}

/**
 * AGREGAR ABOGADO EN MODAL ASISTENTE
 */
document.addEventListener("DOMContentLoaded", function () {

    const lawyerTemplate = document.querySelector(".lawyer-select"); // plantilla clonable
    const lawyerList = document.getElementById("lawyerList"); // para crear asistente
    const addLawyerBtnCreate = document.getElementById("addLawyerBtnCreate");
    const addLawyerBtnEdit = document.getElementById("addLawyerBtnEdit");

    function createSelectInstance() {
        if (!lawyerTemplate) return null;
        const newSelect = lawyerTemplate.cloneNode(true);
        newSelect.style.display = "block";
        newSelect.name = "lawyers[]";
        return newSelect;
    }

    // Añadir select en modal "Crear Asistente"
    if (addLawyerBtnCreate && lawyerList) {
        addLawyerBtnCreate.addEventListener("click", function () {
            const wrapper = document.createElement("div");
            wrapper.style.display = "flex";
            wrapper.style.gap = "10px";
            wrapper.style.marginBottom = "8px";

            const newSelect = createSelectInstance();
            if (!newSelect) return;

            const deleteBtn = document.createElement("button");
            deleteBtn.type = "button";
            deleteBtn.textContent = "Eliminar";
            deleteBtn.classList.add("btn-cancel");
            deleteBtn.addEventListener("click", () => wrapper.remove());

            wrapper.appendChild(newSelect);
            wrapper.appendChild(deleteBtn);

            lawyerList.appendChild(wrapper);
        });
    }

    // Añadir select en modal "Editar Asistente"
    if (addLawyerBtnEdit) {
        addLawyerBtnEdit.addEventListener("click", function () {
            const container = document.getElementById("assignedLawyersContainer");
            if (!container) return;

            const wrapper = document.createElement("div");
            wrapper.style.display = "flex";
            wrapper.style.gap = "10px";
            wrapper.style.marginBottom = "8px";

            const newSelect = createSelectInstance();
            if (!newSelect) return;

            const deleteBtn = document.createElement("button");
            deleteBtn.type = "button";
            deleteBtn.textContent = "Eliminar";
            deleteBtn.classList.add("btn-cancel");
            deleteBtn.addEventListener("click", () => wrapper.remove());

            wrapper.appendChild(newSelect);
            wrapper.appendChild(deleteBtn);
            container.appendChild(wrapper);
        });
    }
});

/**
 * EDITAR ASISTENTE
 */
function setupEditAssistantButton() {
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("btn-edit-assistant")) {
            const btn = e.target;
            const id = btn.dataset.id;

            // Llenar campos del formulario
            document.getElementById("editAssistantNombre").value = btn.dataset.nombre || "";
            document.getElementById("editAssistantApellido").value = btn.dataset.apellido || "";
            document.getElementById("editAssistantTipoDocumento").value = btn.dataset.tipo_documento || "";
            document.getElementById("editAssistantNumeroDocumento").value = btn.dataset.numero_documento || "";
            document.getElementById("editAssistantCorreo").value = btn.dataset.correo || "";
            document.getElementById("editAssistantTelefono").value = btn.dataset.telefono || "";
            

            const editAssistantForm = document.getElementById("form-update");
            if (editAssistantForm) {
                editAssistantForm.action = `/assistants/${id}`;
            }

            const container = document.getElementById("assignedLawyersContainer");
            if (container) {
                container.innerHTML = "";
                const lawyers = JSON.parse(btn.dataset.lawyers || "[]");
                lawyers.forEach((lawyerId) => {
                    UI.addLawyerSelect(lawyerId);
                });
            }

            const editAssistantModal = document.getElementById("editAssistantModal");
            if (editAssistantModal) {
                editAssistantModal.style.display = "flex";
            }
        }
    });

    document.addEventListener("click", function (e) {
        if (e.target.id === "closeEditAssistantModal" || e.target.id === "cancelEditBtn") {
            const editAssistantModal = document.getElementById("editAssistantModal");
            if (editAssistantModal) {
                editAssistantModal.style.display = "none";
            }
        }
    });
}


/**
 * ACTUALIZAR ASISTENTE
 */
function setupUpdateAssistantForm() {
    const updateForm = document.querySelector("#form-update");
    if (!updateForm) return;

    updateForm.addEventListener("submit", async function (e) {
        e.preventDefault();
        const form = e.target;

        // Validar action
        if (!form.action || form.action === "#" || form.action.endsWith("/dashboard")) {
            await Alerts.alertError("Formulario sin destino. Abre el modal de edición correctamente.", "Error");
            return;
        }

        const data = new FormData(form);

        // Añadir spoof _method=PUT para Laravel si no existe
        if (!data.get("_method")) {
            data.append("_method", "PUT");
        }

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");
        if (!csrf) {
            await Alerts.alertError("Token CSRF no encontrado.", "Error");
            return;
        }

        try {
            const response = await fetch(form.action, {
                method: "POST", // Laravel interpretará PUT gracias a _method
                headers: {
                    "X-CSRF-TOKEN": csrf,
                    "Accept": "application/json"
                },
                body: data
            });

            const text = await response.text();

            // Intentar parsear JSON de forma segura
            let payload = null;
            try {
                payload = text ? JSON.parse(text) : null;
            } catch (err) {
                console.error("Respuesta no JSON:", text);
            }

            if (!response.ok) {
                const msg = (payload && payload.message) ? payload.message : "Error del servidor al actualizar el asistente.";
                await Alerts.alertError(msg, "Error");
                return;
            }

            // Éxito: payload contiene la respuesta JSON (si el servidor la devuelve)
            await Alerts.alertSuccess("Asistente actualizado correctamente.", "Hecho");
            // Cerrar modal y/o actualizar UI según sea necesario
            UI.closeEditModal();
            // Actualizar fila en tabla si tienes datos:
            if (payload && payload.assistant) {
                UI.updateRowInTable(payload.assistant.id, payload.assistant);
            }
        } catch (err) {
            console.error(err);
            await Alerts.alertError("Ocurrió un error de red. Inténtalo de nuevo.", "Error de red");
        }
    });
}



/**
 * INICIALIZADOR PRINCIPAL
 */
function init() {
    console.log("🚀 Iniciando aplicación...");

    // Cachear referencias del DOM
    UI.cacheElements();

    // Setup global
    setupGlobalListeners();

    // Formularios y delegación
    setupDeleteLawyerForm();
    setupDeleteProcesoForm();
    setupEditLawyerButton();
    setupCreateLawyerForm();
    setupEditLawyerForm();
    setupEditAssistantButton();
    setupUpdateAssistantForm();

    // Validación
    setupRealTimeValidation();

    // Exponer funciones útiles globalmente (compatibilidad)
    window.showCustomAlert = Alerts.showCustomAlert;
    window.alertSuccess = Alerts.alertSuccess;
    window.alertError = Alerts.alertError;
    window.alertWarning = Alerts.alertWarning;
    window.alertInfo = Alerts.alertInfo;
    window.alertConfirm = Alerts.alertConfirm;
    window.alertDelete = Alerts.alertDelete;
    window.hideCustomAlert = Alerts.hideCustomAlert;
    window.performSearch = Pagination.performSearch;
    window.clearSearch = Pagination.clearSearch;
    window.toggleSidebar = UI.toggleSidebar;
    window.closeSidebar = UI.closeSidebar;
    window.openModal = UI.openModal;
    window.closeModalFunction = UI.closeModalFunction;

    console.log("✓ Aplicación inicializada correctamente");
}

// Ejecutar cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", init);