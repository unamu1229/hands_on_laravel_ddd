<?php


namespace src\Infrastructure;


use Carbon\Carbon;
use src\Domain\Model\Entity\Reservation;
use src\Domain\Model\ValueObject\ParkingId;
use src\Domain\Model\ValueObject\ReservationId;
use src\Domain\Model\ValueObject\UserId;

class ReservationRepository
{
    public function reservationByParkingId(ParkingId $parkingId)
    {
        return new Reservation(new ReservationId(uniqid()), $parkingId, new UserId(uniqid()), (new Carbon())->subDay());
    }

    public function save(Reservation $reservation)
    {
        return true;
    }
}