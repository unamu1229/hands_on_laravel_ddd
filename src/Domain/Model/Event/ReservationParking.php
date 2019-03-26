<?php


namespace src\Domain\Model\Event;


use Carbon\Carbon;
use src\Domain\Model\ValueObject\ParkingId;
use src\Domain\Model\ValueObject\UserId;

class ReservationParking
{
    private $parkingId;

    private $userId;

    private $date;

    public function __construct(ParkingId $parkingId, UserId $userId, Carbon $date)
    {
        $this->parkingId = $parkingId;
        $this->userId = $userId;
        $this->date = $date;
    }

    /**
     * @return ParkingId
     */
    public function getParkingId(): ParkingId
    {
        return $this->parkingId;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return Carbon
     */
    public function getDate(): Carbon
    {
        return $this->date;
    }


}