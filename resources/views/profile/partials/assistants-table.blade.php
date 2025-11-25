<div class="table-wrapper">
    <table class="lawyers-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Tipo Doc.</th>
                <th>N° Documento</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Especialidad</th>
                <th>Abogados Asignados</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="assistantsTableBody">
            @forelse($assistants as $assistant)
            <tr>
                <td>{{ $assistant->nombre }}</td>
                <td>{{ $assistant->apellido }}</td>
                <td>{{ $assistant->tipo_documento }}</td>
                <td>{{ $assistant->numero_documento }}</td>
                <td>{{ $assistant->correo }}</td>
                <td>{{ $assistant->telefono ?? 'N/A' }}</td>
                <td>{{ $assistant->especialidad ?? 'N/A' }}</td>
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
                    <div class="action-buttons-cell">
                        <button class="btn-edit" data-id="{{ $assistant->id }}">Editar</button>
                        <form action="{{ route('lawyers.destroy', $assistant->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('¿Está seguro de eliminar este asistente?')">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align: center; padding: 20px;">
                    No hay asistentes jurídicos registrados
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    
                        <!-- Incluir la paginación -->
    @include('profile.partials.pagination', ['items' => $lawyers])
</div>

