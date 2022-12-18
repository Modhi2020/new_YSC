<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\MediaViewer;

class ViewerCounter
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(MediaViewer $event)
    {
        $this->updateViewer($event->myevent);
    }

    function updateViewer ($myevent)
    {
        $myevent ->viewers = $myevent ->viewers + 1;
        $myevent->save();
    }
}
