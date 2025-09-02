<div class="d-flex justify-content-between align-items-center">
    <div class="pagination-info mb-0">
        Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of {{ $items->total() }} items
    </div>
    @if ($items->hasPages())
    <nav>
        <ul class="pagination mb-0">
            {{-- Previous Page Link --}}
            @if ($items->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            @else
            <li class="page-item">
                <a class="page-link" href="{{ $items->previousPageUrl() }}" rel="prev">&laquo;</a>
            </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($items->links()->elements[0] as $page => $url)
            @if ($page == $items->currentPage())
            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($items->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $items->nextPageUrl() }}" rel="next">&raquo;</a>
            </li>
            @else
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            @endif
        </ul>
    </nav>
    @endif
</div>