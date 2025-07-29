// Variables principales
const hamburgerBtn = document.getElementById("hamburgerBtn");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");
const mainContent = document.getElementById("mainContent");
const createLawyerModal = document.getElementById("createLawyerModal");
const createBtn = document.getElementById("createBtn");
const closeModal = document.getElementById("closeModal");
const cancelBtn = document.getElementById("cancelBtn");

// Variables para modal de edición
const editLawyerModal = document.getElementById("editLawyerModal");
const editLawyerForm = document.getElementById("editLawyerForm");
const closeEditModalBtn = document.getElementById("closeEditModal");
const cancelEditBtn = document.getElementById("cancelEditBtn");

// ===== SISTEMA DE ALERTAS PERSONALIZADAS=====
function showCustomAlert(type, title = '', message = '', showCancel = false, confirmText = 'Aceptar', cancelText = 'Cancelar') {

    // Crear overlay si no existe
    let overlay = document.getElementById('alertOverlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.id = 'alertOverlay';
        overlay.className = 'alert-overlay';

        const buttonsHTML = showCancel
            ? `<div class="alert-buttons">
                  <button class="alert-button secondary" id="cancelAlertBtn">${cancelText}</button>
                  <button class="alert-button ${type}" id="confirmAlertBtn">${confirmText}</button>
               </div>`
            : `<button class="alert-button ${type}" id="confirmAlertBtn">${confirmText}</button>`;

        overlay.innerHTML = `
            <div class="custom-alert" id="customAlert">
                <div class="alert-icon" id="alertIcon"></div>
                <div class="alert-title" id="alertTitle"></div>
                <div class="alert-message" id="alertMessage"></div>
                ${buttonsHTML}
            </div>
        `;
        document.body.appendChild(overlay);

        // Agregar estilos CSS si no existen
        if (!document.getElementById('customAlertStyles')) {
            const style = document.createElement('style');
            style.id = 'customAlertStyles';
            document.head.appendChild(style);
        }
    }

    const alert = document.getElementById('customAlert');
    const icon = document.getElementById('alertIcon');
    const titleEl = document.getElementById('alertTitle');
    const messageEl = document.getElementById('alertMessage');

    // Configurar según el tipo
    alert.className = `custom-alert alert-${type}`;

    switch(type) {
        case 'success':
            icon.innerHTML = '✓';
            titleEl.textContent = title || '¡Éxito!';
            messageEl.textContent = message || 'Operación completada exitosamente';
            break;
        case 'error':
            icon.innerHTML = '❌';
            titleEl.textContent = title || '¡Error!';
            messageEl.textContent = message || 'Algo salió mal. Inténtalo de nuevo.';
            break;
        case 'warning':
            icon.innerHTML = '⚠️';
            titleEl.textContent = title || '¡Atención!';
            messageEl.textContent = message || 'Verifica la información antes de continuar.';
            break;
        case 'info':
            icon.innerHTML = 'ℹ';
            titleEl.textContent = title || 'Información';
            messageEl.textContent = message || 'Proceso en desarrollo.';
            break;
    }

    overlay.classList.add('show');

    // SIEMPRE retornar una promesa
    return new Promise((resolve) => {
        document.getElementById('confirmAlertBtn').onclick = () => {
            hideCustomAlert();
            resolve(true);
        };

        // Solo agregar el botón cancelar si existe
        const cancelBtn = document.getElementById('cancelAlertBtn');
        if (cancelBtn) {
            cancelBtn.onclick = () => {
                hideCustomAlert();
                resolve(false);
            };
        }
    });
}

function hideCustomAlert() {
    const overlay = document.getElementById('alertOverlay');
    if (overlay) {
        overlay.classList.remove('show');
        setTimeout(() => {
            if (overlay.parentNode) {
                overlay.parentNode.removeChild(overlay);
            }
        }, 300);
    }
}

