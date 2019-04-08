<?php


namespace src\Application;


use src\Domain\Model\Event\DomainEvent;
use src\Infrastructure\EventRepository;

class EventService
{

    const EVENT_UNIT = 20;
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
        $storedEvents = $this->eventRepo->currentEvents('src\Domain\Model\Event\ReservationParking', self::EVENT_UNIT);

        if (count($storedEvents) == 0) {
            return [];
        }

        $start = floor((end($storedEvents)->getId() - 1) / self::EVENT_UNIT) * self::EVENT_UNIT + 1;
        $end = $start + (self::EVENT_UNIT - 1);

        return $this->makeEventsFormat($storedEvents, $start, $end, false);
    }


    public function rangeEvents(int $start, int $end)
    {
        $storedEvents = $this->eventRepo->rangeEvents($start, $end);

        $currentEvents = $this->eventRepo->currentEvents('src\Domain\Model\Event\ReservationParking', self::EVENT_UNIT);

        $isNext = false;
        if ($end < end($currentEvents)->getId()) {
            $isNext = true;
        }

        return $this->makeEventsFormat($storedEvents, $start, $end, $isNext);
    }


    private function makeEventsFormat($storedEvents, int $start, int $end, bool $isNext)
    {
        $events = [
            'events' => $storedEvents,
            'rel_self' => [
                'start' => $start,
                'end' => $end
            ],
            'rel_previous' => [
                'start' => $start - self::EVENT_UNIT,
                'end' => $end - self::EVENT_UNIT
            ]
        ];

        if ($isNext) {
            $events['rel_next'] = [
                'start' => $start + self::EVENT_UNIT,
                'end' => $end + self::EVENT_UNIT
            ];
        }

        return $events;
    }

}