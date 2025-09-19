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

                        <!-- Incluir la paginación -->
    @include('profile.partials.pagination', ['items' => $lawyers])

                    </div>

