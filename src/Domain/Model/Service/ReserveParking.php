<?php


namespace src\Domain\Model\Service;


use Carbon\Carbon;
use src\Domain\Model\ValueObject\ParkingId;
use src\Domain\Model\ValueObject\UserId;
use src\Infrastructure\ReservationRepository;

class ReserveParking
{
    public $reservationsRepo;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationsRepo = $reservationRepository;
    }

    public function reserve(ParkingId $parkingId, UserId $userId, Carbon $reserveDate)
    {
        $reservation = $this->reservationsRepo->reservationByParkingId($parkingId);
        if ($reservation->date()->eq($reserveDate)) {
            return false;
        }
        return true;
    }
}