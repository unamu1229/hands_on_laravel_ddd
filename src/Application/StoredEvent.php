<?php


namespace src\Application;


use Carbon\Carbon;

class StoredEvent
{
    private $id;
    private $body;
    private $type;
    private $occurredOn;


    public function __construct(?int $id, string $body, string $type, Carbon $occurredOn)
    {
        $this->id = $id;
        $this->body = $body;
        $this->type = $type;
        $this->occurredOn = $occurredOn;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return Carbon
     */
    public function getOccurredOn(): Carbon
    {
        return $this->occurredOn;
    }



}