// ===== FUNCIONES DE VALIDACIÓN =====
function validateForm(formData) {
    const errors = [];

    // Validar campos requeridos
    if (!formData.get('nombre') || formData.get('nombre').trim() === '') {
        errors.push('El nombre es obligatorio');
    }

    if (!formData.get('apellido') || formData.get('apellido').trim() === '') {
        errors.push('El apellido es obligatorio');
    }

    if (!formData.get('tipoDocumento') || formData.get('tipoDocumento').trim() === '') {
        errors.push('El tipo de documento es obligatorio');
    }

    if (!formData.get('numeroDocumento') || formData.get('numeroDocumento').trim() === '') {
        errors.push('El número de documento es obligatorio');
    }

    if (!formData.get('correo') || formData.get('correo').trim() === '') {
        errors.push('El correo electrónico es obligatorio');
    }

    // NUEVAS VALIDACIONES - Campos ahora obligatorios
    if (!formData.get('telefono') || formData.get('telefono').trim() === '') {
        errors.push('El teléfono es obligatorio');
    }

    if (!formData.get('especialidad') || formData.get('especialidad').trim() === '') {
        errors.push('La especialidad es obligatoria');
    }

    // Validar formato de correo
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (formData.get('correo') && !emailRegex.test(formData.get('correo'))) {
        errors.push('El formato del correo electrónico no es válido');
    }

    return errors;
}

function validateEditForm(formData) {
    const errors = [];

    // Validar campos requeridos para edición
    if (!formData.get('nombre') || formData.get('nombre').trim() === '') {
        errors.push('El nombre es obligatorio');
    }

    if (!formData.get('apellido') || formData.get('apellido').trim() === '') {
        errors.push('El apellido es obligatorio');
    }

    if (!formData.get('tipoDocumento') || formData.get('tipoDocumento').trim() === '') {
        errors.push('El tipo de documento es obligatorio');
    }

    if (!formData.get('numeroDocumento') || formData.get('numeroDocumento').trim() === '') {
        errors.push('El número de documento es obligatorio');
    }

    if (!formData.get('correo') || formData.get('correo').trim() === '') {
        errors.push('El correo electrónico es obligatorio');
    }

    // NUEVAS VALIDACIONES PARA EDICIÓN - Campos ahora obligatorios
    if (!formData.get('telefono') || formData.get('telefono').trim() === '') {
        errors.push('El teléfono es obligatorio');
    }

    if (!formData.get('especialidad') || formData.get('especialidad').trim() === '') {
        errors.push('La especialidad es obligatoria');
    }

    // Validar formato de correo
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (formData.get('correo') && !emailRegex.test(formData.get('correo'))) {
        errors.push('El formato del correo electrónico no es válido');
    }

    return errors;
}

// ===== FUNCIONALIDAD PRINCIPAL =====

// Sidebar y modales
function toggleSidebar() {
    sidebar.classList.toggle("active");
    overlay.classList.toggle("active");
}

function closeSidebar() {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
}

function openModal() {
    createLawyerModal.classList.add("active");
    document.body.style.overflow = "hidden";
}

function closeModalFunction() {
    createLawyerModal.classList.remove("active");
    document.body.style.overflow = "auto";
    document.querySelector("#createLawyerModal form").reset();
}

function openEditModal(lawyerData) {
    document.getElementById("editNombre").value = lawyerData.nombre || "";
    document.getElementById("editApellido").value = lawyerData.apellido || "";
    document.getElementById("editTipoDocumento").value = lawyerData.tipo_documento || "";
    document.getElementById("editNumeroDocumento").value = lawyerData.numero_documento || "";
    document.getElementById("editCorreo").value = lawyerData.correo || "";
    document.getElementById("editTelefono").value = lawyerData.telefono || "";
    document.getElementById("editEspecialidad").value = lawyerData.especialidad || "";

    editLawyerForm.action = "/lawyers/" + lawyerData.id;
    editLawyerModal.classList.add("active");
    document.body.style.overflow = "hidden";
}

function closeEditModal() {
    editLawyerModal.classList.remove("active");
    document.body.style.overflow = "auto";
    editLawyerForm.reset();
}

function updateRowInTable(id, updatedData) {
    const row = document.querySelector(`tr[data-id='${id}']`);
    if (!row) return;

    row.children[0].textContent = updatedData.nombre;
    row.children[1].textContent = updatedData.apellido;
    row.children[2].textContent = updatedData.tipo_documento;
    row.children[3].textContent = updatedData.numero_documento;
    row.children[4].textContent = updatedData.correo;
    row.children[5].textContent = updatedData.telefono || "";
    row.children[6].textContent = updatedData.especialidad || "";
}

