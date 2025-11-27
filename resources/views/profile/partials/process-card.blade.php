<div class="process-grid">
    @forelse($procesos as $proceso)
        <div class="process-card fade-in-up">
            <div class="card-header">
                <div class="card-title">
                    <div class="card-title-icon">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <h2 class="titulo-proceso" data-numero="{{ $loop->iteration }}">
    Proceso Legal {{ $loop->iteration }}
</h2>

                </div>
                <span class="status-badge">{{ $proceso->estado }}</span>
            </div>
            <div class="card-body">
                <div class="card-grid">
                    <div class="info-section">
                        <div class="info-item info-item-blue"> 
                            <div class="info-icon info-icon-blue">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <div class="info-content">
                                <p>Radicado</p>
                                <p>{{ $proceso->numero_radicado }}</p>
                            </div>
                        </div>
                        <div class="info-item info-item-green">
                            <div class="info-icon info-icon-green">
                                <i class="fas fa-balance-scale"></i>
                            </div>
                            <div class="info-content">
                                <p>Tipo de Proceso</p>
                                <p>{{ $proceso->tipo_proceso }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="info-section">
                        <div class="info-item info-item-orange">
                            <div class="info-icon info-icon-orange">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="info-content">
                                <p>Demandante</p>
                                <p>{{ $proceso->demandante }}</p>
                            </div>
                        </div>
                        <div class="info-item info-item-red">
                            <div class="info-icon info-icon-red">
                                <i class="fas fa-user-minus"></i>
                            </div>
                            <div class="info-content">
                                <p>Demandado</p>
                                <p>{{ $proceso->demandado }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="info-item info-item-purple">
                        <div class="info-icon info-icon-purple">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="info-content">
                            <p>Fecha Radicación</p>
                            <p>{{ $proceso->created_at }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('procesos.edit', $proceso->id) }}" class="action-btn" title="Editar">
                                Editar Proceso
                        <i class="fas fa-edit"></i>
                            </a>
                    <a href="{{ route('abogado.crear-concepto', $proceso->id) }}" class="action-btn">
                        <i class="fas fa-edit"></i>
                        Redactar Concepto Jurídico
                    </a>
                    <a href="javascript:void(0);" onclick="openProcessModal ({{ $proceso->id }})" class="action-btn action-view" title="Ver detalles">
                        <i class="fa-regular fa-eye"></i>
                        Ver Detalles
                    </a> 
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <h3>No se encontraron procesos pendientes.</h3>
        </div>
    @endforelse
</div>

<script>
document.getElementById('searchInput')?.addEventListener('input', function() {
    let valor = this.value.trim();
    let cards = document.querySelectorAll('.process-card');

    cards.forEach(card => {
        let titulo = card.querySelector('.titulo-proceso');
        let numero = titulo.getAttribute('data-numero');

        if (valor === '') {
            card.style.display = 'block';
            return;
        }

        if (!isNaN(valor)) {
            // Buscar por número de Proceso Legal
            card.style.display = (numero === valor) ? 'block' : 'none';
        } else {
            // Buscar por texto normal
            let contenido = card.innerText.toLowerCase();
            card.style.display = contenido.includes(valor.toLowerCase()) ? 'block' : 'none';
        }
    });
});
</script>
