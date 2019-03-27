<?php


namespace src\Domain\Model\Service;


use Carbon\Carbon;
use src\Domain\Model\Event\ReservationParking;
use src\Domain\Model\ValueObject\ParkingId;
use src\Domain\Model\ValueObject\UserId;
use src\Infrastructure\ReservationRepository;
use src\Domain\Model\Entity\Reservation;
use src\Domain\Model\ValueObject\ReservationId;

class ReserveParking
{
    public $reservationsRepo;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationsRepo = $reservationRepository;
    }

    public function reserve(ParkingId $parkingId, UserId $userId, Carbon $reserveDate)
    {
        $sameParkingReservation = $this->reservationsRepo->reservationByParkingId($parkingId);
        if ($sameParkingReservation->date()->eq($reserveDate)) {
            return false;
        }
        $reservation = new Reservation(new ReservationId(uniqid()), $parkingId, $userId, $reserveDate);
        $this->reservationsRepo->save($reservation);
        return $reservation->getId();
    }
}