// Variables principales
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const mainContent = document.getElementById('mainContent');
        const createLawyerModal = document.getElementById('createLawyerModal');
        const createBtn = document.getElementById('createBtn');
        const closeModal = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const createLawyerForm = document.getElementById('createLawyerForm');

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

        // Función para abrir el modal
        function openModal() {
            createLawyerModal.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevenir scroll del body
        }

        // Función para cerrar el modal
        function closeModalFunction() {
            createLawyerModal.classList.remove('active');
            document.body.style.overflow = 'auto'; // Restaurar scroll del body
            createLawyerForm.reset(); // Limpiar formulario
        }

        // Event listeners para el hamburger y overlay
        hamburgerBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', closeSidebar);

        // Event listeners para el modal
        createBtn.addEventListener('click', openModal);
        closeModal.addEventListener('click', closeModalFunction);
        cancelBtn.addEventListener('click', closeModalFunction);

        // Cerrar modal al hacer clic fuera de él
        createLawyerModal.addEventListener('click', function(e) {
            if (e.target === createLawyerModal) {
                closeModalFunction();
            }
        });

        // Cerrar sidebar y modal con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSidebar();
                closeModalFunction();
            }
        });

        // Manejar envío del formulario
        createLawyerForm.addEventListener('submit', function(e) {
            e.preventDefaulnumeroDocumentot();

            // Obtener datos del formulario
            const formData = new FormData(this);
            const lawyerData = {
                nombre: formData.get('nombre'),
                apellido: formData.get('apellido'),
                tipoDocumento: formData.get('tipoDocumento'),
                numeroDocumento: formData.get(''),
                correo: formData.get('correo'),
                telefono: formData.get('telefono'),
                especialidad: formData.get('especialidad')
            };

            // Aquí puedes agregar la lógica para enviar los datos al servidor
            console.log('Datos del nuevo abogado:', lawyerData);

            // Agregar fila a la tabla (ejemplo temporal)
            addLawyerToTable(lawyerData);

            // Cerrar modal y mostrar mensaje de éxito
            closeModalFunction();
            alert('Abogado creado exitosamente');
        });

            tableBody.appendChild(newRow);

            // Agregar event listeners a los nuevos botones
            const editBtn = newRow.querySelector('.btn-edit');
            const deleteBtn = newRow.querySelector('.btn-delete');

            editBtn.addEventListener('click', function() {
                alert('Función de editar - En desarrollo');
            });

            deleteBtn.addEventListener('click', function() {
                if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
                    newRow.remove();
                }
            });

        // Funcionalidad de navegación
        document.querySelectorAll('.nav-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Cerrar sidebar después de seleccionar
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
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
                    this.closest('tr').remove();
                }
            });
        });

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


        // Ajustar altura en redimensionamiento
        window.addEventListener('resize', function() {
            // Mantener funcionalidad responsive
        });

        document.getElementById('createLawyerForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;
    const data = new FormData(form);

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
        document.getElementById('createLawyerModal').style.display = 'none';
        // Aquí podrías recargar la tabla si lo deseas
        location.reload(); // opcional
    } else {
        const error = await response.json();
        alert('Error al guardar: ' + (error.message || 'verifica los campos.'));
    }
});