// Event listeners básicos
hamburgerBtn.addEventListener("click", toggleSidebar);
overlay.addEventListener("click", closeSidebar);

createBtn.addEventListener("click", openModal);
closeModal.addEventListener("click", closeModalFunction);
cancelBtn.addEventListener("click", closeModalFunction);

closeEditModalBtn.addEventListener("click", closeEditModal);
cancelEditBtn.addEventListener("click", closeEditModal);

// Cerrar con ESC
document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
        closeSidebar();
        closeModalFunction();
        closeEditModal();
        hideCustomAlert();
    }
});

// Manejo de formularios de eliminación
document.addEventListener('submit', async function(e) {
    if (e.target.classList.contains('delete-lawyer-form')) {
        e.preventDefault();

        const form = e.target;
        const lawyerName = form.dataset.name;

        const confirmed = await showCustomAlert(
            'warning',
            'Confirmar Eliminación',
            `¿Estás seguro de eliminar al abogado ${lawyerName}? Esta acción no se puede deshacer.`,
            true,
            'Eliminar',
            'Cancelar'
        );

        if (confirmed) {
            form.submit();
        }
    }
});

// Edición de abogados
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("btn-edit")) {
        const row = e.target.closest("tr");
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
        openEditModal(lawyerData);
    }
});

editLawyerForm.addEventListener("submit", async function(e) {
    e.preventDefault();

    const form = e.target;
    const data = new FormData(form);
    const lawyerId = form.action.split("/").pop();

    // NUEVA VALIDACIÓN - Verificar campos obligatorios
    const validationErrors = validateEditForm(data);
    if (validationErrors.length > 0) {
        await showCustomAlert('warning', 'Campos Incompletos', validationErrors.join('\n'));
        return;
    }

    try {
        const response = await fetch(form.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            },
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

            updateRowInTable(lawyerId, updatedLawyer);
            showCustomAlert('success', '¡Perfecto!', `El abogado ${updatedLawyer.nombre} ${updatedLawyer.apellido} ha sido actualizado exitosamente.`);
            closeEditModal();
        } else {
            const error = await response.json();

            // MANEJO MEJORADO DE ERRORES DE DUPLICADOS
            if (response.status === 422) {
                if (error.message && (error.message.includes('ya existe') || error.message.includes('duplicado'))) {
                    showCustomAlert('error', 'Información Duplicada', 'Ya existe un abogado con este número de documento o correo electrónico. Por favor, verifica los datos.');
                } else {
                    showCustomAlert('error', 'Error de Validación', error.message || "Los datos ingresados no son válidos. Verifica que todos los campos estén correctos y no duplicados.");
                }
            } else {
                showCustomAlert('error', 'Error de Actualización', "Error al actualizar: " + (error.message || "Verifica que todos los campos estén correctos."));
            }
        }
    } catch (error) {
        console.error(error);
        showCustomAlert('error', 'Error Inesperado', 'Ocurrió un error inesperado. Por favor, inténtalo de nuevo o contacta al soporte técnico.');
    }
});

// CREACIÓN DE ABOGADOS CON VALIDACIONES MEJORADAS
document.getElementById("createLawyerModal").querySelector("form").addEventListener("submit", async function(e) {
    e.preventDefault();

    const form = e.target;
    const data = new FormData(form);

    // NUEVA VALIDACIÓN - Verificar campos obligatorios
    const validationErrors = validateForm(data);
    if (validationErrors.length > 0) {
        await showCustomAlert('warning', 'Campos Incompletos', 'Por favor, completa todos los campos obligatorios:\n\n' + validationErrors.join('\n'));
        return;
    }

    try {
        const response = await fetch("/lawyers", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            },
            body: data,
        });

        if (response.ok) {
            // Mostrar la alerta y esperar a que el usuario haga clic en "Aceptar"
            await showCustomAlert('success', '¡Excelente!', `El abogado ${data.get('nombre')} ${data.get('apellido')} ha sido registrado exitosamente.`);

            // Solo después de que el usuario haga clic en "Aceptar", hacer la limpieza y recarga
            form.reset();
            closeModalFunction();
            location.reload();
        } else {
            const error = await response.json();

            // MANEJO MEJORADO DE ERRORES ESPECÍFICOS
            if (response.status === 422) {
                if (error.message && (error.message.includes('ya existe') || error.message.includes('duplicado') || error.message.includes('unique'))) {
                    showCustomAlert('error', 'Abogado Ya Registrado', 'Ya existe un abogado registrado con este número de documento o correo electrónico. Por favor, verifica la información antes de continuar.');
                } else {
                    showCustomAlert('error', 'Error de Validación', error.message || "Los datos ingresados no son válidos. Verifica que todos los campos estén completos y correctos.");
                }
            } else {
                showCustomAlert('error', 'Error al Crear', "Error al guardar: " + (error.message || "Verifica que todos los campos estén completos y correctos."));
            }
        }
    } catch (error) {
        console.error(error);
        showCustomAlert('error', 'Error de Conexión', 'No se pudo crear el abogado. Verifica tu conexión a internet e inténtalo de nuevo.');
    }
});

