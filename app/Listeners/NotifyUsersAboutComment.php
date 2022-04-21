<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Commentposted;
use App\Jobs\NotifyusersPostWasCommented;

class NotifyUsersAboutComment
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Commentposted $event)
    {
        NotifyusersPostWasCommented::dispatch($event->comment); 
    }
}
