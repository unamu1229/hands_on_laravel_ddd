<?php


namespace src\Infrastructure;


use App\Models\Event;
use src\Application\StoredEvent;

class EventRepository
{
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function save(StoredEvent $storedEvent)
    {
        $event = new Event();
        $event->body = $storedEvent->getBody();
        $event->type_name = $storedEvent->getType();
        $event->occurred_on = $storedEvent->getOccurredOn();
        $event->save();
    }
}