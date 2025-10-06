    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

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


// ===== FUNCIONALIDAD DE SUBIDA DE IMAGEN DE PERFIL =====
function setupImageUpload() {
    const fileInput = document.getElementById('fileInput');
    const profileImage = document.getElementById('profileImage');
    const loadingIndicator = document.getElementById('loadingIndicator');
    
    if (!fileInput || !profileImage) {
        console.warn('Elementos para subida de imagen no encontrados.');
        return;
    }

    profileImage.dataset.originalSrc = profileImage.src;

    fileInput.addEventListener('change', async function(e) {
        const file = e.target.files[0];
        if (!file) return;

        // Validar tipo de archivo
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            await showCustomAlert('error', 'Archivo no válido', 'Solo se permiten archivos JPG, JPEG y PNG.');
            fileInput.value = '';
            return;
        }

        // Validar tamaño (2MB máximo)
        const maxSize = 2 * 1024 * 1024;
        if (file.size > maxSize) {
            await showCustomAlert('error', 'Archivo muy grande', 'El archivo debe ser menor a 2MB.');
            fileInput.value = '';
            return;
        }

        // Mostrar preview inmediato
        const reader = new FileReader();
        reader.onload = function(e) {
            profileImage.src = e.target.result;
        };
        reader.readAsDataURL(file);

        // Mostrar indicador de carga
        if (loadingIndicator) {
            loadingIndicator.style.display = 'block';
        }

        // Obtener CSRF token
        const csrfToken = getCsrfToken();
        if (!csrfToken) {
            await showCustomAlert('error', 'Error de seguridad', 'Token CSRF no encontrado.');
            profileImage.src = profileImage.dataset.originalSrc;
            if (loadingIndicator) loadingIndicator.style.display = 'none';
            return;
        }

        // Crear FormData
        const formData = new FormData();
        formData.append('profile_photo', file);

        try {
            const response = await fetch('/perfil/foto', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                    // NO pongas Content-Type aquí cuando usas FormData
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok && data.success) {
                profileImage.src = data.url + '?t=' + new Date().getTime();
                profileImage.dataset.originalSrc = data.url;
                await showCustomAlert('success', '¡Perfecto!', 'Imagen actualizada correctamente.');
            } else {
                profileImage.src = profileImage.dataset.originalSrc;
                await showCustomAlert('error', 'Error', data.message || 'No se pudo actualizar la imagen.');
            }

        } catch (error) {
            profileImage.src = profileImage.dataset.originalSrc;
            console.error('Error al subir imagen:', error);
            await showCustomAlert('error', 'Error de conexión', 'No se pudo conectar con el servidor.');
        } finally {
            if (loadingIndicator) {
                loadingIndicator.style.display = 'none';
            }
            fileInput.value = '';
        }
    });
}