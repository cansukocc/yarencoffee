@if ($paginator->hasPages())
    <nav aria-label="Sayfalar" class="mt-8 flex items-center justify-between gap-4 text-sm">
        @if ($paginator->onFirstPage())
            <span class="text-muted-foreground">Önceki</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="font-medium text-coffee underline underline-offset-4">Önceki</a>
        @endif

        <span class="text-muted-foreground">Sayfa {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="font-medium text-coffee underline underline-offset-4">Sonraki</a>
        @else
            <span class="text-muted-foreground">Sonraki</span>
        @endif
    </nav>
@endif
