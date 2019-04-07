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
        $currentEvents = $this->eventRepo->currentEvents('src\Domain\Model\Event\ReservationParking', 20);

        if (count($currentEvents) == 0) {
            return [];
        }

        $relSelfStart = round(end($currentEvents)->getId() / 20) * 20 + 1;
        $relSelfEnd = $relSelfStart + (20 - 1);
        return [
            'current_events' => $currentEvents,
            'rel_self' => [
                'start' => $relSelfStart,
                'end' => $relSelfEnd,
            ],
            'rel_previous' => [
                'start' => $relSelfStart - 20,
                'end' => $relSelfEnd - 20
            ]
        ];
    }

}