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

        if (count($currentEvents) == 0) {
            return response([])
                ->header(
                    'Link',
                    route(
                        'reserve.reserve_parking_events') . "/1,20; rel=self"
                );
        }

        $events = [];
        /** @var StoredEvent $currentEvent */
        foreach ($currentEvents['current_events'] as $currentEvent) {
            $events[] = array_merge(
                ['event_id' => $currentEvent->getId()],
                json_decode($currentEvent->getBody(), true)
            );
        }

        $endPoint = route(
            'reserve.reserve_parking_events');
        $relSelf = "<{$endPoint}/{$currentEvents['rel_self']['start']},{$currentEvents['rel_self']['end']}>; rel=self";
        $relPrevious = "<{$endPoint}/{$currentEvents['rel_previous']['start']},{$currentEvents['rel_previous']['end']}>; rel=previous";

        return response($events)
            ->header('Link-self', $relSelf)
            ->header('Link-previous', $relPrevious);
    }

    public function failAuth()
    {
        return response()->json(['auth'=>'fail']);
    }
}
