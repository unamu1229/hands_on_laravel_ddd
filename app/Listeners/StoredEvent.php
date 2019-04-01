<?php

namespace App\Listeners;

use App\Events\ReserveParking;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use src\Application\EventService;

class StoredEvent
{

    private $eventService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Handle the event.
     *
     * @param  ReserveParking  $event
     * @return void
     */
    public function handle(ReserveParking $event)
    {
        $this->eventService->store($event->reservationParking);
    }
}
