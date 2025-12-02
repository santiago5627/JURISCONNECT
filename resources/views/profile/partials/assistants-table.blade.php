<div class="table-container table-wrapper">
    <table class="lawyers-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Tipo Doc.</th>
                <th>N° Documento</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Abogados Asignados</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="assistantsTableBody">
            @forelse($assistants as $assistant)
            <tr data-id="{{ $assistant->id }}">
                <td>{{ $assistant->nombre }}</td>
                <td>{{ $assistant->apellido }}</td>
                <td>{{ $assistant->tipo_documento }}</td>
                <td>{{ $assistant->numero_documento }}</td>
                <td>{{ $assistant->correo }}</td>
                <td>{{ $assistant->telefono ?? 'N/A' }}</td>
                <td>
                    @if($assistant->lawyers && $assistant->lawyers->count() > 0)
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($assistant->lawyers as $lawyer)
                        <li>{{ $lawyer->nombre }} {{ $lawyer->apellido }}</li>
                        @endforeach
                    </ul>
                    @else
                    <span style="color: #999;">Sin abogados asignados</span>
                    @endif
                </td>
                <td>
                    <button class="btn-edit-assistant"
                        data-id="{{ $assistant->id }}"
                        data-nombre="{{ $assistant->nombre }}"
                        data-apellido="{{ $assistant->apellido }}"
                        data-tipo_documento="{{ $assistant->tipo_documento }}"
                        data-numero_documento="{{ $assistant->numero_documento }}"
                        data-correo="{{ $assistant->correo }}"
                        data-telefono="{{ $assistant->telefono }}"
                        data-lawyers='@json($assistant->lawyers->pluck("id"))'>
                        Editar
                    </button>
                    <form action="{{ route('assistants.destroy', $assistant->id) }}"
                        method="POST"
                        class="delete-assistant-form"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px;">
                    No hay asistentes jurídicos registrados
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación corregida -->
    <div id="assistantsPagination">
        @include('profile.partials.pagination', ['items' => $assistants])
    </div>
</div>

<script>
    
    // ==========================================
    // PAGINACIÓN AJAX (Evita recarga de página)
    // ==========================================
    
    function handleAjaxPagination() {
    const lawyersSection = document.querySelector("#assistants-section");
    if (!lawyersSection) return;

    // Delegation
    lawyersSection.addEventListener("click", function (e) { 
        const link = e.target.closest(".pagination-btn.ajax-page");
        if (!link) return;
        e.preventDefault();

        const url = link.getAttribute("href");
        if (!url || url === "#") return;

        const container = lawyersSection.querySelector(".table-wrapper");
        if (container) {
            container.style.opacity = "0.5";
            container.style.pointerEvents = "none";
        }

        fetch(url, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
        })
            .then(async (resp) => {
                if (!resp.ok)
                    throw new Error(`HTTP error! status: ${resp.status}`);
                return resp.json();
            })
            .then((data) => {
                if (data.success && data.html) {
                    const tableContainer =
                        lawyersSection.querySelector(".table-wrapper");
                    if (tableContainer) tableContainer.outerHTML = data.html;
                    if (window.history && window.history.pushState)
                        window.history.pushState({}, "", url);
                    // re-inicializa eventos en nuevo contenido si es necesario
                    handleAjaxPagination();
                } else {
                    throw new Error(
                        data.message || "Formato de respuesta inválido"
                    );
                }
            })
            .catch((error) => {
                console.error("Error completo:", error);
                if (container) {
                    container.innerHTML = `<div class="alert alert-danger"><strong>Error:</strong> ${error.message}<br><small>Revisa la consola para más detalles</small></div>`;
                }
            })
            .finally(() => {
                if (container) {
                    container.style.opacity = "1";
                    container.style.pointerEvents = "auto";
                }
            });
    });
}
    
</script>