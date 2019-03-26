<?php

namespace App\Listeners;

use App\Events\ReserveParking;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use src\Domain\Model\Entity\Reservation;
use src\Domain\Model\ValueObject\ReservationId;
use src\Infrastructure\ReservationRepository;

class SaveReservation
{

    private $reservationRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * Handle the event.
     *
     * @param  ReserveParking  $event
     * @return void
     */
    public function handle(ReserveParking $event)
    {
        $reservationParking = $event->reservationParking;
        $reservation = new Reservation(
            new ReservationId(uniqid()),
            $reservationParking->getParkingId(),
            $reservationParking->getUserId(),
            $reservationParking->getDate()
        );
        $this->reservationRepository->save($reservation);
    }
}
