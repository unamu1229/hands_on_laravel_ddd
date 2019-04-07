<?php


namespace src\Application;


use src\Domain\Model\Event\DomainEvent;
use src\Infrastructure\EventRepository;

class EventService
{
    private $eventRepo;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepo = $eventRepository;
    }

    public function store(DomainEvent $event)
    {
        $event = new StoredEvent(
            null,
            json_encode($event, JSON_PRETTY_PRINT),
            get_class($event),
            $event->occurredOn()
        );
        $this->eventRepo->save($event);
    }


    /**
     * @return array
     */
    public function currentEvents()
    {
        $storedEvents = $this->eventRepo->currentEvents('src\Domain\Model\Event\ReservationParking', 20);

        if (count($storedEvents) == 0) {
            return [];
        }

        $start = round(end($storedEvents)->getId() / 20) * 20 + 1;
        $end = $start + (20 - 1);

        return $this->makeEventsFormat($storedEvents, $start, $end);
    }


    public function rangeEvents(int $start, int $end)
    {
        $storedEvents = $this->eventRepo->rangeEvents($start, $end);

        return $this->makeEventsFormat($storedEvents, $start, $end);
    }


    private function makeEventsFormat($storedEvents, int $start, int $end)
    {
        return [
            'events' => $storedEvents,
            'rel_self' => [
                'start' => $start,
                'end' => $end
            ],
            'rel_previous' => [
                'start' => $start - 20,
                'end' => $end - 20
            ]
        ];
    }

}