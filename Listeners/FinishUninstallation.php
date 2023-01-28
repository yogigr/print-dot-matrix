<?php

namespace Modules\PrintDotMatrix\Listeners;

use App\Events\Module\Uninstalled as Event;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FinishUninstallation
{
    public $alias = 'print-dot-matrix';

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Event $event)
    {
        if ($event->alias != $this->alias) {
            return;
        }
        $this->deleteConfig();
    }

    private function deleteConfig()
    {
        setting()->forget('print-dot-matrix');
        setting()->save();
    }
}
