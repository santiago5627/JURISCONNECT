// Variables principales
const hamburgerBtn = document.getElementById('hamburgerBtn');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const mainContent = document.getElementById('mainContent');
const createLawyerModal = document.getElementById('createLawyerModal');
const createBtn = document.getElementById('createBtn');
const closeModal = document.getElementById('closeModal');
const cancelBtn = document.getElementById('cancelBtn');

// Variables para modal de edición
const editLawyerModal = document.getElementById('editLawyerModal');
const editLawyerForm = document.getElementById('editLawyerForm');
const closeEditModalBtn = document.getElementById('closeEditModal');
const cancelEditBtn = document.getElementById('cancelEditBtn');

// Función para alternar el sidebar
function toggleSidebar() {
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
}

// Función para cerrar el sidebar
function closeSidebar() {
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
}

// Función para abrir el modal de creación
function openModal() {
    createLawyerModal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

// Función para cerrar el modal de creación
function closeModalFunction() {
    createLawyerModal.classList.remove('active');
    document.body.style.overflow = 'auto';
    const form = document.querySelector('#createLawyerModal form');
    if (form) form.reset();
}

// Función para abrir el modal de edición
function openEditModal(lawyerData) {
    // Rellenar los campos del modal de edición
    document.getElementById('editNombre').value = lawyerData.nombre || '';
    document.getElementById('editApellido').value = lawyerData.apellido || '';
    document.getElementById('editTipoDocumento').value = lawyerData.tipo_documento || '';
    document.getElementById('editNumeroDocumento').value = lawyerData.numero_documento || '';
    document.getElementById('editCorreo').value = lawyerData.correo || '';
    document.getElementById('editTelefono').value = lawyerData.telefono || '';
    document.getElementById('editEspecialidad').value = lawyerData.especialidad || '';

    // Establecer la acción del formulario
    editLawyerForm.action = '/lawyers/' + lawyerData.id;
    
    // Mostrar el modal
    editLawyerModal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

// Función para cerrar el modal de edición
function closeEditModal() {
    editLawyerModal.classList.remove('active');
    document.body.style.overflow = 'auto';
    editLawyerForm.reset();
}

// Función para actualizar fila en la tabla
function updateRowInTable(id, updatedData) {
    const row = document.querySelector(`tr[data-id='${id}']`);
    if (!row) return;

    row.children[0].textContent = updatedData.nombre;
    row.children[1].textContent = updatedData.apellido;
    row.children[2].textContent = updatedData.tipo_documento;
    row.children[3].textContent = updatedData.numero_documento;
    row.children[4].textContent = updatedData.correo;
    row.children[5].textContent = updatedData.telefono;
    row.children[6].textContent = updatedData.especialidad;
}

// Event listeners para el hamburger y overlay
hamburgerBtn.addEventListener('click', toggleSidebar);
overlay.addEventListener('click', closeSidebar);

// Event listeners para el modal de creación
createBtn.addEventListener('click', openModal);
closeModal.addEventListener('click', closeModalFunction);
cancelBtn.addEventListener('click', closeModalFunction);

// Event listeners para el modal de edición
closeEditModalBtn.addEventListener('click', closeEditModal);
cancelEditBtn.addEventListener('click', closeEditModal);

// Cerrar modales al hacer clic fuera de ellos
createLawyerModal.addEventListener('click', function(e) {
    if (e.target === createLawyerModal) {
        closeModalFunction();
    }
});

editLawyerModal.addEventListener('click', function(e) {
    if (e.target === editLawyerModal) {
        closeEditModal();
    }
});

// Cerrar sidebar y modales con ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeSidebar();
        closeModalFunction();
        closeEditModal();
    }
});

// Event delegation para botones de editar (funciona con contenido dinámico)
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-edit')) {
        const row = e.target.closest('tr');
        const lawyerData = {
            id: row.dataset.id,
            nombre: row.children[0].textContent,
            apellido: row.children[1].textContent,
            tipo_documento: row.children[2].textContent,
            numero_documento: row.children[3].textContent,
            correo: row.children[4].textContent,
            telefono: row.children[5].textContent, // Estos datos no están visibles en la tabla
            especialidad: row.children[6].textContent
        };
        
        openEditModal(lawyerData);
    }
});

// Manejar envío del formulario de edición
editLawyerForm.addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;
    const data = new FormData(form);
    const lawyerId = form.action.split('/').pop();

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: data
        });

        if (response.ok) {
            // Obtener datos actualizados desde el form
            const updatedLawyer = {
                nombre: data.get('nombre'),
                apellido: data.get('apellido'),
                tipo_documento: data.get('tipoDocumento'),
                numero_documento: data.get('numeroDocumento'),
                correo: data.get('correo'),
                telefono: data.get('telefono'),
                especialidad: data.get('especialidad'),
            };

            updateRowInTable(lawyerId, updatedLawyer);
            alert('Abogado actualizado exitosamente');
            closeEditModal();
        } else {
            const error = await response.json();
            alert('Error al actualizar: ' + (error.message || 'Verifica los campos.'));
        }
    } catch (error) {
        console.error(error);
        alert('Error inesperado al actualizar.');
    }
});

// Manejar envío del formulario de creación
document.getElementById('createLawyerModal').querySelector('form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;
    const data = new FormData(form);

    try {
        const response = await fetch('/lawyers', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: data
        });

        if (response.ok) {
            alert('Abogado creado exitosamente.');
            form.reset();
            closeModalFunction();
            location.reload(); // Recargar la página para mostrar el nuevo registro
        } else {
            const error = await response.json();
            alert('Error al guardar: ' + (error.message || 'verifica los campos.'));
        }
    } catch (error) {
        console.error(error);
        alert('Error inesperado al crear el abogado.');
    }
});

// Funcionalidad de navegación
document.querySelectorAll('.nav-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        closeSidebar();
    });
});

// Funcionalidad del buscador
document.getElementById('searchBtn').addEventListener('click', function() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    filterTable(searchTerm);
});

// Búsqueda en tiempo real
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    filterTable(searchTerm);
});

// Función para filtrar tabla
function filterTable(searchTerm) {
    const rows = document.querySelectorAll('#tableBody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Funcionalidad del botón exportar
document.getElementById('exportBtn').addEventListener('click', function() {
    alert('Exportar a Excel - En desarrollo');
});

// Prevenir zoom en iOS para inputs
if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('focus', function() {
            this.style.fontSize = '16px';
        });
    });
}