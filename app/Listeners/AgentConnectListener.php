<?php

namespace App\Listeners;

use App\Events\AgentConnectedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AgentConnectListener
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
     * @param  AgentConnectEvent  $event
     * @return void
     */
    public function handle(AgentConnectedEvent $event)
    {
        //
    }
}
