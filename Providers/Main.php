<?php

namespace Modules\PrintDotMatrix\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider as Provider;
use Modules\PrintDotMatrix\Http\ViewComposers\Printing;

class Main extends Provider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViews();
        $this->loadTranslations();

        View::composer(['components.documents.show.more-buttons'], Printing::class);
    }

    /**
     * Load views.
     *
     * @return void
     */
    public function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'print-dot-matrix');
    }

    /**
     * Load translations.
     *
     * @return void
     */
    public function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'print-dot-matrix');
    }
}
