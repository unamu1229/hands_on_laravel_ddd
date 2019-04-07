<?php


namespace src\Infrastructure;


use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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
        $eventData = $this->event->newQuery()->where('type_name', '=', $typeName)
            ->orderBy('id', 'desc')->limit($amount)->get();

        if ($eventData->isEmpty()) {
            return [];
        }

        return $this->convertEvents($eventData->reverse());
    }


    public function rangeEvents(int $start, int $end)
    {
        $eventData = $this->event->newQuery()->whereBetween('id', [$start, $end])->get();
        return $this->convertEvents($eventData);
    }


    private function convertEvents(Collection $events)
    {
        $storedEvents = [];
        foreach ($events as $event) {
            $storedEvents[] = new StoredEvent(
                $event->id,
                $event->body,
                $event->type_name,
                new Carbon($event->occured_on)
            );
        }

        return $storedEvents;
    }

}