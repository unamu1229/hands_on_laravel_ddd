<?php

namespace App\Http\Controllers;


use src\Application\EventService;
use src\Application\StoredEvent;

class ReserveController extends Controller
{

    /** @var EventService  */
    private $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function reserveParkingEvents()
    {
        $currentEvents = $this->eventService->currentEvents();
        $events = [];
        /** @var StoredEvent $currentEvent */
        foreach ($currentEvents['current_events'] as $currentEvent) {
            $events[] = array_merge(
                ['event_id' => $currentEvent->getId()],
                json_decode($currentEvent->getBody(), true)
            );
        }

        return response($events)
            ->header(
                'Link',
                route('reserve.reserve_parking_events') . "/{$currentEvents['start']},{$currentEvents['current']}; rel=self"
            );
    }

    public function failAuth()
    {
        return response()->json(['auth'=>'fail']);
    }
}
