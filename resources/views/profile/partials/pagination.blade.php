<!-- Paginación -->
            <div class="pagination-container">
<!-- Paginación desktop -->
            <div class="pagination-desktop">
                <style>
                /* Estilos de Paginación */
.pagination-btn {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    color: #4a5568;
    background: #f7fafc;
    border: 1px solid #e2e8f0;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
}

.pagination-btn:hover:not(.disabled):not(.active) {
    background: #007bff;
    color: white;
    border-color: #007bff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px #007bff;
}

.pagination-btn.active {
    background: linear-gradient(135deg, #007bff 0%, #007bff 100%);
    color: white;
    border-color: #667eea;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    cursor: default;
}

.pagination-btn.disabled {
    background: #edf2f7;
    color: #cbd5e0;
    border-color: #e2e8f0;
    cursor: not-allowed;
    opacity: 0.6;
}

.pagination-btn.ajax-page:active {
    transform: scale(0.95);
}

/* Responsive */
@media (max-width: 640px) {
    .pagination-btn {
        padding: 0.4rem 0.75rem;
        font-size: 0.8125rem;
        min-width: 36px;
    }
};
</style>
                    <!-- Botón Anterior -->
                    @if ($lawyers->onFirstPage())
                        <span class="pagination-btn disabled">Anterior</span>
                    @else
                        <a href="{{ $lawyers->previousPageUrl() }}" class="pagination-btn ajax-page">Anterior</a>
                    @endif

                    <!-- Números de página -->
                    @php
                        $currentPage = $lawyers->currentPage();
                        $lastPage = $lawyers->lastPage();
                        $start = max(1, $currentPage - 2);
                        $end = min($lastPage, $currentPage + 2);
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $lawyers->url(1) }}" class="pagination-btn ajax-page">1</a>
                        @if ($start > 2)
                            <span class="pagination-btn disabled">...</span>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $currentPage)
                            <span class="pagination-btn active">{{ $i }}</span>
                        @else
                            <a href="{{ $lawyers->url($i) }}" class="pagination-btn ajax-page">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($end < $lastPage)
                        @if ($end < $lastPage - 1)
                            <span class="pagination-btn disabled">...</span>
                        @endif
                        <a href="{{ $lawyers->url($lastPage) }}" class="pagination-btn ajax-page">{{ $lastPage }}</a>
                    @endif

                    <!-- Botón Siguiente -->
                    @if ($lawyers->hasMorePages())
                        <a href="{{ $lawyers->nextPageUrl() }}" class="pagination-btn ajax-page">Siguiente</a>
                    @else
                        <span class="pagination-btn disabled">Siguiente</span>
                    @endif
                </div>
            </div>
                </div>
            </div>