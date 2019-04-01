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

}