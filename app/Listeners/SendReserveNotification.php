<?php

namespace App\Listeners;

use App\Events\ReserveParking;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use src\Domain\Model\Service\SendUserEmail;

class SendReserveNotification
{
    private $sendUserEmail;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SendUserEmail $sendUserEmail)
    {
        $this->sendUserEmail = $sendUserEmail;
    }

    /**
     * Handle the event.
     *
     * @param  ReserveParking  $event
     * @return void
     */
    public function handle(ReserveParking $event)
    {
        $this->sendUserEmail->send($event->reservationParking->getUserId());
    }
}
