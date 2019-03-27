<?php


namespace src\Application;


use src\Domain\Model\Service\ReserveParking;
use src\Domain\Model\ValueObject\ParkingId;
use src\Domain\Model\ValueObject\UserId;
use Carbon\Carbon;
use src\Domain\Model\Event\ReservationParking;

class ReservationService
{

    private $reserveParking;

    public function __construct(ReserveParking $reserveParking)
    {
        $this->reserveParking = $reserveParking;
    }

    public function reserveParking(ParkingId $parkingId, UserId $userId, Carbon $reserveDate)
    {
        $this->reserveParking->reserve($parkingId, $userId, $reserveDate);
        event(new \App\Events\ReserveParking(new ReservationParking($parkingId, $userId, $reserveDate)));
        return true;
    }
}