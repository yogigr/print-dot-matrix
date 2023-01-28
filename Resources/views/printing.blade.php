@if (! $hidePrint)
    <x-dropdown.button id="show-more-actions-dot-matrix-print-{{ $document->type }}" onclick="printDotMatrix('test')">
        {{trans('print-dot-matrix::general.print')}}
    </x-dropdown.button>

    @push('scripts_end')
    @php
    $setting = json_encode($setting);
    @endphp
    <script src={{asset('modules/print-dot-matrix/js/print-dot-matrix.min.js')}}></script>
    <script type="text/javascript">
        const setting = {!! $setting !!}
        const printDotMatrix = (msg) => {
            let escp = new Escp(setting.host, setting.port, setting.token);
            escp.reset();
            escp.setPrinterArea('\x4D', '\x30', '\x00', '\x2D', '\x2C', '\x00');
            escp.text(msg)
            escp.reset();
            try {
                escp.sendRaw();
            } catch (err) {
                console.log(err);
            }
        }
    </script>
    @endPush
@endif
