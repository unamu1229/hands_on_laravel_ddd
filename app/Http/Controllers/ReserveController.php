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

        return $this->makeResponse($currentEvents);
    }

    public function reserveParkingRange($start, $end)
    {
        $events = $this->eventService->rangeEvents($start, $end);

        return $this->makeResponse($events);
    }

    public function failAuth()
    {
        return response()->json(['auth'=>'fail']);
    }

    private function makeResponse(array $events)
    {
        $endPoint = route(
            'reserve.reserve_parking_events');

        if (count($events) == 0) {
            return response([])
                ->header('Link-self', "<{$endPoint}/1,20>; rel=self");
        }

        $body = [];
        /** @var StoredEvent $currentEvent */
        foreach ($events['events'] as $currentEvent) {
            $body[] = array_merge(
                ['event_id' => $currentEvent->getId()],
                json_decode($currentEvent->getBody(), true)
            );
        }


        $relSelf = "<{$endPoint}/{$events['rel_self']['start']},{$events['rel_self']['end']}>; rel=self";
        $relPrevious = "<{$endPoint}/{$events['rel_previous']['start']},{$events['rel_previous']['end']}>; rel=previous";

        return response($body)
            ->header('Link-self', $relSelf)
            ->header('Link-previous', $relPrevious);
    }
}
