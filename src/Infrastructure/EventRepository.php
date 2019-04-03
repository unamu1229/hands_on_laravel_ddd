<?php


namespace src\Infrastructure;


use App\Models\Event;
use Carbon\Carbon;
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


    /**
     * @param string $typeName
     * @param int $amount
     * @return StoredEvent[]
     */
    public function currentEvents(string $typeName, int $amount)
    {
        $tmpCurrentEvents = $this->event->newQuery()->where('type_name', '=', $typeName)
            ->orderBy('id', 'desc')->limit($amount)->get();

        if ($tmpCurrentEvents->isEmpty()) {
            return [];
        }

        $currentEvents = [];
        foreach ($tmpCurrentEvents->reverse() as $tmpCurrentEvent) {
            $currentEvents[] = new StoredEvent(
                $tmpCurrentEvent->id,
                $tmpCurrentEvent->body,
                $tmpCurrentEvent->type_name,
                new Carbon($tmpCurrentEvent->occured_on)
            );
        }

        return $currentEvents;
    }

}