// Búsqueda y filtrado
document.getElementById("searchBtn").addEventListener("click", searchLawyersWithAlert);
document.getElementById("searchInput").addEventListener("input", searchLawyersWithoutAlert);

//FUNCION DE BÚSQUEDA SIN ALERTA
function searchLawyersWithoutAlert() {
    const searchTerm = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("#tableBody tr");

    rows.forEach((row) => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

// Función para buscar con alerta (cuando presiona el botón buscar)
function searchLawyersWithAlert() {
    const searchTerm = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("#tableBody tr");
    let visibleRows = 0;

    rows.forEach((row) => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = "";
            visibleRows++;
        } else {
            row.style.display = "none";
        }
    });

    // Solo mostrar alerta cuando se presiona el botón y no hay resultados
    if (searchTerm && visibleRows === 0) {
        showCustomAlert('info', 'Sin resultados', `No se encontraron abogados para "${searchTerm}"`);
    }// Variables principales
const hamburgerBtn = document.getElementById("hamburgerBtn");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");
const mainContent = document.getElementById("mainContent");
const createLawyerModal = document.getElementById("createLawyerModal");
const createBtn = document.getElementById("createBtn");
const closeModal = document.getElementById("closeModal");
const cancelBtn = document.getElementById("cancelBtn");

// Variables para modal de edición
const editLawyerModal = document.getElementById("editLawyerModal");
const editLawyerForm = document.getElementById("editLawyerForm");
const closeEditModalBtn = document.getElementById("closeEditModal");
const cancelEditBtn = document.getElementById("cancelEditBtn");

// ===== SISTEMA DE ALERTAS PERSONALIZADAS=====
function showCustomAlert(type, title = '', message = '', showCancel = false, confirmText = 'Aceptar', cancelText = 'Cancelar') {

    // Crear overlay si no existe
    let overlay = document.getElementById('alertOverlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.id = 'alertOverlay';
        overlay.className = 'alert-overlay';

        const buttonsHTML = showCancel
            ? `<div class="alert-buttons">
                  <button class="alert-button secondary" id="cancelAlertBtn">${cancelText}</button>
                  <button class="alert-button ${type}" id="confirmAlertBtn">${confirmText}</button>
               </div>`
            : `<button class="alert-button ${type}" id="confirmAlertBtn">${confirmText}</button>`;

        overlay.innerHTML = `
            <div class="custom-alert" id="customAlert">
                <div class="alert-icon" id="alertIcon"></div>
                <div class="alert-title" id="alertTitle"></div>
                <div class="alert-message" id="alertMessage"></div>
                ${buttonsHTML}
            </div>
        `;
        document.body.appendChild(overlay);

        // Agregar estilos CSS si no existen
        if (!document.getElementById('customAlertStyles')) {
            const style = document.createElement('style');
            style.id = 'customAlertStyles';
            document.head.appendChild(style);
        }
    }

    const alert = document.getElementById('customAlert');
    const icon = document.getElementById('alertIcon');
    const titleEl = document.getElementById('alertTitle');
    const messageEl = document.getElementById('alertMessage');

    // Configurar según el tipo
    alert.className = `custom-alert alert-${type}`;

    switch(type) {
        case 'success':
            icon.innerHTML = '✓';
            titleEl.textContent = title || '¡Éxito!';
            messageEl.textContent = message || 'Operación completada exitosamente';
            break;
        case 'error':
            icon.innerHTML = '❌';
            titleEl.textContent = title || '¡Error!';
            messageEl.textContent = message || 'Algo salió mal. Inténtalo de nuevo.';
            break;
        case 'warning':
            icon.innerHTML = '⚠️';
            titleEl.textContent = title || '¡Atención!';
            messageEl.textContent = message || 'Verifica la información antes de continuar.';
            break;
        case 'info':
            icon.innerHTML = 'ℹ';
            titleEl.textContent = title || 'Información';
            messageEl.textContent = message || 'Proceso en desarrollo.';
            break;
    }

    overlay.classList.add('show');

    // SIEMPRE retornar una promesa
    return new Promise((resolve) => {
        document.getElementById('confirmAlertBtn').onclick = () => {
            hideCustomAlert();
            resolve(true);
        };

        // Solo agregar el botón cancelar si existe
        const cancelBtn = document.getElementById('cancelAlertBtn');
        if (cancelBtn) {
            cancelBtn.onclick = () => {
                hideCustomAlert();
                resolve(false);
            };
        }
    });
}

function hideCustomAlert() {
    const overlay = document.getElementById('alertOverlay');
    if (overlay) {
        overlay.classList.remove('show');
        setTimeout(() => {
            if (overlay.parentNode) {
                overlay.parentNode.removeChild(overlay);
            }
        }, 300);
    }
}

// ===== FUNCIONES DE VALIDACIÓN =====
function validateForm(formData) {
    const errors = [];

    // Validar campos requeridos
    if (!formData.get('nombre') || formData.get('nombre').trim() === '') {
        errors.push('El nombre es obligatorio');
    }

    if (!formData.get('apellido') || formData.get('apellido').trim() === '') {
        errors.push('El apellido es obligatorio');
    }

    if (!formData.get('tipoDocumento') || formData.get('tipoDocumento').trim() === '') {
        errors.push('El tipo de documento es obligatorio');
    }

    if (!formData.get('numeroDocumento') || formData.get('numeroDocumento').trim() === '') {
        errors.push('El número de documento es obligatorio');
    }

    if (!formData.get('correo') || formData.get('correo').trim() === '') {
        errors.push('El correo electrónico es obligatorio');
    }

    // NUEVAS VALIDACIONES - Campos ahora obligatorios
    if (!formData.get('telefono') || formData.get('telefono').trim() === '') {
        errors.push('El teléfono es obligatorio');
    }

    if (!formData.get('especialidad') || formData.get('especialidad').trim() === '') {
        errors.push('La especialidad es obligatoria');
    }

    // Validar formato de correo
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (formData.get('correo') && !emailRegex.test(formData.get('correo'))) {
        errors.push('El formato del correo electrónico no es válido');
    }

    return errors;
}

function validateEditForm(formData) {
    const errors = [];

    // Validar campos requeridos para edición
    if (!formData.get('nombre') || formData.get('nombre').trim() === '') {
        errors.push('El nombre es obligatorio');
    }

    if (!formData.get('apellido') || formData.get('apellido').trim() === '') {
        errors.push('El apellido es obligatorio');
    }

    if (!formData.get('tipoDocumento') || formData.get('tipoDocumento').trim() === '') {
        errors.push('El tipo de documento es obligatorio');
    }

    if (!formData.get('numeroDocumento') || formData.get('numeroDocumento').trim() === '') {
        errors.push('El número de documento es obligatorio');
    }

    if (!formData.get('correo') || formData.get('correo').trim() === '') {
        errors.push('El correo electrónico es obligatorio');
    }

    // NUEVAS VALIDACIONES PARA EDICIÓN - Campos ahora obligatorios
    if (!formData.get('telefono') || formData.get('telefono').trim() === '') {
        errors.push('El teléfono es obligatorio');
    }

    if (!formData.get('especialidad') || formData.get('especialidad').trim() === '') {
        errors.push('La especialidad es obligatoria');
    }

    // Validar formato de correo
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (formData.get('correo') && !emailRegex.test(formData.get('correo'))) {
        errors.push('El formato del correo electrónico no es válido');
    }

    return errors;
}

// ===== FUNCIONALIDAD PRINCIPAL =====

// Sidebar y modales
function toggleSidebar() {
    sidebar.classList.toggle("active");
    overlay.classList.toggle("active");
}

function closeSidebar() {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
}

function openModal() {
    createLawyerModal.classList.add("active");
    document.body.style.overflow = "hidden";
}

function closeModalFunction() {
    createLawyerModal.classList.remove("active");
    document.body.style.overflow = "auto";
    document.querySelector("#createLawyerModal form").reset();
}

function openEditModal(lawyerData) {
    document.getElementById("editNombre").value = lawyerData.nombre || "";
    document.getElementById("editApellido").value = lawyerData.apellido || "";
    document.getElementById("editTipoDocumento").value = lawyerData.tipo_documento || "";
    document.getElementById("editNumeroDocumento").value = lawyerData.numero_documento || "";
    document.getElementById("editCorreo").value = lawyerData.correo || "";
    document.getElementById("editTelefono").value = lawyerData.telefono || "";
    document.getElementById("editEspecialidad").value = lawyerData.especialidad || "";

    editLawyerForm.action = "/lawyers/" + lawyerData.id;
    editLawyerModal.classList.add("active");
    document.body.style.overflow = "hidden";
}

function closeEditModal() {
    editLawyerModal.classList.remove("active");
    document.body.style.overflow = "auto";
    editLawyerForm.reset();
}

function updateRowInTable(id, updatedData) {
    const row = document.querySelector(`tr[data-id='${id}']`);
    if (!row) return;

    row.children[0].textContent = updatedData.nombre;
    row.children[1].textContent = updatedData.apellido;
    row.children[2].textContent = updatedData.tipo_documento;
    row.children[3].textContent = updatedData.numero_documento;
    row.children[4].textContent = updatedData.correo;
    row.children[5].textContent = updatedData.telefono || "";
    row.children[6].textContent = updatedData.especialidad || "";
}

// Event listeners básicos
hamburgerBtn.addEventListener("click", toggleSidebar);
overlay.addEventListener("click", closeSidebar);

createBtn.addEventListener("click", openModal);
closeModal.addEventListener("click", closeModalFunction);
cancelBtn.addEventListener("click", closeModalFunction);

closeEditModalBtn.addEventListener("click", closeEditModal);
cancelEditBtn.addEventListener("click", closeEditModal);

// Cerrar con ESC
document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
        closeSidebar();
        closeModalFunction();
        closeEditModal();
        hideCustomAlert();
    }
});

