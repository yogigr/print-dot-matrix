<script src={{asset('modules/print-dot-matrix/js/print-dot-matrix.min.js')}}></script>
<script type="text/javascript">
    const printer = {!! $printer !!};
    const doc = {!! json_encode($document) !!};
    const comp = {!! $company !!};
    const issued_at = "{{ $issuedAt }}";
    const printDotMatrix = (msg) => {
        //console.log(doc)
        //console.log(printer)
        //console.log(comp)
        
        let escp = new Escp(printer.host, printer.port, printer.token);
    
        const esc = '\x1B'; //ESC byte in hex notation
        const gs = '\x1D'; //GS
        const lf = '\x0A'; //LF

        
        // Initialize printer
        escp.raw += esc + "@"; 

        //Emphasized + Double-height + Double-width mode selected (ESC ! (8 + 16 + 32)) 56 dec => 38 hex
        //escp.raw +=  esc + "!" + "\x38";

        //Emphasized mode selected (ESC ! (8 ))
        escp.raw +=  esc + "!" + "\x08";

        // Select justification: Centering
        escp.raw += esc + "a" + "\x01";
        
        //header

        // comp name
        escp.raw += comp.name.toUpperCase() + lf;

        // reset printer mode
        escp.raw += esc + "!" + "\x00";

        escp.raw += comp.address + lf;

        escp.raw += comp.phone + lf;

        escp.text("---------------------------------", 33);
        escp.raw += lf;

        // Select justification: left
        escp.raw += esc + "a" + "\x00";
        
        escp.text(issued_at, 16);
        escp.text(doc.document_number, 17, false);

        escp.text("---------------------------------", 33);
    
        //items
        doc.items.forEach((item) => {
            escp.raw += lf;
            escp.text(item.name, 20);
            escp.text(parseFloat(item.quantity).toLocaleString('id'), 2, false);
            escp.text(parseFloat(item.total).toLocaleString('id'), 11, false);
        })

        escp.text("---------------------------------", 33);

        //total
        doc.totals.forEach((total) => {
            escp.raw += lf;
            if (total.code == 'total') {
                escp.raw += esc + '!' + "\x08";
            }
            escp.text(" ", 11);
            escp.text(total.code.toUpperCase(), 10);
            escp.text(parseFloat(total.amount).toLocaleString('id'), 12, false)
        })

        escp.raw += lf;
        escp.text(" ", 11);
        escp.text("DIBAYAR", 10);
        escp.text(parseFloat(doc.paid).toLocaleString('id'), 12, false)

        escp.raw += lf + lf;

        escp.raw += esc + '!' + "\x00";
        // Select justification: Centering
        escp.raw += esc + "a" + "\x01";
        escp.raw += 'TERIMA KASIH'

        escp.raw += lf + lf;

        // Select cut mode and cut paper GS "V" 66 0
        escp.raw += gs + "V" + "\x42" + "\x00";

        //console.log(escp.raw)
        
        try {
            escp.sendRaw();
        } catch (err) {
            console.log(err);
        }
    }
</script>