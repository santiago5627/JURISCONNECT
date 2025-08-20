<x-app-layout>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Editar Proceso Judicial</h4>
                    <a href="{{ route('procesos.show', $proceso->id) }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
   
                    <form method="POST" action="{{ route('procesos.update', $proceso->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipo_proceso" class="form-label">Tipo de Proceso *</label>
                                    <select class="form-control @error('tipo_proceso') is-invalid @enderror" 
                                            id="tipo_proceso" name="tipo_proceso" required>
                                        <option value="">Seleccionar tipo</option>
                                        <option value="Civil" {{ old('tipo_proceso', $proceso->tipo_proceso) == 'Civil' ? 'selected' : '' }}>Civil</option>
                                        <option value="Penal" {{ old('tipo_proceso', $proceso->tipo_proceso) == 'Penal' ? 'selected' : '' }}>Penal</option>
                                        <option value="Laboral" {{ old('tipo_proceso', $proceso->tipo_proceso) == 'Laboral' ? 'selected' : '' }}>Laboral</option>
                                        <option value="Administrativo" {{ old('tipo_proceso', $proceso->tipo_proceso) == 'Administrativo' ? 'selected' : '' }}>Administrativo</option>
                                        <option value="Familia" {{ old('tipo_proceso', $proceso->tipo_proceso) == 'Familia' ? 'selected' : '' }}>Familia</option>
                                        <option value="Comercial" {{ old('tipo_proceso', $proceso->tipo_proceso) == 'Comercial' ? 'selected' : '' }}>Comercial</option>
                                    </select>
                                    @error('tipo_proceso')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="numero_radicado" class="form-label">Número de Radicado *</label>
                                    <input type="text" 
                                           class="form-control @error('numero_radicado') is-invalid @enderror" 
                                           id="numero_radicado" 
                                           name="numero_radicado" 
                                           value="{{ old('numero_radicado', $proceso->numero_radicado) }}" 
                                           required>
                                    @error('numero_radicado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="demandante" class="form-label">Demandante *</label>
                                    <input type="text" 
                                           class="form-control @error('demandante') is-invalid @enderror" 
                                           id="demandante" 
                                           name="demandante" 
                                           value="{{ old('demandante', $proceso->demandante) }}" 
                                           required>
                                    @error('demandante')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="demandado" class="form-label">Demandado *</label>
                                    <input type="text" 
                                           class="form-control @error('demandado') is-invalid @enderror" 
                                           id="demandado" 
                                           name="demandado" 
                                           value="{{ old('demandado', $proceso->demandado) }}" 
                                           required>
                                    @error('demandado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción *</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" 
                                      name="descripcion" 
                                      rows="4" 
                                      required>{{ old('descripcion', $proceso->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="documento" class="form-label">Documento</label>
                            
                            @if($proceso->documento)
                                <div class="mb-2">
                                    <div class="alert alert-info d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fas fa-file-pdf"></i> 
                                            Archivo actual: {{ basename($proceso->documento) }}
                                        </span>
                                        <div>
                                            <a href="{{ Storage::url($proceso->documento) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary me-2">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                            <label class="btn btn-sm btn-outline-danger">
                                                <input type="checkbox" name="eliminar_documento" value="1" class="me-1">
                                                Eliminar
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <input type="file" 
                                   class="form-control @error('documento') is-invalid @enderror" 
                                   id="documento" 
                                   name="documento" 
                                   accept=".pdf,.doc,.docx">
                            <small class="text-muted">Formatos permitidos: PDF, DOC, DOCX. Tamaño máximo: 2MB</small>
                            @error('documento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('procesos.show', $proceso->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Actualizar Proceso
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</x-app-layout>