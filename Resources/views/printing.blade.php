@if (! $hidePrint)
    <x-dropdown.button id="show-more-actions-dot-matrix-print-{{ $document->type }}" onclick="printDotMatrix('test')">
        {{trans('print-dot-matrix::general.print')}}
    </x-dropdown.button>

    @push('scripts_end')
        @include('print-dot-matrix::printing-js')
    @endPush
@endif
