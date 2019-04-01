<?php


namespace src\Domain\Model\Event;



use Carbon\Carbon;

interface DomainEvent
{
    public function occurredOn() : Carbon;
}