// Manejo de formularios de eliminación
document.addEventListener('submit', async function(e) {
    if (e.target.classList.contains('delete-lawyer-form')) {
        e.preventDefault();

        const form = e.target;
        const lawyerName = form.dataset.name;

        const confirmed = await showCustomAlert(
            'warning',
            'Confirmar Eliminación',
            `¿Estás seguro de eliminar al abogado ${lawyerName}? Esta acción no se puede deshacer.`,
            true,
            'Eliminar',
            'Cancelar'
        );

        if (confirmed) {
            form.submit();
        }
    }
});

// Edición de abogados
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("btn-edit")) {
        const row = e.target.closest("tr");
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
        openEditModal(lawyerData);
    }
});

editLawyerForm.addEventListener("submit", async function(e) {
    e.preventDefault();

    const form = e.target;
    const data = new FormData(form);
    const lawyerId = form.action.split("/").pop();

    // NUEVA VALIDACIÓN - Verificar campos obligatorios
    const validationErrors = validateEditForm(data);
    if (validationErrors.length > 0) {
        await showCustomAlert('warning', 'Campos Incompletos', validationErrors.join('\n'));
        return;
    }

    try {
        const response = await fetch(form.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            },
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

            updateRowInTable(lawyerId, updatedLawyer);
            showCustomAlert('success', '¡Perfecto!', `El abogado ${updatedLawyer.nombre} ${updatedLawyer.apellido} ha sido actualizado exitosamente.`);
            closeEditModal();
        } else {
            const error = await response.json();

            // MANEJO MEJORADO DE ERRORES DE DUPLICADOS
            if (response.status === 422) {
                if (error.message && (error.message.includes('ya existe') || error.message.includes('duplicado'))) {
                    showCustomAlert('error', 'Información Duplicada', 'Ya existe un abogado con este número de documento o correo electrónico. Por favor, verifica los datos.');
                } else {
                    showCustomAlert('error', 'Error de Validación', error.message || "Los datos ingresados no son válidos. Verifica que todos los campos estén correctos y no duplicados.");
                }
            } else {
                showCustomAlert('error', 'Error de Actualización', "Error al actualizar: " + (error.message || "Verifica que todos los campos estén correctos."));
            }
        }
    } catch (error) {
        console.error(error);
        showCustomAlert('error', 'Error Inesperado', 'Ocurrió un error inesperado. Por favor, inténtalo de nuevo o contacta al soporte técnico.');
    }
});

