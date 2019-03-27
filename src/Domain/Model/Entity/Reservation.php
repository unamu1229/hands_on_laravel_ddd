<?php


namespace src\Domain\Model\Entity;


use Carbon\Carbon;
use src\Domain\Model\ValueObject\ParkingId;
use src\Domain\Model\ValueObject\ReservationId;
use src\Domain\Model\ValueObject\UserId;

class Reservation
{
    private $id;

    private $date;

    private $parkingId;

    private $userId;

    public function __construct(ReservationId $reservationId, ParkingId $parkingId, UserId $userId, Carbon $date)
    {
        $this->id = $reservationId;
        $this->parkingId = $parkingId;
        $this->userId = $userId;
        $this->date = $date;
    }

    public function date()
    {
        return $this->date;
    }

    /**
     * @return ReservationId
     */
    public function getId(): ReservationId
    {
        return $this->id;
    }


}