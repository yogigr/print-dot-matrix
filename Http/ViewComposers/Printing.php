<?php

namespace Modules\PrintDotMatrix\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Document\Document;

class Printing
{
    public function compose(View $view)
    {
        $data = $view->getData();
        if ($data['document']) {
            $document = $data['document'];
            if ($document->type == Document::INVOICE_TYPE && $document->paid) {
                //push printing to more button component
                $view->getFactory()->startPush('button_print_end', view('print-dot-matrix::printing', [
                    'hidePrint' => $data['hidePrint'],
                    'document' => $document,
                    'setting' => setting('print-dot-matrix')
                ]));
            }
        }
    }
}