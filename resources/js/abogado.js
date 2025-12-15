document.addEventListener('DOMContentLoaded', function () {

    // ============================
    // BUSCADOR DE ABOGADOS
    // ============================
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.querySelector('#lawyersTable tbody');

    if (searchInput && tableBody) {
        searchInput.addEventListener('keyup', function () {
            let filter = searchInput.value.toLowerCase();
            let rows = tableBody.getElementsByTagName('tr');

            Array.from(rows).forEach(row => {
                let name = row.querySelector('.lawyer-name')?.textContent.toLowerCase() || "";
                let lastname = row.querySelector('.lawyer-lastname')?.textContent.toLowerCase() || "";
                let documentNumber = row.querySelector('.lawyer-document')?.textContent.toLowerCase() || "";

                if (
                    name.includes(filter) ||
                    lastname.includes(filter) ||
                    documentNumber.includes(filter)
                ) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    }

    // ============================
    // LÓGICA PARA MODAL DE CREACIÓN (YA EXISTENTE)
    // ============================
    const createBtn = document.getElementById('createBtn');
    const createModal = document.getElementById('createLawyerModal');
    const closeCreate = document.getElementById('closeCreateModal');

    if (createBtn && createModal) {
        createBtn.addEventListener('click', () => {
            createModal.style.display = 'flex';
        });
    }

    if (closeCreate && createModal) {
        closeCreate.addEventListener('click', () => {
            createModal.style.display = 'none';
        });
    }

    // ============================
    // LÓGICA PARA EDITAR ABOGADO (YA EXISTENTE)
    // ============================
    document.querySelectorAll('.edit-lawyer-btn').forEach(button => {
        button.addEventListener('click', function () {
            const lawyerId = this.dataset.id;
            const name = this.dataset.name;
            const lastname = this.dataset.lastname;
            const document = this.dataset.document;

            document.getElementById('edit_id').value = lawyerId;
            document.getElementById('edit_nombre').value = name;
            document.getElementById('edit_apellido').value = lastname;
            document.getElementById('edit_documento').value = document;

            document.getElementById('editLawyerModal').style.display = 'flex';
        });
    });

    const closeEdit = document.getElementById('closeEditModal');
    if (closeEdit) {
        closeEdit.addEventListener('click', function () {
            document.getElementById('editLawyerModal').style.display = 'none';
        });
    }

});
 