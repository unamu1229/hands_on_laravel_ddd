<?php


namespace src\Domain\Model\ValueObject;


class ReservationId
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }


    public function id()
    {
        return $this->id;
    }
}