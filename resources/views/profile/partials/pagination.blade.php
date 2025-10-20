<!-- Paginación -->
            <div class="pagination-container">
<!-- Paginación desktop -->
            <div class="pagination-desktop">

                <div style="display: flex; gap: 0.5rem;">
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