// CREACIÓN DE ABOGADOS CON VALIDACIONES MEJORADAS
document.getElementById("createLawyerModal").querySelector("form").addEventListener("submit", async function(e) {
    e.preventDefault();

    const form = e.target;
    const data = new FormData(form);

    // NUEVA VALIDACIÓN - Verificar campos obligatorios
    const validationErrors = validateForm(data);
    if (validationErrors.length > 0) {
        await showCustomAlert('warning', 'Campos Incompletos', 'Por favor, completa todos los campos obligatorios:\n\n' + validationErrors.join('\n'));
        return;
    }

    try {
        const response = await fetch("/lawyers", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            },
            body: data,
        });

        if (response.ok) {
            // Mostrar la alerta y esperar a que el usuario haga clic en "Aceptar"
            await showCustomAlert('success', '¡Excelente!', `El abogado ${data.get('nombre')} ${data.get('apellido')} ha sido registrado exitosamente.`);

            // Solo después de que el usuario haga clic en "Aceptar", hacer la limpieza y recarga
            form.reset();
            closeModalFunction();
            location.reload();
        } else {
            const error = await response.json();

            // MANEJO MEJORADO DE ERRORES ESPECÍFICOS
            if (response.status === 422) {
                if (error.message && (error.message.includes('ya existe') || error.message.includes('duplicado') || error.message.includes('unique'))) {
                    showCustomAlert('error', 'Abogado Ya Registrado', 'Ya existe un abogado registrado con este número de documento o correo electrónico. Por favor, verifica la información antes de continuar.');
                } else {
                    showCustomAlert('error', 'Error de Validación', error.message || "Los datos ingresados no son válidos. Verifica que todos los campos estén completos y correctos.");
                }
            } else {
                showCustomAlert('error', 'Error al Crear', "Error al guardar: " + (error.message || "Verifica que todos los campos estén completos y correctos."));
            }
        }
    } catch (error) {
        console.error(error);
        showCustomAlert('error', 'Error de Conexión', 'No se pudo crear el abogado. Verifica tu conexión a internet e inténtalo de nuevo.');
    }
});

