@if ($paginator->hasPages())
    <nav class="ap-pagination" role="navigation" aria-label="Paginación">

        {{-- Botón Anterior --}}
        @if ($paginator->onFirstPage())
            <span class="ap-btn ap-btn--secondary ap-pagination__disabled">‹ Anterior</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="ap-btn ap-btn--secondary">‹ Anterior</a>
        @endif

        {{-- Números de página --}}
        <div class="ap-pagination__pages">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="ap-pagination__dots">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="ap-pagination__page ap-pagination__page--active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="ap-pagination__page">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Botón Siguiente --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="ap-btn ap-btn--secondary">Siguiente ›</a>
        @else
            <span class="ap-btn ap-btn--secondary ap-pagination__disabled">Siguiente ›</span>
        @endif

    </nav>
@endif
