@if ($paginator->hasPages())
    <span class='pages'>Page {{ $paginator->currentPage() }} of {{ $paginator->total() }}</span>
    @if ($paginator->onFirstPage())

    @else
        <a class="first" href="{{ $paginator->url(1) }}">« First</a>
        <a class="previouspostslink" rel="prev" href="{{ $paginator->previousPageUrl() }}">«</a>
        <span class='extend'>...</span>
    @endif
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class='current'>{{ $element }}</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class='current'>{{ $page }}</span>
                @else
                    <a class="page larger" href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach
{{--    @if($paginator->total() - $paginator->currentPage() > 10)--}}
{{--        <span class='extend'>...</span>--}}
{{--        <a class="larger page" href="http://javhard.net/page/10">10</a>--}}
{{--    @endif--}}
{{--    @if($paginator->total() - $paginator->currentPage() > 20)--}}
{{--        <a class="larger page" href="http://javhard.net/page/10">10</a>--}}
{{--    @endif--}}
{{--    @if($paginator->total() - $paginator->currentPage() > 30)--}}
{{--        <a class="larger page" href="http://javhard.net/page/10">10</a>--}}
{{--        <span class='extend'>...</span>--}}
{{--    @endif--}}

    @if ($paginator->hasMorePages())
    <a class="nextpostslink" rel="next" href="{{ $paginator->nextPageUrl() }}">&raquo;</a>
    <a class="last" href="{{ $paginator->nextPageUrl() }}">Last &raquo;</a>
    @else
    <span class="current">1,888</span>
    @endif
@endif