// Búsqueda y filtrado
document.getElementById("searchBtn").addEventListener("click", searchLawyersWithAlert);
document.getElementById("searchInput").addEventListener("input", searchLawyersWithoutAlert);

//FUNCION DE BÚSQUEDA SIN ALERTA
function searchLawyersWithoutAlert() {
    const searchTerm = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("#tableBody tr");

    rows.forEach((row) => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

// Función para buscar con alerta (cuando presiona el botón buscar)
function searchLawyersWithAlert() {
    const searchTerm = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("#tableBody tr");
    let visibleRows = 0;

    rows.forEach((row) => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = "";
            visibleRows++;
        } else {
            row.style.display = "none";
        }
    });

    // Solo mostrar alerta cuando se presiona el botón y no hay resultados
    if (searchTerm && visibleRows === 0) {
        showCustomAlert('info', 'Sin resultados', `No se encontraron abogados para "${searchTerm}"`);
    }
}

// Exportar
document.getElementById("exportBtn").addEventListener("click", function() {
    showCustomAlert('info', 'Funcionalidad en Desarrollo', 'La exportación a Excel estará disponible próximamente.');
});

// iOS: Prevenir zoom en inputs
if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
    document.querySelectorAll("input").forEach((input) => {
        input.addEventListener("focus", function() {
            this.style.fontSize = "16px";
        });
    });
}

// Hacer funciones disponibles globalmente
window.showCustomAlert = showCustomAlert;
window.hideCustomAlert = hideCustomAlert;

