<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Tipo de Documento</th>
                <th>Número de Documento</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Especialidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @foreach($lawyers ?? [] as $lawyer)
            <tr data-id="{{ $lawyer->id }}">
                <td>{{ $lawyer->nombre }}</td>
                <td>{{ $lawyer->apellido }}</td>
                <td>{{ $lawyer->tipo_documento }}</td>
                <td>{{ $lawyer->numero_documento }}</td>
                <td>{{ $lawyer->correo }}</td>
                <td>{{ $lawyer->telefono }}</td>
                <td>{{ $lawyer->especialidad }}</td>
                <td>
                    <button class="btn-edit"
                        data-id="{{ $lawyer->id }}"
                        data-nombre="{{ $lawyer->nombre }}"
                        data-apellido="{{ $lawyer->apellido }}"
                        data-tipo_documento="{{ $lawyer->tipo_documento }}"
                        data-numero_documento="{{ $lawyer->numero_documento }}"
                        data-correo="{{ $lawyer->correo }}"
                        data-telefono="{{ $lawyer->telefono }}"
                        data-especialidad="{{ $lawyer->especialidad }}">
                        Editar
                    </button>

                    <form action="{{ route('lawyers.destroy', $lawyer->id) }}"
                        method="POST"
                        class="delete-lawyer-form"
                        data-id="{{ $lawyer->id }}"
                        data-name="{{ $lawyer->nombre }} {{ $lawyer->apellido }}"
                        style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @include('profile.partials.pagination', ['items' => $lawyers, 'pageKey' => 'page'])
</div>


<style>
    .abogado-nombre {
        font-size: inherit;
        color: inherit;
        font-weight: normal;
        margin-left: 6px;
    }
</style>
<script>
document.getElementById('searchInput')?.addEventListener('input', function() {
    let valor = this.value.trim().toLowerCase();
    let cards = document.querySelectorAll('.process-card');

    cards.forEach(card => {
        let titulo = card.querySelector('.titulo-proceso');
        let numero = titulo?.getAttribute('data-numero') ?? '';
        let contenido = card.innerText.toLowerCase();

        // Nombre abogado
        let abogado = card.querySelector('.abogado-nombre')?.innerText.toLowerCase() ?? '';

        // Especialidad abogado
        let especialidad = card.querySelector('.abogado-especialidad')?.innerText.toLowerCase() ?? '';

        if (valor === '') {
            card.style.display = 'block';
            return;
        }

        // Lógica de búsqueda
        if (
            numero.includes(valor) ||
            contenido.includes(valor) ||
            abogado.includes(valor) ||
            especialidad.includes(valor)
        ) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>
