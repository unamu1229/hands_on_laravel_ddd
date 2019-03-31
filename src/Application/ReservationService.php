<?php


namespace src\Application;


use src\Domain\Model\Service\ParkingService;
use src\Domain\Model\ValueObject\ParkingId;
use src\Domain\Model\ValueObject\UserId;
use Carbon\Carbon;
use src\Domain\Model\Event\ReservationParking;

class ReservationService
{

    private $reserveParking;

    public function __construct(ParkingService $reserveParking)
    {
        $this->reserveParking = $reserveParking;
    }

    public function reserveParking(ParkingId $parkingId, UserId $userId, Carbon $reserveDate)
    {
        $reservationId = $this->reserveParking->reserve($parkingId, $userId, $reserveDate);
        event(new \App\Events\ReserveParking(new ReservationParking($parkingId, $userId, $reserveDate)));
        return true;
    }
}