// ===== LÓGICA DE SUBIDA DE IMAGEN =====
document.getElementById('fileInput').addEventListener('change', function(e) {
    const file = e.target.files[0]; // Obtiene el archivo seleccionado
    if (file) {
        // Crea un objeto FormData para enviar el archivo
        const formData = new FormData();
        formData.append('image', file); // 'image' debe coincidir con el nombre esperado en tu controlador

        // Obtiene el token CSRF de la meta etiqueta
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Realiza la petición Fetch a tu ruta de subida de imagen
        fetch('/upload-image', { // Asegúrate de que esta ruta esté definida en web.php
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken // Envía el token CSRF en los headers
            },
            body: formData // Envía el FormData con el archivo
        })
        .then(response => {
            // Verifica si la respuesta es exitosa (código 2xx)
            if (!response.ok) {
                // Si la respuesta no es OK, lanza un error con el mensaje del servidor
                return response.json().then(err => { throw new Error(err.message || 'Error al subir la imagen'); });
            }
            return response.json(); // Parsea la respuesta JSON
        })
        .then(data => {
            // Si la subida fue exitosa, actualiza la imagen en el DOM
            if (data.path) {
                // Asume que tu servidor devuelve la URL pública de la imagen en 'data.path'
                document.querySelector('.profile-pic img').src = `/storage/${data.path}`; // Ajusta la ruta si es necesario (ej: /storage/profile_photos/...)
                showCustomAlert('success', '¡Imagen Actualizada!', 'Tu foto de perfil ha sido subida exitosamente.');
            } else {
                showCustomAlert('error', 'Error de Subida', 'La imagen se subió, pero no se recibió la ruta esperada.');
            }
        })
        .catch(error => {
            // Manejo de errores de la petición fetch o del servidor
            console.error('Error al subir la imagen:', error);
            showCustomAlert('error', 'Error al Subir Imagen', error.message || 'Ocurrió un error al intentar subir la imagen. Inténtalo de nuevo.');
        });
    }
});

}

// Exportar
document.getElementById("exportBtn").addEventListener("click", function() {
    showCustomAlert('info', 'Funcionalidad en Desarrollo', 'La exportación a Excel estará disponible próximamente.');
});

// iOS: Prevenir zoom en inputs
if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
    document.querySelectorAll("input").forEach((input) => {
        input.addEventListener("focus", function() {
            this.style.fontSize = "16px";
        });
    });
}

// Hacer funciones disponibles globalmente
window.showCustomAlert = showCustomAlert;
window.hideCustomAlert = hideCustomAlert;

// ===== LÓGICA DE SUBIDA DE IMAGEN =====
document.getElementById('fileInput').addEventListener('change', function(e) {
    const file = e.target.files[0]; // Obtiene el archivo seleccionado
    if (file) {
        // Crea un objeto FormData para enviar el archivo
        const formData = new FormData();
        formData.append('image', file); // 'image' debe coincidir con el nombre esperado en tu controlador

        // Obtiene el token CSRF de la meta etiqueta
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Realiza la petición Fetch a tu ruta de subida de imagen
        fetch('/upload-image', { // Asegúrate de que esta ruta esté definida en web.php
            method: 'PATH',
            headers: {
                'X-CSRF-TOKEN': csrfToken // Envía el token CSRF en los headers
            },
            body: formData // Envía el FormData con el archivo
        })
        .then(response => {
            // Verifica si la respuesta es exitosa (código 2xx)
            if (!response.ok) {
                // Si la respuesta no es OK, lanza un error con el mensaje del servidor
                return response.json().then(err => { throw new Error(err.message || 'Error al subir la imagen'); });
            }
            return response.json(); // Parsea la respuesta JSON
        })
        .then(data => {
            // Si la subida fue exitosa, actualiza la imagen en el DOM
            if (data.path) {
                // Asume que tu servidor devuelve la URL pública de la imagen en 'data.path'
                document.querySelector('.profile-pic img').src = `/storage/${data.path}`; // Ajusta la ruta si es necesario (ej: /storage/profile_photos/...)
                showCustomAlert('success', '¡Imagen Actualizada!', 'Tu foto de perfil ha sido subida exitosamente.');
            } else {
                showCustomAlert('error', 'Error de Subida', 'La imagen se subió, pero no se recibió la ruta esperada.');
            }
        })
        .catch(error => {
            // Manejo de errores de la petición fetch o del servidor
            console.error('Error al subir la imagen:', error);
            showCustomAlert('error', 'Error al Subir Imagen', error.message || 'Ocurrió un error al intentar subir la imagen. Inténtalo de nuevo.');
        });
    }
});
